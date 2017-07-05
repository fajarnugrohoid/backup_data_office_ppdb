<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'stm-countUp.min.js' );

if(empty($stm_counter_time)) {
	$stm_counter_time = '2.5';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$id = rand(9,9999);

if(!empty($box_bg_color)) {
	$box_bg_color = 'style=color:'.$box_bg_color;
} else {
	$box_bg_color = '';
}

if(empty($stm_icon_size)) {
	$stm_icon_size = '50';
}

?>

<?php if(!empty($stm_counter_value)): ?>

	<div class="stm-icon-counter-boats text-center" <?php echo esc_attr($css_class); ?>>

		<div class="dp-in">
			<div class="clearfix">
				<?php if(!empty($icon)): ?>
					<div class="stm-icon-counter boat-secondary-color">
						<i class="<?php echo $icon; ?>" style="font-size: <?php echo intval($stm_icon_size) ?>px;" <?php echo esc_attr($box_bg_color); ?>></i>
					</div>
				<?php endif; ?>

				<div class="stm-counter-meta heading-font" <?php echo esc_attr($box_bg_color); ?>>
					<div class="stm-value-wrapper">
						<div class="stm-value" id="counter_<?php echo esc_attr( $id ); ?>"></div>
						<?php if(!empty($stm_counter_affix)): ?>
							<div class="stm-value-affix"><?php echo esc_attr($stm_counter_affix); ?></div>
						<?php endif; ?>
					</div>
					<?php if(!empty($stm_counter_label)): ?>
						<div class="stm-label"><?php echo esc_attr($stm_counter_label); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>

	</div>



	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var counter_<?php echo esc_attr( $id ); ?> = new countUp("counter_<?php echo esc_attr( $id ); ?>", 0, <?php echo esc_attr( $stm_counter_value ); ?>, 0, <?php echo esc_attr( $stm_counter_time ); ?>, {
				useEasing : true,
				useGrouping: true,
				separator : ','
			});

			$(window).scroll(function(){
				if( $("#counter_<?php echo esc_attr( $id ); ?>").is_on_screen() ){
					counter_<?php echo esc_attr( $id ); ?>.start();
				}
			});
		});
	</script>

<?php endif; ?>