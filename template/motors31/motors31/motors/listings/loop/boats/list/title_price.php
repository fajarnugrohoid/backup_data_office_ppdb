<?php
$regular_price_label = get_post_meta(get_the_ID(), 'regular_price_label', true);
$special_price_label = get_post_meta(get_the_ID(), 'special_price_label', true);

?>

<div class="meta-top">
    <?php if (!empty($price) and !empty($sale_price) and $price != $sale_price): ?>
        <div class="price discounted-price">
            <div class="regular-price">
                <?php if (!empty($special_price_label)): ?>
                    <span class="label-price"><?php echo esc_attr($special_price_label); ?></span>
                <?php endif; ?>
                <?php echo esc_attr(stm_listing_price_view($price)); ?>
            </div>

            <div class="sale-price">
                <?php if (!empty($regular_price_label)): ?>
                    <span class="label-price"><?php echo esc_attr($regular_price_label); ?></span>
                <?php endif; ?>
                <span class="heading-font"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></span>
            </div>
        </div>
    <?php elseif (!empty($price)): ?>
        <div class="price">
            <div class="normal-price">
                <?php if (!empty($regular_price_label)): ?>
                    <span class="label-price"><?php echo esc_attr($regular_price_label); ?></span>
                <?php endif; ?>
                <?php if (!empty($car_price_form_label)): ?>
                    <span class="heading-font"><?php echo esc_attr($car_price_form_label); ?></span>
                <?php else: ?>
                    <span class="heading-font"><?php echo esc_attr(stm_listing_price_view($price)); ?></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="title heading-font">
        <a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
            <?php echo stm_generate_title_from_slugs(get_the_id()); ?>
        </a>
    </div>
</div>