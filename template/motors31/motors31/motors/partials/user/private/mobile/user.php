<div class="stm-user-mobile-info-wrapper">

	<?php if(!is_user_logged_in()): ?>
		<div class="stm-login-form-mobile-unregistered">
			<form method="post">

				<div class="form-group">
					<h4><?php esc_html_e('Login or E-mail', 'motors'); ?></h4>
					<input type="text" name="stm_user_login" placeholder="<?php esc_html_e('Enter login or E-mail', 'motors') ?>"/>
				</div>

				<div class="form-group">
					<h4><?php esc_html_e('Password', 'motors'); ?></h4>
					<input type="password" name="stm_user_password"  placeholder="<?php esc_html_e('Enter password', 'motors') ?>"/>
				</div>

				<div class="form-group form-checker">
					<label>
						<input type="checkbox" name="stm_remember_me" />
						<span><?php esc_html_e('Remember me', 'motors'); ?></span>
					</label>
				</div>
				<input type="submit" value="<?php esc_html_e('Login', 'motors'); ?>"/>
				<span class="stm-listing-loader"><i class="stm-icon-load1"></i></span>
				<a href="<?php echo esc_url(stm_get_author_link('register')); ?>" class="stm_label"><?php esc_html_e('Sign Up', 'motors'); ?></a>
				<div class="stm-validation-message"></div>
			</form>
		</div>
	<?php else:
		$user = wp_get_current_user();

		$roles = $user->roles;

		if ( in_array( 'stm_dealer', $roles ) ) {
			get_template_part( 'partials/user/private/mobile/dealer', 'profile');
		} else {
			get_template_part( 'partials/user/private/mobile/user', 'profile');
		}
	endif; ?>

</div>