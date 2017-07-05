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
$slug = 'price';

$label_affix = $start_value . ' — ' . $end_value;

$vars = array(
    'slug' => $slug,
    'js_slug' => str_replace('-', 'stmdash', $slug),
    'label' => stripslashes($label_affix),
    'start_value' => $start_value,
    'end_value' => $end_value,
    'min_value' => stm_listings_input('min_' . $slug, $start_value),
    'max_value' => stm_listings_input('max_' . $slug, $end_value)
);
?>

<div class="stm-filter-listing-directory-price">
    <div class="stm-accordion-single-unit price">
        <a class="title" data-toggle="collapse" href="#price" aria-expanded="true">
            <h5><?php _e('Select Price', 'motors'); ?></h5>
            <span class="minus"></span>
        </a>
        <div class="stm-accordion-content">
            <div class="collapse in content" id="price">
                <div class="stm-accordion-content-wrapper">
                    <div class="stm-price-range-unit">
                        <div class="stm-price-range"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-md-wider-right">
                            <input type="text" name="min_price" id="stm_filter_min_price"/>
                        </div>
                        <div class="col-md-6 col-sm-6 col-md-wider-left">
                            <input type="text" name="max_price" id="stm_filter_max_price"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Init slider-->
<?php stm_listings_load_template('filter/types/slider-js', $vars); ?>
