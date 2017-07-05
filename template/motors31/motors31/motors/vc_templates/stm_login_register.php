<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if(!empty($link)) {
	$link = vc_build_link( $link );
}
?>

<div class="stm-login-register-form <?php echo esc_attr($css_class); ?>">
	<?php if(!empty($_GET['user_id']) and !empty($_GET['hash_check'])): ?>
		<?php get_template_part('partials/user/private/password', 'recovery'); ?>
	<?php endif; ?>


	<div class="row">

		<div class="col-md-4">
			<h3><?php esc_html_e('Sign In', 'motors'); ?></h3>
			<div class="stm-login-form">
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
						<div class="stm-forgot-password">
							<a href="#">
								<?php esc_html_e('Forgot Password', 'motors'); ?>
							</a>
						</div>
					</div>
					<input type="submit" value="<?php esc_html_e('Login', 'motors'); ?>"/>
					<span class="stm-listing-loader"><i class="stm-icon-load1"></i></span>
					<div class="stm-validation-message"></div>
				</form>
				<form method="post" class="stm_forgot_password_send">
					<div class="form-group">
						<h4><?php esc_html_e('Login or E-mail', 'motors'); ?></h4>
						<input type="hidden" name="stm_link_send_to" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>" readonly/>
						<input type="text" name="stm_user_login" placeholder="<?php esc_html_e('Enter login or E-mail', 'motors') ?>"/>
						<input type="submit" value="<?php esc_html_e('Send password', 'motors'); ?>"/>
						<span class="stm-listing-loader"><i class="stm-icon-load1"></i></span>
						<div class="stm-validation-message"></div>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-8">
			<h3><?php esc_html_e('Sign Up', 'motors'); ?></h3>
			<div class="stm-register-form">
				<form method="post">

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

					<div class="form-group form-group-submit clearfix">
						<?php
						$has_captcha = '';
						$recaptcha_enabled = get_theme_mod('enable_recaptcha',0);
						$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
						$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
						if(!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)):
							?>
							<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
							<div class="g-recaptcha" data-sitekey="<?php echo esc_attr($recaptcha_public_key); ?>" data-size="normal"></div>
							<?php $has_captcha = 'cptch_nbld'; ?>
						<?php endif; ?>
						<input class="<?php echo esc_attr($has_captcha); ?>" type="submit" value="<?php esc_html_e('Sign up now!', 'motors'); ?>" disabled/>
						<span class="stm-listing-loader"><i class="stm-icon-load1"></i></span>
					</div>

					<div class="stm-validation-message"></div>

				</form>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var $= jQuery;
		$('.stm-show-password .fa').mousedown(function(){
			$(this).closest('.stm-show-password').find('input').attr('type', 'text');
			$(this).addClass('fa-eye');
			$(this).removeClass('fa-eye-slash');
		});

		$(document).mouseup(function(){
			$('.stm-show-password').find('input').attr('type', 'password');
			$('.stm-show-password .fa').addClass('fa-eye-slash');
			$('.stm-show-password .fa').removeClass('fa-eye');
		});
	});
</script>