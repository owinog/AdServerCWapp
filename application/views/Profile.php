<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
	<?php $this->load->view('templates/Headlinks'); ?>
</head>

<body>
	<?php $this->load->view('header'); ?>
	<div class="container">
		<div class="card d-flex flex-row justify-content-between mb-3">
			<p class="card-text my-3 ml-5">Email: <?= $email ?></p>
			<p class="card-text my-3 ">Questions: <?= $num_questions ?></p>
			<p class="card-text my-3">Correct answers: <?= $num_correct_answers ?></p>
			<p class="card-text my-3 mr-5">Votes Recieved: <?= $total_votes ?></p>
		</div>

		<div class="mb-3 d-flex justify-content-center">
			<div class="mr-3">
				<ul class="nav nav-tabs custom-nav p-3" role="tablist">
					<li class="nav-item mb-2">
						<a class="nav-link custom-tab active text-decoration-none text-black" id="questions-tab" data-toggle="tab" href="#questions" role="tab">Questions Asked</a>
					</li>
					<li class="nav-item">
						<a class="nav-link custom-tab text-decoration-none text-black" id="answers-tab" data-toggle="tab" href="#answers" role="tab">Answers
							Given</a>
					</li>
				</ul>

			</div>
			<div class="tab-content">
				<div class="tab-pane fade show active" id="questions" role="tabpanel">
					<div class="question-list">
						<?php if (empty($questions)) : ?>
							<div class="alert alert-info" role="alert">
								No questions found.
							</div>
						<?php endif; ?>
						<?php foreach ($questions as $question) : ?>
							<a href="<?php echo site_url('question/view/' . $question['id']); ?>" class="text-decoration-none text-black">
								<div class="card mb-3 question-card">
									<div class="card-body">
										<div class="d-flex align-items-center justify-content-between">
											<h5 class="font-weight-bold card-title"><?= $question['title'] ?></h5>
											<p class=" text-right text-secondary" style="font-size:14px;">
												<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?>
												ago
											</p>
										</div>
										<hr>
										<p><?= $question['description'] ?></p>
										<p style="font-size:14px;">Answers:
											<?= $this->Question_model->get_answer_count($question['id']) ?>
										</p>
									</div>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="tab-pane fade" id="answers" role="tabpanel">
					<div class="answer-list">
						<?php if (empty($answers)) : ?>
							<div class="alert alert-info" role="alert">
								No Answers found.
							</div>
						<?php endif; ?>
						<?php foreach ($answers as $answer) : ?>
							<a href="<?php echo site_url('question/view/' . $answer['question_id']); ?>" class="text-decoration-none text-black">
								<div class="card mb-3 answer-card">
									<div class="card-body">
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="font-weight-bold card-title"><?= $answer['question_title'] ?></h5>
											<p class=" text-right text-secondary" style="font-size:14px;">
												<?= strtolower(timespan(strtotime($question['date_asked']), time(), 2)); ?>
												ago
											</p>
										</div>
										<p><?= $answer['answer'] ?></p>
									</div>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

		</div>
	</div>
	<script>
		$(function() {
			$('.nav-tabs a').click(function(e) {
				e.preventDefault();
				$(this).tab('show');
			});
		});
	</script>
</body>

</html>