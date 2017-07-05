<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
?>

<div class="<?php echo esc_attr($css_class); ?>">
	<!--Post thumbnail-->
	<?php if ( has_post_thumbnail() ): ?>
	<div class="post-thumbnail">
		<?php the_post_thumbnail( 'stm-img-1110-577', array( 'class' => 'img-responsive' ) ); ?>
	</div>
	<?php endif; ?>
</div>