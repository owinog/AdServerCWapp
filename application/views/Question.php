<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $question['title'] ?></title>

	<?php $this->load->view('templates/Headlinks'); ?>
</head>

<body>
	<?php $this->load->view('Header'); ?>
	<div class="container mt-5">
		<h2><?= $question['title'] ?></h2>
		<p><?= $question['description'] ?></p>
		<p class="text-right" style="font-size:14px">asked by <span><?= ucfirst(strtolower($question['username'])) ?></span>
			<span class=" text-secondary"> <?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?> ago</span>
		</p>
		<hr>
		<div class="row mb-3">
			<div class="col-md-6">
				<h5>Answers</h5>
			</div>
			<div class="col-md-6 text-right">
				<form action="<?php echo site_url('question/view/' . $question['id'] . '/show_answer_form') ?>" method="post">
					<button class="thin-button" type="submit" name="answerButton">Add Answer</button>
				</form>
			</div>
		</div>
		<?php if ($showForm) : ?>
			<div>
				<?php echo validation_errors(); ?>
				<div class="form-group">
					<form action="<?php echo site_url('question/view/' . $question['id'] . '/answer/submit'); ?>" method="post">
						<div class="form-group">
							<textarea class="form-control" type="text" name="answer" placeholder="Enter Answer"></textarea>
						</div>
						<button class="thin-button bg-darkblue" type="submit">Submit</button>
					</form>
				</div>
			</div>
		<?php endif; ?>
		<?php if (empty($question['answers'])) : ?>
			<p>No answers yet.</p>
		<?php else : ?>
			<?php foreach ($question['answers'] as $answer) : ?>
				<div class="card mb-3">
					<div class="card-body d-flex align-items-start">
						<div class="mr-3">
							<a href="<?php echo site_url('question/' . $question['id'] . '/answer/' . $answer['id'] . '/vote/up'); ?>">
								<span>&#x2191;</span>
							</a>
							<div><?= $answer['vote_count'] ?></div>
							<a href="<?php echo site_url('question/' . $question['id'] . '/answer/' . $answer['id'] . '/vote/down'); ?>">
								<span>&#x2193;</span>
							</a>
						</div>
						<div>
							<p><?= $answer['answer'] ?></p>
							<?php if ($this->session->userdata('user_id') == $question['user_id'] && !($answer['is_correct'])) : ?>
								<form action="<?php echo site_url('answer/mark_as_correct') ?>" method="post">
									<input type="hidden" name="answer_id" value="<?= $answer['id'] ?>">
									<input type="hidden" name="question_id" value="<?= $question['id'] ?>">
									<button class="thin-button bg-green" type="submit">Mark as Correct</button>
								</form>
							<?php endif; ?>
							<?php if ($answer['is_correct']) : ?>
								<i class="fas fa-check text-success fa-2x"></i>
							<?php endif; ?>
							<p class="text-right mt-3" style="font-size:14px;">answered by <span><?= ucfirst(strtolower($answer['username'])) ?></span>
								<span class=" text-secondary"> <?= strtolower(timespan(strtotime($answer['date_answered']), time(), 2)); ?> ago</span>
							</p>

						</div>
					</div>

				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</body>

</html>