<?php
$user_page = get_queried_object();
$user_id = $user_page->data->ID;
$user = stm_get_user_custom_fields($user_id);

$ratings = stm_get_dealer_marks($user_id);

$sidebar = get_theme_mod('dealer_sidebar', '1864');
$sidebar_position = get_theme_mod('dealer_sidebar_position', 'right');

$layout = stm_sidebar_layout_mode($sidebar_position, $sidebar);

$inline_list = 'stm-inline-icons';

?>

<div class="container stm-user-public-profile">
    <div class="row">
        <?php echo $layout['content_before']; ?>

        <div class="stm-dealer-public-profile">
            <div class="clearfix">
                <div class="stm-dealer-top-left">
                    <h3><?php stm_display_user_name($user_id); ?></h3>
                    <?php if (!empty($ratings['average'])): ?>
                        <div class="stm-star-rating">
                            <div class="inner">
                                <div class="stm-star-rating-upper"
                                     style="width:<?php echo esc_attr($ratings['average_width']); ?>"></div>
                                <div class="stm-star-rating-lower"></div>
                            </div>
                            <div class="heading-font"><?php echo esc_attr($ratings['average']); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="stm-dealer-top-right">
                    <?php if (!empty($user['logo'])): ?>
                        <img src="<?php echo esc_url($user['logo']); ?>" class="img-responsive"/>
                    <?php else: ?>
                        <img src="<?php stm_get_dealer_logo_placeholder(); ?>" class="img-responsive"/>
                    <?php endif; ?>
                </div>
            </div>

            <div class="stm-dealer-main-info">
                <div class="clearfix">
                    <div class="stm-dealer-image">
                        <?php if (!empty($user['dealer_image'])): $inline_list = ''; ?>
                            <img src="<?php echo esc_url($user['dealer_image']); ?>"/>
                        <?php endif; ?>
                    </div>
                    <div class="stm-dealer-info <?php echo esc_attr($inline_list); ?>">
                        <?php if (!empty($user['location'])): ?>
                            <div class="stm-dealer-info-unit location">
                                <i class="stm-icon-pin"></i>
                                <div class="inner">
                                    <h5><?php esc_html_e('Location', 'motors'); ?></h5>
                                    <span><?php esc_html_e($user['location'], 'motors'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($user['phone'])): ?>
                            <div class="stm-dealer-info-unit phone">
                                <i class="stm-service-icon-sales_phone"></i>
                                <div class="inner">
                                    <h5><?php esc_html_e('Sales Phone', 'motors'); ?></h5>
                                    <span><?php esc_html_e($user['phone'], 'motors'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($user['stm_sales_hours'])): ?>
                            <div class="stm-dealer-info-unit sales_hours">
                                <i class="stm-service-icon-sales_hours"></i>
                                <div class="inner">
                                    <h5><?php esc_html_e('Sales Hours', 'motors'); ?></h5>
                                    <span><?php esc_html_e($user['stm_sales_hours'], 'motors'); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                        <div class="stm-dealer-bot-info">
                            <?php if (!empty($user['website'])): ?>
                                <div class="stm_website_url">
                                    <a href="<?php echo esc_url($user['website']); ?>" target="_blank">
                                        <i class="fa fa-external-link"></i><?php esc_html_e('View Website', 'motors'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($user['socials'])): ?>
                                <div class="socials clearfix">
                                    <?php foreach ($user['socials'] as $social_key => $social): ?>
                                        <a href="<?php echo esc_url($social); ?>">
                                            <?php
                                            if ($social_key == 'youtube') {
                                                $social_key = 'youtube-play';
                                            }
                                            ?>
                                            <i class="fa fa-<?php echo esc_attr($social_key); ?>"></i>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($user['stm_seller_notes'])): ?>
                    <div class="stm-seller-notes">
                        <div class="heading-font"><?php esc_html_e('Seller\'s Notes', 'motors'); ?></div>
                        <?php echo esc_attr($user['stm_seller_notes']); ?>
                    </div>
                <?php endif; ?>

                <div class="stm-dealer-tabs">
                    <!-- Nav tabs -->
                    <ul role="tablist" class="stm-dealer-tabs-list heading-font clearfix">
                        <li role="presentation" class="active">
                            <a href="#stm_d_inv" aria-controls="stm_d_inv" role="tab" data-toggle="tab">
                                <i class="fa fa-car"></i>
                                <?php esc_html_e('Dealer\'s Inventory', 'motors'); ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#stm_d_rev" aria-controls="stm_d_rev" role="tab" data-toggle="tab">
                                <i class="fa fa-star"></i>
                                <?php esc_html_e('Dealer Reviews', 'motors'); ?>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#stm_w_rev" aria-controls="stm_w_rev" role="tab" data-toggle="tab">
                                <i class="stm-service-icon-write-review"></i>
                                <?php esc_html_e('Write a review', 'motors'); ?>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="stm_d_inv">
                            <?php get_template_part('partials/user/dealer', 'inventory'); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="stm_d_rev">
                            <?php get_template_part('partials/user/dealer', 'reviews'); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="stm_w_rev">
                            <?php get_template_part('partials/user/dealer-write', 'review'); ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php echo $layout['content_after']; ?>

        <?php echo $layout['sidebar_before'];

        if (!empty($user['location_lat']) and !empty($user['location_lng']) and !empty($user['location'])) {
            stm_dealer_gmap($user['location_lat'], $user['location_lng']);
        }
        if (!empty($sidebar)):
            $user_sidebar = get_post($sidebar);

            if (!empty($user_sidebar) and !is_wp_error($user_sidebar)):

                ?>
                <div class="stm-user-sidebar">
                    <?php echo apply_filters('the_content', $user_sidebar->post_content); ?>
                    <style type="text/css">
                        <?php echo get_post_meta( $user_sidebar, '_wpb_shortcodes_custom_css', true ); ?>
                    </style>

                    <script type="text/javascript">
                        jQuery(window).load(function () {
                            var $ = jQuery;
                            var inputAuthor = '<input type="hidden" value="<?php echo esc_attr($user_page->ID); ?>" name="stm_changed_recepient"/>';
                            $('.stm_listing_car_form form').append(inputAuthor);
                        })
                    </script>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php echo $layout['sidebar_after']; ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        var $ = jQuery;
        if (location.hash !== '') {
            $('a[href="' + location.hash + '"]').tab('show');
        }
    })
</script>