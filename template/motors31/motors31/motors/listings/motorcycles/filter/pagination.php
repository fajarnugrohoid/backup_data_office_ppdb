
<div class="row stm-ajax-pagination classic-filter-pagination">

    <div class="col-md-12">
        <div class="clearfix">
            <div class="stm-blog-pagination">
                <?php
                echo paginate_links(array(
                    'type' => 'list',
                    'prev_text' => '<i class="fa fa-angle-left"></i>',
                    'next_text' => '<i class="fa fa-angle-right"></i>',
                ));
                ?>
            </div>
            <?php if (stm_is_motorcycle()): ?>
                <div class="stm-motorcycle-per-page stm_boats_view_by">
                    <?php get_template_part('partials/listing-layout-parts/items-per', 'page'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>