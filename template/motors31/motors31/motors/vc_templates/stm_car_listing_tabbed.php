<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );


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

if(empty($per_page)) {
	$per_page = 8;
}

if(empty($tab_affix)){
	$tab_affix = '';
}

if(!empty($enable_search) and $enable_search) {
	//Get columns number
	if(empty($filter_columns_number)) {
		$filter_columns_number = 2;
	}

	$filter_columns_number = 12/$filter_columns_number;

	//Get all filter options from STM listing plugin - Listing - listing categories
	$filter_options = stm_get_car_filter();

	//Creating new array for tax query and meta query
	$tax_query_args = array();

	$terms_args = array(
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => false,
		'fields'     => 'all',
		'pad_counts' => false,
	);

	if(!empty($filter_selected)) {
		$filter_selected = explode( ',', $filter_selected );

		foreach ( $filter_options as $filter_option ) {

			if ( in_array( $filter_option['slug'], $filter_selected ) ) {

				if ( empty( $filter_option['numeric'] ) ) {
					$terms = get_terms( $filter_option['slug'], $terms_args );

					$tax_query_args[ $filter_option['slug'] ] = $terms;
				} else {
					$terms = get_terms( $filter_option['slug'], $terms_args );
					foreach ( $terms as $term ) {
						$term->numeric = true;
					}

					$tax_query_args[ $filter_option['slug'] ] = $terms;
				}
			}
		}
	}

	$get_post_args = array(
		'post_type' => stm_listings_post_type(),
		'post_status' => 'publish',
		'posts_per_page' => -1
	);
	$all_cars = new WP_Query($get_post_args);
	wp_reset_postdata();
}

if(empty($search_label)) {
	$search_label = esc_html__('Search inventory', 'motors');
}

//Search options

$tab_unique = 'listing-cars-id-'.rand(0,99999);
?>

<div class="car-listing-tabs-unit <?php echo esc_attr($tab_unique); ?>">
	<div class="car-listing-top-part" >
		<div class="found-cars-cloned"></div>
		<?php if(!empty($content)): ?>
			<div class="title">
				<?php echo wpb_js_remove_wpautop($content, true); ?>
			</div>
		<?php endif; ?>
			<?php $filter_cats_counter = 0; ?>
			<div class="stm-listing-tabs">
				<ul class="heading-font" role="tablist">
					<?php if(!empty($filter_cats)): ?>
						<?php foreach($filter_cats as $filter_cat): $filter_cats_counter++; ?>
							<?php if(!empty($filter_cat[0]) and !(empty($filter_cat[1]))): ?>
								<?php $current_category = get_term_by('slug', $filter_cat[0], $filter_cat[1]); ?>
								<?php if(!empty($current_category)): ?>
									<li <?php if($filter_cats_counter == 1) {echo esc_attr('class=active');} ?>>
										<a href="#car-listing-category-<?php echo esc_attr($current_category->slug); ?>" role="tab" data-toggle="tab">
											<?php echo esc_attr($current_category->name.' '.$tab_affix); ?>
										</a>
									</li>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if(!empty($enable_search) and $enable_search): ?>
						<li <?php if($filter_cats_counter == 0) {echo esc_attr('class=active');} ?>>
							<a href="#car-listing-tab-search" role="tab" data-toggle="tab">
								<?php echo esc_attr($search_label); ?>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
			<?php $filter_cats_counter = 0; ?>
	</div>

	<div class="car-listing-main-part">
			<div class="tab-content">
				<?php if(!empty($filter_cats)): ?>
					<?php foreach($filter_cats as $filter_cat): $filter_cats_counter++; ?>
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
							<div role="tabpanel" class="tab-pane <?php if($filter_cats_counter == 1) {echo esc_attr('active');} ?>" id="car-listing-category-<?php echo esc_attr($filter_cat[0]); ?>">
								<div class="found-cars-clone"><div class="found-cars heading-font"><i class="stm-icon-car"></i><?php esc_html_e('available','motors'); ?> <span class="blue-lt"><?php echo esc_attr($listing_cars->found_posts); ?> <?php esc_html_e('cars','motors'); ?></span></div></div>
								<?php if($listing_cars->have_posts()):?>
									<div class="row row-4 car-listing-row">
										<?php while($listing_cars->have_posts()):$listing_cars->the_post(); ?>
											<?php get_template_part('partials/car-filter', 'loop'); ?>
										<?php endwhile; ?>
									</div>

									<?php if(!empty($enable_ajax_loading) and $enable_ajax_loading): ?>
										<?php if($listing_cars->found_posts > $per_page ): ?>
											<div class="row car-listing-actions">
												<div class="col-xs-12 text-center">
													<div class="dp-in">
														<div class="preloader">
															<span></span>
															<span></span>
															<span></span>
															<span></span>
															<span></span>
														</div>
														<a class="load-more-btn" href="" onclick="loadMoreCars(jQuery(this),'<?php echo esc_js($filter_cat[0]); ?>','<?php echo esc_js($filter_cat[1]); ?>',<?php echo esc_js(intval($per_page)); ?>,<?php echo esc_js(intval($per_page)); ?>);return false;">
															<?php esc_html_e('Load more', 'motors'); ?>
														</a>
													</div>
												</div>
											</div>
										<?php endif; ?>
									<?php else: ?>
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
				<?php endif; ?>
				<!--Search tab-->
				<?php if(!empty($enable_search) and $enable_search): ?>
					<div role="tabpanel" class="tab-pane <?php if($filter_cats_counter == 0) {echo esc_attr('active');} ?>" id="car-listing-tab-search">
						<div class="found-cars-clone"><div class="found-cars heading-font"><i class="stm-icon-car"></i><?php esc_html_e('available','motors'); ?> <span class="blue-lt"><?php echo esc_attr($all_cars->found_posts); ?> <?php esc_html_e('cars','motors'); ?></span></div></div>
						<?php if(!empty($search_label)): ?>
							<div class="tab-search-title heading-font">
								<?php if(!empty($search_icon)) :?>
									<i class="<?php echo esc_attr($search_icon); ?>"></i>
								<?php endif; ?>
								<?php echo esc_attr($search_label); ?>
							</div>
						<?php endif; ?>
						<div class="filter stm-vc-ajax-filter">
							<?php if(!empty($tax_query_args)): ?>
								<div class="row">
									<form action="<?php echo esc_url(stm_get_listing_archive_link()); ?>" method="get">
										<?php foreach($tax_query_args as $taxonomy_term_key => $taxonomy_term):?>
											<?php if(empty($taxonomy_term[0]->numeric) and !empty($taxonomy_term[0])): ?>
												<div class="col-md-<?php echo esc_attr($filter_columns_number); ?> col-sm-6">
													<div class="form-group">
														<select name="<?php echo esc_attr($taxonomy_term_key) ?>" class="form-control">
															<option value=""><?php echo esc_html__('Select', 'motors').' '.esc_html__(stm_get_name_by_slug($taxonomy_term_key), 'motors'); ?></option>
															<?php foreach($taxonomy_term as $attr_key => $attr):?>
																<option
																	value="<?php echo esc_attr($attr->slug); ?>"
																	<?php if($attr->count == 0) { echo 'disabled'; } ?>
																	>
																	<?php echo esc_attr($attr->name); ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>
												</div>
											<?php endif; ?>
										<?php endforeach; ?>
										<div class="col-md-3 col-sm-6">
											<div class="row">
												<div class="col-md-8 col-sm-12">
													<button type="submit" class="button icon-button"><i class="stm-icon-search"></i><?php esc_html_e('Search', 'motors'); ?></button>
												</div>
												<div class="col-md-4 hidden-sm hidden-xs">
													<a href="" class="reset-all reset-styled" title="<?php esc_html_e('Reset search fields', 'motors'); ?>"><i class="stm-icon-reset"></i></a>
												</div>
											</div>
										</div>
									</form>
								</div>
							<?php endif; ?>
							<?php if( !empty($enable_call_to_action) and $enable_call_to_action): ?>
								<div class="search-call-to-action">
									<div class="stm-call-to-action heading-font" style="background-color:<?php echo esc_attr($call_to_action_color); ?>">
										<div class="clearfix">
											<div class="call-to-action-content pull-left">
												<?php if(!empty($call_to_action_label)): ?>
													<div class="content">
														<?php if(!empty($call_to_action_icon)): ?>
															<i class="<?php echo esc_attr($call_to_action_icon); ?>"></i>
														<?php endif; ?>
														<?php echo esc_attr($call_to_action_label); ?>
													</div>
												<?php endif; ?>
											</div>
											<div class="call-to-action-right">
												<div class="call-to-action-meta">
													<?php if(!empty($call_to_action_label_right)): ?>
														<div class="content">
															<?php if(!empty($call_to_action_icon_right)): ?>
																<i class="<?php echo esc_attr($call_to_action_icon_right); ?>"></i>
															<?php endif; ?>
															<?php echo esc_attr($call_to_action_label_right); ?>
														</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
	</div>
</div>

<?php if(!empty($top_part_bg)): ?>
	<style type="text/css">
		.car-listing-tabs-unit .car-listing-top-part:before {
			background-color: <?php echo esc_attr($top_part_bg); ?>
		}
	</style>
<?php endif; ?>

<script type="text/javascript">
	(function($) {
		"use strict";


		$(document).ready(function () {
			$('.found-cars-cloned').html($('.<?php echo esc_attr($tab_unique); ?> .car-listing-main-part .tab-pane.active .found-cars-clone').html());
			$('.<?php echo esc_attr($tab_unique); ?> a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				var tab_href = $(e.target).attr('href');
				var found_cars = $(tab_href).find('.found-cars-clone').html();
				$('.found-cars-cloned').html(found_cars);

			})
		})
	})(jQuery);
</script>