<?php
$top_bar = get_theme_mod('top_bar_enable', true);
$top_bar_login = get_theme_mod('top_bar_login', true);
$top_bar_wpml_switcher = get_theme_mod('top_bar_wpml_switcher', true);


if(!empty($top_bar) and $top_bar):
?>

	<div id="top-bar">
		<div class="container">

			<?php if(function_exists('icl_get_languages')):
				$langs = icl_get_languages('skip_missing=1&orderby=id&order=asc');
			endif; ?>
				<div class="clearfix top-bar-wrapper">
				<!--LANGS-->
				<?php if(!empty($top_bar_wpml_switcher) and $top_bar_wpml_switcher): ?>
					<?php if(!empty($langs)): ?>
						<?php
						if(count($langs) > 1){
							$langs_exist = 'dropdown_toggle';
						} else {
							$langs_exist = 'no_other_langs';
						}
						?>
						<div class="pull-left language-switcher-unit">
							<div class="stm_current_language <?php echo esc_attr($langs_exist); ?>" <?php if(count($langs) > 1){ ?> id="lang_dropdown" data-toggle="dropdown" <?php } ?>><?php echo esc_attr(ICL_LANGUAGE_NAME); ?><?php if(count($langs) > 1){ ?><i class="fa fa-angle-down"></i><?php } ?></div>
							<?php if(count($langs) > 1): ?>
								<ul class="dropdown-menu lang_dropdown_menu" role="menu" aria-labelledby="lang_dropdown">
									<?php foreach($langs as $lang): ?>
										<?php if(!$lang['active']): ?>
											<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo esc_url($lang['url']); ?>"><?php echo esc_attr($lang['native_name']); ?></a></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>


				<div class="stm-boats-top-bar-right clearfix">

					<!-- Header Top bar Login -->
					<?php if(!empty($top_bar_login) and $top_bar_login): ?>
						<?php if(!stm_is_listing()): ?>
							<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ): ?>
								<div class="pull-right hidden-xs">
									<div class="header-login-url">
										<?php if(is_user_logged_in()): ?>
											<a class="logout-link" href="<?php echo esc_url(wp_logout_url(home_url())); ?>" title="<?php _e('Log out', 'motors'); ?>">
												<i class="stm-boats-icon-cap-hat"></i>
												<?php _e('Log out', 'motors'); ?>
											</a>
										<?php else: ?>
											<a href="<?php echo esc_url(get_permalink( get_option( 'woocommerce_myaccount_page_id' ) )); ?>">
												<i class="stm-boats-icon-cap-hat"></i><span class="vt-top"><?php _e('Sign Up', 'motors'); ?></span>
											</a>
											<span class="vertical-divider"></span>
											<a href="<?php echo esc_url(get_permalink( get_option( 'woocommerce_myaccount_page_id' ) )); ?>"><?php _e('Login', 'motors'); ?></a>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php else: ?>
							<?php
								$login_page = get_theme_mod( 'login_page', 1718);
								if(function_exists('icl_object_id')) {
									$id   = icl_object_id( $login_page, 'page', false, ICL_LANGUAGE_CODE );
									if(is_page($id)) {
										$login_page = $id;
									}
								}
							?>
							<?php if ( !empty($login_page) ): ?>
								<div class="pull-right hidden-xs">
									<div class="header-login-url">
										<?php if(is_user_logged_in()): ?>
											<a class="logout-link" href="<?php echo esc_url(wp_logout_url(home_url())); ?>" title="<?php _e('Log out', 'motors'); ?>">
												<i class="fa fa-icon-stm_icon_user"></i>
												<?php _e('Log out', 'motors'); ?>
											</a>
										<?php else: ?>
											<a href="<?php echo esc_url(get_permalink( $login_page )); ?>">
												<i class="fa fa-user"></i><span class="vt-top"><?php _e('Login', 'motors'); ?></span>
											</a>
											<span class="vertical-divider"></span>
											<a href="<?php echo esc_url(get_permalink( $login_page )); ?>"><?php _e('Register', 'motors'); ?></a>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>

					<div class="stm-boats-top-bar-centered clearfix">

						<?php
						$top_bar_address = get_theme_mod( 'top_bar_address', '1010 Moon ave, New York, NY US' );
						$top_bar_address_mobile = get_theme_mod( 'top_bar_address_mobile', true );

						$top_bar_working_hours = get_theme_mod( 'top_bar_working_hours', 'Mon - Sat 8.00 - 18.00' );
						$top_bar_working_hours_mobile = get_theme_mod( 'top_bar_working_hours_mobile', true );

						$top_bar_phone = get_theme_mod( 'top_bar_phone', '+1 212-226-3126' );
						$top_bar_phone_mobile = get_theme_mod( 'top_bar_phone_mobile', true );

						$top_bar_menu = get_theme_mod('top_bar_menu', false);

						if( $top_bar_menu ): ?>
							<div class="top_bar_menu">
								<?php get_template_part('partials/top-bar', 'menu'); ?>
							</div>
						<?php endif;

						if( $top_bar_address || $top_bar_working_hours || $top_bar_phone ): ?>
							<ul class="top-bar-info clearfix">
								<?php if( $top_bar_working_hours ){ ?>
									<li <?php if(!$top_bar_working_hours_mobile){ ?>class="hidden-info"<?php } ?>><i class="fa fa-calendar-check-o"></i> <?php printf(esc_html__( '%s', 'motors' ), $top_bar_working_hours ); ?></li>
								<?php } ?>
								<?php if( $top_bar_address ){ ?>
									<?php $header_address_url = get_theme_mod('header_address_url'); ?>
									<li <?php if(!$top_bar_address_mobile){ ?>class="hidden-info"<?php } ?>>
										<span class="fancy-iframe" data-url="<?php echo esc_url($header_address_url); ?>">
											<i class="fa fa-map-marker"></i> <?php printf(esc_html__( '%s', 'motors' ),$top_bar_address ); ?>
										</span>
									</li>
								<?php } ?>
								<?php if( $top_bar_phone ){ ?>
									<li <?php if(!$top_bar_phone_mobile){ ?>class="hidden-info"<?php } ?>><i class="fa fa-phone"></i> <?php printf(esc_html__( '%s', 'motors' ),$top_bar_phone ); ?></li>
								<?php } ?>
							</ul>
						<?php endif; ?>

						<?php $socials = stm_get_header_socials('top_bar_socials_enable'); ?>
						<!-- Header top bar Socials -->
						<?php if( !empty($socials) ): ?>
							<div class="header-top-bar-socs">
								<ul class="clearfix">
									<?php foreach ( $socials as $key => $val ): ?>
										<li>
											<a href="<?php echo esc_url($val) ?>">
												<i class="fa fa-<?php echo esc_attr($key); ?>"></i>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

					</div>
				</div>

			</div>
		</div>
	</div>

<?php endif; ?>