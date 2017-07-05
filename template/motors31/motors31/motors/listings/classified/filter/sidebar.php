<?php
	$filter_bg = get_theme_mod('sidebar_filter_bg', get_template_directory_uri() . '/assets/images/listing-directory-filter-bg.jpg');
	if(!empty($filter_bg)){ ?>
		<style type="text/css">
			.stm-template-listing .filter-sidebar:after {
				background-image: url("<?php echo esc_url($filter_bg); ?>");
			}
		</style>
		<?php
	}
?>

<form action="<?php echo stm_listings_current_url() ?>" method="get" data-trigger="filter">
	<div class="filter filter-sidebar ajax-filter">

		<?php do_action( 'stm_listings_filter_before' ); ?>

		<div class="sidebar-entry-header">
			<i class="stm-icon-car_search"></i>
			<span class="h4"><?php _e( 'Search Options', 'motors' ); ?></span>
		</div>

		<div class="row row-pad-top-24">

			<?php foreach ( $filter['filters'] as $attribute => $config ):
				if($attribute == 'price') {
					continue;
				}
				if ( ! empty( $config['slider'] ) && $config['slider'] ):
					stm_listings_load_template( 'filter/types/slider', array(
						'taxonomy' => $config,
						'options'  => $filter['options'][ $attribute ]
					) );
				else: ?>
					<div class="col-md-12 col-sm-6 stm-filter_<?php echo esc_attr( $attribute ) ?>">
						<div class="form-group">
							<?php stm_listings_load_template( 'filter/types/select', array(
								'options' => $filter['options'][ $attribute ],
								'name'    => $attribute
							) ); ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

			<?php stm_listings_load_template('filter/types/location'); ?>

		</div>

		<!--View type-->
		<input type="hidden" id="stm_view_type" name="view_type"
		       value="<?php echo esc_attr( stm_listings_input( 'view_type' ) ); ?>"/>
		<!--Filter links-->
		<input type="hidden" id="stm-filter-links-input" name="stm_filter_link" value=""/>
		<!--Popular-->
		<input type="hidden" name="popular" value="<?php echo esc_attr( stm_listings_input( 'popular' ) ); ?>"/>

		<input type="hidden" name="s" value="<?php echo esc_attr( stm_listings_input( 's' ) ); ?>"/>
		<input type="hidden" name="sort_order" value="<?php echo esc_attr( stm_listings_input( 'sort_order' ) ); ?>"/>

		<div class="sidebar-action-units">
			<input id="stm-classic-filter-submit" class="hidden" type="submit"
			       value="<?php _e( 'Show cars', 'motors' ); ?>"/>

			<a href="<?php echo esc_url( stm_get_listing_archive_link() ); ?>"
			   class="button"><span><?php _e( 'Reset all', 'motors' ); ?></span></a>
		</div>

		<?php do_action( 'stm_listings_filter_after' ); ?>
	</div>

	<!--Classified price-->
	<?php
		if(!empty($filter['options']) and !empty($filter['options']['price'])) {
			stm_listings_load_template( 'filter/types/price', array(
				'taxonomy' => 'price',
				'options'  => $filter['options']['price']
			) );
		}
	?>

	<?php stm_listings_load_template('filter/types/checkboxes', array('filter' => $filter)); ?>

</form>

<?php stm_listings_load_template('filter/types/links', array('filter' => $filter)); ?>

<?php
$stm_vehicle_listing_options = stm_get_car_filter(); ?>
<style type="text/css">
	<?php foreach($stm_vehicle_listing_options as $stm_vehicle_listing_option): ?>
	<?php if(!empty($stm_vehicle_listing_option['numeric']) and $stm_vehicle_listing_option['numeric']): ?>
	.select2-selection__rendered[title="<?php echo esc_html__('Max', 'motors').' '.esc_attr($stm_vehicle_listing_option['single_name']); ?>"] {
	<?php else: ?>
	.select2-selection__rendered[title="<?php echo esc_attr($stm_vehicle_listing_option['single_name']); ?>"] {
	<?php endif; ?>
		background-color: transparent !important;
		border: 1px solid rgba(255,255,255,0.5);
		color: #fff !important;
	}

	<?php if(!empty($stm_vehicle_listing_option['numeric']) and $stm_vehicle_listing_option['numeric']): ?>
	.select2-selection__rendered[title="<?php echo esc_html__('Max', 'motors').' '.esc_attr($stm_vehicle_listing_option['single_name']); ?>"] + .select2-selection__arrow b {
	<?php else: ?>
	.select2-selection__rendered[title="<?php echo esc_attr($stm_vehicle_listing_option['single_name']); ?>"] + .select2-selection__arrow b {
	<?php endif; ?>
		color: rgba(255,255,255,0.5);
	}
	<?php endforeach; ?>
</style>
