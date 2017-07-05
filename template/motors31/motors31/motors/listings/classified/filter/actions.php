<?php $total_matches = $filter['total']; ?>

<div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
	<div class="stm-listing-directory-title">
		<h3 class="title"><?php echo esc_attr($filter['listing_title']); ?></h3>
		<div class="stm-listing-directory-total-matches total stm-secondary-color heading-font"><span><?php echo esc_attr($total_matches); ?></span> <?php esc_html_e('matches', 'motors');  ?></div>
	</div>
	<div class="stm-directory-listing-top__right">
		<div class="clearfix">
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

			<?php
				$sorts = array(
					'date_high' => esc_html__( 'Date: newest first', 'motors' ),
					'date_low' => esc_html__( 'Date: oldest first', 'motors' ),
					'price_low' => esc_html__( 'Price: lower first', 'motors' ),
					'price_high' => esc_html__( 'Price: highest first', 'motors' ),
					'mileage_low' => esc_html__( 'Mileage: lowest first', 'motors' ),
					'mileage_high' => esc_html__( 'Mileage: highest first', 'motors' )
				);

				$selected = stm_listings_input('sort_order', 'date_high');
			?>


			<div class="stm-sort-by-options clearfix">
				<span><?php esc_html_e('Sort by:', 'motors'); ?></span>
				<div class="stm-select-sorting">
					<select>
						<?php foreach($sorts as $key => $label): ?>
							<option value="<?php echo esc_attr($key) ?>" <?php echo ($selected == $key) ? 'selected' : ''; ?>><?php echo esc_attr($label); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>