<?php

$middle_infos = stm_get_car_archive_listings();

if (!empty($middle_infos)): ?>

    <div class="meta-middle">
        <?php foreach ($middle_infos as $middle_info): ?>
            <?php
            $data_meta = get_post_meta(get_the_id(), $middle_info['slug'], true);
            $data_value = '';
            ?>
            <?php if (!empty($data_meta) and $data_meta != 'none' and $middle_info['slug'] != 'price'):
                if (!empty($middle_info['numeric']) and $middle_info['numeric']):
                    $data_value = ucfirst($data_meta);
                else:
                    $data_meta_array = explode(',', $data_meta);
                    $data_value = array();

                    if (!empty($data_meta_array)) {
                        foreach ($data_meta_array as $data_meta_single) {
                            $data_meta = get_the_terms(get_the_ID(), $middle_info['slug']);

                            if (!empty($data_meta) and !is_wp_error($data_meta)) {
                                foreach ($data_meta as $data_metas) {
                                    $data_value[] = esc_attr($data_metas->name);
                                }
                            }
                            break;
                        }
                    }

                endif;

            endif; ?>

            <?php if (!empty($data_value) and $data_value != ''): ?>
                <?php if ($middle_info['slug'] != 'price' and !empty($data_meta)): ?>
                    <div class="meta-middle-unit <?php if (!empty($middle_info['font'])) {
                        echo esc_attr('font-exists');
                    } ?> <?php echo esc_attr($middle_info['slug']); ?>">
                        <div class="meta-middle-unit-top">
                            <?php if (!empty($middle_info['font'])): ?>
                                <div class="icon"><i class="<?php echo esc_attr($middle_info['font']); ?>"></i></div>
                            <?php endif; ?>
                            <div class="name"><?php esc_html_e($middle_info['single_name'], 'motors'); ?></div>
                        </div>

                        <div class="value h5">
                            <?php
                            if (is_array($data_value)) {
                                if (count($data_value) > 1) { ?>

                                    <div
                                        class="stm-tooltip-link"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="<?php echo esc_attr(implode(', ', $data_value)); ?>">
                                        <?php echo $data_value[0] . ' <span class="stm-dots">...</span>'; ?>
                                    </div>

                                <?php } else {
                                    echo esc_attr(implode(', ', $data_value));
                                }
                            } else {
                                echo esc_attr($data_value);
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>