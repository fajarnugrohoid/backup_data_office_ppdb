<?php if (have_posts()):

    $view_type = sanitize_file_name(stm_listings_input('view_type', 'list'));

    /*Filter Badges*/
    stm_listings_load_template('filter/badges');


    if (stm_is_listing()) {
        stm_listings_load_template('classified/filter/featured');
    }

    ?>

    <div class="stm-isotope-sorting stm-isotope-sorting-<?php echo esc_attr($view_type); ?>">

        <?php
        if ($view_type == 'grid'): ?>
        <div class="row row-3 car-listing-row car-listing-modern-grid">
            <?php endif;

            $template = 'partials/listing-cars/listing-' . $view_type . '-loop';

            if (stm_is_listing()) {
                $template = 'partials/listing-cars/listing-' . $view_type . '-directory-loop';
            } elseif (stm_is_boats() and $view_type == 'list') {
                $template = 'partials/listing-cars/listing-' . $view_type . '-loop-boats';
            } elseif (stm_is_motorcycle()) {
                $template = 'partials/listing-cars/motos/' . $view_type;
            }

            while (have_posts()): the_post();

                get_template_part($template);

            endwhile;

            if ($view_type == 'grid'): ?>
        </div>
    <?php endif; ?>

    </div>

<?php else: ?>
    <h3><?php esc_html_e('Sorry, No results', 'motors') ?></h3>
<?php endif; ?>

<?php stm_listings_load_pagination() ?>
