<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Teqa Hub - Home of Tech</title>

	<?php $this->load->view('templates/Headlinks'); ?>

	<!-- Backbone.js + jquery + underscore.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>

<body>
	<?php $this->load->view('Header'); ?>
	<div class="container">
		<div class="row">
			<div class="col">
				<form action="<?php echo site_url('home/search'); ?>" method="get" class="d-flex mb-3">
					<input class="form-control mr-2" type="search" aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" placeholder="Search Questions...">
					<div class="input-group-append">
						<button class="thin-button" type="submit">Search</button>
					</div>
				</form>
			</div>
		</div>
		<?php if (!$showForm) : ?>
			<div class="mb-3">
				<form action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
					<button class="thin-button" type="submit">Ask Question</button>
				</form>
			</div>
		<?php else : ?>
			<hr>
			<h5 class="font-bold text-xl mb-3">Ask a Question</h5>
			<div>
				<?php echo validation_errors(); ?>
				<div class="form-group">
					<form action="<?php echo site_url('home/ask_question'); ?>" method="post">
						<input class="form-control mb-3" type="text" name="title" placeholder="Question Title">
						<textarea class="form-control mb-3" type="text" name="description" placeholder="Question Description" rows="5"></textarea>
						<button class="thin-button bg-darkblue" type="submit">Submit</button>
					</form>
				</div>
			</div>
		<?php endif; ?>
		<div class="question-list">
			<?php if (empty($questions)) : ?>
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
				initialize: function() {
					this.render();
				},
				template: _.template(`
		<a href="<?php echo site_url('question/view/<%= id %>'); ?>" class="text-decoration-none text-black">
			<div class="question-card card mb-3 ">
				<div class="card-body">
					<div class="d-flex align-items-center justify-content-between">
						<h5 class="font-weight-bold card-title">
							<%= title %>
						</h5>
						<p class=" text-right" style="font-size:14px;">by <%= username %>
						<span class=" text-secondary"><%= time_span %> ago</span>
						</p>
						</div>
						<hr>
						<p>
						<%= description %>
					</p>
					<p style="font-size:14px;">Answers: <%= answer_count %>
					</p>
				</div>
			</div>
		</a>`),
				render: function() {
					this.$el.html(this.template(this.model.attributes));
					return this;
				}
			});
			var Questions = Backbone.Collection.extend({
				model: Question
			});
			var QuestionsView = Backbone.View.extend({
				initialize: function() {
					this.render();
				},
				collection: Questions,
				iteratingFunction: function(question) {
					var questionView = new QuestionView({
						model: question
					});
					this.$el.append(questionView.el);
				},
				render: function() {
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

	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>


</html>