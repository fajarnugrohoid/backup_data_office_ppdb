<?php
if (!function_exists('stm_add_a_car_registration')) {
	function stm_add_a_car_registration($user_title='', $user_text='', $link=array()) { ?>

		<div class="stm-user-registration-unit">
			<div class="clearfix stm_register_title">
				<h3><?php esc_html_e('Sign Up', 'motors'); ?></h3>
				<div class="stm_login_me"><?php esc_html_e('Already Registered? Members','motors'); ?>
					<a href="#"><?php esc_html_e('Login Here','motors'); ?></a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-3 col-md-push-9 col-sm-push-9 col-xs-push-0">
					<div class="heading-font stm-title"><?php echo esc_attr($user_title); ?></div>
					<div class="stm-text"><?php echo esc_attr($user_text); ?></div>
				</div>

				<div class="col-md-9 col-sm-9 col-md-pull-3 col-sm-pull-3 col-xs-pull-0">
					<div class="stm-login-register-form">
						<div class="stm-register-form">
							<form method="post">
								<input type="hidden" name="redirect" value="disable">

								<div class="row form-group">
									<div class="col-md-6">
										<h4><?php esc_html_e('First Name', 'motors'); ?></h4>
										<input class="user_validated_field" type="text" name="stm_user_first_name" placeholder="<?php esc_html_e('Enter First name', 'motors') ?>"/>
									</div>
									<div class="col-md-6">
										<h4><?php esc_html_e('Last Name', 'motors'); ?></h4>
										<input class="user_validated_field" type="text" name="stm_user_last_name" placeholder="<?php esc_html_e('Enter Last name', 'motors') ?>"/>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-6">
										<h4><?php esc_html_e('Phone number', 'motors'); ?></h4>
										<input class="user_validated_field" type="tel" name="stm_user_phone" placeholder="<?php esc_html_e('Enter Phone', 'motors') ?>"/>
									</div>
									<div class="col-md-6">
										<h4><?php esc_html_e('Email *', 'motors'); ?></h4>
										<input class="user_validated_field" type="email" name="stm_user_mail" placeholder="<?php esc_html_e('Enter E-mail', 'motors') ?>"/>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-6">
										<h4><?php esc_html_e('Login *', 'motors'); ?></h4>
										<input class="user_validated_field" type="text" name="stm_nickname" placeholder="<?php esc_html_e('Enter Login', 'motors') ?>"/>
									</div>
									<div class="col-md-6">
										<h4><?php esc_html_e('Password *', 'motors'); ?></h4>
										<div class="stm-show-password">
											<i class="fa fa-eye-slash"></i>
											<input class="user_validated_field" type="password" name="stm_user_password"  placeholder="<?php esc_html_e('Enter Password', 'motors') ?>"/>
										</div>
									</div>
								</div>

								<div class="form-group form-checker">
									<label>
										<input type="checkbox" name="stm_accept_terms" />
									<span>
										<?php esc_html_e('I accept the terms of the', 'motors'); ?>
										<?php if(!empty($link) and !empty($link['url'])): ?>
											<a href="<?php echo esc_url($link['url']); ?>"><?php esc_html_e('Membership Agreement', 'motors') ?></a>
										<?php endif; ?>
									</span>
									</label>
								</div>

								<div class="form-group form-group-submit">
									<input type="submit" value="<?php esc_html_e('Sign up now!', 'motors'); ?>" disabled/>
									<span class="stm-listing-loader"><i class="stm-icon-load1"></i></span>
								</div>

								<div class="stm-validation-message"></div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function () {
				var $ = jQuery;
				$('.stm-show-password .fa').mousedown(function () {
					$(this).closest('.stm-show-password').find('input').attr('type', 'text');
					$(this).addClass('fa-eye');
					$(this).removeClass('fa-eye-slash');
				});

				$(document).mouseup(function () {
					$('.stm-show-password').find('input').attr('type', 'password');
					$('.stm-show-password .fa').addClass('fa-eye-slash');
					$('.stm-show-password .fa').removeClass('fa-eye');
				});
			});
		</script>

	<?php }
}

if (!function_exists('stm_add_a_car_user_info')) {
	function stm_add_a_car_user_info($user_login='', $f_name='', $l_name='', $user_id = '') {
		$user = stm_get_user_custom_fields($user_id);
		if(!is_wp_error($user)) {
			$dealer = stm_get_user_role($user['user_id']);
			if($dealer): ?>
				<?php
					$ratings = stm_get_dealer_marks($user_id);
				?>
				<div class="stm-add-a-car-user">
					<div class="clearfix">
						<div class="left-info left-dealer-info">
							<div class="stm-dealer-image-custom-view">
								<?php if(!empty($user['logo'])): ?>
									<img src="<?php echo esc_url($user['logo']); ?>" />
								<?php else: ?>
									<img src="<?php stm_get_dealer_logo_placeholder(); ?>" />
								<?php endif; ?>
							</div>
							<h4><?php stm_display_user_name($user['user_id'], $user_login, $f_name, $l_name); ?></h4>

							<?php if(!empty($ratings['average'])): ?>
								<div class="stm-star-rating">
									<div class="inner">
										<div class="stm-star-rating-upper" style="width:<?php echo esc_attr($ratings['average_width']); ?>"></div>
										<div class="stm-star-rating-lower"></div>
									</div>
									<div class="heading-font"><?php echo $ratings['average']; ?></div>
								</div>
							<?php endif; ?>

						</div>

						<div class="right-info">

							<a target="_blank" href="<?php echo esc_url(add_query_arg(array('view-myself'=>1), get_author_posts_url($user_id))); ?>">
								<i class="fa fa-external-link"></i><?php esc_html_e('Show my Public Profile', 'motors'); ?>
							</a>

							<div class="stm_logout">
								<a href="#"><?php esc_html_e('Log out', 'motors'); ?></a>
								<?php esc_html_e('to choose a different account', 'motors'); ?>
							</div>

						</div>

					</div>
				</div>
			<?php else: ?>
				<div class="stm-add-a-car-user">
					<div class="clearfix">
						<div class="left-info">
							<div class="avatar">
								<?php if(!empty($user['image'])): ?>
									<img src="<?php echo esc_url($user['image']); ?>" />
								<?php else: ?>
									<i class="stm-service-icon-user"></i>
								<?php endif; ?>
							</div>
							<div class="user-info">
								<h4><?php stm_display_user_name($user['user_id'], $user_login, $f_name, $l_name); ?></h4>
								<div class="stm-label"><?php esc_html_e('Private Seller', 'motors'); ?></div>
							</div>
						</div>

						<div class="right-info">

							<a target="_blank" href="<?php echo esc_url(add_query_arg(array('view-myself'=>1), get_author_posts_url($user_id))); ?>">
								<i class="fa fa-external-link"></i><?php esc_html_e('Show my Public Profile', 'motors'); ?>
							</a>

							<div class="stm_logout">
								<a href="#"><?php esc_html_e('Log out', 'motors'); ?></a>
								<?php esc_html_e('to choose a different account', 'motors'); ?>
							</div>

						</div>

					</div>
				</div>
			<?php endif;
		}
	}
}