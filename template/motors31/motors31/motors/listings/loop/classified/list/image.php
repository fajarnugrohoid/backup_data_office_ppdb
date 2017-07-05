<?php
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

$car_media = stm_get_car_medias(get_the_id());
?>

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
			<?php get_template_part('partials/listing-cars/listing-directory', 'badges'); ?>
			<?php if(has_post_thumbnail()): ?>
				<?php
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-796-466');
				?>
				<img
					data-original="<?php echo esc_url($img[0]); ?>"
					src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/plchldr350.png'); ?>"
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
