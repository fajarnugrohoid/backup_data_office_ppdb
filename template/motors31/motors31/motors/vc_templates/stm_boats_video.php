<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

if (empty($height)) {
    $height = '310';
}

if (!empty($image) and !empty($link)):
    $image = explode(',', $image);
    if (!empty($image[0])) {
        $image = $image[0];
        $image = wp_get_attachment_image_src($image, 'full');
        $image = $image[0];
    }
    ?>

    <div class="stm-boats-video-iframe">
        <a href="#" data-url="<?php echo esc_url($link); ?>" class="stm-boats-video-poster fancy-iframe"
           style="background-image: url('<?php echo sanitize_text_field($image); ?>')"></a>
    </div>

    <style>
        .stm-boats-video-iframe {
            height: <?php echo intval($height); ?>px !important;
            width: 100%;
        }
    </style>

    <script type="text/javascript">
        (function ($) {
            "use strict";

            $(document).ready(function ($) {
                stmPlayIframeVideo();
            });

            /* Custom func */
            function stmPlayIframeVideo() {
                $('.stm-boats-video-poster').click(function () {
                    $(this).addClass('video-preloader-hidden');
                    var addPlay = $(this).closest('.stm-boats-video-iframe').find('iframe').attr('src');
                    $(this).closest('.stm-boats-video-iframe').find('iframe').attr('src', addPlay + '&autoplay=1');
                });
            };

        })(jQuery);
    </script>

<?php endif; ?>
