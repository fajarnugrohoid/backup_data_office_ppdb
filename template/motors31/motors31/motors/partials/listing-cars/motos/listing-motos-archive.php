<div class="row">

    <?php $filter = stm_listings_filter(); ?>

    <div class="col-md-3 col-sm-12 classic-filter-row sidebar-sm-mg-bt">
        <?php stm_listings_load_template('motorcycles/filter/sidebar', array('filter' => $filter)); ?>
    </div>

    <div class="col-md-9 col-sm-12">
        <div class="stm-ajax-row">
            <?php stm_listings_load_template('motorcycles/filter/actions', array('filter' => $filter)); ?>
            <div id="listings-result">
                <?php stm_listings_load_results(); ?>
            </div>
        </div>
    </div> <!--col-md-9-->

</div>

<?php wp_reset_postdata(); ?>