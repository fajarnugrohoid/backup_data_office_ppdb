<?php
if(function_exists('icl_get_languages')) {
	$langs = icl_get_languages( 'skip_missing=1&orderby=id&order=asc' );
}

$logo_main = get_theme_mod('logo', get_template_directory_uri() . '/assets/images/tmp/logo.png');

$header_main_phone = get_theme_mod('header_main_phone','888-694-5544');

?>



<div class="stm_motorcycle-header">
	<div class="stm_mc-main header-main">
		<div class="container clearfix">
			<div class="left">
				<div class="clearfix">
					<?php if(!empty($langs)) {
						stm_display_wpml_switcher( $langs );
					} ?>

					<!--Socials-->
					<?php $socials = stm_get_header_socials('header_socials_enable');
					if(!empty($socials)): ?>
						<div class="pull-left">
							<div class="header-main-socs">
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
						</div>
					<?php endif; ?>

				</div>

			</div>
			<div class="right">

					<?php if(empty($logo_main)): ?>
						<a class="blogname hidden-xs" href="<?php echo esc_url(home_url('/')); ?>" title="<?php _e('Home', 'motors'); ?>">
							<h1><?php echo esc_attr(get_bloginfo('name')) ?></h1>
						</a>
					<?php else: ?>
						<a class="bloglogo hidden-xs" href="<?php echo esc_url(home_url('/')); ?>">
							<img
								src="<?php echo esc_url( $logo_main ); ?>"
								style="width: <?php echo get_theme_mod( 'logo_width', '138' ); ?>px;"
								title="<?php _e('Home', 'motors'); ?>"
								alt="<?php esc_html_e('Logo', 'motors'); ?>"
								/>
						</a>
					<?php endif; ?>

				<div class="right-right">
					<div class="clearfix">

						<div class="pull-right">
							<?php get_template_part('partials/top-bar', 'menu'); ?>
						</div>

						<?php if(!empty($header_main_phone)): ?>
							<div class="pull-right">
								<div class="header-main-phone heading-font">
									<div class="phone">
										<span class="phone-number heading-font"><a href="tel:<?php echo preg_replace('/\s/', '', $header_main_phone); ?>"><?php printf(esc_html__( '%s', 'motors' ), $header_main_phone ); ?></a></span>
									</div>
								</div>
							</div>
						<?php endif; ?>

					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="stm_mc-nav">
		<div class="hidden-lg hidden-md hidden-sm visible-xs">
			<?php if(empty($logo_main)): ?>
				<a class="blogname" href="<?php echo esc_url(home_url('/')); ?>" title="<?php _e('Home', 'motors'); ?>">
					<h1><?php echo esc_attr(get_bloginfo('name')) ?></h1>
				</a>
			<?php else: ?>
				<a class="bloglogo" href="<?php echo esc_url(home_url('/')); ?>">
					<img
						src="<?php echo esc_url( $logo_main ); ?>"
						style="width: <?php echo get_theme_mod( 'logo_width', '138' ); ?>px;"
						title="<?php _e('Home', 'motors'); ?>"
						alt="<?php esc_html_e('Logo', 'motors'); ?>"
						/>
				</a>
			<?php endif; ?>
		</div>
		<div class="mobile-menu-trigger hidden-lg hidden-md hidden-sm visible-xs">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="main-menu hidden-xs">
			<div class="container">
				<div class="inner">
					<ul class="header-menu clearfix">
						<?php
						wp_nav_menu( array(
								'menu'              => 'primary',
								'theme_location'    => 'primary',
								'depth'             => 5,
								'container'         => false,
								'menu_class'        => 'header-menu clearfix',
								'items_wrap'        => '%3$s',
								'fallback_cb' => false
							)
						);
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="hidden-lg hidden-md hidden-sm visible-xs">
			<div class="main-menu mobile-menu-holder">
				<div class="container">
					<div class="inner">
						<ul class="header-menu clearfix">
							<?php
							wp_nav_menu( array(
									'menu'              => 'primary',
									'theme_location'    => 'primary',
									'depth'             => 5,
									'container'         => false,
									'menu_class'        => 'header-menu clearfix',
									'items_wrap'        => '%3$s',
									'fallback_cb' => false
								)
							);
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>