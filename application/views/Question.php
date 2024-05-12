<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
	<?php $this->load->view('Header'); ?>

	<div class="container mt-5">
		<h1><?= $question['title'] ?></h1>
		<p><?= $question['description'] ?></p>
		<p class="card-text text-right" style="font-size:small">asked by <span
				class="font-weight-bold"><?= ucfirst(strtolower($question['username'])) ?></span>
			<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago
		</p>

		<?php if ($question['is_solved']): ?>
			<p class="text-success">This question has been solved</p>

		<?php endif; ?>

		<hr>

		<h5>Answers</h5>
		<div class="mb-3">
			<form action="<?php echo site_url('question/view/' . $question['id'] . '/show_answer_form') ?>"
				method="post">
				<button type="submit" name="answerButton" class="btn btn-success">Add Answer</button>
			</form>
		</div>


		<?php if ($showForm): ?>
			<div id="askForm">
				<?php echo validation_errors(); ?>
				<div class="form-group">

					<form action="<?php echo site_url('question/view/' . $question['id'] . '/answer/submit'); ?>"
						method="post">
						<div class="form-group">
							<textarea type="text" class="form-control" name="answer" placeholder="Enter Answer"></textarea>
						</div>

						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		<?php endif; ?>

		<?php if (empty($question['answers'])): ?>
			<p>No answers yet.</p>
		<?php else: ?>


			<?php foreach ($question['answers'] as $answer): ?>
				<div class="card mb-3">
					<div class="card-body d-flex align-items-start">
						<div class="voteButtons mr-3">
							<a
								href="<?php echo site_url('question/' . $question['id'] . '/answer/' . $answer['id'] . '/vote/up'); ?>">
								<span>&#x2191;</span>
							</a>

							<a
								href="<?php echo site_url('question/' . $question['id'] . '/answer/' . $answer['id'] . '/vote/down'); ?>">
								<span>&#x2193;</span>
							</a>
						</div>
						<div class="w-100">
							<p class="card-text"><?= $answer['answer'] ?></p>
							<p class="card-text text-right" style="font-size:small">answered by <span
									class="font-weight-bold"><?= ucfirst(strtolower($answer['username'])) ?></span>
								<?= strtolower(timespan(strtotime($answer['date_answered']), time(), 2)); ?> ago
							</p>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		<?php endif; ?>

	</div>



</body>

</html>
