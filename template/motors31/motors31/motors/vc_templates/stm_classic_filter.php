<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if(stm_is_motorcycle()) {
    get_template_part('partials/single-car-motorcycle/tabs');
}

stm_listings_load_template('filter/inventory/main'); ?>