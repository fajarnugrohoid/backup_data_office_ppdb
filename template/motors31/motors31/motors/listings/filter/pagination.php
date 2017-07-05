<?php if(stm_is_motorcycle()):
    stm_listings_load_template('motorcycles/filter/pagination');
else: ?>
    <div class="stm_ajax_pagination stm-blog-pagination">
        <?php
        echo paginate_links( array(
            'type'      => 'list',
            'prev_text' => '<i class="fa fa-angle-left"></i>',
            'next_text' => '<i class="fa fa-angle-right"></i>',
        ) );
        ?>
    </div>
<?php endif; ?>
