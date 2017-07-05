<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if(empty($per_page)) {
	$per_page = 8;
}

$filter_cats = array();
if(!empty($taxonomy)) {
	$taxonomy = str_replace(' ', '', $taxonomy);
	$taxonomies = explode( ',', $taxonomy );
	if(!empty($taxonomies)){
		foreach($taxonomies as $categories) {
			if(!empty($categories)) {
				$filter_cats[] = explode( '|', $categories );
			}
		}
	}
}

//Set active from category if no recent and popular included
$set_active_category = true;

$set_recent_active = '';
$set_recent_active_fade = '';

$set_popular_active = '';
$set_popular_active_fade = '';

if(!empty($recent) and $recent == 'yes' or !empty($popular) and $popular == 'yes' or !empty($featured) and $featured == 'yes') {
	$set_active_category = false;
}

if(empty($featured)) {
	$set_recent_active = 'active';
	$set_recent_active_fade = 'in';
} else if(empty($recent)) {
	$set_popular_active = 'active';
	$set_popular_active_fade = 'in';
}

$active_category = 0;


?>

<div class="stm_listing_tabs_style_2 <?php echo esc_attr($css_class); ?>">

	<div class="clearfix">

		<?php if(!empty($title)): ?>
			<h3 class="hidden-md hidden-lg hidden-sm"><?php echo esc_attr($title); ?></h3>
		<?php endif; ?>

		<!-- Nav tabs -->
		<ul class="stm_listing_nav_list heading-font" role="tablist">

			<?php foreach($filter_cats as $filter_cat): $active_category++; ?>
				<?php if(!empty($filter_cat[0]) and !(empty($filter_cat[1]))): ?>
					<?php $current_category = get_term_by('slug', $filter_cat[0], $filter_cat[1]); ?>
					<?php if(!empty($current_category)): ?>
						<li role="presentation" <?php if($active_category == 1 and $set_active_category) {echo esc_attr('class=active');} ?>>
							<a href="#car-listing-category-<?php echo esc_attr($current_category->slug); ?>" role="tab" data-toggle="tab">
								<span><?php echo esc_attr($current_category->name.' '.$tab_affix); ?></span>
							</a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php if(!empty($popular) and $popular == 'yes'): ?>
				<li role="presentation" class="<?php echo esc_attr($set_popular_active); ?>">
					<a href="#popular" aria-controls="popular" role="tab" data-toggle="tab"><span><?php echo esc_attr($popular_label); ?></span></a>
				</li>
			<?php endif; ?>

			<?php if(!empty($recent) and $recent == 'yes'): ?>
				<li role="presentation" class="<?php echo esc_attr($set_recent_active); ?>">
					<a href="#recent" aria-controls="recent" role="tab" data-toggle="tab"><span><?php echo esc_attr($recent_label); ?></span></a>
				</li>
			<?php endif; ?>
			
			<?php if(!empty($featured) and $featured == 'yes'): ?>
				<li role="presentation" class="active">
					<a href="#featured" aria-controls="recent" role="tab" data-toggle="tab"><span><?php echo esc_attr($featured_label); ?></span></a>
				</li>
			<?php endif; ?>
			
		</ul>

		<?php if(!empty($title)): ?>
			<h3 class="hidden-xs"><?php echo esc_attr($title); ?></h3>
		<?php endif; ?>

	</div>

	<!-- Tab panes -->
	<div class="tab-content">
		<?php
			$active_category = 0;
			$per_row = 4;
			$template = 'partials/listing-cars/listing-grid-directory-loop-4';
			if(stm_is_motorcycle()){
				$per_row = 3;
				$template = 'partials/listing-cars/motos/moto-single-grid';
			}
		?>
		<?php foreach($filter_cats as $filter_cat): $active_category++; ?>
			<?php if(!empty($filter_cat[0]) and !(empty($filter_cat[1]))): ?>
				<?php
				//Creating custom query for each tab
				$args = array(
					'post_type' => stm_listings_post_type(),
					'post_status' => 'publish',
					'posts_per_page' => intval($per_page)
				);
				$args['tax_query'][] = array(
					'taxonomy' => $filter_cat[1],
					'field'    => 'slug',
					'terms'    => array( $filter_cat[0] )
				);
				$listing_cars = new WP_Query( $args );
				?>
				<div role="tabpanel" class="tab-pane fade <?php if($active_category == 1 and $set_active_category) {echo esc_attr('in active');}; ?>" id="car-listing-category-<?php echo esc_attr($filter_cat[0]); ?>">
					<div class="found-cars-clone"><div class="found-cars heading-font"><i class="stm-icon-car"></i><?php esc_html_e('available','motors'); ?> <span class="blue-lt"><?php echo esc_attr($listing_cars->found_posts); ?> <?php esc_html_e('cars','motors'); ?></span></div></div>
					<?php if($listing_cars->have_posts()):?>
						<div class="row row-<?php echo intval($per_row); ?> car-listing-row">
							<?php while($listing_cars->have_posts()):$listing_cars->the_post(); ?>
								<?php get_template_part($template); ?>
							<?php endwhile; ?>
						</div>

						<?php if(!empty($show_more) and $show_more == 'yes'): ?>
							<div class="row">
								<div class="col-xs-12 text-center">
									<div class="dp-in">
										<a class="load-more-btn" href="<?php echo esc_url(stm_get_listing_archive_link()).'?'.esc_attr($filter_cat[1]).'='.esc_attr($filter_cat[0]); ?>">
											<?php esc_html_e('Show all', 'motors'); ?>
										</a>
									</div>
								</div>
							</div>
						<?php endif; ?>

						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>


		<?php if(!empty($popular) and $popular == 'yes'): ?>
			<div role="tabpanel" class="tab-pane fade <?php echo esc_attr($set_popular_active_fade.' '.$set_popular_active); ?>" id="popular">
				<?php
				$args = array(
					'post_type' => stm_listings_post_type(),
					'post_status' => 'publish',
					'posts_per_page' => intval($per_page),
					'orderby'   => 'meta_value_num',
					'meta_key'  => 'stm_car_views',
					'order' => 'DESC',
				);

				$recent_query = new WP_Query($args);

				if($recent_query->have_posts()): ?>
					<div class="row row-<?php echo intval($per_row); ?> car-listing-row">
						<?php while($recent_query->have_posts()): $recent_query->the_post(); ?>
							<?php get_template_part($template); ?>
						<?php endwhile; ?>
					</div>
					<?php if(!empty($show_more) and $show_more == 'yes'): ?>
						<div class="row">
							<div class="col-xs-12 text-center">
								<div class="dp-in">
									<a class="load-more-btn" href="<?php echo esc_url(stm_get_listing_archive_link().'?popular=true'); ?>">
										<?php esc_html_e('Show all', 'motors'); ?>
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if(!empty($recent) and $recent == 'yes'): ?>
			<div role="tabpanel" class="tab-pane fade <?php echo esc_attr($set_recent_active_fade.' '.$set_recent_active); ?>" id="recent">
				<?php
					$args = array(
						'post_type' => stm_listings_post_type(),
						'post_status' => 'publish',
						'posts_per_page' => intval($per_page)
					);

					$recent_query = new WP_Query($args);

					if($recent_query->have_posts()): ?>
						<div class="row row-<?php echo intval($per_row); ?> car-listing-row">
							<?php while($recent_query->have_posts()): $recent_query->the_post(); ?>
								<?php get_template_part($template); ?>
							<?php endwhile; ?>
						</div>

						<?php if(!empty($show_more) and $show_more == 'yes'): ?>
							<div class="row">
								<div class="col-xs-12 text-center">
									<div class="dp-in">
										<a class="load-more-btn" href="<?php echo esc_url(stm_get_listing_archive_link()); ?>">
											<?php esc_html_e('Show all', 'motors'); ?>
										</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>

			</div>
		<?php endif; ?>
		
		<?php if(!empty($featured) and $featured == 'yes'): ?>
			<div role="tabpanel" class="tab-pane fade active in" id="featured">
				<?php
				$args = array(
					'post_type' => stm_listings_post_type(),
					'post_status' => 'publish',
					'posts_per_page' => intval($per_page),
					'order' => 'rand',
					'meta_query' => array(
						array(
							'key'     => 'special_car',
							'value'   => 'on',
							'compare' => '=' 
						)
					)
				);
			
				$featured_query = new WP_Query($args);

				if($featured_query->have_posts()): ?>
					<div class="row row-<?php echo intval($per_row); ?> car-listing-row">
						<?php while($featured_query->have_posts()): $featured_query->the_post(); ?>
							<?php get_template_part('partials/listing-cars/listing-grid-directory-loop', '4'); ?>
						<?php endwhile; ?>
					</div>
					<?php if(!empty($show_more) and $show_more == 'yes'): ?>
						<div class="row">
							<div class="col-xs-12 text-center">
								<div class="dp-in">
									<a class="load-more-btn" href="<?php echo esc_url(stm_get_listing_archive_link().'?featured_top=true'); ?>">
										<?php esc_html_e('Show all', 'motors'); ?>
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	</div>
</div>