<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
?>

<div class="stm-boats-data <?php echo esc_attr($css_class); ?>">
	<?php get_template_part('partials/single-car-boats/boats', 'data'); ?>
</div>