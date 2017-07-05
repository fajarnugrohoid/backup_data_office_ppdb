<?php

$attributes = stm_listings_filter_terms();

$filter_badges = array();
foreach ($attributes as $attribute => $terms) {

    /*Text field*/
    $options = stm_get_all_by_slug($attribute);

    /*Field affix like mi, km or another defined by user*/
    $affix = '';
    if (!empty($options['number_field_affix'])) {
        $affix = esc_html__($options['number_field_affix'], 'motors');
    }

    /*Slider badge*/
    if (!empty($options['slider']) and $options['slider']) {
        if (!empty($_GET['min_' . $attribute]) and !empty($_GET['max_' . $attribute])) {
            reset($terms);
            $start_value = key($terms);
            end($terms);
            $end_value = key($terms);

            if ($attribute == 'price') {
                $value = stm_listing_price_view(stm_listings_input('min_' . $attribute, $start_value)) . ' - ' . stm_listing_price_view(stm_listings_input('max_' . $attribute, $end_value));
            } else {
                $value = stm_listings_input('min_' . $attribute, $start_value) . ' - ' . stm_listings_input('max_' . $attribute, $end_value) . ' ' . $affix;
            }

            $filter_badges[$attribute] = array(
                'slug' => $attribute,
                'name' => stm_get_name_by_slug($attribute),
                'type' => 'slider',
                'value' => $value,
                'origin' => array('min_' . $attribute, 'max_' . $attribute)
            );
        }
        /*Badge of number field*/
    } elseif (!empty($options['numeric']) and $options['numeric']) {
        if (!empty($_GET[$attribute])) {

            $value = esc_attr($_GET[$attribute]);
            $filter_badges[$attribute] = array(
                'slug' => $attribute,
                'name' => stm_get_name_by_slug($attribute),
                'value' => $value . ' ' . $affix,
                'type' => 'number',
                'origin' => array($attribute)
            );
        }
        /*Badge of text field*/
    } else {
        if (!empty($_GET[$attribute])) {

            $value = esc_attr($_GET[$attribute]);

            $filter_badges[$attribute] = array(
                'slug' => $attribute,
                'name' => stm_get_name_by_slug($attribute),
                'value' => $terms[$value]->name,
                'origin' => array($attribute),
                'type' => 'select',
            );
        }
    }
}

if (!empty($filter_badges)): ?>
    <div class="stm-filter-chosen-units">
        <ul class="stm-filter-chosen-units-list">
            <?php foreach ($filter_badges as $badge => $badge_info):
                $remove_args = $badge_info['origin'];
                $remove_args[] = 'ajax_action';
                $badge_value = str_replace('\\', '', $badge_info['value']);
                ?>
                <li>
                    <span><?php esc_html_e($badge_info['name'], 'motors'); ?>: </span>
                    <?php esc_html_e($badge_value, 'motors'); ?>
                    <i data-url="<?php echo esc_url(remove_query_arg($remove_args)); ?>"
                       data-type="<?php echo $badge_info['type']; ?>"
                       data-slug="<?php echo $badge_info['slug']; ?>"
                       class="fa fa-close stm-clear-listing-one-unit stm-clear-listing-one-unit-classic"></i>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
