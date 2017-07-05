<div class="stm-car-listing-sort-units clearfix">
	<div class="stm-sort-by-options clearfix">
		<span><?php esc_html_e('Sort by:', 'motors'); ?></span>
		<div class="stm-select-sorting">
			<select>
				<option value="date_high" selected><?php esc_html_e( 'Date: newest first', 'motors' ); ?></option>
				<option value="date_low"><?php esc_html_e( 'Date: oldest first', 'motors' ); ?></option>
				<option value="price_low"><?php esc_html_e( 'Price: lower first', 'motors' ); ?></option>
				<option value="price_high"><?php esc_html_e( 'Price: highest first', 'motors' ); ?></option>
				<option value="mileage_low"><?php esc_html_e( 'Mileage: lowest first', 'motors' ); ?></option>
				<option value="mileage_high"><?php esc_html_e( 'Mileage: highest first', 'motors' ); ?></option>
			</select>
		</div>
	</div>

	<?php
		$view_type = stm_listings_input('view_type', 'list');
		if($view_type == 'list') {
			$view_list = 'active';
			$view_grid = '';
		} else {
			$view_grid = 'active';
			$view_list = '';
		}
	?>

	<div class="stm-view-by">
		<a href="#" class="view-grid view-type <?php echo esc_attr($view_grid); ?>" data-view="grid">
			<i class="stm-icon-grid"></i>
		</a>
		<a href="#" class="view-list view-type <?php echo esc_attr($view_list); ?>" data-view="list">
			<i class="stm-icon-list"></i>
		</a>
	</div>
</div>