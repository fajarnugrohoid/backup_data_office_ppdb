<?php

	//Getting gallery list
	$gallery = get_post_meta(get_the_id(), 'gallery', true);
	$video_preview = get_post_meta(get_the_id(), 'video_preview', true);
	$gallery_video = get_post_meta(get_the_id(), 'gallery_video', true);
	$special_car = get_post_meta(get_the_id(),'special_car', true);
	
	$badge_text = get_post_meta(get_the_ID(),'badge_text',true);
	$badge_bg_color = get_post_meta(get_the_ID(),'badge_bg_color',true);


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

	if(!empty($cars_in_favourite) and in_array(get_the_ID(), $cars_in_favourite)){
		$car_already_added_to_favourite = 'active';
	}

	$image_limit = '';

	if(stm_pricing_enabled() and !empty($gallery)) {
		$user_added = get_post_meta(get_the_id(), 'stm_car_user', true);
		if(!empty($user_added)) {
			$limits = stm_get_post_limits( $user_added );
			$image_limit = $limits['images'] - 1;
			$gallery = array_slice($gallery, 0, $image_limit);
		}
	}

?>

<?php if(!has_post_thumbnail() and stm_check_if_car_imported(get_the_id())): ?>
	<img
		src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/automanager_placeholders/plchldr798automanager.png'); ?>"
		class="img-responsive"
		alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
		/>
<?php endif; ?>


<div class="stm-car-carousels stm-listing-car-gallery">
	<!--Actions-->
	<?php
		$show_compare = get_theme_mod('show_compare', true);
		$show_share = get_theme_mod('show_share', true);
		$show_featured_btn = get_theme_mod('show_featured_btn', true);
	?>
	<div class="stm-gallery-actions">
		<?php if(!empty($show_featured_btn)): ?>
			<div class="stm-gallery-action-unit stm-listing-favorite-action <?php esc_attr($car_already_added_to_favourite); ?>" data-id="<?php echo esc_attr(get_the_id()); ?>">
				<i class="stm-service-icon-staricon"></i>
			</div>
		<?php endif; ?>
		<?php if(!empty($show_compare)): ?>
			<?php
				$active = '';
				if(!empty($_COOKIE['compare_ids'])) {
					if(in_array(get_the_ID(), $_COOKIE['compare_ids'])) {
						$active = 'active';
					}
				}
			?>
			<div class="stm-gallery-action-unit compare <?php echo esc_attr($active); ?>" data-id="<?php echo esc_attr(get_the_ID()); ?>" data-title="<?php echo esc_attr(stm_generate_title_from_slugs(get_the_id())); ?>">
				<i class="stm-service-icon-compare-new"></i>
			</div>
		<?php endif; ?>
		<?php if(!empty($show_share)): ?>
			<div class="stm-gallery-action-unit">
				<span class="st_sharethis_large" displaytext=""></span>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">if (typeof stLight != 'undefined') { stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false, onhover: false}); }</script>
				<i class="stm-icon-share"></i>
			</div>
		<?php endif; ?>
	</div>

	<?php $car_media = stm_get_car_medias(get_the_id()); ?>
	<?php if(!empty($car_media['car_videos_count'])): ?>
		<div class="stm-car-medias">
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_id(); ?>">
				<i class="fa fa-film"></i>
				<span><?php echo $car_media['car_videos_count']; ?> <?php esc_html_e('Video', 'motors'); ?></span>
			</div>
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
	<div class="stm-big-car-gallery">

		<?php if(has_post_thumbnail()):
			$full_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'full');
			//Post thumbnail first ?>
			<div class="stm-single-image" data-id="big-image-<?php echo esc_attr(get_post_thumbnail_id(get_the_id())); ?>">
				<a href="<?php echo esc_url($full_src[0]); ?>" class="stm_fancybox" rel="stm-car-gallery">
					<?php the_post_thumbnail('stm-img-796-466', array('class'=>'img-responsive')); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if(!empty($gallery)): ?>
			<?php foreach ( $gallery as $gallery_image ): ?>
				<?php $src = wp_get_attachment_image_src($gallery_image, 'stm-img-796-466'); ?>
				<?php $full_src = wp_get_attachment_image_src($gallery_image, 'full'); ?>
				<?php if(!empty($src[0])): ?>
					<div class="stm-single-image" data-id="big-image-<?php echo esc_attr($gallery_image); ?>">
						<a href="<?php echo esc_url($full_src[0]); ?>" class="stm_fancybox" rel="stm-car-gallery">
							<img src="<?php echo esc_url($src[0]); ?>" alt="<?php echo get_the_title(get_the_ID()).' '.esc_html__('full','motors'); ?>"/>
						</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

	</div>

	<?php if(has_post_thumbnail() and !empty($gallery) ): ?>
		<div class="stm-thumbs-car-gallery">

			<?php if(has_post_thumbnail()):
				//Post thumbnail first ?>
				<div class="stm-single-image" id="big-image-<?php echo esc_attr(get_post_thumbnail_id(get_the_id())); ?>">
					<?php the_post_thumbnail('stm-img-350-205', array('class'=>'img-responsive')); ?>
				</div>
			<?php endif; ?>

			<?php if(!empty($gallery)): ?>
				<?php foreach ( $gallery as $gallery_image ): ?>
					<?php $src = wp_get_attachment_image_src($gallery_image, 'stm-img-350-205'); ?>
					<?php if(!empty($src[0])): ?>
						<div class="stm-single-image" id="big-image-<?php echo esc_attr($gallery_image); ?>">
							<img src="<?php echo esc_url($src[0]); ?>" alt="<?php echo get_the_title(get_the_ID()).' '.esc_html__('full','motors'); ?>"/>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

		</div>
	<?php endif; ?>
</div>


<!--Enable carousel-->
<script type="text/javascript">
	jQuery(document).ready(function($){
		var big = $('.stm-big-car-gallery');
		var small = $('.stm-thumbs-car-gallery');
		var flag = false;
		var duration = 800;

		var owlRtl = false;
		if( $('body').hasClass('rtl') ) {
			owlRtl = true;
		}

		big
			.owlCarousel({
				items: 1,
				rtl: owlRtl,
				smartSpeed: 800,
				dots: false,
				nav: false,
				margin:0,
				autoplay: false,
				loop: false,
				responsiveRefreshRate: 1000
			})
			.on('changed.owl.carousel', function (e) {
				$('.stm-thumbs-car-gallery .owl-item').removeClass('current');
				$('.stm-thumbs-car-gallery .owl-item').eq(e.item.index).addClass('current');
				if (!flag) {
					flag = true;
					small.trigger('to.owl.carousel', [e.item.index, duration, true]);
					flag = false;
				}
			});

		small
			.owlCarousel({
				items: 5,
				rtl: owlRtl,
				smartSpeed: 800,
				dots: false,
				margin: 22,
				autoplay: false,
				nav: true,
				loop: false,
				navText: [],
				responsiveRefreshRate: 1000,
				responsive:{
					0:{
						items:2
					},
					500:{
						items:4
					},
					768:{
						items:5
					},
					1000:{
						items:5
					}
				}
			})
			.on('click', '.owl-item', function(event) {
				big.trigger('to.owl.carousel', [$(this).index(), 400, true]);
			})
			.on('changed.owl.carousel', function (e) {
				if (!flag) {
					flag = true;
					big.trigger('to.owl.carousel', [e.item.index, duration, true]);
					flag = false;
				}
			});

		if($('.stm-thumbs-car-gallery .stm-single-image').length < 6) {
			$('.stm-single-car-page .owl-controls').hide();
			$('.stm-thumbs-car-gallery').css({'margin-top': '22px'});
		}
	})
</script>

<!--JS translations-->
<script type="text/javascript">
	var stm_added_to_compare_text = "<?php esc_html_e('Added to compare', 'motors'); ?>";
	var stm_removed_from_compare_text = "<?php esc_html_e('was removed from compare', 'motors'); ?>";
	var stm_already_added_to_compare_text = "<?php esc_html_e('You have already added 3 cars', 'motors'); ?>";
</script>