<?php
$regular_price_label = get_post_meta(get_the_ID(), 'regular_price_label', true);
$special_price_label = get_post_meta(get_the_ID(),'special_price_label',true);

$price = get_post_meta(get_the_id(),'price',true);
$sale_price = get_post_meta(get_the_id(),'sale_price',true);

$car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true);

$data_price = '0';

if(!empty($price)) {
	$data_price = $price;
}

if(!empty($sale_price)) {
	$data_price = $sale_price;
}

if(empty($price) and !empty($sale_price)) {
	$price = $sale_price;
}

$mileage = get_post_meta(get_the_id(),'mileage',true);

$data_mileage = '0';

if(!empty($mileage)) {
	$data_mileage = $mileage;
}

$taxonomies = stm_get_taxonomies();

$categories = wp_get_post_terms(get_the_ID(), $taxonomies);

$classes = array();

if(!empty($categories)) {
	foreach($categories as $category) {
		$classes[] = $category->slug.'-'.$category->term_id;
	}
}


$show_compare = get_theme_mod( 'show_listing_compare', true );

$cars_in_compare = array();
if ( ! empty( $_COOKIE['compare_ids'] ) ) {
	$cars_in_compare = $_COOKIE['compare_ids'];
}

$car_already_added_to_compare = '';
$car_compare_status           = esc_html__( 'Add to compare', 'motors' );

if ( ! empty( $cars_in_compare ) and in_array( get_the_ID(), $cars_in_compare ) ) {
	$car_already_added_to_compare = 'active';
	$car_compare_status           = esc_html__( 'Remove from compare', 'motors' );
}

$placeholder_path = 'moto-placeholders/moto-350.jpg';

$show_generated_title_as_label = get_theme_mod('show_generated_title_as_label', true);

$badge_text = get_post_meta(get_the_ID(),'badge_text',true);
$badge_bg_color = get_post_meta(get_the_ID(),'badge_bg_color',true);
?>

<div
	class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 stm-isotope-listing-item stm_moto_single_grid_item all <?php print_r(implode(' ', $classes)); ?>"
	data-price="<?php echo esc_attr($data_price) ?>"
	data-date="<?php echo get_the_date('Ymdhi') ?>"
	data-mileage="<?php echo esc_attr($data_mileage); ?>"
	>
	<a href="<?php echo esc_url(get_the_permalink()); ?>" class="rmv_txt_drctn">
		<div class="image">
			<?php if(!empty($badge_text)): ?>
				<?php

				$badge_style = '';
				if(!empty($badge_bg_color)) {
					$badge_style = 'style=background-color:'.$badge_bg_color.';';
				}
				?>
				<div class="special-label special-label-small h6" <?php echo esc_attr($badge_style); ?>>
					<?php echo esc_html__($badge_text, 'motors'); ?>
				</div>
			<?php endif; ?>
			<?php if(has_post_thumbnail()): ?>
				<?php
				$img_placeholder = $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-350-205');
				?>
				<img
					data-original="<?php echo esc_url($img[0]); ?>"
					src="<?php echo esc_url(get_template_directory_uri().'/assets/images/'.$placeholder_path); ?>"
					class="lazy img-responsive"
				    alt="<?php echo stm_generate_title_from_slugs(get_the_id()); ?>"
					/>
			<?php else: ?>
				<img
					src="<?php echo esc_url(get_template_directory_uri().'/assets/images/'.$placeholder_path); ?>"
					class="img-responsive"
					alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
					/>
			<?php endif; ?>
			<div class="stm_moto_hover_unit">

				<!--Compare-->
				<?php if(!empty($show_compare) and $show_compare): ?>
					<div
						class="stm-listing-compare heading-font stm-compare-directory-new <?php echo esc_attr($car_already_added_to_compare); ?>"
						data-id="<?php echo esc_attr(get_the_id()); ?>"
						data-title="<?php echo stm_generate_title_from_slugs(get_the_id(),false); ?>"
						>
						<i class="stm-service-icon-compare-new"></i>
						<?php esc_html_e('Compare', 'motors'); ?>
					</div>
				<?php endif; ?>
				<?php stm_get_boats_image_hover(get_the_ID()); ?>
				<div class="heading-font">
					<?php if(!empty($price) and !empty($sale_price) and $price != $sale_price):?>
						<div class="price discounted-price">
							<div class="regular-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
							<div class="sale-price"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></div>
						</div>
					<?php elseif(!empty($price)): ?>
						<div class="price">
							<?php if(!empty($car_price_form_label)): ?>
								<div class="normal-price"><?php echo esc_attr($car_price_form_label); ?></div>
							<?php else: ?>
								<div class="normal-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<div class="car-title">
					<?php echo stm_generate_title_from_slugs(get_the_id(), true); ?>
				</div>
			</div>

			<?php $labels = stm_get_car_listings(); ?>
			<?php if(!empty($labels)): ?>
				<div class="car-meta-bottom">
					<ul>
						<?php foreach($labels as $label): ?>
							<?php $label_meta = get_post_meta(get_the_id(),$label['slug'],true); ?>
							<?php if(!empty($label_meta) and $label_meta != 'none' and $label['slug'] != 'price'): ?>
								<li>
									<?php if(!empty($label['font'])): ?>
										<i class="<?php echo esc_attr($label['font']) ?>"></i>
									<?php endif; ?>

									<span class="stm_label">
										<?php esc_html_e($label['single_name'], 'motors'); ?>:
									</span>
									
									<?php if(!empty($label['numeric']) and $label['numeric']): ?>
										<span><?php echo esc_attr($label_meta); ?></span>
									<?php else: ?>
										
										<?php 
											$data_meta_array = explode(',',$label_meta);
											$datas = array();
											
											if(!empty($data_meta_array)){
												foreach($data_meta_array as $data_meta_single) {
													$data_meta = get_term_by('slug', $data_meta_single, $label['slug']);
													if(!empty($data_meta->name)) {
														$datas[] = esc_attr($data_meta->name);
													}
												}
											}
										?>

										<?php if(!empty($datas)): ?>
											
											<?php 
												if(count($datas) > 1) { ?>
													
													<span 
														class="stm-tooltip-link" 
														data-toggle="tooltip"
														data-placement="bottom"
														title="<?php echo esc_attr(implode(', ', $datas)); ?>">
														<?php echo $datas[0].'<span class="stm-dots dots-aligned">...</span>'; ?>
													</span>

												<?php } else { ?>
													<span><?php echo implode(', ', $datas); ?></span>
												<?php }
											?>
										<?php endif; ?>
										
									<?php endif; ?>

									<?php if(!empty($label['number_field_affix'])): ?>
										<span><?php esc_html_e($label['number_field_affix'], 'motors'); ?></span>
									<?php endif; ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

		</div>
	</a>
</div>