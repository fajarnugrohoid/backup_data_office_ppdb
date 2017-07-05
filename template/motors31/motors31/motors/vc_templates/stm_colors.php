<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if ( isset( $atts['items'] ) && strlen( $atts['items'] ) > 0 ) {
	$items = vc_param_group_parse_atts( $atts['items'] );
	if ( ! is_array( $items ) ) {
		$temp = explode( ',', $atts['items'] );
		$paramValues = array();
		foreach ( $temp as $value ) {
			$data = explode( '|', $value );
			$newLine = array();
			$newLine['color'] = isset( $data[0] ) ? $data[0] : 0;
			$newLine['color_name'] = isset( $data[1] ) ? $data[1] : '';
			if ( isset( $data[1] ) && preg_match( '/^\d{1,3}\%$/', $data[1] ) ) {
				$colorIndex += 1;
				$newLine['color'] = (float) str_replace( '%', '', $data[1] );
				$newLine['color_name'] = isset( $data[2] ) ? $data[2] : '';
			}
			$paramValues[] = $newLine;
		}
		$atts['items'] = urlencode( json_encode( $paramValues ) );
	}
}

if(!empty($items)): ?>
	<div class="row">
		<?php foreach($items as $item): ?>
			<?php if(empty($item['color'])){
				$item['color'] = '#fff';
			} ?>
			<div class="stm-boats-color">
				<div class="color-round" style="background-color: <?php echo esc_attr($item['color']); ?>"></div>
				<?php if(!empty($item['color_name'])): ?>
					<div class="color-label"><?php echo esc_attr($item['color_name']); ?></div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>