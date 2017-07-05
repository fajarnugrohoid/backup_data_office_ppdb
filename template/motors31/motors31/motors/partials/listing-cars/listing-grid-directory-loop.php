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

//Fav

$cars_in_favourite = array();
if(!empty($_COOKIE['stm_car_favourites'])) {
	$cars_in_favourite = $_COOKIE['stm_car_favourites'];
	$cars_in_favourite = explode(',', $cars_in_favourite);
}

if(is_user_logged_in()) {
	$user = wp_get_current_user();
	$user_id = $user->ID;
	$user_added_fav = get_the_author_meta('stm_user_favourites', $user_id );
	if(!empty($user_added_fav)) {
		$user_added_fav = explode(',', $user_added_fav);
		$cars_in_favourite = $user_added_fav;
	}
}

$car_already_added_to_favourite = '';
$car_favourite_status = esc_html__('Add to favorites', 'motors');

if(!empty($cars_in_favourite) and in_array(get_the_ID(), $cars_in_favourite)){
	$car_already_added_to_favourite = 'active';
	$car_favourite_status = esc_html__('Remove from favorites', 'motors');
}

$show_favorite = get_theme_mod('enable_favorite_items', true);

//Compare
$show_compare = get_theme_mod('show_listing_compare', true);

$cars_in_compare = array();
if(!empty($_COOKIE['compare_ids'])) {
	$cars_in_compare = $_COOKIE['compare_ids'];
}

$car_already_added_to_compare = '';
$car_compare_status = esc_html__('Add to compare', 'motors');

if(!empty($cars_in_compare) and in_array(get_the_ID(), $cars_in_compare)){
	$car_already_added_to_compare = 'active';
	$car_compare_status = esc_html__('Remove from compare', 'motors');
}

/*Media*/
$car_media = stm_get_car_medias(get_the_id());
?>

<div
	class="col-md-4 col-sm-4 col-xs-12 col-xxs-12 stm-directory-grid-loop stm-isotope-listing-item all <?php print_r(implode(' ', $classes)); ?>"
	data-price="<?php echo esc_attr($data_price) ?>"
	data-date="<?php echo get_the_date('Ymdhi') ?>"
	data-mileage="<?php echo esc_attr($data_mileage); ?>"
	>
	<a href="<?php echo esc_url(get_the_permalink()); ?>" class="rmv_txt_drctn">
		<?php if(has_post_thumbnail()): ?>
			<div class="image">
				<?php
				$img_placeholder =
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-255-135');
				?>
				<img
					data-original="<?php echo esc_url($img[0]); ?>"
					src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/plchldr255.png'); ?>"
					class="lazy img-responsive"
					alt="<?php the_title(); ?>"
					/>

				<!--Hover blocks-->
				<?php get_template_part('partials/listing-cars/listing-directory', 'badges'); ?>
				<!---Media-->
				<div class="stm-car-medias">
					<?php if(!empty($car_media['car_photos_count'])): ?>
						<div class="stm-listing-photos-unit stm-car-photos-<?php echo get_the_id(); ?>">
							<i class="stm-service-icon-photo"></i>
							<span><?php echo $car_media['car_photos_count']; ?></span>
						</div>

						<script type="text/javascript">
							jQuery(document).ready(function(){

								jQuery(".stm-car-photos-<?php echo get_the_id(); ?>").click(function(e) {
									e.preventDefault();
									jQuery.fancybox.open([
										<?php foreach($car_media['car_photos'] as $car_photo): ?>
										{
											href  : "<?php echo esc_url($car_photo); ?>"
										},
										<?php endforeach; ?>
									], {
										padding: 0
									}); //open
								});
							});

						</script>
					<?php endif; ?>
					<?php if(!empty($car_media['car_videos_count'])): ?>
						<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_id(); ?>">
							<i class="fa fa-film"></i>
							<span><?php echo $car_media['car_videos_count']; ?></span>
						</div>

						<script type="text/javascript">
							jQuery(document).ready(function(){

								jQuery(".stm-car-videos-<?php echo get_the_id(); ?>").click(function(e) {
									e.preventDefault();
									jQuery.fancybox.open([
										<?php foreach($car_media['car_videos'] as $car_video): ?>
										{
											href  : "<?php echo esc_url($car_video); ?>"
										},
										<?php endforeach; ?>
									], {
										type: 'iframe',
										padding: 0
									}); //open
								}); //click
							}); //ready

						</script>
					<?php endif; ?>
				</div>

				<!--Favorite-->
				<?php if(!empty($show_favorite) and $show_favorite): ?>
					<div
						class="stm-listing-favorite <?php echo esc_attr($car_already_added_to_favourite); ?>"
						data-id="<?php echo esc_attr(get_the_id()); ?>"
						data-toggle="tooltip" data-placement="right" title="<?php echo esc_attr($car_favourite_status); ?>"
						>
						<i class="stm-service-icon-staricon"></i>
					</div>
				<?php endif; ?>

				<!--Compare-->
				<?php if(!empty($show_compare) and $show_compare): ?>
					<div
						class="stm-listing-compare stm-compare-directory-new <?php echo esc_attr($car_already_added_to_compare); ?>"
						data-id="<?php echo esc_attr(get_the_id()); ?>"
						data-title="<?php echo stm_generate_title_from_slugs(get_the_id(),false); ?>"
						data-toggle="tooltip" data-placement="left" title="<?php echo esc_attr($car_compare_status); ?>"
						>
						<i class="stm-service-icon-compare-new"></i>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<img
				src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/plchldr255.png'); ?>"
				class="img-responsive"
				alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
				/>
		<?php endif; ?>
		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
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
				<div class="car-title">
					<?php
					$show_title_two_params_as_labels = get_theme_mod('show_generated_title_as_label', true);
					if($show_title_two_params_as_labels) {
						echo stm_generate_title_from_slugs(get_the_id(),$show_title_two_params_as_labels);
					} else {
						echo esc_attr( trim( preg_replace( '/\s+/', ' ', substr( get_the_title(), 0, 35 ) ) ) );
						if ( strlen( get_the_title() ) > 35 ) {
							echo esc_attr( '...' );
						}
					}

					?>
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