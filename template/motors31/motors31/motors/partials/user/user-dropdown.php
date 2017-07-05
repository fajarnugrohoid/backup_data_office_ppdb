<?php if(is_user_logged_in()): ?>
	<?php
		$user = wp_get_current_user();
		if(!is_wp_error($user)):

		$link = stm_get_author_link($user->data->ID);

		$my_offers = 0;

		$user_cars = stm_user_listings_query($user->data->ID);
		if(!empty($user_cars->post_count)) {
			$my_offers = $user_cars->post_count;
		}

		$my_fav = get_the_author_meta('stm_user_favourites', $user->ID);

		if(!empty($my_fav)) {
			$my_fav = count(array_filter(explode(',', $my_fav)));
		} else {
			$my_fav = 0;
		}

	?>

	<div class="lOffer-account-dropdown">
		<a href="<?php echo esc_url(add_query_arg(array('my_settings' => 1), stm_get_author_link(''))); ?>" class="settings">
			<i class="stm-settings-icon stm-service-icon-cog"></i>
		</a>
		<div class="name">
			<a href="<?php echo esc_url(stm_get_author_link('')); ?>"><?php echo esc_attr(stm_display_user_name($user->ID)); ?></a>
		</div>
		<ul class="account-list">
			<li><a href="<?php echo esc_url(stm_get_author_link('')); ?>"><?php esc_html_e('My items', 'motors'); ?> (<span><?php echo esc_attr($my_offers); ?></span>)</a></li>
			<li class="stm-my-favourites"><a href="<?php echo esc_url(add_query_arg(array('my_favourites' => 1), stm_get_author_link(''))); ?>"><?php esc_html_e('Favorites', 'motors'); ?> (<span><?php echo esc_attr($my_fav); ?></span>)</a></li>
		</ul>
		<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="logout">
			<i class="fa fa-power-off"></i><?php esc_html_e('Logout', 'motors'); ?>
		</a>
	</div>

	<?php endif; ?>

<?php else :?>
	<div class="lOffer-account-dropdown stm-login-form-unregistered">
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
<?php endif; ?>