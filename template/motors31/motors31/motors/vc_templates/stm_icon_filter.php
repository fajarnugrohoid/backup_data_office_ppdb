<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

if (!empty($filter_selected)):

    $filter_selected_info = stm_get_all_by_slug($filter_selected);
    $multiply = false;
    if (!empty($filter_selected_info['listing_rows_numbers'])) {
        $multiply = true;
    }

    $args = array(
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
        'pad_counts' => true
    );

    $terms = get_terms($filter_selected, $args);

    $terms_images = array();
    $terms_text = array();
    if (!empty($terms)) {
        foreach ($terms as $term) {
            $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
            if (empty($image)) {
                $terms_text[] = $term;
            } else {
                $terms_images[] = $term;
            }
        };
    }

    if (empty($limit)) {
        $limit = 20;
    }
    ?>
    <div class="stm_icon_filter_unit">
        <div class="clearfix">
            <?php if (!empty($duration) and count($terms_text) > 0): ?>
                <div class="stm_icon_filter_label">
                    <?php echo esc_attr($duration); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($content)): ?>
                <div class="stm_icon_filter_title"><?php echo wpb_js_remove_wpautop($content, true); ?></div>
            <?php endif; ?>
        </div>

        <?php if (!empty($terms)): ?>
            <div
                class="stm_listing_icon_filter stm_listing_icon_filter_<?php echo esc_attr($per_row); ?> text-<?php echo esc_attr($align); ?>">

                <?php $icon_visiblity = 'non-visible' ?>

                <?php $i = 0;
                foreach ($terms_images as $term): ?>
                    <?php $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
                    if ($multiply) {
                        $link = stm_get_listing_archive_link() . '?' . $filter_selected . '[] = ' . $term->slug;
                    } else {
                        $link = stm_get_listing_archive_link() . '?' . $filter_selected . '=' . $term->slug;
                    }
                    if (!empty($image)):
                        //Getting limit for frontend without showing all
                        if ($limit > $i):
                            $image = wp_get_attachment_image_src($image, 'stm-img-190-132');
                            $category_image = $image[0]; ?>
                            <a href="<?php echo esc_url($link); ?>" class="stm_listing_icon_filter_single"
                               title="<?php echo esc_attr($term->name); ?>">
                                <div class="inner">
                                    <div class="image">
                                        <img src="<?php echo esc_url($category_image); ?>"
                                             alt="<?php echo esc_attr($term->name); ?>"/>
                                    </div>
                                    <div class="name"><?php echo esc_attr($term->name); ?> <span
                                            class="count">(<?php echo $term->count; ?>)</span></div>
                                </div>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo stm_get_listing_archive_link() . '?' . $filter_selected . '=' . $term->slug; ?>"
                               class="stm_listing_icon_filter_single non-visible"
                               title="<?php echo esc_attr($term->name); ?>">
                                <div class="inner">
                                    <div class="name"><?php echo esc_attr($term->name); ?> <span
                                            class="count">(<?php echo $term->count; ?>)</span></div>
                                </div>
                            </a>
                        <?php endif; ?>
                        <?php $i++;
                    else:
                        $icon_visiblity = '';
                    endif; ?>
                <?php endforeach; ?>
                <?php foreach ($terms as $term): ?>
                    <?php $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
                    if ($multiply) {
                        $link = stm_get_listing_archive_link() . '?' . $filter_selected . '[' . $term->slug . '] = ✓';
                    } else {
                        $link = stm_get_listing_archive_link() . '?' . $filter_selected . '=' . $term->slug;
                    }
                    if (empty($image)): ?>
                        <a href="<?php echo esc_url($link); ?>"
                           class="stm_listing_icon_filter_single <?php echo esc_attr($icon_visiblity); ?>"
                           title="<?php echo esc_attr($term->name); ?>">
                            <div class="inner">
                                <div class="name"><?php echo esc_attr($term->name); ?> <span
                                        class="count">(<?php echo $term->count; ?>)</span></div>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php
endif;
?>