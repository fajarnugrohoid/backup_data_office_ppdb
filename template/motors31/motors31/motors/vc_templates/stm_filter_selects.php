<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

//Creating new array for tax query and meta query
$filter_options = stm_get_car_filter();

$tax_query_args = array();

$terms_args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => true,
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


if(empty($filter_columns_number)) {
	$filter_columns_number = 3;
}

$filter_columns_number = 12/$filter_columns_number;

?>

<div class="stm_mc-filter-selects filter-listing filter stm-vc-ajax-filter">
	<?php if(!empty($tax_query_args)): ?>
		<div class="row">
			<form action="<?php echo esc_url(stm_get_listing_archive_link()); ?>" method="get">
				<?php foreach($tax_query_args as $taxonomy_term_key => $taxonomy_term):
					$tax_info = stm_get_all_by_slug($taxonomy_term_key);
					$tax_plural_name = '';
					if(!empty($tax_info['plural_name'])) {
						$tax_plural_name = $tax_info['plural_name'];
					}
					?>
					<?php if(empty($taxonomy_term->numeric) and !empty($taxonomy_term)): ?>
						<div class="col-md-<?php echo esc_attr($filter_columns_number); ?> col-sm-6">
							<div class="stm_mc-plural-name heading-font">
								<?php esc_html_e($tax_plural_name, 'motors'); ?>
							</div>
							<div class="form-group">
								<select name="<?php echo esc_attr($taxonomy_term_key) ?>" class="form-control">
									<option value="">
										<?php echo esc_html__('Select', 'motors').' '.esc_html__(stm_get_name_by_slug($taxonomy_term_key), 'motors'); ?>
									</option>
									<?php foreach($taxonomy_term as $attr_key => $attr):?>
										<option value="<?php echo esc_attr($attr->slug); ?>" <?php if($attr->count == 0) { echo 'disabled'; } ?>>
											<?php echo esc_attr($attr->name); ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<div class="stm_mc-submit-btn">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<?php
								$posts = stm_get_custom_taxonomy_count('', '');
								if(empty($posts)) {
									$posts = '0';
								}
							?>
							<div class="stm_mc-found">
								<span class="number-label"><?php esc_html_e('Found:', 'motors'); ?></span>
								<span class="number-found"><?php echo intval($posts); ?></span>
								<?php esc_html_e('Vehicles', 'motors'); ?>
							</div>
							<button type="submit" class="button icon-button">
								<?php esc_html_e('Search', 'motors'); ?>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	<?php endif; ?>
</div>

<?php
$bind_tax = stm_data_binding();
if(!empty($bind_tax)):
?>

	<script type="text/javascript">
		(function($) {
			"use strict";

			var buttonText = '';
			$('document').ready(function(){
				var stmTaxRelations = <?php echo $bind_tax; ?>;

				$('.stm_mc-filter-selects select:not(.hide)').select2().on('change', function(){

					/*Remove disabled*/

					var stmCurVal = $(this).val();
					var stmCurSelect = $(this).attr('name');

					if (stmTaxRelations[stmCurSelect]) {
						var key = stmTaxRelations[stmCurSelect]['dependency'];
						$('select[name="' + key + '"]').val('');
						if(stmCurVal == '') {
							$('select[name="' + key + '"] > option').each(function () {
								$(this).removeAttr('disabled');
							});

						} else {
							var allowedTerms = stmTaxRelations[stmCurSelect][stmCurVal];

							if(typeof(allowedTerms) == 'object') {
								$('select[name="' + key + '"] > option').removeAttr('disabled');

								$('select[name="' + key + '"] > option').each(function () {
									var optVal = $(this).val();
									if (optVal != '' && $.inArray(optVal, allowedTerms) == -1) {
										$(this).attr('disabled', '1');
									}
								});
							} else {
								$('select[name="' + key + '"]').val(allowedTerms);
							}

							if(typeof(stmTaxRelations[stmCurSelect][stmCurVal]) == 'undefined') {
								$('select[name="' + key + '"] > option').each(function () {
									$(this).removeAttr('disabled');
								});
							}
						}

						$('.stm_mc-filter-selects select[name="' + key + '"]').select2("destroy");

						$('.stm_mc-filter-selects select[name="' + key + '"]').select2();
					}
				});
			});

		})(jQuery);
	</script>

<?php endif; ?>