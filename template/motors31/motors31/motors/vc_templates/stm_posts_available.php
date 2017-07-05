<?php
	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
	extract( $atts );

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );


	$user = wp_get_current_user();
	if(!empty($user->ID)):
		$limits = stm_get_post_limits($user->ID);
?>
		<div class="stm-posts-available-number heading-font <?php echo esc_attr($css_class); ?>">
			<?php esc_html_e('Posts Available', 'motors'); ?>: <span><?php echo esc_attr($limits['posts']); ?></span>
		</div>

<?php endif; ?>