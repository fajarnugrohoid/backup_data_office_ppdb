<?php
$checkboxes = stm_get_car_filter_checkboxes();

$selected_options = array();

if (!empty($checkboxes)) {
    foreach ($checkboxes as $checkbox) {
        if (!empty($_GET[$checkbox['slug']])) {
            $selected_options = $_GET[$checkbox['slug']];
            if (!is_array($selected_options)) {
                $selected_options = array('0' => $selected_options);
            }
        }

        if (!empty($checkbox['enable_checkbox_button']) and $checkbox['enable_checkbox_button'] == 1) {
            $stm_checkbox_ajax_button = 'stm-ajax-checkbox-button';
        } else {
            $stm_checkbox_ajax_button = 'stm-ajax-checkbox-instant';
        }
        ?>

        <?php
        $terms_args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'fields' => 'all',
            'pad_counts' => false,
        );
        ?>

        <div
            class="stm-accordion-single-unit stm-listing-directory-checkboxes stm-<?php echo esc_attr($checkbox['listing_rows_numbers'] . ' ' . $stm_checkbox_ajax_button) ?>">
            <a class="title" data-toggle="collapse" href="#accordion-<?php echo esc_attr($checkbox['slug']); ?>"
               aria-expanded="true">
                <h5><?php esc_html_e($checkbox['single_name'], 'motors'); ?></h5>
                <span class="minus"></span>
            </a>
            <div class="stm-accordion-content">
                <div class="collapse in content" id="accordion-<?php echo esc_attr($checkbox['slug']); ?>">
                    <div class="stm-accordion-content-wrapper stm-accordion-content-padded">
                        <div class="stm-accordion-inner">
                            <?php
                            $terms = get_terms($checkbox['slug'], $terms_args);

                            if (!empty($terms)) {
                                foreach ($terms as $term) {
                                    $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
                                    if (!empty($image)): ?>
                                        <label class="stm-option-label">
                                        <?php
                                        $image = wp_get_attachment_image_src($image, 'stm-img-190-132');
                                        $category_image = $image[0];
                                        ?>
                                        <div class="stm-option-image">
                                            <img src="<?php echo esc_url($category_image); ?>"/>
                                        </div>
                                        <input type="checkbox" name="<?php echo esc_attr($checkbox['slug']) ?>[]"
                                               value="<?php echo esc_attr($term->slug); ?>"
                                               <?php if (in_array($term->slug, $selected_options)): ?>checked<?php endif; ?>/>
                                        <span><?php echo esc_attr($term->name); ?></span>
                                    <?php endif; ?>
                                    </label>
                                <?php }
                                foreach ($terms as $term) {
                                    $image = get_option('stm_taxonomy_listing_image_' . $term->term_id);
                                    if (empty($image)): ?>
                                        <label class="stm-option-label">
                                        <input type="checkbox" name="<?php echo esc_attr($checkbox['slug']) ?>[]"
                                               value="<?php echo esc_attr($term->slug); ?>"
                                               <?php if (in_array($term->slug, $selected_options)): ?>checked<?php endif; ?>/>
                                        <span><?php echo esc_attr($term->name); ?></span>
                                    <?php endif; ?>
                                    </label>
                                <?php }
                            }

                            if (!empty($checkbox['enable_checkbox_button']) and $checkbox['enable_checkbox_button'] == 1): ?>
                                <div class="clearfix"></div>
                                <div class="stm-checkbox-submit">
                                    <a class="button" href="#"><?php echo esc_html_e('Apply', 'motors'); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}