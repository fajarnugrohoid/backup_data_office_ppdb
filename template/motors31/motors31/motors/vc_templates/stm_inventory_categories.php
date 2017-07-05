<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

$filter_cat_main = array();
if (!empty($taxonomy_main)) {
    $taxonomy_main = str_replace(' ', '', $taxonomy_main);
    $taxonomies = explode(',', $taxonomy_main);
    if (!empty($taxonomies[0])) {
        $filter_cat_main = explode('|', $taxonomies[0]);
    }
}

$filter_cats = array();
if (!empty($taxonomy)) {
    $taxonomy = str_replace(' ', '', $taxonomy);
    $taxonomies = explode(',', $taxonomy);
    if (!empty($taxonomies)) {
        foreach ($taxonomies as $categories) {
            if (!empty($categories)) {
                $filter_cats[] = explode('|', $categories);
            }
        }
    }
}

$image_url = '';

if (!empty($image)) {
    $image = explode(',', $image);
    if (!empty($image[0])) {
        $image = $image[0];
        $image = wp_get_attachment_image_src($image, 'full');
        $image_url = $image[0];
    }
}

if (!empty($image_url) and !empty($filter_cat_main)): ?>

    <div class="stm_mc-image-category">

        <div class="links">
            <div class="sub-links">
                <?php foreach ($filter_cats as $filter_cat):
                    $url_params = array(
                        $filter_cat[1] => $filter_cat[0]
                    );

                    if (!empty($filter_cat_main)) {
                        $url_params[$filter_cat_main[1]] = $filter_cat_main[0];
                    }

                    $cat_info = get_term_by('slug', $filter_cat[0], $filter_cat[1]);

                    if (!empty($cat_info->name)): ?>
                        <a href="<?php echo esc_url(add_query_arg($url_params, stm_get_listing_archive_link())); ?>">
                            <?php echo $cat_info->name; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <?php $filter_cat_main_info = get_term_by('slug', $filter_cat_main[0], $filter_cat_main[1]); ?>
            <a class="heading-font"
               href="<?php echo esc_url(add_query_arg($filter_cat_main[1], $filter_cat_main[0], stm_get_listing_archive_link())); ?>">
                <?php echo $filter_cat_main_info->name; ?>
            </a>
        </div>

        <div class="inner">
            <a href="<?php echo esc_url(add_query_arg($filter_cat_main[1], $filter_cat_main[0], stm_get_listing_archive_link())); ?>">
                <img src="<?php echo esc_url($image_url) ?>"/>
            </a>
        </div>
    </div>

<?php endif; ?>