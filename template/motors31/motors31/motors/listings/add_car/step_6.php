<?php
$car_price_form_label = $price = $sale_price = '';
$price = $sale_price = $car_price_form_label = '';
if (!empty($id)) {
    $car_price_form_label = get_post_meta($id, 'car_price_form_label', true);
    $price = get_post_meta($id, 'price', true);
    $sale_price = get_post_meta($id, 'sale_price', true);
}
?>

<div class="stm-form-price-edit">
    <div class="stm-car-listing-data-single stm-border-top-unit ">
        <div class="title heading-font"><?php esc_html_e('Set Your Asking Price', 'motors'); ?></div>
        <span class="step_number step_number_5 heading-font"><?php esc_html_e('step', 'motors'); ?> 6</span>
    </div>

    <?php if (!empty($show_price_label) and $show_price_label == 'yes'): ?>
        <div class="row stm-relative">
            <div class="col-md-12 col-sm-12 stm-prices-add">
                <?php if (!empty($stm_title_price)): ?>
                    <h4><?php echo esc_attr($stm_title_price); ?></h4>
                <?php endif; ?>
                <?php if (!empty($stm_title_desc)): ?>
                    <p><?php echo esc_attr($stm_title_desc); ?></p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="stm_price_input">
                            <div class="stm_label heading-font"><?php esc_html_e('Price', 'motors'); ?>*
                                (<?php echo stm_get_price_currency(); ?>)
                            </div>
                            <input type="number" min="0" class="heading-font" name="stm_car_price" value="<?php echo esc_attr($price); ?>" required/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="stm_price_input">
                            <div class="stm_label heading-font"><?php esc_html_e('Sale Price', 'motors'); ?>
                                (<?php echo stm_get_price_currency(); ?>)
                            </div>
                            <input type="number" min="0" class="heading-font" name="stm_car_sale_price" value="<?php echo esc_attr($sale_price); ?>" required/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="stm_price_input">
                            <div
                                class="stm_label heading-font"><?php esc_html_e('Custom label instead of price', 'motors'); ?></div>
                            <input type="text" class="heading-font" name="car_price_form_label" value="<?php echo $car_price_form_label; ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row stm-relative">
            <div class="col-md-4 col-sm-6">
                <div class="stm_price_input">
                    <div class="stm_label heading-font"><?php esc_html_e('Price', 'motors'); ?>*
                        (<?php echo stm_get_price_currency(); ?>)
                    </div>
                    <input type="number" class="heading-font" name="stm_car_price" value="<?php echo esc_attr($price); ?>" required/>
                </div>
            </div>
            <div class="col-md-8 col-sm-6">
                <?php if (!empty($stm_title_price)): ?>
                    <h4><?php echo esc_attr($stm_title_price); ?></h4>
                <?php endif; ?>
                <?php if (!empty($stm_title_desc)): ?>
                    <p><?php echo esc_attr($stm_title_desc); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>