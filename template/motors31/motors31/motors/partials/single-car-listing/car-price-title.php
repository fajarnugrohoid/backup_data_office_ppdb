<?php
$price = get_post_meta(get_the_ID(), 'price', true);
$sale_price = get_post_meta(get_the_ID(), 'sale_price', true);
$car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true);

if(empty($price) and !empty($sale_price)) {
	$price = $sale_price;
}

if(!empty($price) and !empty($sale_price)) {
	$price = $sale_price;
}
?>

<div class="stm-listing-single-price-title heading-font clearfix">
	<?php if(!empty($price)): ?>
		<?php if(!empty($car_price_form_label)): ?>
			<div class="price"><?php echo esc_attr($car_price_form_label); ?></div>
		<?php else: ?>
			<div class="price"><?php echo stm_listing_price_view($price); ?></div>
		<?php endif; ?>
	<?php endif; ?>
	<div class="title">
		<?php echo stm_generate_title_from_slugs(get_the_ID(), get_theme_mod('show_generated_title_as_label', false)); ?>
	</div>
</div>