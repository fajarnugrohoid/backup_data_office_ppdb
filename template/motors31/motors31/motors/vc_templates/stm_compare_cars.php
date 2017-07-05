<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

if (empty($_COOKIE['compare_ids'])) {
    $compare_ids = array();
} else {
    $compare_ids = $_COOKIE['compare_ids'];
}

$filter_options = stm_get_single_car_listings();

$empty_cars = 3 - count($compare_ids);
$counter = 0;
?>

<div class="<?php echo esc_attr($css_class); ?>">

    <?php if (!empty($compare_ids) or count($compare_ids) != 0): ?>
        <?php $args = array(
            'post_type' => stm_listings_post_type(),
            'post_status' => 'publish',
            'posts_per_page' => 3,

            'post__in' => $compare_ids,
        );
        $compares = new WP_Query($args);

        if ($compares->have_posts()): ?>
            <div class="row row-4 car-listing-row stm-car-compare-row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <h2 class="compare-title"><?php echo esc_html__('Compare Vehicles', 'motors'); ?></h2>
                    <div class="colored-separator text-left">
                        <?php if (stm_is_boats()): ?>
                            <div><i class="stm-boats-icon-wave stm-base-color"></i></div>
                        <?php else: ?>
                            <div class="first-long"></div>
                            <div class="last-short"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php while ($compares->have_posts()): $compares->the_post();
                    $counter++; ?>
                    <!--Compare car description-->
                    <div
                        class="col-md-3 col-sm-3 col-xs-4 compare-col-stm compare-col-stm-<?php echo esc_attr(get_the_ID()); ?>">
                        <a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
                            <div class="compare-col-stm-empty">
                                <div class="image">
                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="stm-compare-car-img">
                                            <?php the_post_thumbnail('stm-img-255-135', array('class' => 'img-responsive ')); ?>
                                        </div>
                                    <?php } else { ?>
                                        <i class="stm-icon-add_car"></i>
                                        <img class="stm-compare-empty"
                                             src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/compare-empty.jpg'); ?>"
                                             alt="<?php esc_html_e('Empty', 'motors'); ?>"/>
                                    <?php }; ?>
                                </div>
                            </div>
                        </a>
                        <div class="remove-compare-unlinkable">
							<span
                                class="remove-from-compare"
                                data-id="<?php echo esc_attr(get_the_ID()); ?>"
                                data-action="remove">
								<i class="stm-icon-remove"></i>
								<span><?php esc_html_e('Remove from list', 'motors'); ?></span>
							</span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
                            <div class="listing-car-item-meta">
                                <div class="car-meta-top heading-font clearfix">
                                    <?php $price = get_post_meta(get_the_id(), 'price', true); ?>
                                    <?php $sale_price = get_post_meta(get_the_id(), 'sale_price', true); ?>
                                    <?php $car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true); ?>
                                    <?php if (empty($car_price_form_label)): ?>
                                        <?php if (!empty($price) and !empty($sale_price)): ?>
                                            <div class="price discounted-price">
                                                <div
                                                    class="regular-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
                                                <div
                                                    class="sale-price"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></div>
                                            </div>
                                        <?php elseif (!empty($price)): ?>
                                            <div class="price">
                                                <div
                                                    class="normal-price"><?php echo esc_attr(stm_listing_price_view($price)); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="price">
                                            <div
                                                class="normal-price"><?php echo esc_attr($car_price_form_label); ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="car-title"><?php the_title(); ?></div>
                                </div>
                            </div>
                        </a>

                        <span class="btn btn-default add-to-compare hidden" data-action="remove"
                              data-id="<?php echo esc_js(get_the_ID()); ?>">
							<?php esc_html_e('Remove from compare', 'motors'); ?>
						</span>
                    </div> <!--md-3-->
                <?php endwhile; ?>
                <?php for ($i = 0; $i < $empty_cars; $i++) { ?>
                    <div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-empty">
                        <a href="<?php echo esc_url(stm_get_listing_archive_link()); ?>">
                            <div class="image">
                                <i class="stm-icon-add_car"></i>
                                <img class="stm-compare-empty"
                                     src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/compare-empty.jpg'); ?>"
                                     alt="<?php esc_html_e('Empty', 'motors'); ?>"/>
                            </div>
                            <div class="h5"><?php esc_html_e('Add car to compare', 'motors'); ?></div>
                        </a>
                    </div>
                <?php } ?>
            </div> <!--row-->
        <?php endif; ?>
        <?php if ($compares->have_posts()): ?>
            <div class="row row-4 stm-compare-row">
                <div class="col-md-3 col-sm-3 hidden-xs">
                    <?php if (!empty($filter_options)): ?>
                        <div class="compare-options">
                            <table>
                                <?php foreach ($filter_options as $filter_option): ?>
                                    <?php if ($filter_option['slug'] != 'price') { ?>
                                        <tr>
                                            <?php $compare_option = get_post_meta(get_the_id(), $filter_option['slug'], true); ?>
                                            <td class="compare-value-hover"
                                                data-value="<?php echo esc_attr('compare-value-' . $filter_option['slug']) ?>">
                                                <?php esc_html_e($filter_option['single_name'], 'motors'); ?>
                                            </td>
                                        </tr>
                                    <?php }; ?>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <?php while ($compares->have_posts()): $compares->the_post(); ?>
                    <div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-<?php echo esc_attr(get_the_ID()); ?>">
                        <?php if (!empty($filter_options)): ?>
                            <div class="compare-values">
                                <?php if (has_post_thumbnail(get_the_ID())): ?>
                                    <div class="compare-car-visible">
                                        <?php the_post_thumbnail('stm-img-796-466', array('class' => 'img-responsive stm-img-mobile-compare')); ?>
                                    </div>
                                <?php endif; ?>
                                <h4 class="text-transform compare-car-visible"><?php the_title(); ?></h4>
                                <table>
                                    <?php foreach ($filter_options as $filter_option): ?>
                                        <?php if ($filter_option['slug'] != 'price') { ?>
                                            <tr>
                                                <?php $compare_option = get_post_meta(get_the_id(), $filter_option['slug'], true); ?>
                                                <td class="compare-value-hover"
                                                    data-value="<?php echo esc_attr('compare-value-' . $filter_option['slug']) ?>">
                                                    <div class="h5">
                                                        <?php if (!empty($compare_option)) {
                                                            //if numeric get value from meta
                                                            if (!empty($filter_option['numeric']) and $filter_option['numeric']) {
                                                                echo esc_attr($compare_option);
                                                            } else {
                                                                //not numeric, get category name by meta
                                                                $data_meta_array = explode(',', $compare_option);
                                                                $datas = array();

                                                                if (!empty($data_meta_array)) {
                                                                    foreach ($data_meta_array as $data_meta_single) {
                                                                        $data_meta = get_term_by('slug', $data_meta_single, $filter_option['slug']);
                                                                        if (!empty($data_meta->name)) {
                                                                            $datas[] = esc_attr($data_meta->name);
                                                                        }
                                                                    }
                                                                }
                                                                if (!empty($datas)) {
                                                                    echo implode(', ', $datas);;
                                                                } else {
                                                                    esc_html_e('None', 'motors');
                                                                }
                                                            }
                                                        } else {
                                                            esc_html_e('None', 'motors');
                                                        } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div> <!--md-3-->
                <?php endwhile; ?>
                <?php for ($i = 0; $i < $empty_cars; $i++) { ?>
                    <?php if (!empty($filter_options)): ?>
                        <div class="col-md-3 col-sm-3 hidden-xs">
                            <div class="compare-options">
                                <table>
                                    <?php foreach ($filter_options as $filter_option): ?>
                                        <?php if ($filter_option['slug'] != 'price') { ?>
                                            <tr>
                                                <td class="compare-value-hover">&nbsp;</td>
                                            </tr>
                                        <?php }; ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php } ?>
            </div> <!--row-->
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

    <?php else: //If empty cars, just everything without cars =) ?>
        <div class="row row-4 car-listing-row stm-car-compare-row hidden-xs">
            <div class="col-md-3 col-sm-3">
                <h2 class="compare-title"><?php echo esc_html__('Compare Vehicles', 'motors'); ?></h2>
                <div class="colored-separator text-left">
                    <?php if (stm_is_boats()): ?>
                        <div><i class="stm-boats-icon-wave stm-base-color"></i></div>
                    <?php else: ?>
                        <div class="first-long"></div>
                        <div class="last-short"></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php for ($i = 0; $i < $empty_cars; $i++) { ?>
                <div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-empty">
                    <a href="<?php echo esc_url(stm_get_listing_archive_link()); ?>">
                        <div class="image">
                            <i class="stm-icon-add_car"></i>
                            <img class="stm-compare-empty"
                                 src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/compare-empty.jpg'); ?>"
                                 alt="<?php esc_html_e('Empty', 'motors'); ?>"/>
                        </div>
                        <div class="h5"><?php esc_html_e('Add car to compare', 'motors'); ?></div>
                    </a>
                </div>
            <?php } ?>
        </div> <!--row-->
        <div class="row row-4 stm-compare-row hidden-xs">
            <div class="col-md-3 col-sm-3 col-xs-4 hidden-xs">
                <?php if (!empty($filter_options)): ?>
                    <div class="compare-options">
                        <table>
                            <?php foreach ($filter_options as $filter_option): ?>
                                <?php if ($filter_option['slug'] != 'price') { ?>
                                    <tr>
                                        <?php $compare_option = get_post_meta(get_the_id(), $filter_option['slug'], true); ?>
                                        <td class="compare-value-hover"
                                            data-value="<?php echo esc_attr('compare-value-' . $filter_option['slug']) ?>">
                                            <?php esc_html_e($filter_option['single_name'], 'motors'); ?>
                                        </td>
                                    </tr>
                                <?php }; ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <?php for ($i = 0; $i < $empty_cars; $i++) { ?>
                <?php if (!empty($filter_options)): ?>
                    <div class="col-md-3 col-sm-3 col-xs-4">
                        <div class="compare-options">
                            <table>
                                <?php foreach ($filter_options as $filter_option): ?>
                                    <?php if ($filter_option['slug'] != 'price') { ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php }; ?>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div> <!--row-->
    <?php endif; ?>

    <!--Additional features-->
    <?php if (!empty($compares)): ?>
        <?php if ($compares->have_posts()): ?>
            <div class="row row-4 row-compare-features hidden-xs">
                <div class="col-md-3 col-sm-3">
                    <h4 class="stm-compare-features"><?php echo esc_attr('Additional features', 'motors'); ?></h4>
                </div>
                <?php while ($compares->have_posts()): $compares->the_post(); ?>
                    <?php $features = get_post_meta(get_the_ID(), 'additional_features', true); ?>
                    <?php if (!empty($features)): ?>
                        <div class="col-md-3 col-sm-3 compare-col-stm-<?php echo esc_attr(get_the_ID()); ?>">
                            <?php $features = explode(',', $features); ?>
                            <ul class="list-style-2">
                                <?php foreach ($features as $feature): ?>
                                    <li><?php echo esc_attr($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
</div> <!--container-->


<div class="compare-empty-car-top">
    <div class="col-md-3 col-sm-3 col-xs-4 compare-col-stm-empty">
        <a href="<?php echo esc_url(get_post_type_archive_link(stm_listings_post_type())); ?>">
            <div class="image">
                <i class="stm-icon-add_car"></i>
                <img class="stm-compare-empty"
                     src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/compare-empty.jpg'); ?>"
                     alt="<?php esc_html_e('Empty', 'motors'); ?>"/>
            </div>
            <div class="h5"><?php esc_html_e('Add car to compare', 'motors'); ?></div>
        </a>
    </div>
</div>

<div class="compare-empty-car-bottom">
    <?php if (!empty($filter_options)): ?>
        <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="compare-options">
                <table>
                    <?php foreach ($filter_options as $filter_option): ?>
                        <?php if ($filter_option['slug'] != 'price') { ?>
                            <tr>
                                <td class="compare-value-hover">&nbsp;</td>
                            </tr>
                        <?php }; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.compare-value-hover').hover(function () {
            var dataValue = $(this).data('value');
            $('.compare-value-hover[data-value = ' + dataValue + ']').addClass('hovered');
        }, function () {
            $('.compare-value-hover').removeClass('hovered');
        })
    })
</script>