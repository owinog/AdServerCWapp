<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Teqa Hub - Qs for Techies</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<style>
		.question-list {
			height: 400px;
			overflow-y: auto;
		}

		.question-card {
			transition: transform .5s;
		}

		.question-card:hover {
			color: grey;
		}

		.question-card:active {
			transform: scale(0.99);
			color: grey;
		}
	</style>
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
		<!-- Ask Question button -->
		<div class="mb-3">
			<form action="<?php echo site_url('home/show_ask_form'); ?>" method="post">
				<button type="submit" name="askButton" class="btn btn-success">Ask Question</button>
			</form>
		</div>

		<?php if ($showForm): ?>
			<div id="askForm">
				<?php echo validation_errors(); ?>
				<div class="form-group">
					<form action="<?php echo site_url('home/ask_question'); ?>" method="post">
						<input type="text" class="form-control col-md-4" name="title" placeholder="Question Title">
						<input type="text" class="form-control col-md-6" name="description"
							placeholder="Question Description">
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		<?php endif; ?>


		<!-- List of questions -->
		<div class="question-list">
			<?php if (empty($questions)): ?>
				<div class="alert alert-info" role="alert">
					No questions found.
				</div>
			<?php endif; ?>

			<?php foreach ($questions as $question): ?>
				<a href="<?php echo site_url('question/view/' . $question['id']); ?>" class="text-decoration-none"
					style="color:black; ">
					<div class="card mb-3 question-card">
						<div class="card-body">
							<div class="d-flex justify-content-between align-items-center">

								<h5 class="card-title"><?= $question['title'] ?></h5>
								<p class="card-text text-right" style="font-size:small">by <span
										class="font-weight-bold"><?= ucfirst(strtolower($question['username'])) ?></span>
									<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago
								</p>
							</div>

							<p class="card-text"><?= $question['description'] ?></p>
							<p class="card-text">Answers: <?= $this->Question_model->get_answer_count($question['id']) ?>
							</p>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>

</body>

</html>