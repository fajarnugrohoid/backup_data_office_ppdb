<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'stm-countUp.min.js' );

if(empty($duration)) {
	$duration = '2.5';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$id = rand(9,9999);
?>


<?php if(!empty($counter_value)): ?>

	<div class="stm-counter clearfix">
		
		<div class="stm-counter-circle heading-font" id="counter_<?php echo esc_attr( $id ); ?>"></div>
		
		<?php if(!empty($title)): ?>
			<div class="stm-counter-label">
				<div class="h4"><?php echo esc_attr($title); ?></div>
			</div>
		<?php endif; ?>
	</div>
	
	
	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var counter_<?php echo esc_attr( $id ); ?> = new countUp("counter_<?php echo esc_attr( $id ); ?>", 0, <?php echo esc_attr( $counter_value ); ?>, 0, <?php echo esc_attr( $duration ); ?>, {
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