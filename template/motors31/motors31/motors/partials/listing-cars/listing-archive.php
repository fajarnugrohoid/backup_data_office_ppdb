<div class="row">

    <?php $sidebar_pos = stm_get_sidebar_position(); ?>

    <div class="col-md-3 col-sm-12 classic-filter-row sidebar-sm-mg-bt <?php echo $sidebar_pos['sidebar'] ?>">
        <?php stm_listings_load_template('filter/sidebar'); ?>
    </div>

    <div class="col-md-9 col-sm-12 <?php echo $sidebar_pos['content'] ?>">

        <div class="stm-ajax-row">
            <?php stm_listings_load_template('filter/actions'); ?>

            <div id="listings-result">
                <?php stm_listings_load_results(); ?>
            </div>
        </div>

    </div> <!--col-md-9-->
</div>