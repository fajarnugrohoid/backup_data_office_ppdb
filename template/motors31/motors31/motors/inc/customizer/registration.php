<?php

if (!function_exists('stm_is_listing')) {
    function stm_is_listing()
    {
        $listing = get_option('stm_motors_chosen_template');

        if ($listing == 'listing') {
            $listing = true;
        } else {
            $listing = false;
        }

        return $listing;
    }
}

if (!function_exists('stm_is_boats')) {
    function stm_is_boats()
    {
        $listing = get_option('stm_motors_chosen_template');

        if ($listing == 'boats') {
            $listing = true;
        } else {
            $listing = false;
        }

        return $listing;
    }
}

if (!function_exists('stm_is_motorcycle')) {
    function stm_is_motorcycle()
    {
        $listing = get_option('stm_motors_chosen_template');

        if ($listing == 'motorcycle') {
            $listing = true;
        } else {
            $listing = false;
        }

        return $listing;
    }
}

if (!function_exists('stm_get_current_layout')) {
    function stm_get_current_layout()
    {
        $layout = get_option('stm_motors_chosen_template');

        if (empty($layout)) {
            $layout = 'car_dealer';
        }

        return $layout;
    }
}

$show_on_listing = false;
$show_on_dealer = true;

if (stm_is_listing()) {
    $margin_top = 17;
    $show_on_listing = true;
    $show_on_dealer = false;
    $footer_bg = '#153e4d';
} else {
    $margin_top = 0;
    $footer_bg = '#232628';
}

$socials = array(
    'facebook' => esc_html__('Facebook', 'motors'),
    'twitter' => esc_html__('Twitter', 'motors'),
    'vk' => esc_html__('VK', 'motors'),
    'instagram' => esc_html__('Instagram', 'motors'),
    'behance' => esc_html__('Behance', 'motors'),
    'dribbble' => esc_html__('Dribbble', 'motors'),
    'flickr' => esc_html__('Flickr', 'motors'),
    'git' => esc_html__('Git', 'motors'),
    'linkedin' => esc_html__('Linkedin', 'motors'),
    'pinterest' => esc_html__('Pinterest', 'motors'),
    'yahoo' => esc_html__('Yahoo', 'motors'),
    'delicious' => esc_html__('Delicious', 'motors'),
    'dropbox' => esc_html__('Dropbox', 'motors'),
    'reddit' => esc_html__('Reddit', 'motors'),
    'soundcloud' => esc_html__('Soundcloud', 'motors'),
    'google' => esc_html__('Google', 'motors'),
    'google-plus' => esc_html__('Google +', 'motors'),
    'skype' => esc_html__('Skype', 'motors'),
    'youtube' => esc_html__('Youtube', 'motors'),
    'youtube-play' => esc_html__('Youtube Play', 'motors'),
    'tumblr' => esc_html__('Tumblr', 'motors'),
    'whatsapp' => esc_html__('Whatsapp', 'motors'),
);

$positions = array(
    'left' => esc_html__('Left', 'motors'),
    'right' => esc_html__('Right', 'motors'),
);

STM_Customizer::setPanels(array(
    'site_settings' => array(
        'title' => esc_html__('Site Settings', 'motors'),
        'priority' => 10
    ),
    'header' => array(
        'title' => esc_html__('Header', 'motors'),
        'priority' => 20
    ),
    'listing' => array(
        'title' => esc_html__('Listing', 'motors'),
        'priority' => 30
    ),
    'footer' => array(
        'title' => esc_html__('Footer', 'motors'),
        'priority' => 50
    )
));

STM_Customizer::setSection('title_tagline', array(
    'title' => esc_html__('Logo &amp; Title', 'motors'),
    'panel' => 'site_settings',
    'priority' => 200,
    'fields' => array(
        'logo' => array(
            'label' => esc_html__('Logo', 'motors'),
            'type' => 'image',
            'default' => get_template_directory_uri() . '/assets/images/tmp/logo.png'
        ),
        'logo_width' => array(
            'label' => esc_html__('Logo Width (px)', 'motors'),
            'type' => 'text'
        ),
        'menu_top_margin' => array(
            'label' => esc_html__('Menu margin top (px)', 'motors'),
            'type' => 'text',
            'default' => $margin_top
        ),
        'logo_break_2' => array(
            'type' => 'stm-separator',
        ),
        'logo_font_family' => array(
            'label' => esc_html__('Text Logo Font Family', 'motors'),
            'type' => 'stm-font-family',
            'description' => esc_html__('If you dont have logo, you can customize your brand name', 'motors'),
            'output' => '#header .logo-main .blogname h1'
        ),
        'logo_font_size' => array(
            'label' => esc_html__('Text Logo Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '30',
            'output' => '#header .logo-main .blogname h1'
        ),
        'logo_color' => array(
            'label' => esc_html__('Text Logo Color', 'motors'),
            'type' => 'color',
            'output' => array('color' => '#header .logo-main .blogname h1'),
            'transport' => 'postMessage',
            'default' => '#fff'
        ),
    )
));

STM_Customizer::setSection('site_settings', array(
    'title' => esc_html__('One Click update', 'motors'),
    'panel' => 'site_settings',
    'priority' => 250,
    'fields' => array(
        'envato_username' => array(
            'label' => esc_html__('Envato Username', 'motors'),
            'type' => 'text',
            'default' => '',
            'description' => esc_html__('Enter here your ThemeForest (or Envato) username account (i.e. Stylemixthemes).', 'motors')
        ),
        'envato_api' => array(
            'label' => esc_html__('Envato API Key', 'motors'),
            'type' => 'text',
            'default' => '',
            'description' => esc_html__('Enter here the secret api key you have created on ThemeForest. You can create a new one in the Settings > API Keys section of your profile.', 'motors')
        ),
    )
));

STM_Customizer::setSection('google_api_settings', array(
    'title' => esc_html__('Google Api Settings', 'motors'),
    'panel' => 'site_settings',
    'priority' => 300,
    'fields' => array(
        'google_api_key' => array(
            'label' => esc_html__('Google API Key', 'motors'),
            'type' => 'text',
            'description' => esc_html__('Enter here the secret api key you have created on Google APIs. You can enable MAP API in Google APIs > Google Maps APIs > Google Maps JavaScript API.', 'motors')
        ),
    )
));

$site_styles = array();

if (!stm_is_boats()) {
    if (stm_is_motorcycle()) {
        $site_styles['site_style'] = array(
            'label' => esc_html__('Style', 'motors'),
            'type' => 'stm-select',
            'choices' => array(
                'site_style_default' => esc_html__('Default', 'motors'),
                'site_style_custom' => esc_html__('Custom Colors', 'motors'),
            ),
            'default' => 'site_style_default'
        );
    } else {
        $site_styles['site_style'] = array(
            'label' => esc_html__('Style', 'motors'),
            'type' => 'stm-select',
            'choices' => array(
                'site_style_default' => esc_html__('Default', 'motors'),
                'site_style_blue' => esc_html__('Blue', 'motors'),
                'site_style_light_blue' => esc_html__('Light Blue', 'motors'),
                'site_style_orange' => esc_html__('Green', 'motors'),
                'site_style_red' => esc_html__('Red', 'motors'),
                'site_style_yellow' => esc_html__('Yellow', 'motors'),
                'site_style_custom' => esc_html__('Custom Colors', 'motors'),
            )
        );
    }
} else {
    $site_styles['site_style'] = array(
        'label' => esc_html__('Style', 'motors'),
        'type' => 'stm-select',
        'choices' => array(
            'site_style_default' => esc_html__('Default', 'motors'),
            'site_style_blue' => esc_html__('Corall', 'motors'),
            'site_style_light_blue' => esc_html__('Turquoise', 'motors'),
            'site_style_orange' => esc_html__('Green', 'motors'),
            'site_style_red' => esc_html__('Red', 'motors'),
            'site_style_custom' => esc_html__('Custom Colors', 'motors'),
        )
    );
}

if (stm_is_motorcycle()) {
    $site_styles['site_style_base_color'] = array(
        'label' => esc_html__('Custom Base Color', 'motors'),
        'type' => 'color',
        'default' => '#df1d1d'
    );

    $site_styles['site_style_secondary_color'] = array(
        'label' => esc_html__('Custom Secondary Color', 'motors'),
        'type' => 'color',
        'default' => '#2f3c40'
    );
} else {
    if (stm_is_boats()) {
        $site_styles['site_style_base_color'] = array(
            'label' => esc_html__('Custom Base Color', 'motors'),
            'type' => 'color',
            'default' => '#31a3c6'
        );

        $site_styles['site_style_secondary_color'] = array(
            'label' => esc_html__('Custom Secondary Color', 'motors'),
            'type' => 'color',
            'default' => '#ceac61'
        );

        $site_styles['site_style_base_color_listing'] = array(
            'label' => esc_html__('Custom Third Color', 'motors'),
            'type' => 'color',
            'default' => '#002568'
        );

    } else {
        $site_styles['site_style_base_color'] = array(
            'label' => esc_html__('Custom Base Car Dealer Color', 'motors'),
            'type' => 'color',
            'default' => '#cc6119'
        );

        $site_styles['site_style_secondary_color'] = array(
            'label' => esc_html__('Custom Secondary Car Dealer Color', 'motors'),
            'type' => 'color',
            'default' => '#6c98e1'
        );

        $site_styles['site_style_base_color_listing'] = array(
            'label' => esc_html__('Custom Base Listing Color', 'motors'),
            'type' => 'color',
            'default' => '#1bc744'
        );

        $site_styles['site_style_secondary_color_listing'] = array(
            'label' => esc_html__('Custom Secondary Listing Color', 'motors'),
            'type' => 'color',
            'default' => '#153e4d'
        );
    }
}

$site_styles_default = array(
    'site_boxed' => array(
        'label' => esc_html__('Enable Boxed Layout', 'motors'),
        'type' => 'stm-checkbox',
        'default' => false
    ),
    'bg_image' => array(
        'label' => esc_html__('Background Image', 'motors'),
        'type' => 'stm-bg',
        'choices' => array(
            'stm-background-customizer-box_img_5' => 'box_img_5_preview.png',
            'stm-background-customizer-box_img_1' => 'box_img_1_preview.png',
            'stm-background-customizer-box_img_2' => 'box_img_2_preview.png',
            'stm-background-customizer-box_img_3' => 'box_img_3_preview.jpg',
            'stm-background-customizer-box_img_4' => 'box_img_4_preview.jpg',
        )
    ),
    'custom_bg_image' => array(
        'label' => esc_html__('Custom Bg Image', 'motors'),
        'type' => 'image'
    ),

    'frontend_customizer' => array(
        'label' => esc_html__('Frontend Customizer', 'motors'),
        'type' => 'stm-checkbox',
        'default' => false
    ),
    'enable_preloader' => array(
        'label' => esc_html__('Enable Preloader', 'motors'),
        'type' => 'stm-checkbox',
        'default' => false
    ),
    'smooth_scroll' => array(
        'label' => esc_html__('Site smooth scroll', 'motors'),
        'type' => 'stm-checkbox',
        'default' => false
    ),
);

if (stm_is_motorcycle()) {
    $site_styles['site_bg_color'] = array(
        'label' => esc_html__('Site Background Color', 'motors'),
        'type' => 'color',
        'default' => '#0e1315'
    );
}

$site_styles = array_merge($site_styles, $site_styles_default);


STM_Customizer::setSection('site_style', array(
    'title' => esc_html__('Style', 'motors'),
    'panel' => 'site_settings',
    'priority' => 220,
    'fields' => $site_styles
));

//Typography
STM_Customizer::setSection('typography', array(
    'title' => esc_html__('Typography', 'motors'),
    'panel' => 'site_settings',
    'priority' => 230,
    'fields' => array(
        'typography_body_font_family' => array(
            'label' => esc_html__('Body Font Family', 'motors'),
            'type' => 'stm-font-family',
            'output' => 'body, .normal_font, #top-bar, #top-bar a,.icon-box .icon-text .content',
        ),
        'typography_body_font_size' => array(
            'label' => esc_html__('Body Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '30',
            'output' => 'body, .normal_font',
            'default' => '14'
        ),
        'typography_body_line_height' => array(
            'label' => esc_html__('Body Line Height', 'motors'),
            'type' => 'stm-attr',
            'units' => 'px',
            'mode' => 'line-height',
            'output' => 'body, .normal_font',
            'default' => '22'
        ),
        'typography_body_color' => array(
            'label' => esc_html__('Body Font Color', 'motors'),
            'type' => 'color',
            'output' => array('color' => 'body, .normal_font'),
            'transport' => 'postMessage',
            'default' => '#232628'
        ),
        'typography_break_1' => array(
            'type' => 'stm-separator',
        ),
        'typography_menu_font_family' => array(
            'label' => esc_html__('Menu Text Font Family', 'motors'),
            'type' => 'stm-font-family',
            'output' => '.header-menu li a',
        ),
        'typography_menu_font_size' => array(
            'label' => esc_html__('Menu Text Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '30',
            'output' => '.header-menu li a',
            'default' => '13'
        ),
        'typography_menu_color' => array(
            'label' => esc_html__('Menu Text Color', 'motors'),
            'type' => 'color',
            'output' => array('color' => '.header-menu li a'),
            'transport' => 'postMessage',
            'default' => '#232628'
        ),
        'typography_break_2' => array(
            'type' => 'stm-separator',
        ),
        'typography_heading_font_family' => array(
            'label' => esc_html__('Headings Font Family', 'motors'),
            'type' => 'stm-font-family',
            'output' => 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6,.heading-font,.button,
			.load-more-btn,.vc_tta-panel-title,.page-numbers li > a,.page-numbers li > span,
			.vc_tta-tabs .vc_tta-tabs-container .vc_tta-tabs-list .vc_tta-tab a span,.stm_auto_loan_calculator input,
			.post-content blockquote,.contact-us-label,.stm-shop-sidebar-area .widget.widget_product_categories > ul,
			#main .stm-shop-sidebar-area .widget .product_list_widget li .product-title,
			#main .stm-shop-sidebar-area .widget .product_list_widget li a,
			.woocommerce ul.products li.product .onsale,
			.woocommerce div.product p.price, .woocommerce div.product span.price,
			.woocommerce div.product .woocommerce-tabs ul.tabs li a,
			.woocommerce table.shop_attributes td,
			.woocommerce table.shop_table td.product-name a,
			.woocommerce-cart table.cart td.product-price,
			.woocommerce-cart table.cart td.product-subtotal,
			.stm-list-style-counter li:before,
			.ab-booking-form .ab-nav-steps .ab-btn,
			body.stm-template-motorcycle .stm_motorcycle-header .stm_mc-main.header-main .stm_top-menu li .sub-menu a,
			.wpb_tour_tabs_wrapper.ui-tabs ul.wpb_tabs_nav > li > a,
			.header-listing .listing-menu li a'
        ),
        'typography_heading_color' => array(
            'label' => esc_html__('Headings Color', 'motors'),
            'type' => 'color',
            'output' => array('color' => 'h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6,.heading-font,.button,.load-more-btn,.vc_tta-panel-title,.page-numbers li > a,.page-numbers li > span,.vc_tta-tabs .vc_tta-tabs-container .vc_tta-tabs-list .vc_tta-tab a span,.stm_auto_loan_calculator input'),
            'transport' => 'postMessage',
            'default' => '#232628'
        ),
        'typography_h1_font_size' => array(
            'label' => esc_html__('H1 Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '50',
            'output' => 'h1, .h1',
            'default' => '50'
        ),
        'typography_h2_font_size' => array(
            'label' => esc_html__('H2 Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '50',
            'output' => 'h2, .h2',
            'default' => '36'
        ),
        'typography_h3_font_size' => array(
            'label' => esc_html__('H3 Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '50',
            'output' => 'h3, .h3',
            'default' => '26'
        ),
        'typography_h4_font_size' => array(
            'label' => esc_html__('H4 Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '50',
            'output' => 'h4, .h4',
            'default' => '16'
        ),
        'typography_h5_font_size' => array(
            'label' => esc_html__('H5 Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '50',
            'output' => 'h5, .h5',
            'default' => '14'
        ),
        'typography_h6_font_size' => array(
            'label' => esc_html__('H6 Font Size', 'motors'),
            'type' => 'stm-attr',
            'mode' => 'font-size',
            'units' => 'px',
            'min' => '0',
            'max' => '50',
            'output' => 'h6, .h6',
            'default' => '12'
        ),
    )
));

STM_Customizer::setSection('static_front_page', array(
    'title' => esc_html__('Static Front Page', 'motors'),
    'panel' => 'site_settings',
    'priority' => 190,
));

$default_color = '#232628';
if (stm_is_boats()) {
    $default_color = '#002568';
}

$header_layout_settings = array(
    'title' => esc_html__('Main settings', 'motors'),
    'panel' => 'header',
    'fields' => array(
        'header_bg_color' => array(
            'label' => esc_html__('Header Background Color', 'motors'),
            'type' => 'color',
            'output' => array('background-color' => '.header-main'),
            'transport' => 'postMessage',
            'default' => $default_color
        ),
        //Main phone
        'header_main_phone_label' => array(
            'label' => esc_html__('Main phone label', 'motors'),
            'type' => 'text',
            'default' => 'Sales'
        ),
        'header_main_phone' => array(
            'label' => esc_html__('Main phone', 'motors'),
            'type' => 'text',
            'default' => '888-694-5544'
        ),
        'header_layout_break_1' => array(
            'type' => 'stm-separator',
        ),
        //Secondary phone 1
        'header_secondary_phone_label_1' => array(
            'label' => esc_html__('Secondary phone label 1', 'motors'),
            'type' => 'text',
            'default' => 'Service'
        ),
        'header_secondary_phone_1' => array(
            'label' => esc_html__('Secondary phone 1', 'motors'),
            'type' => 'text',
            'default' => '888-637-7262'
        ),
        //Secondary phone 2
        'header_secondary_phone_label_2' => array(
            'label' => esc_html__('Secondary phone label 2', 'motors'),
            'type' => 'text',
            'default' => 'Parts'
        ),
        'header_secondary_phone_2' => array(
            'label' => esc_html__('Secondary phone 2', 'motors'),
            'type' => 'text',
            'default' => '888-404-7008'
        ),
        'header_layout_break_2' => array(
            'type' => 'stm-separator',
        ),
        //Address
        'header_address' => array(
            'label' => esc_html__('Address', 'motors'),
            'type' => 'text',
            'default' => '1840 E Garvey Ave South West Covina, CA 91791'
        ),
        'header_address_url' => array(
            'label' => esc_html__('Google Map Address URL', 'motors'),
            'type' => 'text',
        ),
        'header_break_1' => array(
            'type' => 'stm-separator',
        ),
        'header_style' => array(
            'label' => esc_html__('Header Style', 'motors'),
            'type' => 'stm-heading',
        ),
        'header_sticky' => array(
            'label' => esc_html__('Sticky', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        'header_compare_show' => array(
            'label' => esc_html__('Show compare', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        'header_cart_show' => array(
            'label' => esc_html__('Show cart', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
    )
);

if (stm_is_listing()) {
    $header_layout_settings['fields']['header_layout_break_listing'] = array(
        'type' => 'stm-separator',
    );
    $header_layout_settings['fields']['header_listing_layout_image_bg'] = array(
        'label' => esc_html__('Listing layout header image for non-transparent option', 'motors'),
        'type' => 'image'
    );
    $header_layout_settings['fields']['header_listing_btn_text'] = array(
        'label' => esc_html__('Button label in header', 'motors'),
        'type' => 'text',
        'default' => esc_html__('Add your item', 'motors')
    );
    $header_layout_settings['fields']['header_listing_btn_link'] = array(
        'label' => esc_html__('Button link in header', 'motors'),
        'type' => 'text',
        'default' => esc_attr('/add-car')
    );
}

if (stm_get_current_layout() == 'boats') {
    $header_layout_settings['fields']['header_layout_break_listing'] = array(
        'type' => 'stm-separator',
    );
    $header_layout_settings['fields']['boats_header_layout'] = array(
        'label' => esc_html__('Boats Header Layout', 'motors'),
        'type' => 'stm-select',
        'default' => 'boats',
        'choices' => array(
            'boats' => esc_html__('Boats', 'motors'),
            'car_dealer' => esc_html__('Car Dealer', 'motors'),
        )
    );
    $header_layout_settings['fields']['shopping_cart_boats'] = array(
        'label' => esc_html__('Shopping Cart Enabled (Woocommerce needed)', 'motors'),
        'type' => 'stm-checkbox',
        'sanitize_callback' => 'sanitize_checkbox',
        'default' => true
    );
}

if (stm_get_current_layout() == 'motorcycle') {
    $header_layout_settings['fields']['header_layout_break_listing'] = array(
        'type' => 'stm-separator',
    );
    $header_layout_settings['fields']['motorcycle_header_layout'] = array(
        'label' => esc_html__('Motorcycle Header Layout', 'motors'),
        'type' => 'stm-select',
        'default' => 'motorcycle',
        'choices' => array(
            'motorcycle' => esc_html__('Motorcycle', 'motors'),
        )
    );
}

STM_Customizer::setSection('header_layout', $header_layout_settings);

STM_Customizer::setSection('header_top_bar', array(
    'title' => esc_html__('Top bar', 'motors'),
    'panel' => 'header',
    'fields' => array(
        'top_bar_enable' => array(
            'label' => esc_html__('Top bar Enabled', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        'top_bar_login' => array(
            'label' => esc_html__('Top bar Login Enabled (Woocommerce needed or listing Layout chosen)', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        'top_bar_wpml_switcher' => array(
            'label' => esc_html__('Top bar language switcher (WPML needed)', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        //Address
        'top_bar_address' => array(
            'label' => esc_html__('Address', 'motors'),
            'type' => 'text',
            'default' => '1010 Moon ave, New York, NY US'
        ),
        'top_bar_address' => array(
            'label' => esc_html__('Address', 'motors'),
            'type' => 'text',
            'default' => '1010 Moon ave, New York, NY US'
        ),
        'top_bar_address_mobile' => array(
            'label' => esc_html__('Show address on mobile', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        //Working Hours
        'top_bar_working_hours' => array(
            'label' => esc_html__('Working Hours', 'motors'),
            'type' => 'text',
            'default' => 'Mon - Sat 8.00 - 18.00'
        ),
        'top_bar_working_hours_mobile' => array(
            'label' => esc_html__('Show Working hours on mobile', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        //Phone number
        'top_bar_phone' => array(
            'label' => esc_html__('Phone number', 'motors'),
            'type' => 'text',
            'default' => '+1 212-226-3126'
        ),
        'top_bar_phone_mobile' => array(
            'label' => esc_html__('Show phone on mobile', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        // Top bar menu
        'top_bar_menu' => array(
            'label' => esc_html__('Top bar menu Enabled', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => false
        ),
        'top_bar_socials_enable' => array(
            'label' => esc_html__('Top bar Socials', 'motors'),
            'type' => 'stm-multiple-checkbox',
            'choices' => $socials
        ),
        'top_bar_bg_color' => array(
            'label' => esc_html__('Top bar background color', 'motors'),
            'type' => 'color',
            'output' => array('background-color' => '#top-bar'),
            'transport' => 'postMessage',
            'default' => $default_color
        ),
    )
));

STM_Customizer::setSection('service_layout', array(
    'title' => esc_html__('Service Layout', 'motors'),
    'fields' => array(
        'service_header_label' => array(
            'label' => esc_html__('Header button label', 'motors'),
            'type' => 'text',
            'default' => esc_html__('Make an Appointment', 'motors')
        ),
        'service_header_link' => array(
            'label' => esc_html__('Header button link', 'motors'),
            'type' => 'text',
            'default' => '#appointment-form',
        ),
    )
));

STM_Customizer::setSection('header_socials', array(
    'title' => esc_html__('Header Socials', 'motors'),
    'panel' => 'header',
    'fields' => array(
        'header_socials_enable' => array(
            'label' => esc_html__('Header Socials', 'motors'),
            'type' => 'stm-multiple-checkbox',
            'choices' => $socials
        ),
    )
));

STM_Customizer::setSection('footer_layout', array(
    'title' => esc_html__('Main settings', 'motors'),
    'panel' => 'footer',
    'fields' => array(
        'footer_bg_color' => array(
            'label' => esc_html__('Footer background color', 'motors'),
            'type' => 'color',
            'output' => array('background-color' => '#footer-main'),
            'transport' => 'postMessage',
            'default' => $footer_bg
        ),
        'footer_sidebar_count' => array(
            'label' => esc_html__('Widget Areas', 'motors'),
            'type' => 'stm-select',
            'default' => 4,
            'choices' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4
            )
        ),
        'footer_break_2' => array(
            'type' => 'stm-separator',
        ),
        'footer_copyright' => array(
            'label' => esc_html__('Footer copyright Enabled', 'motors'),
            'type' => 'stm-checkbox',
            'sanitize_callback' => 'sanitize_checkbox',
            'default' => true
        ),
        'footer_copyright_color' => array(
            'label' => esc_html__('Footer Copyright background color', 'motors'),
            'type' => 'color',
            'output' => array('background-color' => '#footer-main'),
            'transport' => 'postMessage',
            'default' => '#232628'
        ),
        'footer_copyright_text' => array(
            'label' => esc_html__('Copyright', 'motors'),
            'default' => esc_html__('&copy; 2015 <a target="_blank" href="http://www.stylemixthemes.com/">Stylemix Themes</a><span class="divider"></span>Trademarks and brands are the property of their respective owners.', 'motors'),
            'type' => 'stm-text'
        ),
        'footer_socials_enable' => array(
            'label' => esc_html__('Copyright Socials', 'motors'),
            'type' => 'stm-multiple-checkbox',
            'choices' => $socials
        ),
    )
));

STM_Customizer::setSection('footer_scripts', array(
    'title' => esc_html__('Additional Scripts', 'motors'),
    'panel' => 'footer',
    'fields' => array(
        'footer_custom_scripts' => array(
            'label' => '',
            'type' => 'stm-code',
            'placeholder' => 'alert("hello");',
            'description' => esc_html__("Enter in any custom script to include in your site's footer. Be sure to use double quotes for strings.", 'motors')
        )
    )
));

if (!stm_is_motorcycle()) {
    $listing_features = array(
        'listing_archive' => array(
            'label' => esc_html__('Listing archive', 'motors'),
            'type' => 'stm-post-type',
            'post_type' => 'page',
            'description' => esc_html__('Choose listing archive page', 'motors'),
            'default' => ''
        ),
        'listing_filter_position' => array(
            'label' => esc_html__('Filter Position', 'motors'),
            'type' => 'stm-select',
            'default' => 'left',
            'choices' => $positions
        ),
        'classic_listing_title_bg' => array(
            'label' => esc_html__('Title background', 'motors'),
            'type' => 'image'
        ),
        'classic_listing_title' => array(
            'label' => esc_html__('Listing archive "Title box" title', 'motors'),
            'type' => 'text',
            'default' => esc_html__('Inventory', 'motors'),
        ),
        'price_currency' => array(
            'label' => esc_html__('Price currency', 'motors'),
            'type' => 'text',
            'default' => '$'
        ),
        'price_currency_position' => array(
            'label' => esc_html__('Price currency position', 'motors'),
            'type' => 'stm-select',
            'choices' => $positions,
            'default' => 'left'
        ),
        'price_delimeter' => array(
            'label' => esc_html__('Price delimeter', 'motors'),
            'type' => 'text',
            'default' => ' '
        ),
        'enable_location' => array(
            'label' => esc_html__('Show location/include location in filter', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'distance_measure_unit' => array(
            'label' => esc_html__('Unit measurement', 'motors'),
            'type' => 'stm-select',
            'choices' => array(
                'miles' => esc_html__('Miles', 'motors'),
                'kilometers' => esc_html__('Kilometers', 'motors'),
            ),
            'default' => 'miles'
        ),
        'distance_search' => array(
            'label' => esc_html__('Search radius', 'motors'),
            'type' => 'text',
        ),
        'show_listing_stock' => array(
            'label' => esc_html__('Show stock', 'motors'),
            'type' => 'checkbox',
            'default' => $show_on_dealer
        ),
        'show_listing_test_drive' => array(
            'label' => esc_html__('Show test drive schedule', 'motors'),
            'type' => 'checkbox',
            'default' => false
        ),
        'show_listing_compare' => array(
            'label' => esc_html__('Show compare', 'motors'),
            'type' => 'checkbox',
            'default' => $show_on_dealer
        ),
        'show_listing_share' => array(
            'label' => esc_html__('Show share block', 'motors'),
            'type' => 'checkbox',
        ),
        'show_listing_pdf' => array(
            'label' => esc_html__('Show PDF brochure', 'motors'),
            'type' => 'checkbox',
        ),
        'show_listing_certified_logo_1' => array(
            'label' => esc_html__('Show certified logo 1', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'show_listing_certified_logo_2' => array(
            'label' => esc_html__('Show certified logo 2', 'motors'),
            'type' => 'checkbox',
            'default' => $show_on_dealer
        ),
        'typography_break_1' => array(
            'type' => 'stm-separator',
        ),
        'listing_directory_title_default' => array(
            'label' => esc_html__('Default Title', 'motors'),
            'type' => 'text',
            'default' => esc_html__('Cars for sale', 'motors')
        ),
        'listing_directory_title_generated_affix' => array(
            'label' => esc_html__('Generated title affix', 'motors'),
            'type' => 'text',
            'default' => esc_html__(' for sale', 'motors')
        ),
        'listing_directory_title_frontend' => array(
            'label' => esc_html__('Display generated car title as:', 'motors'),
            'type' => 'text',
            'default' => esc_html__('{make} {serie} {ca-year}', 'motors'),
            'description' => esc_html__('"Put in curly brackets slug of taxonomy. For Example - {make} {serie} {ca-year}. Leave empty if you want to display default car title."', 'motors'),
        ),
        'show_generated_title_as_label' => array(
            'label' => esc_html__('Show two first parametres as a badge (only on archive page)', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'enable_favorite_items' => array(
            'label' => esc_html__('Enable favorites', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'listing_directory_enable_dealer_info' => array(
            'label' => esc_html__('Enable dealer info on listing', 'motors'),
            'type' => 'checkbox',
            'default' => $show_on_listing
        ),
        'hide_price_labels' => array(
            'label' => esc_html__('Hide price labels on listing archive', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'sidebar_filter_bg' => array(
            'label' => esc_html__('Listing sidebar filter background', 'motors'),
            'type' => 'image',
            'default' => get_template_directory_uri() . '/assets/images/listing-directory-filter-bg.jpg'
        ),
    );

    $listing_features['listing_grid_choices'] = array(
        'label' => esc_html__('Items per page choices(Grid version. Ex: 9,12,18,27).', 'motors'),
        'type' => 'text',
        'default' => '9,12,18,27'
    );
    $listing_features['listing_grid_choice'] = array(
        'label' => esc_html__('Default choice (Ex: 9).', 'motors'),
        'type' => 'text',
        'default' => '9'
    );
} else {
    $listing_features = array(
        'listing_archive' => array(
            'label' => esc_html__('Listing archive', 'motors'),
            'type' => 'stm-post-type',
            'post_type' => 'page',
            'description' => esc_html__('Choose listing archive page', 'motors'),
            'default' => ''
        ),
        'listing_filter_position' => array(
            'label' => esc_html__('Filter Position', 'motors'),
            'type' => 'stm-select',
            'default' => 'left',
            'choices' => $positions
        ),
        'classic_listing_title_bg' => array(
            'label' => esc_html__('Title background', 'motors'),
            'type' => 'image'
        ),
        'classic_listing_title' => array(
            'label' => esc_html__('Listing archive "Title box" title', 'motors'),
            'type' => 'text',
            'default' => esc_html__('Inventory', 'motors'),
        ),
        'price_currency' => array(
            'label' => esc_html__('Price currency', 'motors'),
            'type' => 'text',
            'default' => '$'
        ),
        'price_currency_position' => array(
            'label' => esc_html__('Price currency position', 'motors'),
            'type' => 'stm-select',
            'choices' => $positions,
            'default' => 'left'
        ),
        'price_delimeter' => array(
            'label' => esc_html__('Price delimeter', 'motors'),
            'type' => 'text',
            'default' => ' '
        ),
        'show_listing_stock' => array(
            'label' => esc_html__('Show stock', 'motors'),
            'type' => 'checkbox',
            'default' => $show_on_dealer
        ),
        'show_listing_compare' => array(
            'label' => esc_html__('Show compare', 'motors'),
            'type' => 'checkbox',
            'default' => $show_on_dealer
        ),
        'show_listing_test_drive' => array(
            'label' => esc_html__('Show "Test drive" popup', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'show_listing_quote' => array(
            'label' => esc_html__('Show "Quote by phone"', 'motors'),
            'type' => 'checkbox',
            'default' => false
        ),
        'show_listing_trade' => array(
            'label' => esc_html__('Show "Trade value" popup', 'motors'),
            'type' => 'checkbox',
            'default' => false
        ),
        'show_listing_calculate' => array(
            'label' => esc_html__('Show "Calculate Payment" popup', 'motors'),
            'type' => 'checkbox',
            'default' => false
        ),
        'show_listing_vin' => array(
            'label' => esc_html__('Show "VIN" link', 'motors'),
            'type' => 'checkbox',
            'default' => true
        ),
        'typography_break_1' => array(
            'type' => 'stm-separator',
        ),
        'listing_directory_title_default' => array(
            'label' => esc_html__('Default Title', 'motors'),
            'type' => 'text',
            'default' => esc_html__('Cars for sale', 'motors')
        ),
        'listing_directory_title_generated_affix' => array(
            'label' => esc_html__('Generated title affix', 'motors'),
            'type' => 'text',
            'default' => esc_html__(' for sale', 'motors')
        ),
        'listing_directory_title_frontend' => array(
            'label' => esc_html__('Display generated car title as:', 'motors'),
            'type' => 'text',
            'default' => esc_html__('{make} {serie} {ca-year}', 'motors'),
            'description' => esc_html__('"Put in curly brackets slug of taxonomy. For Example - {make} {serie} {ca-year}. Leave empty if you want to display default car title."', 'motors'),
        ),
        'show_generated_title_as_label' => array(
            'label' => esc_html__('Show first parametre as a badge (only on archive page)', 'motors'),
            'type' => 'checkbox',
            'default' => true
        )
    );

    $listing_features['listing_grid_choices'] = array(
        'label' => esc_html__('Items per page choices(Grid version. Ex: 9,12,18,27).', 'motors'),
        'type' => 'text',
        'default' => '9,12,18,27'
    );
    $listing_features['listing_grid_choice'] = array(
        'label' => esc_html__('Default choice (Ex: 9).', 'motors'),
        'type' => 'text',
        'default' => '9'
    );
}

if (stm_is_boats()) {
    $listing_features['listing_boat_filter'] = array(
        'label' => esc_html__('Use Boats filter style', 'motors'),
        'type' => 'checkbox',
        'default' => true
    );
    $listing_features['listing_list_sort_slug'] = array(
        'label' => esc_html__('List version sort parameter (Type slug)', 'motors'),
        'type' => 'text',
        'default' => 'make'
    );
    $listing_features['listing_grid_choices'] = array(
        'label' => esc_html__('Items per page choices(Grid version. Ex: 9,12,18,27).', 'motors'),
        'type' => 'text',
        'default' => '9,12,18,27'
    );
    $listing_features['listing_grid_choice'] = array(
        'label' => esc_html__('Default choice (Ex: 9).', 'motors'),
        'type' => 'text',
        'default' => '9'
    );
}

STM_Customizer::setSection('listing_features', array(
    'title' => esc_html__('Inventory settings', 'motors'),
    'panel' => 'listing',
    'fields' => $listing_features
));

$single_car_settings = array(
    'show_stock' => array(
        'label' => esc_html__('Show stock', 'motors'),
        'type' => 'checkbox',
        'default' => true,
        'default' => true
    ),
    'show_test_drive' => array(
        'label' => esc_html__('Show test drive schedule', 'motors'),
        'type' => 'checkbox',
        'default' => true
    ),
    'show_compare' => array(
        'label' => esc_html__('Show compare', 'motors'),
        'type' => 'checkbox',
        'default' => true
    ),
    'show_share' => array(
        'label' => esc_html__('Show share block', 'motors'),
        'type' => 'checkbox',
        'default' => true
    ),
    'show_pdf' => array(
        'label' => esc_html__('Show PDF brochure', 'motors'),
        'type' => 'checkbox',
        'default' => true
    ),
    'show_certified_logo_1' => array(
        'label' => esc_html__('Show certified logo 1', 'motors'),
        'type' => 'checkbox',
    ),
    'show_certified_logo_2' => array(
        'label' => esc_html__('Show certified logo 2', 'motors'),
        'type' => 'checkbox',
    ),
    'show_featured_btn' => array(
        'label' => esc_html__('Show featured button', 'motors'),
        'type' => 'checkbox',
        'default' => $show_on_listing
    ),
    'single_car_break' => array(
        'type' => 'stm-separator',
    ),
    'show_vin' => array(
        'label' => esc_html__('Show VIN', 'motors'),
        'type' => 'checkbox',
        'default' => $show_on_listing
    ),
    'show_registered' => array(
        'label' => esc_html__('Show Registered date', 'motors'),
        'type' => 'checkbox',
        'default' => $show_on_listing
    ),
    'show_history' => array(
        'label' => esc_html__('Show History', 'motors'),
        'type' => 'checkbox',
        'default' => $show_on_listing
    ),
);

if (stm_is_motorcycle()) {
    $single_car_settings['stm_single_car_page'] = array(
        'label' => esc_html__('Single car page background', 'motors'),
        'type' => 'image',
    );
    $single_car_settings['stm_car_link_quote'] = array(
        'label' => esc_html__('Request a quote link', 'motors'),
        'type' => 'text',
    );
}

if (stm_is_listing()) {
    $single_car_settings['stm_similar_query'] = array(
        'label' => esc_html__('Show similar cars by param (slug of listing category, separated by comma, without spaces. Ex: make,condition)', 'motors'),
        'type' => 'text',
        'default' => ''
    );
}

STM_Customizer::setSection('car_settings', array(
    'title' => esc_html__('Single Car Settings', 'motors'),
    'panel' => 'listing',
    'fields' => $single_car_settings
));

STM_Customizer::setSection('compare', array(
    'title' => esc_html__('Compare', 'motors'),
    'panel' => 'listing',
    'fields' => array(
        'compare_page' => array(
            'label' => esc_html__('Compare page', 'motors'),
            'type' => 'stm-post-type',
            'post_type' => 'page',
            'description' => esc_html__('Choose landing page for compare', 'motors'),
            'default' => '156'
        ),
    )
));

if (stm_is_listing()) {
    STM_Customizer::setSection('user_dealer', array(
        'title' => esc_html__('User/Dealer options', 'motors'),
        'panel' => 'listing',
        'fields' => array(
            'dealer_list_page' => array(
                'label' => esc_html__('Dealer list page', 'motors'),
                'type' => 'stm-post-type',
                'post_type' => 'page',
                'description' => esc_html__('Choose page for Dealer list page', 'motors'),
                'default' => '2119'
            ),
            'login_page' => array(
                'label' => esc_html__('Login/Registration page', 'motors'),
                'type' => 'stm-post-type',
                'post_type' => 'page',
                'description' => esc_html__('Choose page for login User/Dealer', 'motors'),
                'default' => '1718'
            ),
            'user_sidebar' => array(
                'label' => esc_html__('Default user sidebar', 'motors'),
                'type' => 'stm-post-type',
                'post_type' => 'sidebar',
                'description' => esc_html__('Choose page for Default user sidebar', 'motors'),
                'default' => '1725'
            ),
            'user_sidebar_position' => array(
                'label' => esc_html__('User Sidebar Position', 'motors'),
                'type' => 'radio',
                'choices' => array(
                    'left' => __('Left', 'motors'),
                    'right' => __('Right', 'motors')
                ),
                'default' => 'right'
            ),
            'dealer_sidebar' => array(
                'label' => esc_html__('Default dealer sidebar', 'motors'),
                'type' => 'stm-post-type',
                'post_type' => 'sidebar',
                'description' => esc_html__('Choose page for Default user sidebar', 'motors'),
                'default' => '1864'
            ),
            'dealer_sidebar_position' => array(
                'label' => esc_html__('Dealer Sidebar Position', 'motors'),
                'type' => 'radio',
                'choices' => array(
                    'left' => __('Left', 'motors'),
                    'right' => __('Right', 'motors')
                ),
                'default' => 'right'
            ),
            'user_add_car_page' => array(
                'label' => esc_html__('Add a car page', 'motors'),
                'type' => 'stm-post-type',
                'post_type' => 'page',
                'description' => esc_html__('Choose page for Add to car Page (Also, this page will be used for editing items)', 'motors'),
                'default' => '1755'
            ),
            'dealer_rate_1' => array(
                'label' => esc_html__('Rate 1 label:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('Customer Service', 'motors'),
            ),
            'dealer_rate_2' => array(
                'label' => esc_html__('Rate 2 label:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('Buying Process', 'motors'),
            ),
            'dealer_rate_3' => array(
                'label' => esc_html__('Rate 3 label:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('Overall Experience', 'motors'),
            ),
            'user_post_limit' => array(
                'label' => esc_html__('User Posts Limit:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('3', 'motors'),
            ),
            'user_post_images_limit' => array(
                'label' => esc_html__('User Post Images Upload Limit:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('5', 'motors'),
            ),
            'dealer_post_limit' => array(
                'label' => esc_html__('Dealer Posts Limit:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('50', 'motors'),
            ),
            'dealer_post_images_limit' => array(
                'label' => esc_html__('Dealer Post Images Upload Limit:', 'motors'),
                'type' => 'text',
                'default' => esc_html__('10', 'motors'),
            ),
            'user_image_size_limit' => array(
                'label' => esc_html__('Image size limit (Kb)', 'motors'),
                'type' => 'text',
                'default' => esc_html__('4000', 'motors'),
            ),
            'user_premoderation' => array(
                'label' => esc_html__('Enable User ads moderation', 'motors'),
                'type' => 'stm-checkbox',
                'default' => true
            ),
            'dealer_premoderation' => array(
                'label' => esc_html__('Enable Dealer ads moderation', 'motors'),
                'type' => 'stm-checkbox',
                'default' => false
            ),

            'enable_plans_sep' => array(
                'type' => 'stm-separator',
            ),

            'enable_plans' => array(
                'label' => esc_html__('Enable Pricing Plans (Woocommerce)', 'motors'),
                'type' => 'stm-checkbox',
                'default' => false
            ),
            'pricing_link' => array(
                'label' => esc_html__('Pricing Link', 'motors'),
                'type' => 'stm-post-type',
                'post_type' => 'page',
            ),

            'enable_demo_sep' => array(
                'type' => 'stm-separator',
            ),
            'site_demo_mode' => array(
                'label' => esc_html__('Site demo mode', 'motors'),
                'type' => 'stm-checkbox',
                'default' => false
            ),
        )
    ));

    STM_Customizer::setSection('stm_paypal_options', array(
        'title' => esc_html__('Paypal options', 'motors'),
        'panel' => 'listing',
        'fields' => array(
            'paypal_currency' => array(
                'label' => esc_html__('Currency', 'motors'),
                'type' => 'text',
                'default' => esc_html__('USD', 'motors'),
                'description' => esc_html__('Ex.: USD', 'motors'),
            ),
            'paypal_email' => array(
                'label' => esc_html__('Paypal Email', 'motors'),
                'type' => 'text',
                'default' => '',
            ),
            'paypal_mode' => array(
                'label' => esc_html__('Paypal mode', 'motors'),
                'type' => 'stm-select',
                'choices' => array(
                    'sandbox' => esc_html__('Sandbox', 'motors'),
                    'live' => esc_html__('Live', 'motors'),
                ),
                'default' => 'sandbox'
            ),
            'membership_cost' => array(
                'label' => esc_html__('Membership price', 'motors'),
                'type' => 'text',
                'default' => '',
                'description' => esc_html__('Membership submission price', 'motors'),
            ),
        )
    ));
}

STM_Customizer::setSection('shop', array(
    'title' => esc_html__('Shop', 'motors'),
    'priority' => 45,
    'fields' => array(
        'shop_sidebar' => array(
            'label' => esc_html__('Choose Shop Sidebar', 'motors'),
            'type' => 'stm-post-type',
            'post_type' => 'sidebar',
            'default' => '768'
        ),
        'shop_sidebar_position' => array(
            'label' => esc_html__('Shop Sidebar Position', 'motors'),
            'type' => 'radio',
            'choices' => array(
                'left' => __('Left', 'motors'),
                'right' => __('Right', 'motors')
            ),
            'default' => 'left'
        ),
    )
));


// Get sidebar posts
$sidebars = array(
    'no_sidebar' => esc_html__('Without sidebar', 'motors'),
    'primary_sidebar' => esc_html__('Primary sidebar', 'motors'),
);

$query = get_posts(array('post_type' => 'sidebar', 'posts_per_page' => -1));

if ($query) {
    foreach ($query as $post) {
        $sidebars[$post->ID] = get_the_title($post->ID);
    }
}


STM_Customizer::setSection('blog', array(
    'title' => esc_html__('Blog', 'motors'),
    'priority' => 40,
    'fields' => array(
        'view_type' => array(
            'label' => esc_html__('View type', 'motors'),
            'type' => 'radio',
            'choices' => array(
                'grid' => __('Grid', 'motors'),
                'list' => __('List', 'motors')
            ),
            'default' => 'grid'
        ),
        'sidebar' => array(
            'label' => esc_html__('Choose archive sidebar', 'motors'),
            'type' => 'stm-select',
            'choices' => $sidebars,
            'default' => 'primary_sidebar'
        ),
        'sidebar_blog' => array(
            'label' => esc_html__('Choose default sidebar for single blog post', 'motors'),
            'type' => 'stm-select',
            'choices' => $sidebars,
            'default' => 'primary_sidebar'
        ),
        'sidebar_position' => array(
            'label' => esc_html__('Sidebar position', 'motors'),
            'type' => 'radio',
            'choices' => array(
                'left' => __('Left', 'motors'),
                'right' => __('Right', 'motors')
            ),
            'default' => 'right'
        ),
        'blog_show_excerpt' => array(
            'label' => esc_html__('Show excerpt', 'motors'),
            'type' => 'checkbox',
        ),
    )
));

STM_Customizer::setSection('socials', array(
    'title' => esc_html__('Socials', 'motors'),
    'priority' => 60,
    'fields' => array(
        'socials_link' => array(
            'label' => esc_html__('Socials Links', 'motors'),
            'type' => 'stm-socials',
            'choices' => $socials
        )
    )
));

STM_Customizer::setSection('socials_widget', array(
    'title' => esc_html__('Socials Widget', 'motors'),
    'priority' => 70,
    'fields' => array(
        'socials_widget_enable' => array(
            'label' => esc_html__('"Social Widget" socials', 'motors'),
            'type' => 'stm-multiple-checkbox',
            'choices' => $socials
        )
    )
));


$allowed_tags = array(
    'a' => array(
        'href' => array(),
        'title' => array()
    )
);

$html = 'You can get a Google reCAPTCHA API from <a href="http://www.google.com/recaptcha/intro/" target="_blank">here</a>';

STM_Customizer::setSection('recaptcha', array(
    'title' => esc_html__('Recaptcha', 'motors'),
    'priority' => 80,
    'fields' => array(
        'enable_recaptcha' => array(
            'label' => esc_html__('Recaptcha', 'motors'),
            'type' => 'checkbox',
            'description' => wp_kses($html, $allowed_tags)
        ),
        'recaptcha_public_key' => array(
            'label' => esc_html__('Public key', 'motors'),
            'type' => 'text',
        ),
        'recaptcha_secret_key' => array(
            'label' => esc_html__('Secret key', 'motors'),
            'type' => 'text',
        ),
    )
));

STM_Customizer::setSection('css', array(
    'title' => esc_html__('CSS', 'motors'),
    'fields' => array(
        'custom_css' => array(
            'label' => '',
            'type' => 'stm-code',
            'placeholder' => ".classname {\n\tbackground: #000;\n}"
        )
    )
));