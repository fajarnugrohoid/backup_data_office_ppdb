<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$icon_styles = 'style=';

if(!empty($icon_color)) {
	$icon_styles .= 'color:' . $icon_color .';';
}

if(!empty($icon_size)) {
	$icon_styles .= 'font-size:' . $icon_size . 'px;';
}

?>

<div class="stm-service-layout-icon-box <?php echo esc_attr($css_class); ?>">
	<div class="inner clearfix">
		<?php if(!empty($icon)): ?>
			<div class="icon">
				<i class="<?php echo esc_attr($icon); ?> stm-service-primary-color" <?php echo esc_attr($icon_styles); ?>></i>
			</div>
		<?php endif; ?>
		
		<div class="icon-box-content">
			
			<?php if(!empty($title)): ?>
				<div class="title h4"><?php echo esc_attr($title); ?></div>
			<?php endif; ?>
			
			<?php if(!empty($content)): ?>
				<div class="content">
					<?php echo wpb_js_remove_wpautop($content, true); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>