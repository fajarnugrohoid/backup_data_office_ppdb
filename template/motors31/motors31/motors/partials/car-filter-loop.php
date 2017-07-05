<?php $car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true); ?>

<?php
//Compare
if(stm_is_boats()) {
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

	$placeholder_path = 'plchldr255.png';
	if(stm_is_boats()){
		$placeholder_path = 'boats-placeholders/boats-250.png';
	}
}
?>
	
<div class="col-md-3 col-sm-4 col-xs-12 col-xxs-12 stm-template-front-loop">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn xx">
		<div class="image">
			<?php if(has_post_thumbnail()): ?>
				<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-255-135'); ?>
				<?php $img_2x = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-796-466'); ?>
				<?php echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'stm-img-255-135', false, array( 'data-retina' => $img_2x[0], 'alt' => get_the_title() ) ); ?>
			<?php else: ?>
				<?php if(stm_check_if_car_imported(get_the_id())): ?>
					<img
						src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/automanager_placeholders/plchldr255automanager.png'); ?>"
						class="img-responsive"
						alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
						/>
				<?php else: ?>
					<img
						src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/plchldr255.png'); ?>"
						class="img-responsive"
						alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
						/>
				<?php endif; ?>
			<?php endif; ?>
			<?php if(stm_is_boats()){
				stm_get_boats_image_hover(get_the_ID()); ?>
				<!--Compare-->
				<?php if(!empty($show_compare) and $show_compare): ?>
					<div
						class="stm-listing-compare stm-compare-directory-new <?php echo esc_attr($car_already_added_to_compare); ?>"
						data-id="<?php echo esc_attr(get_the_id()); ?>"
						data-title="<?php echo stm_generate_title_from_slugs(get_the_id(),false); ?>"
						data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr($car_compare_status); ?>"
						>
						<i class="stm-boats-icon-add-to-compare"></i>
					</div>
				<?php endif;
			} ?>
		</div>
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<?php $price = get_post_meta(get_the_id(),'price',true);
				$sale_price = get_post_meta(get_the_id(),'sale_price',true);
				if(empty($price) and !empty($sale_price)) {
					$price = $sale_price;
				}
				?>
				<?php if(!empty($car_price_form_label)): ?>
					<div class="price">
							<div class="normal-price"><?php echo esc_attr($car_price_form_label); ?></div>
						</div>
				<?php else: ?>
					<?php if(!empty($price) and !empty($sale_price) and $price != $sale_price):?>
						<div class="price discounted-price">
							<div class="regular-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
							<div class="sale-price"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></div>
						</div>
					<?php elseif(!empty($price)): ?>
						<div class="price">
							<div class="normal-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="car-title">
					<?php echo esc_attr(trim(preg_replace( '/\s+/', ' ', substr(stm_generate_title_from_slugs(get_the_id()), 0, 35) ))); ?>
					<?php if(strlen(stm_generate_title_from_slugs(get_the_id())) > 35){
						echo esc_attr('...');
					} ?>
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
							</li>
						<?php endif; ?>
						
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

		</div>
	</a>
</div>