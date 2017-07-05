<!--Location inputs-->
<?php
$stm_lat = $stm_lng = $stm_location = '';
if ( isset( $_GET['ca_location'] ) ) {
	$stm_location = $_GET['ca_location'];
}
if ( isset( $_GET['stm_lng'] ) ) {
	$stm_lng = $_GET['stm_lng'];
}
if ( isset( $_GET['stm_lat'] ) ) {
	$stm_lat = $_GET['stm_lat'];
}
?>

<?php if ( stm_enable_location() and stm_is_listing() or stm_is_boats() ): ?>
	<div class="col-md-12 col-sm-12">
		<div class="form-group boats-location">
			<div class="stm-location-search-unit">
				<input type="text" id="ca_location_listing_filter"
				       class="stm_listing_search_location" name="ca_location"
				       value="<?php echo esc_attr( $stm_location ); ?>"/>
				<input type="hidden" name="stm_lat"
				       value="<?php echo esc_attr( floatval( $stm_lat ) ); ?>">
				<input type="hidden" name="stm_lng"
				       value="<?php echo esc_attr( floatval( $stm_lng ) ); ?>">
			</div>
		</div>
	</div>
<?php endif; ?>