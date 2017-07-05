<?php
$hide_labels = get_theme_mod('hide_price_labels', true);

if ($hide_labels) {
    $hide_labels = 'stm-listing-no-price-labels';
} else {
    $hide_labels = '';
}

$classes = array();

$classes[] = 'stm-special-car-top-' . get_post_meta(get_the_ID(), 'special_car', true);

$classes[] = $hide_labels;

if(empty($modern_filter)){
    $modern_filter = false;
}

stm_listings_load_template('loop/start', array('modern' => $modern_filter, 'listing_classes' => $classes));

?>
    <?php stm_listings_load_template('loop/classified/list/image'); ?>

    <div class="content">
        <?php stm_listings_load_template('loop/classified/list/title_price', array('hide_labels' => $hide_labels)) ?>

        <?php stm_listings_load_template('loop/classified/list/options'); ?>

        <div class="meta-bottom">
            <?php get_template_part('partials/listing-cars/listing-directive-list-loop', 'actions'); ?>
        </div>

        <a href="<?php the_permalink(); ?>"
           class="stm-car-view-more button visible-xs"><?php esc_html_e('View more', 'motors'); ?></a>

    </div>
</div>