<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

if ('' === $images) {
    $images = '-1,-2,-3';
}

$images = explode(',', $images);
$i = -1;

$image_gallery = 'media-carousel-' . rand(0, 99999);

$fullwidth_class_outer = $fullwidth_class = '';

$slides_horizontal = 4;

$slides_vertical = 3;

if (!empty($fullwidth) and $fullwidth == 'enable') {
    $fullwidth_class = 'stm-carousel-fullwidth';
    $fullwidth_class_outer = 'stm-carousel-fullwidth-wrapper';

    $slides_horizontal = 2;

    $slides_vertical = 1;
}

?>

<div class="<?php echo esc_attr($fullwidth_class_outer); ?>">
    <div
        class="stm-carousel dwqdqwdqw owl-carousel <?php echo esc_attr($image_gallery); ?> <?php echo esc_attr($css_class); ?> <?php echo esc_attr($fullwidth_class); ?>">

        <?php if (!empty($images)):
            foreach ($images as $attach_id):
                $i++;
                $post_thumbnail = wpb_getImageBySize(array(
                    'attach_id' => $attach_id,
                    'thumb_size' => $image_size
                ));

                $thumbnail = $post_thumbnail['thumbnail']; ?>

                <div class="media-carousel-item">
                    <?php
                    $fancy_link = wp_get_attachment_image_src($attach_id, 'full');
                    if (!empty($fancy_link)) {
                        $fancy_link = $fancy_link[0];
                    } else {
                        $fancy_link = '';
                    }
                    ?>
                    <a class="stm_fancybox" href="<?php echo esc_attr($fancy_link); ?>"
                       title="<?php esc_html_e('Watch in popup', 'motors'); ?>"
                       rel="<?php echo esc_attr($image_gallery); ?>">
                        <?php echo $thumbnail; ?>
                    </a>
                </div>

            <?php endforeach;
        endif; ?>

    </div>
</div>


<script type="text/javascript">
    (function ($) {
        "use strict";

        var $owl = $('.<?php echo esc_js($image_gallery); ?>');

        <?php if($fullwidth_class != 'stm-carousel-fullwidth'): ?>

        $(document).ready(function () {
            var owlRtl = false;
            if ($('body').hasClass('rtl')) {
                owlRtl = true;
            }


            $owl.on('initialized.owl.carousel', function (e) {
                $owl.find('.owl-dots').before('<div class="stm-owl-prev"><i class="fa fa-angle-left"></i></div>');
                $owl.find('.owl-dots').after('<div class="stm-owl-next"><i class="fa fa-angle-right"></i></div>');
            })
            $owl.owlCarousel({
                rtl: owlRtl,
                items: 3,
                smartSpeed: 800,
                dots: true,
                margin: 10,
                autoplay: false,
                loop: true,
                responsiveRefreshRate: 1000,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1000: {
                        items:<?php echo esc_js($slides_per_row); ?>
                    }
                }
            });
            $owl.on('click', '.stm-owl-prev', function () {
                $owl.trigger('prev.owl.carousel');
            })
            $owl.on('click', '.stm-owl-next', function () {
                $owl.trigger('next.owl.carousel');
            });

            $('.vc_tta-tabs .vc_tta-tab a').click(function () {
                var tabId = $(this).attr('href');
                setTimeout(function () {

                    var $owlTab = $(tabId + ' .<?php echo esc_js($image_gallery); ?>');

                    $owlTab.trigger('destroy.owl.carousel');
                    $owlTab.html($owlTab.find('.owl-stage-outer').html()).removeClass('owl-loaded');

                    $owlTab.on('initialized.owl.carousel', function (e) {
                        $owlTab.find('.owl-dots').before('<div class="stm-owl-prev"><i class="fa fa-angle-left"></i></div>');
                        $owlTab.find('.owl-dots').after('<div class="stm-owl-next"><i class="fa fa-angle-right"></i></div>');
                    });

                    $owlTab.owlCarousel({
                        rtl: owlRtl,
                        items: 3,
                        smartSpeed: 800,
                        dots: true,
                        margin: 10,
                        autoplay: false,
                        loop: true,
                        responsiveRefreshRate: 1000,
                        responsive: {
                            0: {
                                items: 1
                            },
                            500: {
                                items: 2,
                                loop: false
                            },
                            768: {
                                items: <?php echo esc_attr($slides_vertical) ?>,
                                loop: false
                            },
                            991: {
                                items: <?php echo esc_attr($slides_horizontal) ?>,
                                loop: false
                            },
                            1025: {
                                items:<?php echo esc_js($slides_per_row); ?>
                            }
                        }
                    });
                }, 200);

            });

        });

        <?php else: ?>

        $(window).load(function () {

            var owlRtl = false;
            if ($('body').hasClass('rtl')) {
                owlRtl = true;
            }

            $owl.on('initialized.owl.carousel', function (e) {
                $owl.find('.owl-dots').before('<div class="stm-owl-prev"><i class="fa fa-angle-left"></i></div>');
                $owl.find('.owl-dots').after('<div class="stm-owl-next"><i class="fa fa-angle-right"></i></div>');
            });

            $owl.owlCarousel({
                rtl: owlRtl,
                items: 3,
                smartSpeed: 800,
                dots: true,
                margin: 10,
                autoplay: false,
                loop: true,
                responsiveRefreshRate: 1000,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 2,
                        loop: false
                    },
                    768: {
                        items: <?php echo esc_attr($slides_vertical) ?>,
                        loop: false
                    },
                    991: {
                        items: <?php echo esc_attr($slides_horizontal) ?>,
                        loop: false
                    },
                    1025: {
                        items:<?php echo esc_js($slides_per_row); ?>
                    }
                }
            });
            $owl.on('click', '.stm-owl-prev', function () {
                $owl.trigger('prev.owl.carousel');
            })
            $owl.on('click', '.stm-owl-next', function () {
                $owl.trigger('next.owl.carousel');
            });

        });

        <?php endif; ?>

    })(jQuery);
</script>