<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<?php $this->load->view('templates/Headlinks'); ?>
</head>

<body>
	<?php $this->load->view('header'); ?>
	<div class="container pt-5">
		<div class="d-flex justify-content-center">
			<div class="col-md-4">
				<?php if (isset($error)) : ?>
					<div class="alert alert-danger">
						<?= $error ?>
					</div>
				<?php endif; ?>
				<form action="<?= site_url('user/register') ?>" method="post">
					<div class="form-group mb-3">
						<label for="username">Username</label>
						<input class="form-control" type="text" id="username" name="username" required>
					</div>
					<div class="form-group mb-3">
						<label for="email">Email</label>
						<input class="form-control" type="email" id="email" name="email" required>
					</div>
					<div class="form-group mb-5">
						<label for="password">Password</label>
						<input class="form-control" type="password" id="password" name="password" required>
					</div>
					<div class="form-group d-flex justify-content-center">
						<button class="button bg-darkblue" type="submit">Register</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>