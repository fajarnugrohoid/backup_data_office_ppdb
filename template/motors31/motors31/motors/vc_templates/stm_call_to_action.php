<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

$link = vc_build_link($link);

//Get icon or image
if (!empty($icon_or_image) and $icon_or_image == 'image') {
    if (!empty($text_image)) {
        $text_image = wp_get_attachment_image_src($text_image, 'thumbnail');
        if (!empty($text_image[0])) {
            $text_image = $text_image[0];
        }
    }
} elseif (!empty($icon_or_image) and $icon_or_image == 'icon') {

}

//Get bg
if (!empty($image)) {
    $image = explode(',', $image);
    if (!empty($image[0])) {
        $image = $image[0];
        $image = wp_get_attachment_image_src($image, 'full');
        $image = $image[0];
    }
}

$ca_rand = rand(0, 99999);
$ca_unique = ' stm-call-to-action-' . $ca_rand;

?>

    <div class="<?php echo esc_attr($css_class); ?>">
        <?php if (!empty($link['url'])): ?>
        <a
            class="icon-box-link"
            href="<?php echo esc_url($link['url']) ?>"
            title="<?php if (!empty($link['title'])) {
                echo esc_attr($link['title']);
            }; ?>"
            <?php if (!empty($link['target'])): ?>
                target="_blank"
            <?php endif; ?>>
            <?php endif; ?>

            <div class="stm-call-to-action-1<?php echo esc_attr($css_class . $ca_unique); ?>">
                <div class="stm-call-action-left">
                    <div class="stm-call-action-content">
                        <div class="stm-call-action-<?php echo esc_attr($icon_or_image) ?>">
                            <?php if (!empty($icon_or_image) and $icon_or_image == 'image' and !empty($text_image)): ?>
                                <img src="<?php echo esc_url($text_image); ?>"
                                     alt="<?php esc_html_e('Call to action', 'motors'); ?>"/>
                            <?php endif; ?>
                            <?php if (!empty($icon_or_image) and $icon_or_image == 'icon') { ?>
                                <i class="<?php echo esc_attr($text_icon); ?>"></i>
                            <?php } ?>
                        </div>
                        <?php if (!empty($content)): ?>
                            <div class="content heading-font">
                                <?php echo wpb_js_remove_wpautop($content); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($image)): ?>
                    <div class="stm-call-action-right">
                        <div class="stm-call-action-right-banner"
                             style="background-image:url('<?php echo esc_url($image); ?>')"></div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($link['url'])): ?>
        </a>
    <?php endif; ?>
    </div>

<?php if (!empty($box_color)): ?>
    <style type="text/css">
        .stm-call-to-action-<?php echo esc_attr($ca_rand); ?> .stm-call-action-left,
        .stm-call-to-action-<?php echo esc_attr($ca_rand); ?> .stm-call-action-left:after {
            background-color: <?php echo esc_attr($box_color); ?>;
        }
    </style>
<?php endif; ?>