<?php if(has_post_thumbnail()):
	$full_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'full');
	//Post thumbnail first ?>
	<div class="stm-single-image" data-id="big-image-<?php echo esc_attr(get_post_thumbnail_id(get_the_id())); ?>">
		<a href="<?php echo esc_url($full_src[0]); ?>" class="stm_fancybox" rel="stm-car-gallery">
			<?php the_post_thumbnail('stm-img-1110-577', array('class'=>'img-responsive')); ?>
		</a>
	</div>
<?php endif; ?>