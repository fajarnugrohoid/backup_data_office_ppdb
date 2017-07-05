<?php
$regular_price_label = get_post_meta(get_the_ID(), 'regular_price_label', true);
$special_price_label = get_post_meta(get_the_ID(),'special_price_label',true);

$badge_text = get_post_meta(get_the_ID(),'badge_text',true);
$badge_bg_color = get_post_meta(get_the_ID(),'badge_bg_color',true);

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

$mileage = get_post_meta(get_the_id(),'mileage',true);

$data_mileage = '0';

if(!empty($mileage)) {
	$data_mileage = $mileage;
}

$special_car = get_post_meta(get_the_ID(),'special_car', true);
$gallery_video = get_post_meta(get_the_ID(), 'gallery_video', true);

$middle_infos = stm_get_car_archive_listings();

$middle_infos[] = 'location';

$total_infos = count($middle_infos);




$taxonomies = stm_get_taxonomies();

$categories = wp_get_post_terms(get_the_ID(), $taxonomies);

$classes = array();

if(!empty($categories)) {
	foreach($categories as $category) {
		$classes[] = $category->slug.'-'.$category->term_id;
	}
}

//Lat lang location
$stm_car_location = get_post_meta(get_the_ID(),'stm_car_location', true);
$stm_to_lng = get_post_meta(get_the_ID(),'stm_lng_car_admin', true);
$stm_to_lat = get_post_meta(get_the_ID(),'stm_lat_car_admin', true);


$distance = '';
if(stm_location_validates()) {

	$stm_from_lng = esc_attr(floatval($_GET['stm_lng']));
	$stm_from_lat = esc_attr(floatval($_GET['stm_lat']));

	if(!empty($stm_to_lng) and !empty($stm_to_lat)) {
		$distance = stm_calculate_distance_between_two_points( $stm_from_lat, $stm_from_lng, $stm_to_lat, $stm_to_lng );
	}
}


$show_title_two_params_as_labels = get_theme_mod('show_generated_title_as_label', true);

$car_media = stm_get_car_medias(get_the_id());
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

$hide_labels = get_theme_mod('hide_price_labels', true);


if($hide_labels) {
	$hide_labels = 'stm-listing-no-price-labels';
} else {
	$hide_labels = '';
}

?>

<div
	class="<?php echo esc_attr($hide_labels); ?> animated fadeIn listing-list-loop stm-listing-directory-list-loop stm-isotope-listing-item all <?php print_r(implode(' ', $classes)); ?>"
	data-price="<?php echo esc_attr($data_price) ?>"
    data-date="<?php echo get_the_date('Ymdhi') ?>"
    data-mileage="<?php echo esc_attr($data_mileage); ?>"
    <?php if(isset($distance)): ?>
        data-distance="<?php echo esc_attr(floatval($distance)); ?>"
    <?php endif; ?>
	>

		<div class="image">

			<!--Hover blocks-->
			<!---Media-->
			<div class="stm-car-medias">
				<?php if(!empty($car_media['car_photos_count'])): ?>
					<div class="stm-listing-photos-unit stm-car-photos-<?php echo get_the_id(); ?>">
						<i class="stm-service-icon-photo"></i>
						<span><?php echo $car_media['car_photos_count']; ?></span>
					</div>

					<script type="text/javascript">
						jQuery(document).ready(function(){

							jQuery(".stm-car-photos-<?php echo get_the_id(); ?>").click(function() {
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

							jQuery(".stm-car-videos-<?php echo get_the_id(); ?>").click(function() {
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
			<!--Compare-->
			<?php if(!empty($show_compare) and $show_compare): ?>
				<div
					class="stm-listing-compare <?php echo esc_attr($car_already_added_to_compare); ?>"
					data-id="<?php echo esc_attr(get_the_id()); ?>"
					data-title="<?php echo stm_generate_title_from_slugs(get_the_id(),false); ?>"
					data-toggle="tooltip" data-placement="left" title="<?php echo esc_attr($car_compare_status); ?>"
					>
					<i class="stm-service-icon-compare-new"></i>
				</div>
			<?php endif; ?>

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

			<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
				<div class="image-inner">
					<?php if(has_post_thumbnail()): ?>
						<?php
							$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-796-466');
						?>
						<img
							src="<?php echo esc_url($img[0]); ?>"
							class="lazy img-responsive"
							alt="<?php the_title(); ?>"
						/>

					<?php else : ?>
						<img
							src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/plchldr350.png'); ?>"
							class="img-responsive"
							alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
						/>
					<?php endif; ?>
				</div>
			</a>
		</div>


		<div class="content">
			<div class="meta-top">
				<?php if($hide_labels and !empty($price)): ?>
					<?php
						if(!empty($sale_price)) {
							$price = $sale_price;
						};
					?>
					<div class="price">
						<div class="normal-price">
							<?php if(!empty($car_price_form_label)): ?>
								<span class="heading-font"><?php echo esc_attr($car_price_form_label); ?></span>
							<?php else: ?>
								<span class="heading-font"><?php echo esc_attr(stm_listing_price_view($price)); ?></span>
							<?php endif; ?>
						</div>
					</div>

				<?php else: ?>
					<?php if(!empty($price) and !empty($sale_price) and $price != $sale_price):?>
						<div class="price discounted-price">
							<div class="regular-price">
								<?php if(!empty($special_price_label)): ?>
									<span class="label-price"><?php echo esc_attr($special_price_label); ?></span>
								<?php endif; ?>
								<?php echo esc_attr(stm_listing_price_view($price)); ?>
							</div>

							<div class="sale-price">
								<?php if(!empty($regular_price_label)): ?>
									<span class="label-price"><?php echo esc_attr($regular_price_label); ?></span>
								<?php endif; ?>
								<span class="heading-font"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></span>
							</div>
						</div>
					<?php elseif(!empty($price)): ?>
						<div class="price">
							<div class="normal-price">
								<?php if(!empty($regular_price_label)): ?>
									<span class="label-price"><?php echo esc_attr($regular_price_label); ?></span>
								<?php endif; ?>
								<?php if(!empty($car_price_form_label)): ?>
									<span class="heading-font"><?php echo esc_attr($car_price_form_label); ?></span>
								<?php else: ?>
									<span class="heading-font"><?php echo esc_attr(stm_listing_price_view($price)); ?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<div class="title heading-font">
					<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
						<?php echo stm_generate_title_from_slugs(get_the_id(),$show_title_two_params_as_labels); ?>
					</a>
				</div>
			</div>
			<?php if(!empty($middle_infos)): ?>

				<div class="meta-middle">
					<div class="meta-middle-row clearfix">
						<?php $counter = 0; ?>
						<?php foreach($middle_infos as $middle_info_key => $middle_info): ?>
							<?php
							if($middle_info != 'location'):
								$data_meta = get_post_meta(get_the_id(), $middle_info['slug'], true);
								$data_value = '';
							?>
							<?php if(!empty($data_meta) and $data_meta != 'none' and $middle_info['slug'] != 'price'):
								if(!empty($middle_info['numeric']) and $middle_info['numeric']):
									$affix = '';
									if(!empty($middle_info['number_field_affix'])) {
										$affix = esc_html__($middle_info['number_field_affix'], 'motors');
									}
									$data_value = ucfirst($data_meta) . ' ' . $affix;
								else:
									$data_meta_array = explode(',',$data_meta);
									$data_value = array();

									if(!empty($data_meta_array)){
										foreach($data_meta_array as $data_meta_single) {
											$data_meta = get_term_by('slug', $data_meta_single, $middle_info['slug']);
											if(!empty($data_meta->name)) {
												$data_value[] = esc_attr($data_meta->name);
											}
										}
									}

								endif;

							endif;
							endif //location;
							?>

							<?php if($middle_info == 'location'): $data_value = ''; ?>
								<?php if(!empty($stm_car_location) or !empty($distance)): ?>
									<div class="meta-middle-unit font-exists location">
										<div class="meta-middle-unit-top">
											<div class="icon"><i class="stm-service-icon-pin_big"></i></div>
											<div class="name"><?php esc_html_e('Distance', 'motors'); ?></div>
										</div>

										<div class="value">
											<?php if(!empty($distance)): ?>
												<div
													class="stm-tooltip-link"
													data-toggle="tooltip"
													data-placement="bottom"
													title="<?php echo $distance; ?>">
													<?php echo $distance; ?>
												</div>

											<?php else: ?>
												<div
													class="stm-tooltip-link"
													data-toggle="tooltip"
													data-placement="bottom"
													title="<?php echo $stm_car_location; ?>">
													<?php echo $stm_car_location; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<div class="meta-middle-unit meta-middle-divider"></div>
									<?php $counter++; ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if(!empty($data_value) and $data_value != ''): ?>


								<?php if($middle_info['slug'] != 'price' and !empty($data_meta)): ?>
									<?php $counter++; ?>
									<div class="meta-middle-unit <?php if(!empty($middle_info['font'])){ echo esc_attr('font-exists');} ?> <?php echo esc_attr($middle_info['slug']); ?>">
										<div class="meta-middle-unit-top">
											<?php if(!empty($middle_info['font'])): ?>
												<div class="icon"><i class="<?php echo esc_attr($middle_info['font']); ?>"></i></div>
											<?php endif; ?>
											<div class="name"><?php esc_html_e($middle_info['single_name'],'motors'); ?></div>
										</div>

										<div class="value">
											<?php
												if(is_array($data_value)){
													if(count($data_value) > 1) { ?>
														<div
															class="stm-tooltip-link"
															data-toggle="tooltip"
															data-placement="bottom"
															title="<?php echo esc_attr(implode(', ', $data_value)); ?>">
															<?php echo esc_attr(implode(', ', $data_value)); ?>
														</div>
													<?php } else {
														echo esc_attr(implode(', ', $data_value));
													}
												} else {
													echo esc_attr($data_value);
												}
											?>
										</div>
									</div>
									<div class="meta-middle-unit meta-middle-divider"></div>
								<?php endif; ?>


								<?php if($counter%4==0): ?>
									</div>
									<?php
										$row_no_filled = $total_infos - ($counter + 1);
										if($row_no_filled < 5) {
											$row_no_filled = 'stm-middle-info-not-filled';
										} else {
											$row_no_filled = '';
										}
									?>
									<div class="meta-middle-row <?php echo esc_attr($row_no_filled); ?> clearfix">
								<?php endif; ?>

							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="meta-bottom">
				<?php get_template_part('partials/listing-cars/listing-directive-list-loop', 'actions'); ?>
			</div>

			<a href="<?php the_permalink(); ?>" class="stm-car-view-more button visible-xs"><?php esc_html_e('View more', 'motors'); ?></a>
		</div>

</div>
