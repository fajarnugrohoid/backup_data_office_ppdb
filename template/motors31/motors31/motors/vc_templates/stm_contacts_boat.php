<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

?>

<div class="stm-boat-contact-wrapper">
	<?php if(!empty($title)): ?>
		<h4><?php echo esc_attr($title); ?></h4>
	<?php endif; ?>
	<?php echo wpb_js_remove_wpautop($content); ?>
</div>