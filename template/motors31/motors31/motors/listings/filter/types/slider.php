<?php
if (empty($options)) {
    return;
}

/*Get min and max value*/
reset($options);
$start_value = key($options);
end($options);
$end_value = key($options);

/*Current slug*/
$slug = $taxonomy['slug'];

$info = stm_get_all_by_slug($slug);
$affix = '';
if (!empty($info['number_field_affix'])) {
    $affix = str_replace('\\', '', $info['number_field_affix']);
}

$vars = array(
    'slug' => $slug,
    'affix' => $affix,
    'js_slug' => str_replace('-', 'stmdash', $slug),
    'start_value' => $start_value,
    'end_value' => $end_value,
    'min_value' => stm_listings_input('min_' . $slug, $start_value),
    'max_value' => stm_listings_input('max_' . $slug, $end_value)
);

$label_affix = $vars['min_value'] . $affix . ' — ' . $vars['max_value'] . $affix;
if($slug == 'price') {
    $label_affix = stm_listing_price_view($vars['min_value']) . ' — ' . stm_listing_price_view($vars['max_value']);
}

$vars['label'] = stripslashes($label_affix);

?>

<div class="col-md-12 col-sm-12">
    <div class="filter-<?php echo esc_attr($vars['slug']); ?> stm-slider-filter-type-unit">
        <div class="clearfix">
            <h5 class="pull-left"><?php _e($taxonomy['single_name'], 'motors'); ?></h5>
            <div class="stm-current-slider-labels"><?php echo $vars['label']; ?></div>
        </div>

        <div class="stm-price-range-unit">
            <div class="stm-<?php echo esc_attr($vars['slug']); ?>-range stm-filter-type-slider"></div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-md-wider-right">
                <input type="text" name="min_<?php echo esc_attr($vars['slug']); ?>"
                       id="stm_filter_min_<?php echo esc_attr($vars['slug']); ?>" class="form-control"/>
            </div>
            <div class="col-md-6 col-sm-6 col-md-wider-left">
                <input type="text" name="max_<?php echo esc_attr($vars['slug']); ?>"
                       id="stm_filter_max_<?php echo esc_attr($vars['slug']); ?>" class="form-control"/>
            </div>
        </div>
    </div>

    <!--Init slider-->
    <?php stm_listings_load_template('filter/types/slider-js', $vars); ?>
</div>