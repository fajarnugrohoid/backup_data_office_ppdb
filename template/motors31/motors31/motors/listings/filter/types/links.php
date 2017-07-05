<?php $filter_links = stm_get_car_filter_links(); ?>

<?php if (!empty($filter_links) and !empty($filter['options'])): ?>
    <div class="stm-filter-links">
        <?php foreach ($filter_links as $filter_link) :
            $options = $filter['options'];
            $slug = $filter_link['slug'];
            if (!empty($options[$slug])) :
                $filter_links_cats = $options[$slug];
                if (!empty($filter_links_cats)): ?>

                    <style type="text/css">
                        .stm-filter_<?php echo esc_attr($slug) ?> {display: none;}
                    </style>

                    <div class="stm-accordion-single-unit">
                        <a class="title collapsed" data-toggle="collapse"
                           href="#<?php echo esc_attr($filter_link['slug']); ?>" aria-expanded="false">
                            <h5><?php printf(esc_html__('%s', 'motors'), $filter_link['single_name']); ?></h5>
                            <span class="minus"></span>
                        </a>

                        <div class="stm-accordion-content">
                            <div class="collapsed collapse content"
                                 id="<?php echo esc_attr($filter_link['slug']); ?>">
                                <ul class="list-style-3">
                                    <?php foreach ($filter_links_cats as $key => $filter_links_cat):
                                        $count = '0';
                                        if (!empty($filter_links_cat['count'])) {
                                            $count = $filter_links_cat['count'];
                                        }
                                        ?>
                                        <li
                                            class="stm-single-filter-link"
                                            data-slug="<?php echo esc_attr($filter_link['slug']) ?>"
                                            data-value="<?php echo esc_attr($key) ?>"
                                        >
                                            <a href="?<?php echo esc_attr($filter_link['slug'] . '=' . $key); ?>">
                                                <?php echo esc_attr($filter_links_cat['label']) . ' <span>(' . $count . ')</span>'; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>