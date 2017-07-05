<div class="row">

    <div class="col-md-12 col-sm-12 classic-filter-row sidebar-sm-mg-bt">
        <?php stm_listings_load_template('boats/filter/sidebar'); ?>
    </div>

    <div class="col-md-12 col-sm-12">

        <div class="stm-ajax-row">
            <?php stm_listings_load_template('boats/filter/actions'); ?>

            <div id="listings-result">
                <?php stm_listings_load_results(); ?>
            </div>
        </div>

    </div> <!--col-md-9-->
</div>

<?php stm_listings_load_template('boats/filter/binding'); ?>