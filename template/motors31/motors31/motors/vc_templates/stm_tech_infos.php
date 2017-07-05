<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if(!empty($icon_size)) {
	$icon_style = 'style=font-size:'. esc_attr($icon_size) .'px;';
} else {
	$icon_style = '';
}

?>

<div class="stm-tech-infos">
	<div class="stm-tech-title">
		<?php if(!empty($icon)): ?>
			<i class="<?php echo esc_attr($icon) ?>" <?php echo esc_attr($icon_style); ?>></i>
		<?php endif; ?>
		<?php if(!empty($title)): ?>
			<div class="title h5"><?php echo esc_html($title); ?></div>
		<?php endif; ?>
	</div>

	<table>
		<tbody>
			<?php echo wpb_js_remove_wpautop($content); ?>
		</tbody>
	</table>
</div>
