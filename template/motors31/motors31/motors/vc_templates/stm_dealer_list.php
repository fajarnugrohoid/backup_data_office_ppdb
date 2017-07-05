<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$stm_filter_dealers_by = explode(',', $stm_filter_dealers_by);
if(empty($taxonomy)) {
	$taxonomy = '';
}

$response = stm_get_filtered_dealers();

$user_list = $response['user_list'];
$title = $response['title'];

if ( ! empty( $_GET['stm_sort_by'] ) ) {
	$sort_by = sanitize_title( $_GET['stm_sort_by'] );
} else {
	$sort_by = 'reviews';
}

$filters = array(
	'reviews' => esc_html__('Reviews', 'motors'),
	'date' => esc_html__('Date', 'motors'),
	'cars' => esc_html__('Cars number', 'motors'),
	'watches' => esc_html__('Popularity', 'motors')
);

?>

<div class="stm_dynamic_listing_filter stm_dynamic_listing_dealer_filter animated fadeIn ">
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="stm_all_listing_tab">
			<form action="<?php echo esc_url(stm_get_dealer_list_page()); ?>" method="GET">
				<button type="submit" class="heading-font"><i class="fa fa-search"></i><?php esc_html_e('Find Dealer', 'motors'); ?></button>
				<input type="hidden" name="stm_dealer_show_taxonomies" value="<?php echo esc_attr($taxonomy); ?>"/>
				<input type="hidden" name="stm_sort_by" value="<?php echo esc_attr($sort_by); ?>"/>
				<div class="stm-filter-tab-selects">
					<div class="row">
						<?php if(!empty($stm_filter_dealers_by)): ?>
							<?php foreach($stm_filter_dealers_by as $stm_filter_dealers): ?>
								<?php $terms = stm_get_category_by_slug_all( $stm_filter_dealers ); ?>
								<div class="col-md-4 col-sm-6 col-xs-12 stm-select-col">
									<div class="stm-ajax-reloadable">
										<select
											name="<?php echo esc_attr($stm_filter_dealers); ?>"
											data-class="stm_select_overflowed stm_select_dealer">
											<option value=""><?php esc_html_e('Choose', 'motors'); echo esc_attr(' ' . stm_get_name_by_slug($stm_filter_dealers)); ?></option>
											<?php
												if ( ! empty( $terms ) ) {
													foreach ( $terms as $term ) {
														$selected = '';
														if(!empty($_GET[$stm_filter_dealers]) and $_GET[$stm_filter_dealers] == $term->slug) {
															$selected = 'selected';
														}
														echo '<option value="' . $term->slug . '" ' . $selected . '>' . $term->name; '</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						<div class="col-md-4 col-sm-6 col-xs-12 stm-select-col">
							<div class="stm-location-search-unit">
								<input
									type="text"
                                     class="stm_listing_filter_text stm_listing_search_location"
                                     id="stm-car-location-stm_all_listing_tab"
                                     name="ca_location"
									 value="<?php echo !empty($_GET['ca_location']) ? esc_attr($_GET['ca_location']) : ''; ?>"
                                     placeholder="<?php esc_html_e('Enter a location', 'motors'); ?>"
                                     autocomplete="off">
								<input type="hidden" name="stm_lat" value="<?php echo !empty($_GET['stm_lat']) ? floatval($_GET['stm_lat']) : ''; ?>">
								<input type="hidden" name="stm_lng" value="<?php echo !empty($_GET['stm_lng']) ? floatval($_GET['stm_lng']) : ''; ?>">
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12 stm-select-col">
							<div class="stm-keyword-search-unit">
								<input
									type="text"
									class="stm_listing_filter_text stm_listing_search_location"
									name="dealer_keyword"
									value="<?php echo !empty($_GET['dealer_keyword']) ? esc_attr($_GET['dealer_keyword']) : ''; ?>"
									placeholder="<?php esc_html_e('Keyword', 'motors'); ?>">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="dealer-search-title">
		<div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
			<div class="stm-listing-directory-title">
				<div class="title"><?php echo wp_kses_post($title); ?></div>
			</div>
			<div class="stm-directory-listing-top__right">
				<div class="clearfix">
					<div class="stm-sort-by-options clearfix">
						<span><?php esc_html_e('Sort by:', 'motors'); ?></span>
						<div class="stm-select-sorting">
							<select>
								<?php foreach($filters as $filter_name => $filter): ?>
									<?php
										$selected = '';
										if($sort_by == $filter_name) {
											$selected = 'selected';
										}
									?>
									<option value="<?php echo esc_attr($filter_name) ?>" <?php echo esc_attr($selected); ?>>
										<?php echo esc_attr($filter); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="dealer-search-results">
		<?php
			if(!empty($user_list)) { ?>
				<table class="stm_dealer_list_table">
					<?php foreach($user_list as $user) { ?>
						<?php stm_get_single_dealer($user, $taxonomy); ?>
					<?php } ?>
				</table>
				<?php if(!empty($response['button']) and $response['button'] == 'show'): ?>
					<a class="stm-load-more-dealers button" href="#" data-offset="12"><span><?php esc_html_e('Show more', 'motors') ?></span></a>
				<?php endif; ?>
			<?php } else { ?>
				<h4><?php esc_html_e('No dealers on your search parameters', 'motors'); ?></h4>
			<?php }
		?>
	</div>


</div>