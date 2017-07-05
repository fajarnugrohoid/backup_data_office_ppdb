<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
?>

<div class="stm-call-to-action heading-font" style="background-color:<?php echo esc_attr($call_to_action_color); ?>">
	<div class="clearfix">
		<div class="call-to-action-content pull-left">
			<?php if(!empty($call_to_action_label)): ?>
				<div class="content">
					<?php if(!empty($call_to_action_icon)): ?>
						<i class="<?php echo esc_attr($call_to_action_icon); ?>"></i>
					<?php endif; ?>
					<?php echo esc_attr($call_to_action_label); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="call-to-action-right">
			<div class="call-to-action-meta">
				<?php if(!empty($call_to_action_label_right)): ?>
					<div class="content">
						<?php if(!empty($call_to_action_icon_right)): ?>
							<i class="<?php echo esc_attr($call_to_action_icon_right); ?>"></i>
						<?php endif; ?>
						<?php echo esc_attr($call_to_action_label_right); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</div>