<?php

if(empty($modern_filter)){
    $modern_filter = false;
}

stm_listings_load_template('loop/start', array('modern' => $modern_filter)); ?>

    <?php stm_listings_load_template('loop/default/list/image'); ?>

    <div class="content">
        <div class="meta-top">
            <!--Price-->
            <?php stm_listings_load_template('loop/default/list/price'); ?>
            <!--Title-->
            <?php stm_listings_load_template('loop/default/list/title'); ?>
        </div>

        <!--Item parameters-->
        <div class="meta-middle">
            <?php stm_listings_load_template('loop/default/list/options'); ?>
        </div>

        <!--Item options-->
        <div class="meta-bottom">
            <?php stm_listings_load_template('loop/default/list/features'); ?>
        </div>
    </div>
</div>