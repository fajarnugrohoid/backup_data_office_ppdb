<?php
$data = stm_get_single_car_listings();
$post_id = get_the_ID();
$show_compare = get_theme_mod('show_compare', true);
$stm_car_location = get_post_meta($post_id, 'stm_car_location', true);
?>

<?php if (!empty($data)): ?>
    <div class="single-boat-data-units">
        <div class="single-boat-data">
            <?php foreach ($data as $data_value): ?>
                <?php if ($data_value['slug'] != 'price'): ?>
                    <?php $data_meta = get_post_meta($post_id, $data_value['slug'], true); ?>
                    <?php if (!empty($data_meta) and $data_meta != 'none'): ?>

                        <div class="t-row">
                            <div class="t-label">
                                <?php if (!empty($data_value['font'])): ?>
                                    <i class="<?php echo esc_attr($data_value['font']) ?>"></i>
                                <?php endif; ?>
                                <?php esc_html_e($data_value['single_name'], 'motors'); ?>
                            </div>
                            <?php if (!empty($data_value['numeric']) and $data_value['numeric']): ?>
                                <div class="t-value h6"><?php echo esc_attr(ucfirst($data_meta)); ?></div>
                            <?php else: ?>
                                <?php
                                $data_meta_array = explode(',', $data_meta);
                                $datas = array();

                                if (!empty($data_meta_array)) {
                                    foreach ($data_meta_array as $data_meta_single) {
                                        $data_meta = get_term_by('slug', $data_meta_single, $data_value['slug']);
                                        if (!empty($data_meta->name)) {
                                            $datas[] = esc_attr($data_meta->name);
                                        }
                                    }
                                }
                                ?>
                                <div class="t-value h6"><?php echo implode(', ', $datas); ?></div>
                            <?php endif; ?>
                        </div>

                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if (!empty($stm_car_location)): ?>
                <div class="t-row">
                    <div class="t-label">
                        <i class="stm-boats-icon-pin"></i>
                        <?php esc_html_e('Location', 'motors'); ?>
                    </div>
                    <div class="t-value h6"><?php echo esc_attr($stm_car_location); ?></div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($show_compare)): ?>
            <?php
            $active = '';
            if (!empty($_COOKIE['compare_ids'])) {
                if (in_array(get_the_ID(), $_COOKIE['compare_ids'])) {
                    $active = 'active';
                }
            }
            ?>
            <div class="stm-gallery-action-unit compare <?php echo esc_attr($active); ?>"
                 data-id="<?php echo esc_attr(get_the_ID()); ?>"
                 data-title="<?php echo esc_attr(stm_generate_title_from_slugs(get_the_id())); ?>">
                <i class="stm-boats-icon-add-to-compare"></i>
            </div>
            <!--JS translations-->
            <script type="text/javascript">
                var stm_added_to_compare_text = "<?php esc_html_e('Added to compare', 'motors'); ?>";
                var stm_removed_from_compare_text = "<?php esc_html_e('was removed from compare', 'motors'); ?>";
                var stm_already_added_to_compare_text = "<?php esc_html_e('You have already added 3 cars', 'motors'); ?>";
            </script>
        <?php endif; ?>
    </div>
<?php endif; ?>
