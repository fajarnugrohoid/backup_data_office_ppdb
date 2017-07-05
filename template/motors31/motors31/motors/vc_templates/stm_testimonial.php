<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(empty($image_size)) {
	$image_size = '213x142';
}

$thumbnail = '';

if (!empty($image)) {
	$image = explode(',', $image);
	if (!empty($image[0])) {
		$image = $image[0];
		$post_thumbnail = wpb_getImageBySize(array(
			'attach_id' => $image,
			'thumb_size' => $image_size
		));

		$thumbnail = $post_thumbnail['thumbnail'];
	}
}
?>

<div class="testimonial-unit">
	<div class="clearfix">
		<?php if(!empty($thumbnail)): ?>
			<div class="image">
				<?php echo $thumbnail; ?>
			</div>
		<?php endif; ?>
		<div class="content">
			<?php echo wpb_js_remove_wpautop($content); ?>
		</div>
	</div>
	<div class="testimonial-meta">
		<?php if(!empty($author)): ?>
			<div class="author heading-font">
				<?php echo esc_attr($author); ?>
			</div>
		<?php endif; ?>
		<?php if(!empty($author_car)): ?>
			<div class="author-car">
				<i class="stm-icon-car"></i>
				<?php echo esc_attr($author_car); ?>
			</div>
		<?php endif; ?>
	</div>
</div>