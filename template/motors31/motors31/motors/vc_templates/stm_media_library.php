<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( '' === $images ) {
	$images = '-1,-2,-3';
}

$images = explode( ',', $images );
$i = - 1;

$image_gallery = 'media-widget-'.rand(0,99999);
?>

<div class="widget widget_media_library">
	<?php if(!empty($title)): ?>
		<h4 class="widgettitle"><?php echo esc_attr($title); ?></h4>
	<?php endif; ?>
	<?php if(!empty($images)): ?>
		<div class="media-widget-list clearfix">
			<?php foreach ( $images as $attach_id ):
				$i ++;
				$post_thumbnail = wp_get_attachment_image_src($attach_id, 'thumbnail');

				$thumbnail = $post_thumbnail[0]; ?>

				<div class="media-widget-item">
					<?php
					$fancy_link = wp_get_attachment_image_src($attach_id, 'full');
					if(!empty($fancy_link)){
						$fancy_link = $fancy_link[0];
					} else {
						$fancy_link = '';
					}
					?>
					<a class="stm_fancybox" href="<?php echo esc_attr($fancy_link); ?>" title="<?php esc_html_e('Watch in popup', 'motors'); ?>" rel="<?php echo esc_attr($image_gallery); ?>">
						<img src="<?php echo esc_url($thumbnail); ?>" class="img-responsive" alt="<?php esc_html_e('Media gallery image','motors'); ?>"/>
					</a>
				</div>

			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>