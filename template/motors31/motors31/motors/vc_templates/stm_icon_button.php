<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$link = vc_build_link( $link );

if(empty($align)) {
	$align = 'left';
}

if(empty($box_bg_color)) {
	$box_bg_color_rgba = '';
} else {
	$box_bg_color_rgba = $box_bg_color;

}

if(empty($box_text_color)) {
	$box_text_color = '#fff';
}

$styles = 'background-color:'.$box_bg_color_rgba.'; color:'.$box_text_color.'!important;';

if(!empty($box_bg_color)) {
	$styles .= 'box-shadow: 0 2px 0 rgba('.stm_hex2rgb($box_bg_color).',0.8)';
}

?>

<?php if(!empty($link['url']) and !empty($link['title'])): ?>
	<div class="text-<?php echo esc_attr($align); ?>">
		<?php if(empty($icon)): ?>
			<a class="stm-button <?php echo esc_attr($css_class) ?>"
			    style="<?php echo esc_attr($styles); ?>"
				href="<?php echo esc_url($link['url']) ?>"
				title="<?php echo esc_attr($link['title']); ?>"
				<?php if(!empty($link['target'])): ?>
					target="_blank"
				<?php endif; ?>><?php echo esc_attr($link['title']); ?></a>
		<?php else: ?>
			<a class="button stm-button stm-button-icon stm-button-secondary-color <?php echo esc_attr($css_class) ?>"
			   style="<?php echo esc_attr($styles); ?>"
			   href="<?php echo esc_url($link['url']) ?>"
			   title="<?php echo esc_attr($link['title']); ?>"
				<?php if(!empty($link['target'])): ?>
					target="_blank"
				<?php endif; ?>><?php if(!empty($icon)): ?><i class="<?php echo esc_attr($icon); ?>"></i><?php endif; ?><?php echo esc_attr($link['title']); ?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>