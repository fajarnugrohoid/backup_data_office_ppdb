<?php $logo_main = get_theme_mod('logo', get_template_directory_uri() . '/assets/images/tmp/logo-boats.png'); ?>

<div class="stm-boats-mobile-header">
	<?php if(empty($logo_main)): ?>
		<a class="blogname" href="<?php echo esc_url(home_url('/')); ?>" title="<?php _e('Home', 'motors'); ?>">
			<h1><?php echo esc_attr(get_bloginfo('name')) ?></h1>
		</a>
	<?php else: ?>
		<a class="bloglogo" href="<?php echo esc_url(home_url('/')); ?>">
			<img
				src="<?php echo esc_url( $logo_main ); ?>"
				style="width: <?php echo get_theme_mod( 'logo_width', '160' ); ?>px;"
				title="<?php _e('Home', 'motors'); ?>"
				alt="<?php esc_html_e('Logo', 'motors'); ?>"
				/>
		</a>
	<?php endif; ?>

	<div class="stm-menu-boats-trigger">
		<span></span>
		<span></span>
		<span></span>
	</div>
</div>

<div class="stm-boats-mobile-menu">
	<div class="inner">
		<div class="inner-content">
			<ul class="listing-menu heading-font clearfix">
				<?php
				wp_nav_menu( array(
						'menu'              => 'primary',
						'theme_location'    => 'primary',
						'depth'             => 3,
						'container'         => false,
						'menu_class'        => 'service-header-menu clearfix',
						'items_wrap'        => '%3$s',
						'fallback_cb' => false
					)
				);
				?>
			</ul>
			<?php get_template_part('partials/top-bar-boats', 'mobile'); ?>
		</div>
	</div>
</div>