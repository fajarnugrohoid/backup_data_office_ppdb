<?php

if(empty($_COOKIE['compare_ids'])) {
	$_COOKIE['compare_ids'] = array();
}
$compare_page = get_theme_mod( 'compare_page', 156 );

//Get archive shop page id
if( function_exists('WC')) {
	$woocommerce_shop_page_id = WC()->cart->get_cart_url();
}

//Get page option
$transparent_header = get_post_meta(get_the_id(), 'transparent_header', true);
$transparent_header_class = 'header-nav-default';

if(!empty($transparent_header) and $transparent_header == 'on') {
	$transparent_header_class = 'header-nav-transparent';
} else {
	$transparent_header_class = 'header-nav-default';
}

$fixed_header = get_theme_mod('header_sticky', true);
if(!empty($fixed_header) and $fixed_header) {
	$fixed_header_class = 'header-nav-fixed';
} else {
	$fixed_header_class = '';
}
?>

<div id="header-nav-holder" class="hidden-sm hidden-xs">
	<div class="header-nav <?php echo esc_attr($transparent_header_class.' '.$fixed_header_class); ?>">
		<div class="container">
			<div class="header-help-bar-trigger">
				<i class="fa fa-chevron-down"></i>
			</div>
			<div class="header-help-bar">
				<ul>
					<?php if(!empty($compare_page)): ?>
						<li class="help-bar-compare">
							<a
							href="<?php echo esc_url(get_the_permalink($compare_page)); ?>"
							title="<?php esc_html_e('Watch compared', 'motors'); ?>">
								<span class="list-label heading-font"><?php esc_html_e('Compare', 'motors'); ?></span>
								<i class="list-icon stm-icon-speedometr2"></i>
								<span class="list-badge"><span class="stm-current-cars-in-compare"><?php if(count($_COOKIE['compare_ids'])){ echo esc_attr(count($_COOKIE['compare_ids'])); } ?></span></span>
							</a>
						</li>
					<?php endif; ?>


					<?php if(!empty($woocommerce_shop_page_id)): ?>
						<?php $items = WC()->cart->cart_contents_count; ?>
						<!--Shop archive-->
						<li class="help-bar-shop">
							<a
							href="<?php echo esc_url($woocommerce_shop_page_id); ?>"
							title="<?php esc_html_e('Watch shop items', 'motors'); ?>"
							>
								<span class="list-label heading-font"><?php esc_html_e('Cart', 'motors'); ?></span>
								<i class="list-icon stm-icon-shop_bag"></i>
								<span class="list-badge"><span class="stm-current-items-in-cart"><?php if($items != 0) { echo esc_attr($items); } ?></span></span>
							</a>
						</li>
					<?php endif; ?>
					<!--Live chat-->
					<li class="help-bar-live-chat">
						<a
							id="chat-widget"
							title="<?php esc_html_e('Open Live Chat', 'motors'); ?>"
							>
							<span class="list-label heading-font"><?php esc_html_e('Live chat', 'motors'); ?></span>
							<i class="list-icon stm-icon-chat2"></i>
						</a>
					</li>

					<li class="nav-search">
						<a href="" data-toggle="modal" data-target="#searchModal"><i class="stm-icon-search"></i></a>
					</li>
				</ul>
			</div>
			<div class="main-menu">
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