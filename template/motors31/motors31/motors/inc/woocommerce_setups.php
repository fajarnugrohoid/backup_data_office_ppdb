<?php
// Declare Woo support
add_action('after_setup_theme', 'stm_woocommerce_support');
function stm_woocommerce_support()
{
    add_theme_support('woocommerce');
}

//Remove Woo Breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

function stm_remove_woo_widgets()
{
    unregister_widget('WC_Widget_Recent_Products');
    unregister_widget('WC_Widget_Featured_Products');
    //unregister_widget( 'WC_Widget_Product_Categories' );
    unregister_widget('WC_Widget_Product_Tag_Cloud');
    //unregister_widget( 'WC_Widget_Cart' );
    unregister_widget('WC_Widget_Layered_Nav');
    unregister_widget('WC_Widget_Layered_Nav_Filters');
    //unregister_widget( 'WC_Widget_Price_Filter' );
    unregister_widget('WC_Widget_Product_Search');
    //unregister_widget( 'WC_Widget_Top_Rated_Products' );
    unregister_widget('WC_Widget_Recent_Reviews');
    unregister_widget('WC_Widget_Recently_Viewed');
    unregister_widget('WC_Widget_Best_Sellers');
    unregister_widget('WC_Widget_Onsale');
    unregister_widget('WC_Widget_Random_Products');
}

add_action('widgets_init', 'stm_remove_woo_widgets');


if (version_compare(WOOCOMMERCE_VERSION, "2.1") >= 0) {
    add_filter('woocommerce_enqueue_styles', '__return_false');
} else {
    define('WOOCOMMERCE_USE_CSS', false);
}

add_filter('woocommerce_show_page_title', '__return_false');

add_filter('loop_shop_per_page', create_function('$cols', 'return 12;'), 20);

add_filter('add_to_cart_fragments', 'stm_woocommerce_header_add_to_cart_fragment');
function stm_woocommerce_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;
    $cart_count = $woocommerce->cart->cart_contents_count;
    if ($cart_count == 0) {
        $cart_count = '';
        if (stm_is_boats()) {
            $cart_count = '0';
        }
    }
    ob_start();
    ?>
    <span class="stm-current-items-in-cart"><?php echo esc_attr($cart_count); ?></span>
    <?php
    $fragments['.stm-current-items-in-cart'] = ob_get_clean();

    return $fragments;
}

add_filter('woocommerce_output_related_products_args', 'stm_related_products_args');

function stm_related_products_args($args)
{
    $args['posts_per_page'] = 3; // 3 related products
    return $args;
}

add_action('wp_enqueue_scripts', 'stm_woo_dequeue_styles_and_scripts', 100);

function stm_woo_dequeue_styles_and_scripts()
{
    if (class_exists('woocommerce')) {
        wp_dequeue_style('select2');
        wp_deregister_style('select2');

        wp_dequeue_script('select2');
        wp_deregister_script('select2');

    }
}

if (stm_pricing_enabled()) {
    /*Remove Fields*/
    add_filter('woocommerce_checkout_fields', 'stm_override_checkout_fields');

    if (!function_exists('stm_override_checkout_fields')) {
        function stm_override_checkout_fields($fields)
        {
            unset($fields['billing']['billing_address_1']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_city']);
            unset($fields['billing']['billing_postcode']);
            unset($fields['billing']['billing_country']);
            unset($fields['billing']['billing_state']);

            return $fields;
        }
    }

    add_filter('woocommerce_add_to_cart_redirect', 'stm_woocommerce_add_to_cart_redirect');
    function stm_woocommerce_add_to_cart_redirect($url)
    {
        if(is_shop()) {
            return $url;
        } else {
            return WC()->cart->get_checkout_url();
        }
    }

    if (class_exists('STM_PostType')) {

        STM_PostType::addMetaBox('stm_pricing_plans', esc_html__('Pricing Plan Options (Works only with "Subscription" Product)', 'motors'), array('product'), '', '', '', array(
            'fields' => array(
                'stm_price_plan_quota' => array(
                    'label' => __('Price Plan Cars Quota', 'motors'),
                    'type' => 'text',
                ),
                'stm_price_plan_media_quota' => array(
                    'label' => __('Price Plan Car Images Quota', 'motors'),
                    'type' => 'text',
                ),
                'stm_price_plan_role' => array(
                    'label' => __('Price Plan User Role', 'motors'),
                    'type' => 'select',
                    'options' => array(
                        'user' => __('User', 'motors'),
                        'dealer' => __('Dealer', 'motors'),
                    )
                ),
            )
        ));
    }


    if (!function_exists('stm_user_active_subscriptions')) {
        function stm_user_active_subscriptions($get_paused = false)
        {
            $user_subscriptions = new Subscriptio_User;
            $user_subscriptions = $user_subscriptions->find_subscriptions(true);

            $active_subscription = '';
            $has_active = false;

            if ($get_paused) {
                $statuses = array('overdue', 'suspended');
            } else {
                $statuses = array('active');
            }

            foreach ($user_subscriptions as $user_subscription) {
                if (in_array($user_subscription->status, $statuses) and !$has_active) {
                    $active_subscription = $user_subscription;
                    $has_active = true;
                }
            }

            $user_subscriptions = $active_subscription;

            $user_subscription_quota = array();

            if (!empty($user_subscriptions)) {
                $post_limit = intval(get_post_meta($user_subscriptions->product_id, 'stm_price_plan_quota', true));
                $image_limit = intval(get_post_meta($user_subscriptions->product_id, 'stm_price_plan_media_quota', true));

                if (!empty($post_limit) and !empty($image_limit)) {
                    $user_subscription_quota['user_id'] = $user_subscriptions->user_id;
                    $user_subscription_quota['sub_id'] = $user_subscriptions->id;
                    $user_subscription_quota['product_id'] = $user_subscriptions->product_id;
                    $user_subscription_quota['plan_name'] = $user_subscriptions->product_name;
                    $user_subscription_quota['post_limit'] = $post_limit;
                    $user_subscription_quota['image_limit'] = $image_limit;
                    $user_subscription_quota['status'] = $user_subscriptions->status;
                    $user_subscription_quota['last_order_id'] = $user_subscriptions->last_order_id;
                    $user_subscription_quota['expires'] = $user_subscriptions->payment_due_readable;
                }

            }

            return $user_subscription_quota;
        }
    }

    add_action('init', 'stm_user_active_subscriptions');

    if (!function_exists('stm_move_draft_over_limit')) {
        function stm_move_draft_over_limit($subscription, $old_status, $new_status)
        {

            $product_id = $subscription->product_id;
            $user_id = $subscription->user_id;


            $role = get_post_meta($product_id, 'stm_price_plan_role', true);

            if (!in_array($new_status, array('active', 'trial'))) {
                $user_limits = stm_get_post_limits($user_id);

                $posts_args = array(
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => stm_listings_post_type(),
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'meta_query' => array(
                        array(
                            'key' => 'stm_car_user',
                            'value' => $user_id,
                            'compare' => ''
                        )
                    ),
                    'fields' => 'ids'
                );

                $user_posts = get_posts($posts_args);
                if (count($user_posts) > $user_limits['posts_allowed']) {
                    array_splice($user_posts, 0, $user_limits['posts_allowed']);
                    foreach ($user_posts as $user_post) {
                        $draft_post = array(
                            'ID' => $user_post,
                            'post_status' => 'draft'
                        );
                        wp_update_post($draft_post);
                    }
                }

                /*Change user back to private if not admin*/
                if (!user_can($user_id, 'manage_options')) {
                    wp_update_user(array(
                        'ID' => $user_id,
                        'role' => 'subscriber'
                    ));
                }

            } else {
                /*If plan includes dealeship, change user role to dealer*/
                if ($role == 'dealer') {
                    wp_update_user(array(
                        'ID' => $user_id,
                        'role' => 'stm_dealer'
                    ));
                }
            }
        }
    }

    add_action('subscriptio_status_changed', 'stm_move_draft_over_limit', 10, 3);


    function stm_save_customer_note_meta($subscription_id, $post)
    {

        $slug = 'subscription';

        // If this isn't a 'subscription' post, don't update it.
        if ($slug != $post->post_type) {
            return;
        }

        $note = get_post_meta($subscription_id, 'renewal_customer_note', true);
        if (empty($note)) {
            update_post_meta($subscription_id, 'renewal_customer_note', '');
        }
    }

    add_action('save_post', 'stm_save_customer_note_meta', 10, 2);
}