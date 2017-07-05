<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

?>

<div class="stm-contact-us-form-wrapper <?php echo esc_attr($css_class); ?>">
	<?php if($title): ?>
		<h2><?php echo esc_attr($title); ?></h2>
	<?php endif; ?>
	<?php if($form != '' and $form != 'none'): ?>
		<?php $cf7 = get_post($form); ?>
		<?php echo(do_shortcode('[contact-form-7 id="'.$cf7->ID.'" title="'.($cf7->post_title).'"]')); ?>
	<?php endif; ?>
</div>