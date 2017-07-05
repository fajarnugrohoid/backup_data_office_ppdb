<?php
	//Getting gallery list
	$gallery = get_post_meta(get_the_id(), 'gallery', true);

	if(!empty($gallery)):
?>

	<div class="row">
		<?php foreach($gallery as $gallery_item): ?>
			<div class="col-md-4 col-sm-4">
				<?php
					$src = wp_get_attachment_image_src($gallery_item, 'stm-img-350-181');
					$src_full = wp_get_attachment_image_src($gallery_item, 'full');
					if(!empty($src[0]) and !empty($src_full[0])):
				?>
					<a href="<?php echo esc_url($src_full[0]); ?>" class="stm_fancybox" rel="gallery">
						<img src="<?php echo esc_url($src[0]) ?>" />
					</a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>