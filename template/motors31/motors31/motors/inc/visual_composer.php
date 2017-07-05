<?php

add_action('vc_before_init', 'stm_vc_set_as_theme');

function stm_vc_set_as_theme()
{
    vc_set_as_theme(true);
}

if (function_exists('vc_set_default_editor_post_types')) {
    vc_set_default_editor_post_types(array('page', 'post', 'sidebar', 'product', stm_listings_post_type()));
}

add_action('init', 'stm_update_existing_shortcodes');

function stm_update_existing_shortcodes()
{

    if (function_exists('vc_add_params')) {


        vc_add_params('vc_row', array(
            array(
                'type' => 'checkbox',
                'heading' => __('Enable STM Fullwidth', 'motors'),
                'param_name' => 'stm_fullwidth',
                'value' => array(
                    __('Yes', 'motors') => 'yes',
                ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Enable STM Fullwidth without js', 'motors'),
                'param_name' => 'stm_fullwidth',
                'value' => array(
                    __('Yes', 'motors') => 'yes',
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Blackout Opacity', 'motors'),
                'param_name' => 'blackout_opacity',
                'value' => array(
                    __('0%', 'motors') => '0',
                    __('20%', 'motors') => '20',
                    __('40%', 'motors') => '40',
                    __('60%', 'motors') => '60',
                    __('80%', 'motors') => '80',
                ),
                'dependency' => array('element' => 'stm_fullwidth', 'value' => 'yes'),
            )
        ));

        vc_add_param('vc_single_image', array(
            'type' => 'checkbox',
            'heading' => __('Enable STM theme fancybox on click', 'motors'),
            'param_name' => 'stm_fancybox',
            'value' => array(
                __('Yes', 'motors') => 'yes',
            ),
        ));

        vc_add_param('vc_tabs', array(
            'type' => 'checkbox',
            'heading' => __('Style 2', 'motors'),
            'param_name' => 'vc_tabs_style_2',
            'value' => array(
                __('Yes', 'motors') => 'yes',
            ),
        ));

        vc_add_param('vc_tabs', array(
            'type' => 'checkbox',
            'heading' => __('Service Style', 'motors'),
            'param_name' => 'vc_tabs_style_service',
            'value' => array(
                __('Yes', 'motors') => 'yes',
            ),
        ));

    }

    if (function_exists('vc_remove_param')) {
        vc_remove_param('vc_cta_button2', 'h2');
        vc_remove_param('vc_cta_button2', 'content');
        vc_remove_param('vc_cta_button2', 'btn_style');
        vc_remove_param('vc_cta_button2', 'color');
        vc_remove_param('vc_cta_button2', 'size');
        vc_remove_param('vc_cta_button2', 'css_animation');

        //Accordion
        vc_remove_param('vc_tta_accordion', 'color');
        vc_remove_param('vc_tta_accordion', 'shape');
        vc_remove_param('vc_tta_accordion', 'style');
        vc_remove_param('vc_tta_accordion', 'spacing');
        vc_remove_param('vc_tta_accordion', 'c_align');
        vc_remove_param('vc_tta_accordion', 'c_position');

        //Tabs
        vc_remove_param('vc_tta_tabs', 'title');
        vc_remove_param('vc_tta_tabs', 'style');
        vc_remove_param('vc_tta_tabs', 'shape');
        vc_remove_param('vc_tta_tabs', 'color');
        vc_remove_param('vc_tta_tabs', 'spacing');
        vc_remove_param('vc_tta_tabs', 'gap');
        vc_remove_param('vc_tta_tabs', 'alignment');
        vc_remove_param('vc_tta_tabs', 'pagination_style');
        vc_remove_param('vc_tta_tabs', 'pagination_color');

        //Toggle
        vc_remove_param('vc_toggle', 'style');
        vc_remove_param('vc_toggle', 'color');
        vc_remove_param('vc_toggle', 'size');
    }

    if (function_exists('vc_remove_element')) {
        vc_remove_element("vc_gallery");
        vc_remove_element("vc_images_carousel");
        vc_remove_element("vc_tta_tour");
        vc_remove_element("vc_cta");
        //vc_remove_element( "vc_toggle" );
        vc_remove_element("vc_tta_pageable");
        vc_remove_element("vc_cta_button");
        vc_remove_element("vc_posts_slider");
        vc_remove_element("vc_icon");
        vc_remove_element("vc_pinterest");
        vc_remove_element("vc_googleplus");
        vc_remove_element("vc_facebook");
        vc_remove_element("vc_tweetmeme");
    }

}

if (function_exists('vc_map')) {
    add_action('init', 'vc_stm_elements');
}

function vc_stm_elements()
{
    $order_by_values = array(
        '',
        __('Date', 'motors') => 'date',
        __('ID', 'motors') => 'ID',
        __('Author', 'motors') => 'author',
        __('Title', 'motors') => 'title',
        __('Modified', 'motors') => 'modified',
        __('Random', 'motors') => 'rand',
        __('Comment count', 'motors') => 'comment_count',
        __('Menu order', 'motors') => 'menu_order',
    );

    $order_way_values = array(
        '',
        __('Descending', 'motors') => 'DESC',
        __('Ascending', 'motors') => 'ASC',
    );

    vc_map(array(
        'name' => __('STM Auto Loan Calculator', 'motors'),
        'base' => 'stm_auto_loan_calculator',
        'icon' => 'stm_auto_loan_calculator',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Calculator Heading', 'motors'),
                'param_name' => 'title'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Currency symbol', 'motors'),
                'param_name' => 'currency_symbol'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Labels font size', 'motors'),
                'param_name' => 'label_font_size'
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Wide version', 'motors'),
                'param_name' => 'wide_version',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Get all filter options from STM listing plugin - Listing - listing categories
    if (function_exists('stm_get_car_filter')) {
        $filter_options = stm_get_car_filter();
    } else {
        $filter_options = array();
    }

    $stm_filter_options = array();

    if (!empty($filter_options)) {
        foreach ($filter_options as $filter_option) {
            $stm_filter_options[$filter_option['single_name']] = $filter_option['slug'];
        }
    }

    if (function_exists('stm_get_car_filter_checkboxes')) {
        $stm_get_car_filter_checkboxes = stm_get_car_filter_checkboxes();
    } else {
        $stm_get_car_filter_checkboxes = array();
    }

    if (!empty($stm_get_car_filter_checkboxes)) {
        foreach ($stm_get_car_filter_checkboxes as $filter_option) {
            $stm_filter_options[$filter_option['single_name']] = $filter_option['slug'];
        }
    }


    /*Products*/
    $plan_args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key'     => '_subscriptio',
                'value'   => 'yes',
                'compare' => '=',
            )
        )
    );

    $products = new WP_Query($plan_args);
    $products_array = array(__('Choose plan', 'motors') => '');
    if($products->have_posts()) {
        while($products->have_posts()) {
            $products->the_post();
            $title = get_the_title();
            $id = get_the_ID();
            $products_array[$title] = $id;
        }

    }


    //Icon box
    vc_map(array(
        'name' => __('STM Icon Box', 'motors'),
        'base' => 'stm_icon_box',
        'icon' => 'stm_icon_box',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => __('Title', 'motors'),
                'param_name' => 'title'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Title Holder', 'motors'),
                'param_name' => 'title_holder',
                'value' => array(
                    'H1' => 'h1',
                    'H2' => 'h2',
                    'H3' => 'h3',
                    'H4' => 'h4',
                    'H5' => 'h5',
                    'H6' => 'h6',
                ),
                'std' => 'h3'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Style', 'motors'),
                'param_name' => 'style_layout',
                'value' => array(
                    esc_html__('Car dealer', 'motors') => 'car_dealer',
                    esc_html__('Boats', 'motors') => 'boats'
                ),
                'std' => 'car_dealer'
            ),
            array(
                'type' => 'vc_link',
                'heading' => __('Link', 'motors'),
                'param_name' => 'link'
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box background color', 'motors'),
                'param_name' => 'box_bg_color',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box text color', 'motors'),
                'param_name' => 'box_text_color',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box text color on hover', 'motors'),
                'param_name' => 'box_text_color_hover',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Icon background color', 'motors'),
                'param_name' => 'icon_bg_color',
                'description' => __('Don\'t forget to add paddings in Icon design options tab', 'motors'),
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Show bottom triangle', 'motors'),
                'param_name' => 'bottom_triangle',
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'motors'),
                'param_name' => 'icon',
                'value' => ''
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Icon color', 'motors'),
                'param_name' => 'icon_color',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Icon Size', 'motors'),
                'param_name' => 'icon_size',
                'description' => __('Enter icon size in px', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Content line height', 'motors'),
                'param_name' => 'line_height',
                'description' => __('Optional', 'motors')
            ),
            array(
                'type' => 'textarea_html',
                'heading' => __('Text', 'motors'),
                'param_name' => 'content'
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Icon Css', 'motors'),
                'param_name' => 'css_icon',
                'group' => __('Icon Design options', 'motors')
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Colored Sep
    $colored = array(
        array(
            'type' => 'colorpicker',
            'heading' => __('Separator Color', 'motors'),
            'param_name' => 'color'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Align', 'motors'),
            'param_name' => 'align',
            'value' => array(
                __('Left', 'motors') => 'text-left',
                __('Center', 'motors') => 'text-center',
                __('Right', 'motors') => 'text-right',
            ),
            'std' => 'text-center'
        ),
        array(
            'type' => 'css_editor',
            'heading' => __('Css', 'motors'),
            'param_name' => 'css',
            'group' => __('Design options', 'motors')
        )
    );

    vc_map(array(
        'name' => __('STM Colored Separator', 'motors'),
        'base' => 'stm_color_separator',
        'icon' => 'stm_color_separator',
        'category' => __('STM', 'motors'),
        'params' => $colored
    ));

    //Spec offers
    vc_map(array(
        'name' => __('STM Special Offers', 'motors'),
        'base' => 'stm_special_offers',
        'icon' => 'stm_special_offers',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => __('Title', 'motors'),
                'param_name' => 'title'
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Show link to all specials', 'motors'),
                'param_name' => 'show_all_link_specials',
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Colored first word', 'motors'),
                'param_name' => 'colored_first_word',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Car listing Tabs
    vc_map(array(
        'name' => __('STM Car listing tabs', 'motors'),
        'base' => 'stm_car_listing_tabbed',
        'icon' => 'stm_car_listing_tabbed',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'colorpicker',
                'heading' => __('Top part background color', 'motors'),
                'param_name' => 'top_part_bg',
                'value' => '#232628'
            ),
            array(
                'type' => 'stm_autocomplete_vc',
                'heading' => __('Select category', 'motors'),
                'param_name' => 'taxonomy',
                'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Tab affix', 'motors'),
                'param_name' => 'tab_affix',
                'value' => __('cars', 'motors'),
                'description' => __('This will appear after category name', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Cars per load', 'motors'),
                'param_name' => 'per_page',
                'description' => __('-1 will show all cars from category', 'motors')
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Enable ajax loading', 'motors'),
                'param_name' => 'enable_ajax_loading',
            ),
            array(
                'type' => 'textarea_html',
                'heading' => __('Text', 'motors'),
                'param_name' => 'content'
            ),
            //Search tab Start
            array(
                'type' => 'checkbox',
                'heading' => __('Enable search', 'motors'),
                'param_name' => 'enable_search',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Search label', 'motors'),
                'param_name' => 'search_label',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Search label icon', 'motors'),
                'param_name' => 'search_icon',
                'value' => '',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Number of filter columns', 'motors'),
                'param_name' => 'filter_columns_number',
                'value' => array(
                    '6' => '6',
                    '4' => '4',
                    '3' => '3',
                    '2' => '2',
                    '1' => '1'
                ),
                'std' => '2',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'checkbox',
                'heading' => __('Select Filter options', 'motors'),
                'param_name' => 'filter_selected',
                'value' => $stm_filter_options,
                'group' => __('Search Options', 'motors')
            ),
            //Call to action
            array(
                'type' => 'checkbox',
                'heading' => __('Enable call-to-action', 'motors'),
                'param_name' => 'enable_call_to_action',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Call to action label', 'motors'),
                'param_name' => 'call_to_action_label',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Call to action label icon', 'motors'),
                'param_name' => 'call_to_action_icon',
                'value' => '',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Call to action label right', 'motors'),
                'param_name' => 'call_to_action_label_right',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Call to action label icon right', 'motors'),
                'param_name' => 'call_to_action_icon_right',
                'value' => '',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Call to action background color', 'motors'),
                'param_name' => 'call_to_action_color',
                'value' => '#fab637',
                'group' => __('Search Options', 'motors')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Call to action text color', 'motors'),
                'param_name' => 'call_to_action_text_color',
                'value' => '#fff',
                'group' => __('Search Options', 'motors')
            ),
            //Search tab End

            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            ),
        ),
    ));

    //Carousel
    vc_map(array(
        'name' => __('STM Carousel', 'motors'),
        'base' => 'stm_carousel',
        'icon' => 'stm_carousel',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_images',
                'heading' => __('Images', 'motors'),
                'param_name' => 'images'
            ),
            array(
                'type' => 'checkbox',
                'param_name' => 'fullwidth',
                'value' => array(
                    esc_html__('Enable Fullwidth', 'motors') => 'enable'
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Image size', 'motors'),
                'param_name' => 'image_size',
                'value' => 'thumbnail',
                'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'motors'),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Number of slides per row', 'motors'),
                'param_name' => 'slides_per_row',
                'value' => array(
                    '6' => '6',
                    '5' => '5',
                    '4' => '4',
                    '3' => '3',
                    '2' => '2',
                    '1' => '1'
                ),
                'std' => '4',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Testimonials
    vc_map(array(
        'name' => __('STM Testimonials', 'motors'),
        'base' => 'stm_testimonials',
        'as_parent' => array('only' => 'stm_testimonial'),
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        ),
        'js_view' => 'VcColumnView'
    ));

    vc_map(array(
        'name' => __('STM Testimonial', 'motors'),
        'base' => 'stm_testimonial',
        'as_child' => array('only' => 'stm_testimonials'),
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Image size', 'motors'),
                'param_name' => 'image_size',
                'value' => '213x142',
                'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'motors'),
            ),
            array(
                'type' => 'textarea_html',
                'heading' => __('Text', 'motors'),
                'param_name' => 'content'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Author name', 'motors'),
                'param_name' => 'author',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Author car model', 'motors'),
                'param_name' => 'author_car',
            ),
        )
    ));

    //OUR TEAM
    vc_map(array(
        'name' => __('STM Our team', 'motors'),
        'base' => 'stm_our_team',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Image size', 'motors'),
                'param_name' => 'image_size',
                'value' => '257x170',
                'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'motors'),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Team member Name', 'motors'),
                'param_name' => 'name',
                'holder' => 'div'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Team member position', 'motors'),
                'param_name' => 'position',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Team member email', 'motors'),
                'param_name' => 'email',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Team member phone', 'motors'),
                'param_name' => 'phone',
            ),
        )
    ));

    //OUR Partners
    vc_map(array(
        'name' => __('STM Our partners', 'motors'),
        'base' => 'stm_our_partners',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_images',
                'heading' => __('Partners Images', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Number to show', 'motors'),
                'param_name' => 'number_to_show',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Image size', 'motors'),
                'param_name' => 'image_size',
                'value' => '150x50',
                'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'motors'),
            ),
        )
    ));

    //OUR Partners
    vc_map(array(
        'name' => __('STM Services Archive', 'motors'),
        'base' => 'stm_service_archive',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Services per page', 'motors'),
                'param_name' => 'per_page',
                'value' => '6'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Image size', 'motors'),
                'param_name' => 'image_size',
                'value' => '350x205',
                'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'motors'),
            ),
        )
    ));

    //Tech info
    vc_map(array(
        'name' => __('STM Technical informations', 'motors'),
        'base' => 'stm_tech_infos',
        'as_parent' => array('only' => 'stm_tech_info'),
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Title', 'motors'),
                'param_name' => 'title',
                'holder' => 'div'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Icon size (px)', 'motors'),
                'param_name' => 'icon_size',
                'value' => '27'
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'motors'),
                'param_name' => 'icon',
                'value' => '',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        ),
        'js_view' => 'VcColumnView'
    ));
    vc_map(array(
        'name' => __('STM Technical information', 'motors'),
        'base' => 'stm_tech_info',
        'as_child' => array('only' => 'stm_tech_infos'),
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Sub title', 'motors'),
                'param_name' => 'subtitle',
                'holder' => 'div'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Technical parameter', 'motors'),
                'param_name' => 'name',
                'holder' => 'div'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Technical value', 'motors'),
                'param_name' => 'value',
                'holder' => 'div'
            ),
        )
    ));

    //GMAP
    vc_map(array(
        'name' => esc_html__('Google Map', 'motors'),
        'base' => 'stm_gmap',
        'icon' => 'stm_gmap',
        'category' => esc_html__('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Map Width', 'motors'),
                'param_name' => 'map_width',
                'value' => '100%',
                'description' => esc_html__('Enter map width in px or %', 'motors')
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Map Height', 'motors'),
                'param_name' => 'map_height',
                'value' => '460px',
                'description' => esc_html__('Enter map height in px', 'motors')
            ),
            array(
                'type' => 'attach_images',
                'heading' => __('Pin image', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Latitude', 'motors'),
                'param_name' => 'lat',
                'description' => wp_kses(__('<a href="http://www.latlong.net/convert-address-to-lat-long.html">Here is a tool</a> where you can find Latitude & Longitude of your location', 'motors'), array('a' => array('href' => array())))
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Longitude', 'motors'),
                'param_name' => 'lng',
                'description' => wp_kses(__('<a href="http://www.latlong.net/convert-address-to-lat-long.html">Here is a tool</a> where you can find Latitude & Longitude of your location', 'motors'), array('a' => array('href' => array())))
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Map Zoom', 'motors'),
                'param_name' => 'map_zoom',
                'value' => 18
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('InfoWindow text', 'motors'),
                'param_name' => 'infowindow_text',
            ),
            array(
                'type' => 'checkbox',
                'param_name' => 'disable_mouse_whell',
                'value' => array(
                    esc_html__('Disable map zoom on mouse wheel scroll', 'motors') => 'disable'
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra class name', 'motors'),
                'param_name' => 'el_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'motors')
            ),
            array(
                'type' => 'css_editor',
                'heading' => esc_html__('Css', 'motors'),
                'param_name' => 'css',
                'group' => esc_html__('Design options', 'motors')
            )
        )
    ));

    //Single car elements
    //Title
    vc_map(array(
        'name' => __('STM Single Car Title', 'motors'),
        'base' => 'stm_single_car_title',
        'icon' => 'stm_single_car_title',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    //Actions
    vc_map(array(
        'name' => __('STM Single Car Actions', 'motors'),
        'base' => 'stm_single_car_actions',
        'icon' => 'stm_single_car_actions',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    //Gallery
    vc_map(array(
        'name' => __('STM Single Car Gallery', 'motors'),
        'base' => 'stm_single_car_gallery',
        'icon' => 'stm_single_car_gallery',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    //Price
    vc_map(array(
        'name' => __('STM Single Car Price', 'motors'),
        'base' => 'stm_single_car_price',
        'icon' => 'stm_single_car_price',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    //Data
    vc_map(array(
        'name' => __('STM Single Car Data', 'motors'),
        'base' => 'stm_single_car_data',
        'icon' => 'stm_single_car_data',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    //MPG
    vc_map(array(
        'name' => __('STM Single Car MPG', 'motors'),
        'base' => 'stm_single_car_mpg',
        'icon' => 'stm_single_car_mpg',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    //Calculator
    vc_map(array(
        'name' => __('STM Single Car Calculator', 'motors'),
        'base' => 'stm_single_car_calculator',
        'icon' => 'stm_single_car_calculator',
        'category' => __('STM Single Car', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Compare cars
    vc_map(array(
        'name' => __('STM Compare Cars', 'motors'),
        'base' => 'stm_compare_cars',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Compare cars
    vc_map(array(
        'name' => __('STM Call to Action', 'motors'),
        'base' => 'stm_call_to_action',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'vc_link',
                'heading' => __('Link', 'motors'),
                'param_name' => 'link'
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box color', 'motors'),
                'param_name' => 'box_color',
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Call to action background', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Attach icon or image', 'motors'),
                'param_name' => 'icon_or_image',
                'value' => array(
                    'Icon' => 'icon',
                    'Image' => 'image'
                ),
                'std' => 'image'
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Text image', 'motors'),
                'param_name' => 'text_image',
                'dependency' => array(
                    'element' => 'icon_or_image',
                    'value' => array('image')
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Text icon', 'motors'),
                'param_name' => 'text_icon',
                'dependency' => array(
                    'element' => 'icon_or_image',
                    'value' => array('icon')
                ),
            ),
            array(
                'type' => 'textarea_html',
                'heading' => esc_html__('Call to action text', 'motors'),
                'param_name' => 'content',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //C2A 2
    vc_map(array(
        'name' => __('STM Call to action 2', 'motors'),
        'base' => 'stm_call_to_action_2',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Call to action label', 'motors'),
                'param_name' => 'call_to_action_label',
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Call to action label icon', 'motors'),
                'param_name' => 'call_to_action_icon',
                'value' => '',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Call to action label right', 'motors'),
                'param_name' => 'call_to_action_label_right',
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Call to action label icon right', 'motors'),
                'param_name' => 'call_to_action_icon_right',
                'value' => '',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Call to action background color', 'motors'),
                'param_name' => 'call_to_action_color',
                'value' => '#fab637',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Call to action text color', 'motors'),
                'param_name' => 'call_to_action_text_color',
                'value' => '#fff',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        ),
    ));

    //Working days
    vc_map(array(
        'name' => __('STM Working days', 'motors'),
        'base' => 'stm_working_days',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'motors'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Sunday', 'motors'),
                'param_name' => 'sunday',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Monday', 'motors'),
                'param_name' => 'monday',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Tuesday', 'motors'),
                'param_name' => 'tuesday',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Wednesday', 'motors'),
                'param_name' => 'wednesday',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Thursday', 'motors'),
                'param_name' => 'thursday',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Friday', 'motors'),
                'param_name' => 'friday',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Saturday', 'motors'),
                'param_name' => 'saturday',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Widgets
    //Media library
    vc_map(array(
        'name' => __('STM Media Library', 'motors'),
        'base' => 'stm_media_library',
        'icon' => 'stm_media_library',
        'category' => __('STM Widgets', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Widget title', 'motors'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'attach_images',
                'heading' => __('Images', 'motors'),
                'param_name' => 'images'
            ),
        )
    ));
    //Recent posts
    vc_map(array(
        'name' => __('STM Recent Posts', 'motors'),
        'base' => 'stm_recent_posts',
        'icon' => 'stm_recent_posts',
        'category' => __('STM Widgets', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Widget title', 'motors'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Number of posts', 'motors'),
                'param_name' => 'number_of_posts',
            ),
        )
    ));

    $stm_sidebars_array = get_posts(array('post_type' => 'sidebar', 'posts_per_page' => -1));
    $stm_sidebars = array(__('Select', 'motors') => 0);
    if ($stm_sidebars_array) {
        foreach ($stm_sidebars_array as $val) {
            $stm_sidebars[get_the_title($val)] = $val->ID;
        }
    }

    vc_map(array(
        'name' => __('STM Sidebar', 'motors'),
        'base' => 'stm_sidebar',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => __('Choose sidebar', 'motors'),
                'param_name' => 'sidebar',
                'value' => $stm_sidebars
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    //Post partials
    //Stm post title/image
    vc_map(array(
        'name' => __('STM Post title', 'motors'),
        'base' => 'stm_post_title',
        'icon' => 'stm_post_title',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    vc_map(array(
        'name' => __('STM Post image', 'motors'),
        'base' => 'stm_post_image',
        'icon' => 'stm_post_image',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    vc_map(array(
        'name' => __('STM Post Info', 'motors'),
        'base' => 'stm_post_info',
        'icon' => 'stm_post_info',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));
    vc_map(array(
        'name' => __('STM Post Meta Bottom(share, tags, categories)', 'motors'),
        'base' => 'stm_post_meta_bottom',
        'icon' => 'stm_post_meta_bottom',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css_share',
                'group' => __('Share this css', 'motors')
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Post Author Box', 'motors'),
        'base' => 'stm_post_author_box',
        'icon' => 'stm_post_author_box',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Post Comments', 'motors'),
        'base' => 'stm_post_comments',
        'icon' => 'stm_post_comments',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Post FullWidth Info', 'motors'),
        'base' => 'stm_post_fullwidth_info',
        'icon' => 'stm_post_fullwidth_info',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Post Animated Image', 'motors'),
        'base' => 'stm_post_animated_image',
        'icon' => 'stm_post_animated_image',
        'category' => __('STM Post Partials', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Subtitle', 'motors'),
                'param_name' => 'subtitle',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));


    $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
    $available_cf7 = array();
    if ($cf7Forms = get_posts($args)) {
        foreach ($cf7Forms as $cf7Form) {
            $available_cf7[$cf7Form->post_title] = $cf7Form->ID;
        };
    } else {
        $available_cf7['No CF7 forms found'] = 'none';
    };
    vc_map(array(
        'name' => __('STM Contact form', 'motors'),
        'base' => 'stm_contact_form',
        'icon' => 'icon-wpb-contactform7',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Title', 'motors'),
                'param_name' => 'title'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Choose form', 'motors'),
                'param_name' => 'form',
                'value' => $available_cf7,
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Service Contact form', 'motors'),
        'base' => 'stm_service_contact_form',
        'icon' => 'icon-wpb-contactform7',
        'category' => __('STM Service Layout', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Choose form', 'motors'),
                'param_name' => 'form',
                'value' => $available_cf7,
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    /*Modern filter*/
    vc_map(array(
        'name' => __('STM Modern Filter', 'motors'),
        'base' => 'stm_modern_filter',
        'icon' => 'stm_modern_filter',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    /*Classic filter*/
    if (stm_is_motorcycle()) {
        $classic_filter_args = array(
            array(
                'type' => 'dropdown',
                'heading' => __('Choose sidebar', 'motors'),
                'param_name' => 'sidebar',
                'value' => $stm_sidebars
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        );
    } else {
        $classic_filter_args = array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        );
    }

    vc_map(array(
        'name' => __('STM Classic Filter', 'motors'),
        'base' => 'stm_classic_filter',
        'icon' => 'stm_classic_filter',
        'category' => __('STM', 'motors'),
        'params' => $classic_filter_args
    ));

    /*Button*/
    vc_map(array(
        'name' => __('STM Icon Button', 'motors'),
        'base' => 'stm_icon_button',
        'icon' => 'stm_icon_button',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'vc_link',
                'heading' => __('Link', 'motors'),
                'param_name' => 'link'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Alignment', 'motors'),
                'param_name' => 'align',
                'value' => array(
                    __('Left', 'motors') => 'left',
                    __('Right', 'motors') => 'right',
                    __('Center', 'motors') => 'center',
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'motors'),
                'param_name' => 'icon',
                'value' => ''
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box background color', 'motors'),
                'param_name' => 'box_bg_color',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box text color', 'motors'),
                'param_name' => 'box_text_color',
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Sidebar call to action', 'motors'),
        'base' => 'stm_sidebar_call_to_action',
        'icon' => 'stm_sidebar_call_to_action',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'vc_link',
                'heading' => __('Link', 'motors'),
                'param_name' => 'link'
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Attach icon or image', 'motors'),
                'param_name' => 'icon_or_image',
                'value' => array(
                    'Icon' => 'icon',
                    'Image' => 'image'
                ),
                'std' => 'image'
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Text image', 'motors'),
                'param_name' => 'text_image',
                'dependency' => array(
                    'element' => 'icon_or_image',
                    'value' => array('image')
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Text image width', 'motors'),
                'param_name' => 'text_image_width',
                'dependency' => array(
                    'element' => 'icon_or_image',
                    'value' => array('image')
                ),
            ),
            array(
                'type' => 'iconpicker',
                'heading' => __('Text icon', 'motors'),
                'param_name' => 'text_icon',
                'dependency' => array(
                    'element' => 'icon_or_image',
                    'value' => array('icon')
                ),
            ),
            array(
                'type' => 'textarea_html',
                'heading' => esc_html__('Call to action text', 'motors'),
                'param_name' => 'content',
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Image size', 'motors'),
                'param_name' => 'image_size',
                'value' => '253x233',
                'description' => __('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'motors'),
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    /*Sell a car*/
    vc_map(array(
        'name' => __('STM Sell a car', 'motors'),
        'base' => 'stm_sell_a_car',
        'icon' => 'stm_sell_a_car',
        'category' => __('STM', 'motors'),
        'params' => array(
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    // Service layout related modules, but still they can be used everywhere
    vc_map(array(
        'name' => __('STM Service Icon Box', 'motors'),
        'base' => 'stm_service_icon_box',
        'icon' => 'stm_service_icon_box',
        'category' => __('STM Service Layout', 'motors'),
        'params' => array(
            array(
                'type' => 'iconpicker',
                'heading' => __('Icon', 'motors'),
                'param_name' => 'icon',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Icon color', 'motors'),
                'param_name' => 'icon_color',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Icon size(px)', 'motors'),
                'param_name' => 'icon_size',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'motors'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'textarea_html',
                'heading' => __('Text', 'motors'),
                'param_name' => 'content'
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Service Info Box', 'motors'),
        'base' => 'stm_service_info_box',
        'icon' => 'stm_service_info_box',
        'category' => __('STM Service Layout', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'motors'),
                'param_name' => 'image'
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Box background color', 'motors'),
                'param_name' => 'box_bg_color',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Title', 'motors'),
                'param_name' => 'title',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Title color', 'motors'),
                'param_name' => 'title_color',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Price label', 'motors'),
                'param_name' => 'price_label',
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Price value', 'motors'),
                'param_name' => 'price_value',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Price color', 'motors'),
                'param_name' => 'price_color',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Price background color', 'motors'),
                'param_name' => 'price_background_color',
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Content color', 'motors'),
                'param_name' => 'content_color',
            ),
            array(
                'type' => 'textarea_html',
                'heading' => __('Text', 'motors'),
                'param_name' => 'content'
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Stats Counter', 'motors'),
        'base' => 'stm_stats_counter',
        'icon' => 'stm_stats_counter',
        'category' => __('STM Service Layout', 'motors'),
        'params' => array(
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => __('Title', 'motors'),
                'param_name' => 'title'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Counter Value', 'motors'),
                'param_name' => 'counter_value',
                'value' => '1000'
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Duration', 'motors'),
                'param_name' => 'duration',
                'value' => '2.5'
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        )
    ));

    vc_map(array(
        'name' => __('STM Image links', 'motors'),
        'base' => 'stm_image_links',
        'as_parent' => array('only' => 'stm_image_link'),
        'icon' => 'stm_image_links',
        'category' => __('STM Service Layout', 'motors'),
        'params' => array(
            array(
                'type' => 'dropdown',
                'heading' => __('Image per row', 'motors'),
                'param_name' => 'row_number',
                'value' => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'std' => '4'
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        ),
        'js_view' => 'VcColumnView'
    ));

    vc_map(array(
        'name' => __('STM Image Link', 'motors'),
        'base' => 'stm_image_link',
        'as_child' => array('only' => 'stm_image_links'),
        'category' => __('STM Service Layout', 'motors'),
        'params' => array(
            array(
                'type' => 'attach_image',
                'heading' => __('Image', 'motors'),
                'param_name' => 'images'
            ),
            array(
                'type' => 'attach_image',
                'heading' => __('Image @2x', 'motors'),
                'param_name' => 'retina_images'
            ),
            array(
                'type' => 'vc_link',
                'heading' => __('Link', 'motors'),
                'param_name' => 'link'
            ),
            array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            )
        ),
    ));


    //Listing shortcodes
    if (!stm_is_motorcycle()) {
        if (!stm_is_boats()) {
            vc_map(array(
                'name' => __('STM Listing banner', 'motors'),
                'base' => 'stm_listing_banner',
                'icon' => 'stm_listing_banner',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Image', 'motors'),
                        'param_name' => 'image'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Show SVG arrow', 'motors'),
                        'param_name' => 'show_svg_arrow',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                        'std' => 'yes'
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => __('Content', 'motors'),
                        'param_name' => 'content'
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Icon Filter', 'motors'),
                'base' => 'stm_icon_filter',
                'icon' => 'stm_icon_filter',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select Icon Filter taxonomy', 'motors'),
                        'param_name' => 'filter_selected',
                        'value' => $stm_filter_options
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Limit', 'motors'),
                        'param_name' => 'limit',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Per row', 'motors'),
                        'param_name' => 'per_row',
                        'value' => array(
                            '1' => 1,
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                            '6' => 6,
                            '9' => 9,
                            '12' => 12
                        ),
                        'std' => 4
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Items Align', 'motors'),
                        'param_name' => 'align',
                        'value' => array(
                            __('Left', 'motors') => 'left',
                            __('Center', 'motors') => 'center',
                            __('Right', 'motors') => 'right',
                        ),
                        'std' => 'left'
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => __('Content', 'motors'),
                        'param_name' => 'content'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('"Show all" label text', 'motors'),
                        'param_name' => 'duration',
                        'description' => __('If you want to show only important types, other will be hidden, till user click on this label', 'motors'),
                        'value' => 'Show all'
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Listing tabs style 2', 'motors'),
                'base' => 'stm_listings_tabs_2',
                'icon' => 'stm_listings_tabs_2',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number of cars to show in tab', 'motors'),
                        'param_name' => 'per_page',
                        'std' => '8'
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Include recent items', 'motors'),
                        'param_name' => 'recent',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                        'std' => 'yes'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Recent tabs label', 'motors'),
                        'param_name' => 'recent_label',
                        'std' => __('Recent items', 'motors'),
                        'dependency' => array('element' => 'recent', 'value' => 'yes'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Include popular items', 'motors'),
                        'param_name' => 'popular',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                        'std' => 'yes'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Popular tabs label', 'motors'),
                        'param_name' => 'popular_label',
                        'std' => __('Popular items', 'motors'),
                        'dependency' => array('element' => 'popular', 'value' => 'yes'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Include featured items', 'motors'),
                        'param_name' => 'featured',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                        'std' => 'yes'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Featured tabs label', 'motors'),
                        'param_name' => 'featured_label',
                        'std' => __('Featured items', 'motors'),
                        'dependency' => array('element' => 'featured', 'value' => 'yes'),
                    ),
                    array(
                        'type' => 'stm_autocomplete_vc',
                        'heading' => __('Select category', 'motors'),
                        'param_name' => 'taxonomy',
                        'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Category tabs affix', 'motors'),
                        'param_name' => 'tab_affix',
                        'std' => __('items', 'motors'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Show "Show more" button in tabs', 'motors'),
                        'param_name' => 'show_more',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                        'std' => 'yes'
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Blog grid', 'motors'),
                'base' => 'stm_blog_grid',
                'icon' => 'stm_blog_grid',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number of posts to show', 'motors'),
                        'param_name' => 'per_page',
                        'std' => '2',
                        'description' => __('Sticky posts are not counted here, so if you want to show 3 posts, and you have one sticky post, type "2" in this field', 'motors')
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            $stm_filter_options_location = $stm_filter_options;
            $stm_filter_options_location['Location'] = esc_html__('location', 'motors');
            vc_map(array(
                'name' => __('STM Listing Search (tabs)', 'motors'),
                'base' => 'stm_listing_search',
                'icon' => 'stm_listing_search',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(

                    array(
                        'type' => 'checkbox',
                        'heading' => __('Show All', 'motors'),
                        'param_name' => 'show_all',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                        'std' => 'yes'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('All tab label', 'motors'),
                        'param_name' => 'show_all_label',
                        'std' => __('All conditions', 'motors'),
                        'dependency' => array('element' => 'show_all', 'value' => 'yes'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Search button postfix', 'motors'),
                        'param_name' => 'search_button_postfix',
                        'std' => __('Cars', 'motors'),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Select Taxonomies, which will be in this tab as filter', 'motors'),
                        'param_name' => 'filter_all',
                        'value' => $stm_filter_options_location,
                        'dependency' => array('element' => 'show_all', 'value' => 'yes'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Select prefix', 'motors'),
                        'param_name' => 'select_prefix',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Select affix', 'motors'),
                        'param_name' => 'select_affix',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number Select prefix', 'motors'),
                        'param_name' => 'number_prefix',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number Select affix', 'motors'),
                        'param_name' => 'number_affix',
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => __('Items', 'motors'),
                        'param_name' => 'items',
                        'description' => __('Enter values for items - title, sub title.', 'motors'),
                        'value' => urlencode(json_encode(array(
                            array(
                                'label' => __('Taxonomy', 'motors'),
                                'value' => '',
                            ),
                            array(
                                'label' => __('Tab Title', 'motors'),
                                'value' => '',
                            ),
                            array(
                                'label' => __('Filters', 'motors'),
                                'value' => '',
                            ),
                        ))),
                        'params' => array(
                            array(
                                'type' => 'stm_autocomplete_vc',
                                'heading' => __('Taxonomy', 'motors'),
                                'param_name' => 'taxonomy_tab',
                                'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions. Note, only one taxonomy will be used as tab). This parameter will be used as default filter for this tab.', 'motors'),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Tab title', 'motors'),
                                'param_name' => 'tab_title_single',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => __('Select Taxonomies, which will be in this tab as filter', 'motors'),
                                'param_name' => 'filter_selected',
                                'value' => $stm_filter_options_location
                            ),
                        ),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Heading Title', 'motors'),
                'base' => 'stm_heading_title',
                'icon' => 'stm_heading_title',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Car Top Info (Title, price)', 'motors'),
                'base' => 'stm_car_top_info',
                'icon' => 'stm_car_top_info',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Car Gallery', 'motors'),
                'base' => 'stm_car_listing_gallery',
                'icon' => 'stm_car_listing_gallery',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Car Details', 'motors'),
                'base' => 'stm_car_listing_details',
                'icon' => 'stm_car_listing_details',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Car Features', 'motors'),
                'base' => 'stm_car_listing_features',
                'icon' => 'stm_car_listing_features',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Car Dealer Info', 'motors'),
                'base' => 'stm_car_dealer_info',
                'icon' => 'stm_car_dealer_info',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Car Listing Contact Form', 'motors'),
                'base' => 'stm_car_listing_contact_form',
                'icon' => 'stm_car_listing_contact_form',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Choose form', 'motors'),
                        'param_name' => 'form',
                        'value' => $available_cf7,
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Similar cars', 'motors'),
                'base' => 'stm_car_listing_similar',
                'icon' => 'stm_car_listing_similar',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            //Pricing
            $stm_pt_params = array();

            $stm_pt_params[] = array(
                'type' => 'dropdown',
                'heading' => __('Tables', 'motors'),
                'param_name' => 'pricing_tables_count',
                'value' => array(
                    __('Three', 'motors') => 'three',
                    __('Two', 'motors') => 'two',
                    __('One', 'motors') => 'one',
                ),
                'std' => 'three'
            );

            for ($i = 1; $i <= 3; $i++) {
                $stm_pt_params[] = array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'motors'),
                    'param_name' => 'pt_' . $i . '_title',
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );

                $stm_pt_params[] = array(
                    'type' => 'param_group',
                    'heading' => __('Period', 'motors'),
                    'param_name' => 'pt_' . $i . '_periods',
                    'value' => urlencode(json_encode(array(
                        array(
                            'label' => __('Period', 'motors'),
                            'value' => '',
                        ),
                        array(
                            'label' => __('Price', 'motors'),
                            'value' => '',
                        ),
                        array(
                            'label' => __('Period Text', 'motors'),
                            'value' => '',
                        ),
                        array(
                            'label' => __('Period link', 'motors'),
                            'value' => '',
                        ),
                    ))),
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Period', 'motors'),
                            'param_name' => 'pt_' . $i . '_periods_period',
                            'value' => array(
                                __('Month', 'motors') => 'month',
                                __('Yearly', 'motors') => 'yearly'
                            ),
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Price', 'motors'),
                            'param_name' => 'pt_' . $i . '_periods_price',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Plan add to cart (Plan ID)', 'motors'),
                            'param_name' => 'pt_' . $i . '_periods_link',
                            'value' => $products_array,
                            'group' => sprintf(__("Table %s", 'motors'), $i)
                        )
                    ),
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );

                $stm_pt_params[] = array(
                    'type' => 'param_group',
                    'heading' => __('Features', 'motors'),
                    'param_name' => 'pt_' . $i . '_features',
                    'value' => urlencode(json_encode(array(
                        array(
                            'label' => __('Title', 'motors'),
                            'value' => '',
                        ),
                        array(
                            'label' => __('Check', 'motors'),
                            'value' => '',
                        ),
                        array(
                            'label' => __('Text', 'motors'),
                            'value' => '',
                        )
                    ))),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Title', 'motors'),
                            'param_name' => 'pt_' . $i . '_feature_title',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Check', 'motors'),
                            'param_name' => 'pt_' . $i . '_feature_check',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Text', 'motors'),
                            'param_name' => 'pt_' . $i . '_feature_text',
                            'admin_label' => true,
                        )
                    ),
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );

                $stm_pt_params[] = array(
                    'type' => 'param_group',
                    'heading' => __('Labels', 'motors'),
                    'param_name' => 'pt_' . $i . '_labels',
                    'value' => urlencode(json_encode(array(
                        array(
                            'label' => __('Label text', 'motors'),
                            'value' => '',
                        ),
                        array(
                            'label' => __('Label color', 'motors'),
                            'value' => '',
                        ),
                    ))),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Label text', 'motors'),
                            'param_name' => 'pt_' . $i . '_label_text',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => __('Label background color', 'motors'),
                            'param_name' => 'pt_' . $i . '_label_color',
                        ),
                    ),
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );

                $stm_pt_params[] = array(
                    'type' => 'textfield',
                    'heading' => __('Link text', 'motors'),
                    'param_name' => 'pt_' . $i . '_link_text',
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );

                $stm_pt_params[] = array(
                    'type' => 'vc_link',
                    'heading' => __('Link', 'motors'),
                    'param_name' => 'pt_' . $i . '_link',
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );

                $stm_pt_params[] = array(
                    'type' => 'dropdown',
                    'heading' => __('Plan add to cart (Plan ID)', 'motors'),
                    'param_name' => 'pt_' . $i . '_add_to_cart',
                    'value' => $products_array,
                    'group' => sprintf(__("Table %s", 'motors'), $i)
                );
            }

            $stm_pt_params[] = array(
                'type' => 'textfield',
                'heading' => __('Price label', 'motors'),
                'param_name' => 'stm_motors_price_label',
            );

            $stm_pt_params[] = array(
                'type' => 'css_editor',
                'heading' => __('Css', 'motors'),
                'param_name' => 'css',
                'group' => __('Design options', 'motors')
            );

            // Pricing Tables
            vc_map(array(
                'name' => __('STM Pricing Tables', 'motors'),
                'base' => 'stm_pricing_tables',
                'category' => __('STM Listing Single Car modules', 'motors'),
                'params' => $stm_pt_params
            ));

            //Account
            vc_map(array(
                'name' => __('STM User/Dealer login/register', 'motors'),
                'base' => 'stm_login_register',
                'icon' => 'stm_login_register',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'vc_link',
                        'heading' => __('Link', 'motors'),
                        'param_name' => 'link'
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            //Add a car available
            vc_map(array(
                'name' => __('STM Posts Available', 'motors'),
                'base' => 'stm_posts_available',
                'icon' => 'stm_posts_available',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            /*Add car*/
            vc_map(array(
                'name' => __('STM Add a car', 'motors'),
                'base' => 'stm_add_a_car',
                'icon' => 'stm_add_a_car',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Include car title', 'motors'),
                        'param_name' => 'show_car_title',
                        'std' => 'no',
                        'value' => array(
                            esc_html__('Yes', 'motors') => 'yes',
                            esc_html__('No', 'motors') => 'no'
                        ),
                    ),
                    array(
                        'type' => 'stm_autocomplete_vc_taxonomies',
                        'heading' => __('Main taxonomies to fill', 'motors'),
                        'param_name' => 'taxonomy',
                        'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Show number fields as input instead of dropdown', 'motors'),
                        'param_name' => 'use_inputs',
                        'value' => array(
                            __('Yes', 'motors') => 'yes',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Allowed histories', 'motors'),
                        'param_name' => 'stm_histories',
                        'description' => esc_html__('Enter allowed histories, separated by comma without spaces. Example - (Carfax, AutoCheck, Carfax 1 Owner, etc)', 'motors'),
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => __('Items', 'motors'),
                        'param_name' => 'items',
                        'value' => urlencode(json_encode(array(
                            array(
                                'label' => __('Car feature title', 'motors'),
                                'value' => '',
                            ),
                            array(
                                'label' => __('Car features', 'motors'),
                                'value' => '',
                            ),
                        ))),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => __('Car feature section title', 'motors'),
                                'param_name' => 'tab_title_single',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Car feature section features', 'motors'),
                                'param_name' => 'tab_title_labels',
                                'description' => esc_html__('Enter features, separated by comma without spaces. Example - (Bluetooth,DVD Player,etc)', 'motors')
                            ),
                        ),
                        'group' => esc_html__('Step 2 features', 'motors')
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => __('Media gallery notification text', 'motors'),
                        'param_name' => 'content',
                        'group' => esc_html__('Step 3 gallery', 'motors')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Seller template phrases', 'motors'),
                        'param_name' => 'stm_phrases',
                        'description' => esc_html__('Enter phrases, separated by comma without spaces. Example - (Excellent condition, Always garaged, etc)', 'motors'),
                        'group' => esc_html__('Step 4 phrases', 'motors')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title for new users', 'motors'),
                        'param_name' => 'stm_title_user',
                        'group' => esc_html__('Register/Login User', 'motors')
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Text for new users', 'motors'),
                        'param_name' => 'stm_text_user',
                        'group' => esc_html__('Register/Login User', 'motors')
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => __('Agreement page', 'motors'),
                        'param_name' => 'link',
                        'group' => esc_html__('Register/Login User', 'motors')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Price title', 'motors'),
                        'param_name' => 'stm_title_price',
                        'group' => esc_html__('Price', 'motors')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Show Price label', 'motors'),
                        'param_name' => 'show_price_label',
                        'group' => esc_html__('Price', 'motors'),
                        'std' => 'no',
                        'value' => array(
                            esc_html__('Yes', 'motors') => 'yes',
                            esc_html__('No', 'motors') => 'no'
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Price description', 'motors'),
                        'param_name' => 'stm_title_desc',
                        'group' => esc_html__('Price', 'motors'),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            //Add a car available
            vc_map(array(
                'name' => __('STM Dealer List', 'motors'),
                'base' => 'stm_dealer_list',
                'icon' => 'stm_dealer_list',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Select Taxonomies, which will be in this tab as filter', 'motors'),
                        'param_name' => 'stm_filter_dealers_by',
                        'value' => $stm_filter_options_location,
                    ),
                    array(
                        'type' => 'stm_autocomplete_vc',
                        'heading' => __('Show dealer category fields', 'motors'),
                        'param_name' => 'taxonomy',
                        'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    ),
                )
            ));


            vc_map(array(
                'name' => __('STM Icon Counter', 'motors'),
                'base' => 'stm_icon_counter',
                'icon' => 'stm_icon_counter',
                'category' => __('STM Listing Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'iconpicker',
                        'heading' => __('Icon', 'motors'),
                        'param_name' => 'icon',
                        'value' => ''
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Icon size(px)', 'motors'),
                        'param_name' => 'stm_icon_size',
                        'description' => __('Just type a number.', 'motors'),
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __('Icon Box Text Color', 'motors'),
                        'param_name' => 'box_bg_color',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Count to number', 'motors'),
                        'param_name' => 'stm_counter_value',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Count time (.s)', 'motors'),
                        'param_name' => 'stm_counter_time',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Counter Affix', 'motors'),
                        'param_name' => 'stm_counter_affix',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Count label', 'motors'),
                        'param_name' => 'stm_counter_label',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    ),
                )
            ));
        } else {
            vc_map(array(
                'name' => __('STM Icon Counter', 'motors'),
                'base' => 'stm_icon_counter_boats',
                'icon' => 'stm_icon_counter_boats',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'iconpicker',
                        'heading' => __('Icon', 'motors'),
                        'param_name' => 'icon',
                        'value' => ''
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Icon size(px)', 'motors'),
                        'param_name' => 'stm_icon_size',
                        'description' => __('Just type a number.', 'motors'),
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __('Icon Box Text Color', 'motors'),
                        'param_name' => 'box_bg_color',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Count to number', 'motors'),
                        'param_name' => 'stm_counter_value',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Count time (.s)', 'motors'),
                        'param_name' => 'stm_counter_time',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Counter Affix', 'motors'),
                        'param_name' => 'stm_counter_affix',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Count label', 'motors'),
                        'param_name' => 'stm_counter_label',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    ),
                )
            ));
            vc_map(array(
                'name' => __('STM Featured Boats', 'motors'),
                'base' => 'stm_featured_boats',
                'icon' => 'stm_featured_boats',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Display number', 'motors'),
                        'param_name' => 'per_page',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    ),
                )
            ));
            vc_map(array(
                'name' => __('STM Row Icons', 'motors'),
                'base' => 'stm_row_icons',
                'icon' => 'stm_row_icons',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select Icon Filter taxonomy', 'motors'),
                        'param_name' => 'filter_selected',
                        'value' => $stm_filter_options
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    ),
                )
            ));
            vc_map(array(
                'name' => __('STM Video', 'motors'),
                'base' => 'stm_boats_video',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Video poster', 'motors'),
                        'param_name' => 'image'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Iframe Height', 'motors'),
                        'param_name' => 'height',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Video Link', 'motors'),
                        'param_name' => 'link',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            //Testimonials Boats
            vc_map(array(
                'name' => __('STM Testimonials Boats', 'motors'),
                'base' => 'stm_testimonials_boats',
                'as_parent' => array('only' => 'stm_testimonial_boats'),
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                ),
                'js_view' => 'VcColumnView'
            ));

            vc_map(array(
                'name' => __('STM Testimonial Boats', 'motors'),
                'base' => 'stm_testimonial_boats',
                'as_child' => array('only' => 'stm_testimonials_boats'),
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Image', 'motors'),
                        'param_name' => 'image'
                    ),
                    array(
                        'type' => 'textarea_html',
                        'heading' => __('Text', 'motors'),
                        'param_name' => 'content'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Author name', 'motors'),
                        'param_name' => 'author',
                    ),
                )
            ));

            vc_map(array(
                'name' => __('STM Latest News', 'motors'),
                'base' => 'stm_latest_news',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number of news to display', 'motors'),
                        'param_name' => 'number_of_posts',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Colors', 'motors'),
                'base' => 'stm_colors',
                'icon' => 'stm_colors',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'param_group',
                        'heading' => __('Colors', 'motors'),
                        'param_name' => 'items',
                        'value' => urlencode(json_encode(array(
                            array(
                                'label' => __('Color name', 'motors'),
                                'value' => '',
                            ),
                            array(
                                'label' => __('Color', 'motors'),
                                'value' => '',
                            ),
                        ))),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => __('Color name', 'motors'),
                                'param_name' => 'color_name',
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => __('Color', 'motors'),
                                'param_name' => 'color',
                            ),
                        ),
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Boat Title&Price', 'motors'),
                'base' => 'stm_boat_title',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Boat Image', 'motors'),
                'base' => 'stm_boat_image',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Boat Data', 'motors'),
                'base' => 'stm_boat_data',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Boat Gallery', 'motors'),
                'base' => 'stm_boat_gallery',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Boat Videos', 'motors'),
                'base' => 'stm_boat_videos',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            vc_map(array(
                'name' => __('STM Contact Information', 'motors'),
                'base' => 'stm_contact_information',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Address', 'motors'),
                        'param_name' => 'address',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Phone', 'motors'),
                        'param_name' => 'phone',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Mail', 'motors'),
                        'param_name' => 'mail',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Hours', 'motors'),
                        'param_name' => 'hours',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));

            //Tech info
            vc_map(array(
                'name' => __('STM Contacts', 'motors'),
                'base' => 'stm_contacts_boat',
                'as_parent' => array('only' => 'stm_contact_boat'),
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                ),
                'js_view' => 'VcColumnView'
            ));
            vc_map(array(
                'name' => __('STM Contact', 'motors'),
                'base' => 'stm_contact_boat',
                'as_child' => array('only' => 'stm_contacts_boat'),
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'attach_images',
                        'heading' => __('Image', 'motors'),
                        'param_name' => 'images'
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Name', 'motors'),
                        'param_name' => 'name',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Phone', 'motors'),
                        'param_name' => 'phone',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Mail', 'motors'),
                        'param_name' => 'mail',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Skype', 'motors'),
                        'param_name' => 'skype',
                    ),
                )
            ));

            vc_map(array(
                'name' => __('STM Featured Boats Widget', 'motors'),
                'base' => 'stm_featured_boats_side',
                'category' => __('STM Boats Layout', 'motors'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'motors'),
                        'param_name' => 'title',
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __('Css', 'motors'),
                        'param_name' => 'css',
                        'group' => __('Design options', 'motors')
                    )
                )
            ));
        }
    }


    /*MOTOS*/
    if (stm_is_motorcycle()) {
        vc_map(array(
            'name' => __('STM Filter Selects', 'motors'),
            'base' => 'stm_filter_selects',
            'category' => __('STM Motos Layout', 'motors'),
            'params' => array(
                array(
                    'type' => 'checkbox',
                    'heading' => __('Select Filter options', 'motors'),
                    'param_name' => 'filter_selected',
                    'value' => $stm_filter_options,
                    'group' => __('Search Options', 'motors')
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Number of filter columns', 'motors'),
                    'param_name' => 'filter_columns_number',
                    'value' => array(
                        '6' => '6',
                        '4' => '4',
                        '3' => '3',
                        '2' => '2',
                        '1' => '1'
                    ),
                    'std' => '3',
                    'group' => __('Search Options', 'motors')
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));

        vc_map(array(
            'name' => __('STM Inventory Category', 'motors'),
            'base' => 'stm_inventory_categories',
            'category' => __('STM Motos Layout', 'motors'),
            'params' => array(
                array(
                    'type' => 'stm_autocomplete_vc',
                    'heading' => __('Select main category (Only one category will be selected)', 'motors'),
                    'param_name' => 'taxonomy_main',
                    'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
                ),
                array(
                    'type' => 'stm_autocomplete_vc',
                    'heading' => __('Select subcategories', 'motors'),
                    'param_name' => 'taxonomy',
                    'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __('Image', 'motors'),
                    'param_name' => 'image'
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));
        vc_map(array(
            'name' => __('STM Listing tabs style 2', 'motors'),
            'base' => 'stm_listings_tabs_2',
            'icon' => 'stm_listings_tabs_2',
            'category' => __('STM Motos Layout', 'motors'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'motors'),
                    'param_name' => 'title'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Number of cars to show in tab', 'motors'),
                    'param_name' => 'per_page',
                    'std' => '8'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Include recent items', 'motors'),
                    'param_name' => 'recent',
                    'value' => array(
                        __('Yes', 'motors') => 'yes',
                    ),
                    'std' => 'yes'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Recent tabs label', 'motors'),
                    'param_name' => 'recent_label',
                    'std' => __('Recent items', 'motors'),
                    'dependency' => array('element' => 'recent', 'value' => 'yes'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Include popular items', 'motors'),
                    'param_name' => 'popular',
                    'value' => array(
                        __('Yes', 'motors') => 'yes',
                    ),
                    'std' => 'yes'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Popular tabs label', 'motors'),
                    'param_name' => 'popular_label',
                    'std' => __('Popular items', 'motors'),
                    'dependency' => array('element' => 'popular', 'value' => 'yes'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Include featured items', 'motors'),
                    'param_name' => 'featured',
                    'value' => array(
                        __('Yes', 'motors') => 'yes',
                    ),
                    'std' => 'yes'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Featured tabs label', 'motors'),
                    'param_name' => 'featured_label',
                    'std' => __('Featured items', 'motors'),
                    'dependency' => array('element' => 'featured', 'value' => 'yes'),
                ),
                array(
                    'type' => 'stm_autocomplete_vc',
                    'heading' => __('Select category', 'motors'),
                    'param_name' => 'taxonomy',
                    'description' => __('Type slug of the category (don\'t delete anything from autocompleted suggestions)', 'motors')
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Category tabs affix', 'motors'),
                    'param_name' => 'tab_affix',
                    'std' => __('items', 'motors'),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Show "Show more" button in tabs', 'motors'),
                    'param_name' => 'show_more',
                    'value' => array(
                        __('Yes', 'motors') => 'yes',
                    ),
                    'std' => 'yes'
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));
        vc_map(array(
            'name' => __('STM Video', 'motors'),
            'base' => 'stm_boats_video',
            'category' => __('STM Motos Layout', 'motors'),
            'params' => array(
                array(
                    'type' => 'attach_image',
                    'heading' => __('Video poster', 'motors'),
                    'param_name' => 'image'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Iframe Height', 'motors'),
                    'param_name' => 'height',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Video Link', 'motors'),
                    'param_name' => 'link',
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));
        vc_map(array(
            'name' => __('STM Row Icons', 'motors'),
            'base' => 'stm_row_icons',
            'icon' => 'stm_row_icons',
            'category' => __('STM Motos Layout', 'motors'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select Icon Filter taxonomy', 'motors'),
                    'param_name' => 'filter_selected',
                    'value' => $stm_filter_options
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                ),
            )
        ));

        vc_map(array(
            'name' => __('STM Car Features', 'motors'),
            'base' => 'stm_car_listing_features',
            'icon' => 'stm_car_listing_features',
            'category' => __('STM Single Motorcycle', 'motors'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'motors'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));

        vc_map(array(
            'name' => __('STM Moto Gallery', 'motors'),
            'base' => 'stm_boat_gallery',
            'category' => __('STM Single Motorcycle', 'motors'),
            'params' => array(
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));

        vc_map(array(
            'name' => __('STM Moto Top (Title, Price, Featured Photo)', 'motors'),
            'base' => 'stm_moto_top',
            'category' => __('STM Single Motorcycle', 'motors'),
            'params' => array(
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));

        vc_map(array(
            'name' => __('STM Moto Data', 'motors'),
            'base' => 'stm_moto_data',
            'category' => __('STM Single Motorcycle', 'motors'),
            'params' => array(
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));

        vc_map(array(
            'name' => __('STM Moto Links', 'motors'),
            'base' => 'stm_moto_links',
            'category' => __('STM Single Motorcycle', 'motors'),
            'params' => array(
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));

        vc_map(array(
            'name' => __('STM Contact Information', 'motors'),
            'base' => 'stm_contact_information',
            'category' => __('STM Motos Layout', 'motors'),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'motors'),
                    'param_name' => 'title',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Address', 'motors'),
                    'param_name' => 'address',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Phone', 'motors'),
                    'param_name' => 'phone',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Mail', 'motors'),
                    'param_name' => 'mail',
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Hours', 'motors'),
                    'param_name' => 'hours',
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => __('Css', 'motors'),
                    'param_name' => 'css',
                    'group' => __('Design options', 'motors')
                )
            )
        ));
    }

}

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Stm_Testimonials extends WPBakeryShortCodesContainer
    {
    }

    class WPBakeryShortCode_Stm_Tech_Infos extends WPBakeryShortCodesContainer
    {
    }

    class WPBakeryShortCode_Stm_Image_Links extends WPBakeryShortCodesContainer
    {
    }

    if (stm_is_boats()) {
        class WPBakeryShortCode_Stm_Testimonials_Boats extends WPBakeryShortCodesContainer
        {
        }

        class WPBakeryShortCode_Stm_Contacts_Boat extends WPBakeryShortCodesContainer
        {
        }
    }
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Stm_Auto_Loan_Calculator extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Listing_Filter extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Icon_Box extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Color_Separator extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Special_Offers extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Car_Listing_Tabbed extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Carousel extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Testimonial extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Our_Team extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Our_Partners extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Service_Archive extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Tech_Info extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Gmap extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Title extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Actions extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Gallery extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Price extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Data extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Mpg extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Single_Car_Calculator extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Compare_Cars extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Call_To_Action extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Call_To_Action_2 extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Working_Days extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Media_Library extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Recent_Posts extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_Stm_Sidebar extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Title extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Info extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Image extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Meta_Bottom extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Author_Box extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Comments extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Contact_Form extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Service_Contact_Form extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Fullwidth_Info extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Post_Animated_Image extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Modern_Filter extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Classic_Filter extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Icon_Button extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Sidebar_Call_To_Action extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Sell_A_Car extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Service_Icon_Box extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Service_Info_Box extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Stats_Counter extends WPBakeryShortCode
    {
    }

    class WPBakeryShortCode_STM_Image_Link extends WPBakeryShortCode
    {
    }

    if (!stm_is_motorcycle()) {
        if (!stm_is_boats()) {

            class WPBakeryShortCode_Stm_Listing_Banner extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Icon_Filter extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Listings_Tabs_2 extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Blog_Grid extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Listing_Search extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Heading_Title extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Top_Info extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Listing_Gallery extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Listing_Details extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Listing_Features extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Dealer_Info extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Listing_Contact_Form extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Car_Listing_Similar extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Pricing_Tables extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Login_Register extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Posts_Available extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Add_A_Car extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Dealer_List extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Icon_Counter extends WPBakeryShortCode
            {
            }
        } else {
            class WPBakeryShortCode_Stm_Icon_Counter_Boats extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Featured_Boats extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Row_Icons extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Boats_Video extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Testimonial_Boats extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Latest_News extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Colors extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Boat_Gallery extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Boat_Videos extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Contact_Information extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Contact_Info extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Contact_Boat extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Boat_Title extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Boat_Image extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Boat_Data extends WPBakeryShortCode
            {
            }

            class WPBakeryShortCode_Stm_Featured_Boats_Side extends WPBakeryShortCode
            {
            }

        }
    }

    if (stm_is_motorcycle()) {
        class WPBakeryShortCode_Stm_Filter_Selects extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Inventory_Categories extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Listings_Tabs_2 extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Boats_Video extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Row_Icons extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Car_Listing_Features extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Boat_Gallery extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Contact_Information extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Moto_Top extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Moto_Data extends WPBakeryShortCode
        {
        }

        class WPBakeryShortCode_Stm_Moto_Links extends WPBakeryShortCode
        {
        }
    }
}

//Add icons
add_filter('vc_iconpicker-type-fontawesome', 'vc_stm_icons');

if (!function_exists('vc_stm_icons')) {
    function vc_stm_icons($fonts)
    {

        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $custom_fonts = get_option('stm_fonts');
        foreach ($custom_fonts as $font => $info) {
            $icon_set = array();
            $icons = array();
            $upload_dir = wp_upload_dir();
            $path = trailingslashit($upload_dir['basedir']);
            $file = $path . $info['include'] . '/' . $info['config'];
            include($file);
            if (!empty($icons)) {
                $icon_set = array_merge($icon_set, $icons);
            }
            if (!empty($icon_set)) {
                foreach ($icon_set as $icons) {
                    foreach ($icons as $icon) {
                        $fonts['Theme Icons'][] = array(
                            $font . '-' . $icon['class'] => $icon['class']
                        );
                    }
                }
            }
        }

        $service_icons = json_decode($wp_filesystem->get_contents(get_template_directory() . '/assets/js/service_icons.json'), true);

        foreach ($service_icons['icons'] as $icon) {
            $fonts['Service Icons'][] = array(
                "stm-service-icon-" . $icon['properties']['name'] => 'STM ' . $icon['properties']['name']
            );
        }

        if (stm_is_boats()) {
            $boat_icons = json_decode($wp_filesystem->get_contents(get_template_directory() . '/assets/js/boat_icons.json'), true);

            foreach ($boat_icons['icons'] as $icon) {
                $fonts['Boat Icons'][] = array(
                    "stm-boats-icon-" . $icon['properties']['name'] => 'STM ' . $icon['properties']['name']
                );
            }
        }

        if (stm_is_motorcycle()) {
            $moto_icons = json_decode($wp_filesystem->get_contents(get_template_directory() . '/assets/js/moto_icons.json'), true);

            foreach ($moto_icons['icons'] as $icon) {
                $fonts['Motorcycle Icons'][] = array(
                    "stm-moto-icon-" . $icon['properties']['name'] => 'STM ' . $icon['properties']['name']
                );
            }
        }

        return $fonts;
    }
}

vc_add_shortcode_param('stm_autocomplete_vc', 'stm_autocomplete_vc_st', get_template_directory_uri() . '/inc/vc_extend/jquery-ui.min.js');
function stm_autocomplete_vc_st($settings, $value)
{
    return '<div class="stm_autocomplete_vc_field">'
    . '<script type="text/javascript">'
    . 'var st_vc_taxonomies = ' . json_encode(stm_get_categories())
    . '</script>'
    . '<input type="text" name="' . esc_attr($settings['param_name']) . '" class="stm_autocomplete_vc wpb_vc_param_value wpb-textinput ' .
    esc_attr($settings['param_name']) . ' ' .
    esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '" />' .
    '</div>';
}

vc_add_shortcode_param('stm_autocomplete_vc_taxonomies', 'stm_autocomplete_vc_st_taxonomies', get_template_directory_uri() . '/inc/vc_extend/jquery-ui.min.js');
function stm_autocomplete_vc_st_taxonomies($settings, $value)
{
    return '<div class="stm_autocomplete_vc_field">'
    . '<script type="text/javascript">'
    . 'var st_vc_taxonomies = ' . json_encode(stm_get_taxonomies())
    . '</script>'
    . '<input type="text" name="' . esc_attr($settings['param_name']) . '" class="stm_autocomplete_vc wpb_vc_param_value wpb-textinput ' .
    esc_attr($settings['param_name']) . ' ' .
    esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '" />' .
    '</div>';
}