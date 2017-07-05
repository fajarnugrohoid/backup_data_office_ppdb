<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$testimonials_carousel = 'testimonials_carousel_boats_'.rand(0,99999);

?>

<div class="testimonials-carousel-boats <?php echo esc_attr($testimonials_carousel.$css_class); ?>">
	<?php echo wpb_js_remove_wpautop($content); ?>
</div>

<script type="text/javascript">
	(function($) {
		"use strict";

		var owlRtl = false;
		if( $('body').hasClass('rtl') ) {
			owlRtl = true;
		}

		var owl = $('.<?php echo esc_js($testimonials_carousel); ?>');

		$(document).ready(function () {
			owl.owlCarousel({
				rtl: owlRtl,
				items: 1,
				smartSpeed: 800,
				dots: true,
				nav:true,
				autoplay: false,
				loop: true,
				navText: '',
				responsiveRefreshRate: 1000
			});
		});
	})(jQuery);
</script>