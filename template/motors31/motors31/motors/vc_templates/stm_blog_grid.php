<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if(empty($per_page)) {
	$per_page = 3;
}

$args = array(
	'post_type' => 'post',
	'status' => 'publish',
	'posts_per_page' => intval($per_page)
);

$query = new WP_Query($args);

?>

	<?php if($query->have_posts()): ?>
		<div class="row row-3">
			<?php while($query->have_posts()): $query->the_post(); ?>

				<?php get_template_part('partials/blog/grid', 'loop'); ?>

			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

