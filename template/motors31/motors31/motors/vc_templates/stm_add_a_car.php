<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

$terms_args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
    'fields' => 'all',
    'pad_counts' => true,
);

if (!empty($taxonomy)) {
    $taxonomy = array_filter(array_unique(explode(',', str_replace(' ', '', $taxonomy))));
}

if (!empty($link)) {
    $link = vc_build_link($link);
} else {
    $link = array();
}

$data = stm_get_single_car_listings();

if (isset($atts['items']) && strlen($atts['items']) > 0) {
    $items = vc_param_group_parse_atts($atts['items']);
    if (!is_array($items)) {
        $temp = explode(',', $atts['items']);
        $paramValues = array();
        foreach ($temp as $value) {
            $data = explode('|', $value);
            $newLine = array();
            $newLine['title'] = isset($data[0]) ? $data[0] : 0;
            $newLine['sub_title'] = isset($data[1]) ? $data[1] : '';
            if (isset($data[1]) && preg_match('/^\d{1,3}\%$/', $data[1])) {
                $colorIndex += 1;
                $newLine['title'] = (float)str_replace('%', '', $data[1]);
                $newLine['sub_title'] = isset($data[2]) ? $data[2] : '';
            }
            $paramValues[] = $newLine;
        }
        $atts['items'] = urlencode(json_encode($paramValues));
    }
}

if (empty($items)) {
    $items = array();
}

if (empty($stm_title_user)) {
    $stm_title_user = '';
}

if (empty($stm_text_user)) {
    $stm_text_user = '';
}

if (empty($stm_histories)) {
    $stm_histories = '';
}

if (empty($stm_phrases)) {
    $stm_phrases = '';
}

$vars = array(
    'id' => stm_listings_input('item_id'),
    'taxonomy' => $taxonomy,
    'link' => $link,
    'data' => $data,
    'items' => $items,
    'stm_title_user' => $stm_title_user,
    'stm_text_user' => $stm_text_user,
    'stm_histories' => $stm_histories,
    'stm_phrases' => $stm_phrases,
    'show_car_title' => $show_car_title,
    'use_inputs' => $use_inputs,
    'show_price_label' => $show_price_label,
    'stm_title_desc' => $stm_title_desc,
    'content' => $content
);

$car_edit = false;
$stm_edit_car_form = '';

if (!empty($_GET['edit_car']) and $_GET['edit_car']) {
    $car_edit = true;
    $stm_edit_car_form = 'stm_edit_car_form';
}

$restricted = false;

if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $restrictions = stm_get_post_limits($user_id);
} else {
    $restrictions = stm_get_post_limits('');
}

if ($restrictions['posts'] < 1) {
    $restricted = true;
}

if ($restricted and !$car_edit): ?>
    <div class="stm-no-available-adds-overlay"></div>
    <div class="stm-no-available-adds">
        <h3><?php esc_html_e('Posts Available', 'motors'); ?>: <span>0</span></h3>
        <p><?php esc_html_e('You ended the limit of free classified ads. Please select one of the following', 'motors'); ?></p>
        <div class="clearfix">
            <?php if (stm_pricing_enabled()): ?>
                <?php $stm_pricing_link = stm_pricing_link();
                if (!empty($stm_pricing_link)): ?>
                    <a href="<?php echo esc_url($stm_pricing_link); ?>" class="button stm-green">
                        <?php esc_html_e('Upgrade Plan', 'motors'); ?>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <?php if ($restrictions['role'] == 'user'): ?>
                    <a href="<?php echo esc_url(add_query_arg(array('become_dealer' => 1), stm_get_author_link(''))); ?>"
                       class="button stm-green"><?php esc_html_e('Become a Dealer', 'motors'); ?></a>
                <?php endif; ?>
            <?php endif; ?>
            <a href="<?php echo esc_url(stm_get_author_link('')); ?>"
               class="button stm-green-dk"><?php esc_html_e('My inventory', 'motors'); ?></a>
        </div>
    </div>
<?php endif; ?>

<?php stm_listings_load_template('add_car/binding'); ?>

<div class="stm_add_car_form <?php echo esc_attr($stm_edit_car_form); echo esc_attr($css_class); ?>">

    <?php

    if ($car_edit) {
        if (!is_user_logged_in()) {
            echo '<h4>' . esc_html__('Please login.', 'motors') . '</h4></div>';
            return false;
        }

        if (!empty($_GET['item_id'])) {
            $item_id = intval($_GET['item_id']);

            $car_user = get_post_meta($item_id, 'stm_car_user', true);

            if (intval($user_id) != intval($car_user)) {
                echo '<h4>' . esc_html__('You are not the owner of this car.', 'motors') . '</h4></div>';
                return false;
            }
        } else {
            echo '<h4>' . esc_html__('No car to edit.', 'motors') . '</h4></div>';
            return false;
        }
    } ?>

    <form method="POST" action="" enctype="multipart/form-data" id="stm_sell_a_car_form">

        <?php if ($car_edit){ ?>
            <input type="hidden" value="<?php echo intval($vars['id']); ?>" name="stm_current_car_id"/>
            <input type="hidden" value="update" name="stm_edit"/>
        <?php } else { ?>
            <input type="hidden" value="adding" name="stm_edit"/>
        <?php } ?>

        <?php stm_listings_load_template('add_car/title', $vars); ?>

        <?php stm_listings_load_template('add_car/step_1', $vars); ?>

        <?php stm_listings_load_template('add_car/step_2', $vars); ?>

        <?php stm_listings_load_template('add_car/step_3', $vars); ?>

        <?php stm_listings_load_template('add_car/step_4', $vars); ?>

        <?php stm_listings_load_template('add_car/step_5', $vars); ?>

        <?php stm_listings_load_template('add_car/step_6', $vars); ?>

    </form>

    <?php stm_listings_load_template('add_car/check_user', $vars); ?>

</div>

