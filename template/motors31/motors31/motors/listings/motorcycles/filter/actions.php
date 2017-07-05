<?php $total_matches = $filter['total']; ?>

<div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
    <div class="stm-listing-directory-title">
        <h3 class="title"><?php echo esc_attr($filter['listing_title']); ?></h3>
        <div class="stm-listing-directory-total-matches total stm-secondary-color heading-font">
            <span><?php echo esc_attr($total_matches); ?></span> <?php esc_html_e('matches', 'motors'); ?></div>
    </div>
    <div class="stm-directory-listing-top__right">
        <div class="clearfix">
            <?php
            $view_type = stm_listings_input('view_type', 'list');
            if ($view_type == 'list') {
                $view_list = 'active';
                $view_grid = '';
            } else {
                $view_grid = 'active';
                $view_list = '';
            }
            ?>
            <div class="stm-view-by">
                <a href="#" class="view-grid view-type <?php echo esc_attr($view_grid); ?>" data-view="grid">
                    <i class="stm-icon-grid"></i>
                </a>
                <a href="#" class="view-list view-type <?php echo esc_attr($view_list); ?>" data-view="list">
                    <i class="stm-icon-list"></i>
                </a>
            </div>

        </div>
    </div>
</div>