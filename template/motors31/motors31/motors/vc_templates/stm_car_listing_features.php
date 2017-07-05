<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

?>

<?php if(!empty($title)): ?>
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php echo esc_attr($title); ?></div>
	</div>
<?php endif; ?>

<div class="<?php echo esc_attr($css_class); ?>">
	<?php get_template_part('partials/single-car-listing/car-features'); ?>
</div>