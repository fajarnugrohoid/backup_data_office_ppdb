<?php

$middle_infos = stm_get_car_archive_listings();

$middle_infos[] = 'location';

$total_infos = count($middle_infos);

$stm_car_location = get_post_meta(get_the_ID(), 'stm_car_location', true);

/*Get distance value*/
$car = get_post(get_the_ID());
$distance = '';

if (isset($car->stm_distance)) {
    $distance_affix = stm_distance_measure_unit();
    $distance_measure = get_theme_mod('distance_measure_unit', 'miles');
    $distance = $car->stm_distance;
    if ($distance_measure == 'kilometers') {
        $distance = $distance * 1.609344;
    }
    $distance = round($distance, 1) . ' ' . $distance_affix;
}


if (!empty($middle_infos)): ?>

    <div class="meta-middle">
        <div class="meta-middle-row clearfix">
            <?php $counter = 0; ?>
            <?php foreach ($middle_infos as $middle_info_key => $middle_info): ?>
            <?php
            if ($middle_info != 'location'):
                $data_meta = get_post_meta(get_the_id(), $middle_info['slug'], true);
                $data_value = '';
                ?>
                <?php if (!empty($data_meta) and $data_meta != 'none' and $middle_info['slug'] != 'price'):
                if (!empty($middle_info['numeric']) and $middle_info['numeric']):
                    $affix = '';
                    if (!empty($middle_info['number_field_affix'])) {
                        $affix = esc_html__($middle_info['number_field_affix'], 'motors');
                    }
                    $data_value = ucfirst($data_meta) . ' ' . $affix;
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

            endif;
            endif //location;
            ?>

            <?php if ($middle_info == 'location'): $data_value = ''; ?>
                <?php if (!empty($stm_car_location) or !empty($distance)): ?>
                    <div class="meta-middle-unit font-exists location">
                        <div class="meta-middle-unit-top">
                            <div class="icon"><i class="stm-service-icon-pin_big"></i></div>
                            <div class="name"><?php esc_html_e('Distance', 'motors'); ?></div>
                        </div>

                        <div class="value">
                            <?php if (!empty($distance)): ?>
                                <div
                                    class="stm-tooltip-link"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="<?php echo $distance; ?>">
                                    <?php echo $distance; ?>
                                </div>

                            <?php else: ?>
                                <div
                                    class="stm-tooltip-link"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="<?php echo $stm_car_location; ?>">
                                    <?php echo $stm_car_location; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="meta-middle-unit meta-middle-divider"></div>
                    <?php $counter++; ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (!empty($data_value) and $data_value != ''): ?>


            <?php if ($middle_info['slug'] != 'price' and !empty($data_meta)): ?>
                <?php $counter++; ?>
                <div class="meta-middle-unit <?php if (!empty($middle_info['font'])) {
                    echo esc_attr('font-exists');
                } ?> <?php echo esc_attr($middle_info['slug']); ?>">
                    <div class="meta-middle-unit-top">
                        <?php if (!empty($middle_info['font'])): ?>
                            <div class="icon"><i class="<?php echo esc_attr($middle_info['font']); ?>"></i></div>
                        <?php endif; ?>
                        <div class="name"><?php esc_html_e($middle_info['single_name'], 'motors'); ?></div>
                    </div>

                    <div class="value">
                        <?php
                        if (is_array($data_value)) {
                            if (count($data_value) > 1) { ?>
                                <div
                                    class="stm-tooltip-link"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="<?php echo esc_attr(implode(', ', $data_value)); ?>">
                                    <?php echo esc_attr(implode(', ', $data_value)); ?>
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
                <div class="meta-middle-unit meta-middle-divider"></div>
            <?php endif; ?>


            <?php if ($counter % 4 == 0): ?>
        </div>
        <?php
        $row_no_filled = $total_infos - ($counter + 1);
        if ($row_no_filled < 5) {
            $row_no_filled = 'stm-middle-info-not-filled';
        } else {
            $row_no_filled = '';
        }
        ?>
        <div class="meta-middle-row <?php echo esc_attr($row_no_filled); ?> clearfix">
            <?php endif; ?>

            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>