<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));
$link = vc_build_link($link);

if (empty($image_size)) {
    $image_size = '253x233';
}

$thumbnail = '';

if (!empty($image)) {
    $image = explode(',', $image);
    if(!empty($image[0])) {
        $image = $image[0];

        $post_thumbnail = wpb_getImageBySize(array(
            'attach_id' => $image,
            'thumb_size' => $image_size
        ));

        $thumbnail = $post_thumbnail['thumbnail'];
    }
}

if (empty($text_image_width)) {
    $text_image_width = '';
}
?>

<div class="stm-compact-sidebar<?php echo esc_attr($css_class); ?>">
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

        <?php if (!empty($icon_or_image) and $icon_or_image == 'image'): ?>

            <?php if (!empty($text_image)): ?>
                <?php $text_image_src = wp_get_attachment_image_src($text_image, 'stm-img-350-356'); ?>
                <?php if (!empty($text_image_src) and !empty($text_image_src[0])): ?>

                    <?php $text_image_width = 'style=max-width:' . $text_image_width . 'px;'; ?>

                    <div class="text-image" <?php echo esc_attr($text_image_width); ?>>
                        <img class="img-responsive" src="<?php echo esc_url($text_image_src[0]); ?>"/>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php elseif (!empty($icon_or_image) and $icon_or_image == 'icon'): ?>
            <?php if (!empty($text_icon)): ?>
                <div class="icon">
                    <i class="<?php echo esc_attr($text_icon); ?>"></i>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!empty($content)): ?>
            <div class="content">
                <?php echo wpb_js_remove_wpautop($content, true); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($thumbnail)): ?>
            <div class="image">
                <?php echo $thumbnail; ?>
            </div>
        <?php endif; ?>



        <?php if (!empty($link['url'])): ?>
    </a>
<?php endif; ?>
</div>