<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teqa Hub - Home of Tech</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
	<?php $this->load->view('templates/Headlinks'); ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>

<body>
	<?php $this->load->view('Header'); ?>
	<div class="container">
		<div class="row mt-3 mb-3">
			<div class="col">
				<form class="form-inline" action="<?php echo site_url('home/search'); ?>" method="get">
					<div class="input-group w-100">
						<input class="form-control mr-sm-2" type="search" placeholder="Search Questions..."
							aria-label="Search" name="search"
							value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
						<div class="input-group-append">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php if (!$showForm): ?>
			<div 
			>
				<form action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
					<button type="submit" name="askButton"
						>Ask Question</button>
				</form>
			</div>
		<?php else: ?>
			<hr class="my-4">
			<h5 class="font-bold text-xl mb-4">Ask a Question</h5>
			<div id="askForm">
				<?php echo validation_errors(); ?>
				<div class="form-group">
					<form action="<?php echo site_url('home/ask_question'); ?>" method="post">
						<input type="text" 
						name="title" placeholder="Question Title">
						<textarea 
						type="text" 
						name="description"
							placeholder="Question Description" 
							rows="5"></textarea>
						<button type="submit"
							>Submit</button>
					</form>
				</div>
			</div>
		<?php endif; ?>

		<div class="question-list mt-3">
			<?php if (empty($questions)): ?>
				<div class="alert alert-info mt-3" role="alert">
					No questions found.
				</div>
			<?php endif; ?>

			<div id="questions"></div>
		</div>

		<?php echo '<script>';
		echo 'var questionsData = ' . json_encode($questions) . ';';
		echo '</script>'; ?>
		<script>

			var Question = Backbone.Model.extend({
				defaults: {
					id: "",
					title: "",
					description: "",
					user_id: "",
					username: "",
					date_asked: "",
					is_solved: "",
					answer_count: "",
					time_span: ""
				}
			});

			var question = new Question();

			var QuestionView = Backbone.View.extend({

				model: Question,

				initialize: function () {
					this.render();
				},

				template: _.template(`
		<a href="<?php echo site_url('question/view/<%= id %>'); ?>" class="text-decoration-none" style="color:black; ">
			<div class="card mb-3 question-card">
				<div class="card-body">
					<div class="flex justify-between items-center">

						<h5 class="font-bold text-lg">
							<%= title %>
						</h5>
						<p class="text-sm text-right" style="font-size:small">by <span
								class="font-bold"><%= username %></span>
							<%= time_span %> ago
						</p>
					</div>

					<p class="mt-2">
						<%= description %>
					</p>
					<p class="card-text">Answers: <%= answer_count %>
					</p>
				</div>
			</div>
		</a>`),

				render: function () {
					this.$el.html(this.template(this.model.attributes));
					return this;
				}
			});


			var Questions = Backbone.Collection.extend({
				model: Question
			});

			var QuestionsView = Backbone.View.extend({

				initialize: function () {
					this.render();
				},
				collection: Questions,

				iteratingFunction: function (question) {
					var questionView = new QuestionView({
						model: question
					});
					this.$el.append(questionView.el);

				},

				render: function () {
					this.collection.forEach(this.iteratingFunction, this);
				}
			});

			var question_collection = new Questions();
			question_collection.reset(questionsData)
			var questionsView = new QuestionsView({
				collection: question_collection,

			});
			$('#questions').append(questionsView.el);

		</script>

	</div>
	<!-- <?php $this->load->view('Footer'); ?> -->

	<!-- Include Alpine.js for interactive components -->
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

</body>

</html>
