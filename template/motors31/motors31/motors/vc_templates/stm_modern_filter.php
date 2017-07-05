<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

$args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
    'pad_counts' => true,
);

/*Get modern Filter*/
$modern_filter = stm_get_car_modern_filter();

$query_args = array(
    'post_type' => stm_listings_post_type(),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'paged' => false
);

$listings = new WP_Query($query_args);

$listing_filter_position = get_theme_mod('listing_filter_position', 'left');
if (!empty($_GET['filter_position']) and $_GET['filter_position'] == 'right') {
    $listing_filter_position = 'right';
}

$sidebar_pos_classes = '';
$content_pos_classes = '';

if ($listing_filter_position == 'right') {
    $sidebar_pos_classes = 'col-md-push-9 col-sm-push-0';
    $content_pos_classes = 'col-md-pull-3 col-sm-pull-0';
}

?>

<div class="row" id="modern-filter-listing">
    <div class="col-md-3 col-sm-12 sidebar-sm-mg-bt <?php echo esc_attr($sidebar_pos_classes); ?>">
        <?php if (!empty($modern_filter)): $counter = 0; ?>
            <?php foreach ($modern_filter as $modern_filter_unit): $counter++; ?>
                <?php $terms = get_terms(array($modern_filter_unit['slug']), $args); ?>
                <!--If its not price-->
                <?php if ($modern_filter_unit['slug'] != 'price'): ?>
                    <!--First one if ts not image goes on another view-->
                    <?php if ($counter == 1 and empty($modern_filter_unit['use_on_car_modern_filter_view_images']) and !$modern_filter_unit['use_on_car_modern_filter_view_images']): ?>
                    <?php if (!empty($terms)): ?>
                    <div class="stm-accordion-single-unit <?php echo esc_attr($modern_filter_unit['slug']); ?>">
                        <a class="title" data-toggle="collapse"
                           href="#<?php echo esc_attr($modern_filter_unit['slug']) ?>" aria-expanded="true">
                            <h5><?php esc_html_e($modern_filter_unit['single_name'], 'motors'); ?></h5>
                            <span class="minus"></span>
                        </a>
                        <div class="stm-accordion-content">
                            <div class="collapse in content" id="<?php echo esc_attr($modern_filter_unit['slug']); ?>">
                                <div class="stm-accordion-content-wrapper">
                                    <?php foreach ($terms as $term): ?>
                                        <?php if (!empty($_GET[$modern_filter_unit['slug']]) and $_GET[$modern_filter_unit['slug']] == $term->slug) { ?>
                                        <script type="text/javascript">
                                            jQuery(window).load(function () {
                                                var $ = jQuery;
                                                $('input[name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"]').click();
                                                $.uniform.update();
                                            });
                                        </script>
                                    <?php } ?>
                                        <div class="stm-single-unit">
                                            <label>
                                                <input type="checkbox"
                                                       name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"
                                                       data-name="<?php echo esc_attr($term->name); ?>"
                                                />
                                                <?php echo esc_attr($term->name); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php else: ?>
                    <!--if its not first one and have images-->
                    <?php if (!empty($modern_filter_unit['use_on_car_modern_filter_view_images'])): ?>
                    <?php if (!empty($terms)): ?>
                    <div
                        class="stm-accordion-single-unit stm-modern-filter-unit-images <?php echo esc_attr($modern_filter_unit['slug']); ?>">
                        <a class="title" data-toggle="collapse"
                           href="#<?php echo esc_attr($modern_filter_unit['slug']) ?>" aria-expanded="true">
                            <h5><?php esc_html_e($modern_filter_unit['single_name'], 'motors'); ?></h5>
                            <span class="minus"></span>
                        </a>
                        <div class="stm-accordion-content">
                            <div class="collapse in content" id="<?php echo esc_attr($modern_filter_unit['slug']); ?>">
                                <div class="stm-accordion-content-wrapper">
                                    <div class="stm-single-unit-wrapper">
                                        <?php $number_of_images = 0; ?>
                                        <?php $images = 0;
                                        foreach ($terms as $term): $images++; ?>
                                            <?php if (!empty($_GET[$modern_filter_unit['slug']]) and $_GET[$modern_filter_unit['slug']] == $term->slug) { ?>
                                            <script type="text/javascript">
                                                jQuery(window).load(function () {
                                                    var $ = jQuery;
                                                    $('input[name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"]').click();
                                                    $.uniform.update();
                                                });
                                            </script>
                                        <?php } ?>
                                        <?php
                                        $category_image = '';
                                        $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
                                        if (!empty($image)) {
                                            $image = wp_get_attachment_image_src($image, 'stm-img-190-132');
                                            $category_image = $image[0];
                                        }

                                        if (!empty($image)):
                                        $number_of_images++; ?>
                                            <div class="stm-single-unit-image">
                                                <label>
                                                    <?php if (!empty($category_image)): ?>
                                                        <span class="image">
																			<img class="img-reponsive"
                                                                                 src="<?php echo esc_url($category_image); ?>"
                                                                                 alt="<?php esc_html_e('Brand', 'motors'); ?>"/>
																		</span>
                                                    <?php endif; ?>
                                                    <input type="checkbox"
                                                           name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"
                                                           data-name="<?php echo esc_attr($term->name); ?>"
                                                    />
                                                    <?php echo esc_attr($term->name); ?>
                                                </label>
                                            </div>
                                        <?php endif; ?>

                                        <?php endforeach; ?>


                                        <?php if ($number_of_images < count($terms)): ?>
                                            <div class="stm-modern-view-others">
                                                <a href=""><?php echo esc_html_e('View all', 'motors'); ?></a>
                                            </div>
                                            <div class="stm-modern-filter-others">
                                                <?php $non_images = 0;
                                                foreach ($terms as $term): $non_images++; ?>

                                                    <?php
                                                    $category_image = '';
                                                    $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
                                                    if (!empty($image)) {
                                                        $image = wp_get_attachment_image_src($image, 'stm-img-190-132');
                                                        $category_image = $image[0];
                                                    }

                                                    if (empty($image)): ?>
                                                        <div class="stm-single-unit-image stm-no-image">
                                                            <label>
                                                                <input type="checkbox"
                                                                       name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"
                                                                       data-name="<?php echo esc_attr($term->name); ?>"
                                                                />
                                                                <?php echo esc_attr($term->name); ?>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                    <!--All others-->
                <?php else: ?>
                    <?php if (!empty($terms)): ?>
                    <div class="stm-accordion-single-unit <?php echo esc_attr($modern_filter_unit['slug']); ?>">
                        <a class="title" data-toggle="collapse"
                           href="#<?php echo esc_attr($modern_filter_unit['slug']) ?>" aria-expanded="true">
                            <h5><?php esc_html_e($modern_filter_unit['single_name'], 'motors'); ?></h5>
                            <span class="minus"></span>
                        </a>
                        <div class="stm-accordion-content">
                            <div class="collapse in content" id="<?php echo esc_attr($modern_filter_unit['slug']); ?>">
                                <div class="stm-accordion-content-wrapper">
                                    <?php foreach ($terms as $term): ?>
                                        <?php if (!empty($_GET[$modern_filter_unit['slug']]) and $_GET[$modern_filter_unit['slug']] == $term->slug) { ?>
                                        <script type="text/javascript">
                                            jQuery(window).load(function () {
                                                var $ = jQuery;
                                                $('input[name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"]').click();
                                                $.uniform.update();
                                            });
                                        </script>
                                    <?php } ?>
                                        <div class="stm-single-unit">
                                            <label>
                                                <input type="checkbox"
                                                       name="<?php echo esc_attr($term->slug . '-' . $term->term_id); ?>"
                                                       data-name="<?php echo esc_attr($term->name); ?>"
                                                />
                                                <?php echo esc_attr($term->name); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php endif; ?>


                <?php endif; ?> <!--first one not image-->
                <?php else: ?>
                    <?php if (!empty($terms)):
                    foreach ($terms as $term) {
                        $prices[] = intval($term->name);
                    }
                    sort($prices);
                    ?>

                    <div
                        class="stm-accordion-single-unit stm-modern-price-unit <?php echo esc_attr($modern_filter_unit['slug']); ?>">
                        <a class="title" data-toggle="collapse"
                           href="#<?php echo esc_attr($modern_filter_unit['slug']) ?>" aria-expanded="true">
                            <h5><?php esc_html_e($modern_filter_unit['single_name'], 'motors'); ?></h5>
                            <span class="minus"></span>
                        </a>
                        <div class="stm-accordion-content">
                            <div class="collapse in content" id="<?php echo esc_attr($modern_filter_unit['slug']); ?>">
                                <div class="stm-accordion-content-wrapper stm-modern-filter-price">

                                    <div class="stm-price-range-unit">
                                        <div class="stm-price-range"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-md-wider-right">
                                            <input type="text" name="min_price" id="stm_filter_min_price" readonly/>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-md-wider-left">
                                            <input type="text" name="max_price" id="stm_filter_max_price" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        var stmOptions;
                        (function ($) {
                            $(document).ready(function () {
                                stmOptions = {
                                    range: true,
                                    min: <?php echo esc_js($prices[0]); ?>,
                                    max: <?php echo esc_js($prices[count($prices) - 1]); ?>,
                                    values: [<?php echo esc_js($prices[0]); ?>, <?php echo esc_js($prices[count($prices) - 1]); ?>],
                                    step: 100,
                                    slide: function (event, ui) {
                                        $("#stm_filter_min_price").val(ui.values[0]);
                                        $("#stm_filter_max_price").val(ui.values[1]);
                                    }
                                }
                                $(".stm-price-range").slider(stmOptions);

                                $("#stm_filter_min_price").val($(".stm-price-range").slider("values", 0));
                                $("#stm_filter_max_price").val($(".stm-price-range").slider("values", 1));
                            })
                        })(jQuery);
                    </script>
                <?php endif; ?> <!--if terms price not empty-->
                <?php endif; ?> <!--price-->
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="col-md-9 col-sm-12 <?php echo esc_attr($content_pos_classes); ?>">
        <div class="stm-car-listing-sort-units stm-modern-filter-actions clearfix">
            <div class="stm-modern-filter-found-cars">
                <h4><span
                        class="orange"><?php echo esc_attr($listings->found_posts); ?></span> <?php esc_html_e('Vehicles available', 'motors'); ?>
                </h4>
            </div>
            <?php
            $view_list = '';
            $view_grid = '';

            if (!empty($_GET['view_type'])) {
                if ($_GET['view_type'] == 'list') {
                    $view_list = 'active';
                } elseif ($_GET['view_type'] == 'grid') {
                    $view_grid = 'active';
                }
            } else {
                $view_list = 'active';
            }

            ?>
            <div class="stm-view-by">
                <a href="?view_type=grid" class="stm-modern-view view-grid view-type <?php echo esc_attr($view_grid); ?>">
                    <i class="stm-icon-grid"></i>
                </a>
                <a href="?view_type=list" class="stm-modern-view view-list view-type <?php echo esc_attr($view_list); ?>">
                    <i class="stm-icon-list"></i>
                </a>
            </div>
            <div class="stm-sort-by-options clearfix">
                <span><?php esc_html_e('Sort by:', 'motors'); ?></span>
                <div class="stm-select-sorting">
                    <select>
                        <option value="date_high" selected><?php esc_html_e('Date: newest first', 'motors'); ?></option>
                        <option value="date_low"><?php esc_html_e('Date: oldest first', 'motors'); ?></option>
                        <option value="price_low"><?php esc_html_e('Price: lower first', 'motors'); ?></option>
                        <option value="price_high"><?php esc_html_e('Price: highest first', 'motors'); ?></option>
                        <option value="mileage_low"><?php esc_html_e('Mileage: lowest first', 'motors'); ?></option>
                        <option value="mileage_high"><?php esc_html_e('Mileage: highest first', 'motors'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modern-filter-badges">
            <ul class="stm-filter-chosen-units-list">

            </ul>
        </div>
        <?php if ($listings->have_posts()): ?>
            <?php if ($view_grid == 'active'): ?>
                <div class="row row-3 car-listing-row <?php if ($view_grid == 'active') {
                    echo esc_attr('car-listing-modern-grid');
                } ?>">
            <?php endif; ?>

            <div class="stm-isotope-sorting">

                <?php
                $template = 'partials/listing-cars/listing-grid-loop';
                if ($view_grid == 'active') {
                    if (stm_is_motorcycle()) {
                        $template = 'partials/listing-cars/motos/grid';
                    } elseif (stm_is_listing()) {
                        $template = 'partials/listing-cars/listing-grid-directory-loop';
                    } else {
                        $template = 'partials/listing-cars/listing-grid-loop';
                    }
                } else {
                    if (stm_is_motorcycle()) {
                        $template = 'partials/listing-cars/motos/list';
                    } elseif (stm_is_listing()) {
                        $template = 'partials/listing-cars/listing-list-directory-loop';
                    } else {
                        $template = 'partials/listing-cars/listing-list-loop';
                    }
                }

                $modern_filter = true;
                ?>

                <?php while ($listings->have_posts()): $listings->the_post();
                    include(locate_template($template . '.php'));
                endwhile; ?>

                <a class="button stm-show-all-modern-filter stm-hidden-filter"><?php esc_html_e('Show all', 'motors'); ?></a>

            </div>

            <?php if ($view_grid == 'active'): ?>
                </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div>
</div>