<?php
if(!empty($modern) and $modern) {
    $classes = array();
    $taxonomies = stm_get_taxonomies();

    $categories = wp_get_post_terms(get_the_ID(), $taxonomies);

    $classes = array();

    if (!empty($categories)) {
        foreach ($categories as $category) {
            $classes[] = $category->slug . '-' . $category->term_id;
        }
    }

    /*Price*/
    $price = get_post_meta(get_the_id(),'price',true);
    $sale_price = get_post_meta(get_the_id(),'sale_price',true);
    $data_price = '0';

    if(!empty($price)) {
        $data_price = $price;
    }

    if(!empty($sale_price)) {
        $data_price = $sale_price;
    }

    if(empty($price) and !empty($sale_price)) {
        $price = $sale_price;
    }

    /*Mileage*/
    $mileage = get_post_meta(get_the_id(),'mileage',true);

    $data_mileage = '0';

    if(!empty($mileage)) {
        $data_mileage = $mileage;
    }

    if(!empty($listing_classes)) {
        $classes = array_merge($classes, $listing_classes);
    }
    ?>

    <div
        class="listing-list-loop stm-listing-directory-list-loop stm-isotope-listing-item all <?php print_r(implode(' ', $classes)); ?>"
        data-price="<?php echo esc_attr($data_price) ?>"
        data-date="<?php echo get_the_date('Ymdhi') ?>"
        data-mileage="<?php echo esc_attr($data_mileage); ?>"
    >

<?php } else { ?>

    <div class="listing-list-loop stm-listing-directory-list-loop stm-isotope-listing-item">

<?php }
