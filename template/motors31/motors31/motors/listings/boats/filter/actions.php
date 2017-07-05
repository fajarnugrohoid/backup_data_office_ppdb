<?php $current_view_type = stm_listings_input('view_type', 'list'); ?>

<div class="stm-car-listing-sort-units clearfix sort-type-<?php echo esc_attr($current_view_type); ?>">
    <?php if ($current_view_type == 'grid'): ?>
        <div class="stm-sort-by-options clearfix">
            <span><?php esc_html_e('Sort by:', 'motors'); ?></span>
            <div class="stm-select-sorting">
                <select>
                    <option value="date_high" selected><?php esc_html_e('Date: newest first', 'motors'); ?></option>
                    <option value="date_low"><?php esc_html_e('Date: oldest first', 'motors'); ?></option>
                    <option value="price_low"><?php esc_html_e('Price: lower first', 'motors'); ?></option>
                    <option value="price_high"><?php esc_html_e('Price: highest first', 'motors'); ?></option>
                </select>
            </div>
        </div>
        <div class="stm_boats_view_by">
            <?php get_template_part('partials/listing-layout-parts/items-per', 'page'); ?>
        </div>
    <?php else: ?>
        <?php get_template_part('partials/listing-layout-parts/boats-list', 'sort'); ?>
    <?php endif; ?>
</div>