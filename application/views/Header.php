<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="container header mb-3">
	<div class="d-flex justify-content-between align-items-baseline mt-5">
		<div class="d-flex align-items-baseline">
			<h1 class="mr-3 font-weight-bold text-decoration-none"><a href="<?php echo site_url('home'); ?>">Teqa Hub</a>
			</h1>
			<h2 class="grey-title"><?= isset($title) ? $title : '' ?></h2>

		</div>
		<div>
			<?php if (isset($user_id) && $user_id) : ?>
				<div class="d-flex">
					<h3>Welcome, <a href="<?php echo site_url('user/profile'); ?>"><?= $username ?></a></h3>
					<?php if (isset($title) && $title == 'Profile') : ?>

						<form action="<?php echo site_url('user/logout'); ?>" method="post">
							<button class="button bg-red ml-3" type="submit">Logout</button>
						</form>

					<?php endif; ?>
				</div>
			<?php else : ?>
				<div>
					<a href=" <?php echo site_url('login'); ?>">
						<button class="button bg-green">Login</button></a>
					<a href="<?php echo site_url('register'); ?>">
						<button class="button bg-darkblue">Sign Up</button>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>