<?php $logo_main = get_theme_mod('logo', get_template_directory_uri() . '/assets/images/tmp/logo-boats.png');

$fixed_header = get_theme_mod('header_sticky', true);
if(!empty($fixed_header) and $fixed_header) {
	$fixed_header_class = 'header-listing-fixed';
} else {
	$fixed_header_class = '';
}

//Get archive shop page id
if( function_exists('WC')) {
	$woocommerce_shop_page_id = WC()->cart->get_cart_url();
}

$transparent_header = get_post_meta(get_the_id(), 'transparent_header', true);

if(empty($transparent_header)) {
	$transparent_header_class = 'listing-nontransparent-header';
} else {
	$transparent_header_class = '';
}

if(empty($_COOKIE['compare_ids'])) {
	$_COOKIE['compare_ids'] = array();
}

$compare_page = get_theme_mod( 'compare_page', 156 );

$shopping_cart_boats = get_theme_mod('shopping_cart_boats', true);

?>

<div class="header-listing <?php echo esc_attr($fixed_header_class.' '.$transparent_header_class); ?>">

	<div class="container header-inner-content">
		<!--Logo-->
		<div class="listing-logo-main">
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
		</div>

		<div class="listing-service-right clearfix">

			<div class="listing-right-actions">

				<?php if($shopping_cart_boats): ?>
					<div class="pull-right">
						<?php if(!empty($woocommerce_shop_page_id)): ?>
							<?php $items = WC()->cart->cart_contents_count; ?>
							<!--Shop archive-->
							<div class="help-bar-shop">
								<a
									href="<?php echo esc_url($woocommerce_shop_page_id); ?>"
									title="<?php esc_html_e('Watch shop items', 'motors'); ?>"
									>
									<i class="stm-boats-icon-cart"></i>
									<span class="list-badge"><span class="stm-current-items-in-cart"><?php echo esc_attr($items); ?></span></span>
								</a>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if(!empty($compare_page)): ?>
					<div class="pull-right">
						<a
							class="lOffer-compare"
							href="<?php echo esc_url(get_the_permalink($compare_page)); ?>"
							title="<?php esc_html_e('Watch compared', 'motors'); ?>">
							<span class="heading-font"><?php esc_html_e('Compare', 'motors'); ?></span>
							<i class="list-icon stm-boats-icon-compare-boats"></i>
							<span class="list-badge"><span class="stm-current-cars-in-compare"><?php if(!empty($_COOKIE['compare_ids']) and count($_COOKIE['compare_ids'])){ echo esc_attr(count($_COOKIE['compare_ids'])); } ?></span></span>
						</a>
					</div>
				<?php endif; ?>

			</div>

			<ul class="listing-menu clearfix">
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
		</div>
	</div>
</div>