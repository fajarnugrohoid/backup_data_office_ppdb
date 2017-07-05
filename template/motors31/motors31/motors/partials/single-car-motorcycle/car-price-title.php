<?php
$price = get_post_meta(get_the_ID(), 'price', true);
$sale_price = get_post_meta(get_the_ID(), 'sale_price', true);
$car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true);

$regular_price_label = get_post_meta(get_the_ID(), 'regular_price_label', true);
$special_price_label = get_post_meta(get_the_ID(), 'special_price_label', true);
?>

<div class="stm-listing-single-price-title heading-font clearfix">
	<?php if(!empty($price)): ?>
		<?php if(!empty($car_price_form_label)): ?>
			<div class="price">
				<div class="inner">
					<?php echo esc_attr($car_price_form_label); ?>
				</div>
			</div>
		<?php else: ?>
			<div class="price_unit">
				<?php if(!empty($sale_price)): ?>
					<div class="sale-price">
						<div class="inner">
							<?php if(!empty($special_price_label)): ?>
								<div class="stm_label"><?php echo esc_attr($special_price_label); ?></div>
							<?php endif; ?>
							<del><?php echo stm_listing_price_view($sale_price); ?></del>
						</div>
					</div>
				<?php endif; ?>
				<div class="price">
					<div class="inner">
						<?php if(!empty($regular_price_label)): ?>
							<div class="stm_label"><?php echo esc_attr($regular_price_label); ?></div>
						<?php endif; ?>
						<?php echo stm_listing_price_view($price); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<div class="title">
		<?php echo stm_generate_title_from_slugs(get_the_ID(), true); ?>
	</div>
</div>