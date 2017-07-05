<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'stm_gmap' );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
if ( ! empty( $el_class ) ) {
	$css_class .= ' ' . $el_class;
}
$id = rand();

if ( empty( $lat ) ) {
	$lat = 36.169941;
}
if ( empty( $lng ) ) {
	$lng = - 115.139830;
}

$map_style = array();
if ( $map_width ) {
	$map_style['width'] = ' width: ' . $map_width . ';';
}
if ( $map_height ) {
	$map_style['height'] = ' height: ' . $map_height . ';';
}
if ( $disable_mouse_whell == 'disable' ) {
	$disable_mouse_whell = 'false';
} else {
	$disable_mouse_whell = 'true';
}

$pin = 'map-marker';
if(stm_is_boats()) {
	$pin = 'boats-pin';
}

$pin_url = get_template_directory_uri() . '/assets/images/' . $pin . '.png';

if (!empty($image)) {
	$image = explode(',',$image);
	if(!empty($image[0])) {
		$image = $image[0];
		$image = wp_get_attachment_image_src($image, 'full');
		$pin_url = $image[0];
	}
}
?>

	<div<?php echo( ( $map_style ) ? ' style="' . esc_attr( implode( ' ', $map_style ) ) . '"' : '' ); ?> id="stm_map-<?php echo esc_attr( $id ); ?>" class="stm_gmap<?php echo esc_attr( $css_class ); ?>"></div>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			google.maps.event.addDomListener(window, 'load', init);

			var center, map;
			function init() {
				center = new google.maps.LatLng(<?php echo esc_js( $lat ); ?>, <?php echo esc_js( $lng ); ?>);
				var mapOptions = {
					zoom: <?php echo esc_js( $map_zoom ); ?>,
					center: center,
					scrollwheel: <?php echo esc_js( $disable_mouse_whell ); ?>
				};
				var mapElement = document.getElementById('stm_map-<?php echo esc_js( $id ); ?>');
				map = new google.maps.Map(mapElement, mapOptions);
				var marker = new google.maps.Marker({
					position: center,
					icon: '<?php echo esc_url($pin_url); ?>',
					map: map
				});

				<?php if(!empty($infowindow_text)): ?>
				var infowindow = new google.maps.InfoWindow({
					content: '<h6><?php echo esc_js($infowindow_text); ?></h6>',
					pixelOffset: new google.maps.Size(0,71),
					boxStyle: {
						width: "320px"
					}
				});

				marker.addListener('click', function() {
					infowindow.open(map, marker);
					map.setCenter(center);
				});
				<?php endif; ?>
			}

			$('.vc_tta-tab').click(function(){
				if(typeof map != 'undefined' && typeof center != 'undefined') {
					setTimeout(function () {
						google.maps.event.trigger(map, "resize");
						map.setCenter(center);
					}, 1000);
				}
			})

			$('.wpb_tour_tabs_wrapper.ui-tabs ul.wpb_tabs_nav > li').click(function(){
				if(typeof map != 'undefined' && typeof center != 'undefined') {
					setTimeout(function () {
						google.maps.event.trigger(map, "resize");
						map.setCenter(center);
					}, 1000);
				}
			})

			$(window).resize(function(){
				if(typeof map != 'undefined' && typeof center != 'undefined') {
					setTimeout(function () {
						map.setCenter(center);
					}, 1000);
				}
			})
		});
	</script>

<?php if(!empty($infowindow_text)): ?>
	<!--Infowindow styles-->
	<style type="text/css">
		/* white background and box outline */
		.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div {
			border: none !important;
			box-shadow: rgba(0, 0, 0, 0.1) 5px 5px 5px !important;
		}
		/* arrow first */
		.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div:first-child > div {
			left: 3px !important;
			transform: skewX(36deg) !important;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px !important;
			z-index: 40;
		}
		/* arrow second */
		.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div:nth-child(2) > div {
			left: 2px !important;
			transform: skewX(-36deg) !important;
			box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 1px !important;
			z-index: 40;
		}

		.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div:first-child {
			display: none !important;
		}

		.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div:nth-child(2){
			background-color: transparent !important;
			box-shadow: none !important;
		}

		.gm-style .gm-style-iw {
			padding: 10px 10px 5px 10px;
			min-height: 54px;
			width: 240px !important;
		}
		.gm-style .gm-style-iw > div > div {
			overflow: hidden !important;
		}
		.gm-style .gm-style-iw h6 {
			margin-bottom: 0 !important;
			font-weight: 400 !important;
		}
	</style>
<?php endif; ?>