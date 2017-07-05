<?php
$tab_tax = '';
$tab_tax_exist = false;
$filter_tab = stm_get_car_filter();
foreach($filter_tab as $filter_taxex) {
    if(!empty($filter_taxex['use_on_tabs']) and $filter_taxex['use_on_tabs'] and !$tab_tax_exist) {
        $tab_tax = $filter_taxex;
        $tab_tax_exist = true;
    }
}

if($tab_tax_exist) {
    echo '<style type="text/css">';
    echo '.filter .stm-filter_' . $tab_tax['slug'] . '{display:none}';
    echo '</style>';
}
?>

<form action="<?php echo stm_listings_current_url() ?>" method="get" data-trigger="filter">
    <div class="filter filter-sidebar ajax-filter">

        <?php do_action('stm_listings_filter_before'); ?>

        <div class="sidebar-entry-header">
            <span class="h4"><?php _e( 'Search', 'motors' ); ?></span>
            <a class="heading-font" href="<?php echo esc_url(stm_get_listing_archive_link()) ?>">
                <?php esc_html_e('Reset All', 'motors'); ?>
            </a>
        </div>

        <div class="row row-pad-top-24">

            <?php foreach ($filter['filters'] as $attribute => $config):
                if (!empty($config['slider']) && $config['slider']):
                    stm_listings_load_template('filter/types/slider', array(
                        'taxonomy' => $config,
                        'options' => $filter['options'][$attribute]
                    ));
                else: ?>
                    <div class="col-md-12 col-sm-6 stm-filter_<?php echo esc_attr($attribute) ?>">
                        <div class="form-group">
                            <?php stm_listings_load_template('filter/types/select', array(
                                'options' => $filter['options'][$attribute],
                                'name' => $attribute
                            )); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php stm_listings_load_template('filter/types/location'); ?>

        </div>

        <!--View type-->
        <input type="hidden" id="stm_view_type" name="view_type"
               value="<?php echo esc_attr(stm_listings_input('view_type')); ?>"/>
        <!--Filter links-->
        <input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
        <!--Popular-->
        <input type="hidden" name="popular" value="<?php echo esc_attr(stm_listings_input('popular')); ?>"/>

        <input type="text" name="s" value="<?php echo esc_attr(stm_listings_input('s')); ?>" placeholder="<?php esc_html_e('Keyword', 'motors'); ?>"/>
        <input type="hidden" name="sort_order" value="<?php echo esc_attr(stm_listings_input('sort_order')); ?>"/>

        <div class="sidebar-action-units">
            <input id="stm-classic-filter-submit" class="hidden" type="submit"
                   value="<?php _e('Show cars', 'motors'); ?>"/>

            <a href="<?php echo esc_url(stm_get_listing_archive_link()); ?>"
               class="button"><span><?php _e('Reset all', 'motors'); ?></span></a>
        </div>

        <?php do_action('stm_listings_filter_after'); ?>
    </div>

    <?php stm_listings_load_template('filter/types/checkboxes', array('filter' => $filter)); ?>

</form>

<?php stm_listings_load_template('filter/types/links', array('filter' => $filter)); ?>

<?php
$stm_vehicle_listing_options = stm_get_car_filter(); ?>
<style type="text/css">
    <?php foreach($stm_vehicle_listing_options as $stm_vehicle_listing_option): ?>
    <?php if(!empty($stm_vehicle_listing_option['numeric']) and $stm_vehicle_listing_option['numeric']): ?>
    .select2-selection__rendered[title="<?php echo esc_html__('Max', 'motors').' '.esc_attr($stm_vehicle_listing_option['single_name']); ?>"] {

    <?php else: ?>
    .select2-selection__rendered[title="<?php echo esc_attr($stm_vehicle_listing_option['single_name']); ?>"] {
    <?php endif; ?> background-color: transparent !important;
        border: 1px solid rgba(170, 170, 170, 0.4) !important;
        color: #fff !important;
    }

    <?php if(!empty($stm_vehicle_listing_option['numeric']) and $stm_vehicle_listing_option['numeric']): ?>
    .select2-selection__rendered[title="<?php echo esc_html__('Max', 'motors').' '.esc_attr($stm_vehicle_listing_option['single_name']); ?>"] + .select2-selection__arrow b {

    <?php else: ?>
    .select2-selection__rendered[title="<?php echo esc_attr($stm_vehicle_listing_option['single_name']); ?>"] + .select2-selection__arrow b {
    <?php endif; ?> color: rgba(255, 255, 255, 0.5);
    }

    <?php endforeach; ?>
</style>
