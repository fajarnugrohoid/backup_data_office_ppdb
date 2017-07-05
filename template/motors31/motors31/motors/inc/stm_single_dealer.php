<?php if(!function_exists('stm_get_single_dealer')) {
	function stm_get_single_dealer($dealer_info, $taxonomy='') {

		$dealer_cars_count = $dealer_info['cars_count'];
		$cars_count_text = esc_html__('Cars in stock', 'motors');
		if($dealer_cars_count == 1) {
			$cars_count_text = esc_html__('Car in stock', 'motors');
		}

		if(!empty($taxonomy)) {
			$taxonomy = $taxonomy;
		}elseif(!empty($_GET['stm_dealer_show_taxonomies'])) {
			$taxonomy = sanitize_text_field($_GET['stm_dealer_show_taxonomies']);
		} else {
			$taxonomy = '';
		}


		$taxonomy = array_filter(explode(', ',$taxonomy));
		$ratings = $dealer_info['ratings'];
		$tax_term = array();
		if(!empty($taxonomy)) {
			foreach($taxonomy as $tax) {
				$term_tax = explode(' | ', $tax);
				$tax_term[$term_tax[0]] = sanitize_title($term_tax[1]);
			}
		}

		$dealer_category_labels = array();

		$dealer_cars = $dealer_info['cars'];
		if($dealer_cars->have_posts()){
			while($dealer_cars->have_posts()){
				$dealer_cars->the_post();
				foreach($tax_term as $term => $tax) {
					$terms_all = wp_get_object_terms( get_the_ID(), $tax);
					if(!empty($terms_all)) {
						foreach ( $terms_all as $term_single ) {
							if ( $term_single->slug == $term ) {
								$dealer_category_labels[] = $term_single->name;
							}
						}
					}
				}
			}
		}

		wp_reset_postdata();

		$dealer_category_labels = array_unique($dealer_category_labels);

		?>
			<tr class="stm-single-dealer animated fadeIn">

				<td class="image">
					<a href="<?php echo esc_url(stm_get_author_link($dealer_info['id'])); ?>" target="_blank">
						<?php if(!empty($dealer_info['fields']['logo'])): ?>
							<img src="<?php echo esc_url($dealer_info['fields']['logo']); ?>" class="img-responsive" />
						<?php else: ?>
							<img src="<?php stm_get_dealer_logo_placeholder(); ?>" class="no-logo" />
						<?php endif; ?>
					</a>
				</td>

				<td class="dealer-info">
					<div class="title">
						<a class="h4" href="<?php echo esc_url(stm_get_author_link($dealer_info['id'])); ?>" target="_blank"><?php stm_display_user_name($dealer_info['id']); ?></a>
					</div>
					<div class="rating">
						<div class="dealer-rating">
							<div class="stm-rate-unit">
								<div class="stm-rate-inner">
									<div class="stm-rate-not-filled"></div>
									<?php if(!empty($ratings['average_width'])): ?>
										<div class="stm-rate-filled" style="width:<?php echo esc_attr($ratings['average_width']); ?>"></div>
									<?php else: ?>
										<div class="stm-rate-filled" style="width:0%"></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="stm-rate-sum">(<?php esc_html_e('Reviews', 'motors'); ?> <?php echo esc_attr($ratings['count']); ?>)</div>
						</div>
					</div>
				</td>

				<td class="dealer-cars">
					<div class="inner">
						<a href="<?php echo esc_url(stm_get_author_link($dealer_info['id'])); ?>#stm_d_inv" target="_blank">
							<div class="dealer-labels heading-font">
								<?php echo intval($dealer_cars_count); ?>
								<?php if(!empty($dealer_category_labels)):
									echo esc_attr(implode('/', $dealer_category_labels));
								endif; ?>
							</div>
							<div class="dealer-cars-count">
								<i class="stm-service-icon-body_type"></i>
								<?php echo esc_attr($cars_count_text); ?>
							</div>
						</a>
					</div>
				</td>

				<td class="dealer-phone">
					<div class="inner">
						<?php if(!empty($dealer_info['fields']['phone'])): ?>
							<div class="phone heading-font">
								<i class="stm-service-icon-phone_2"></i>
								<?php echo esc_attr($dealer_info['fields']['phone']); ?>
							</div>
						<?php endif; ?>
					</div>
				</td>


				<td class="dealer-location">
					<div class="clearfix">
						<?php if(!empty($dealer_info['fields']['location']) and !empty($dealer_info['fields']['location_lat']) and !empty($dealer_info['fields']['location_lng'])): ?>
							<a
								href="https://maps.google.com?q=<?php echo esc_attr($dealer_info['fields']['location']); ?>"
								target="_blank"
								class="map_link"
							>
								<i class="fa fa-external-link"></i>
								<?php esc_html_e('See map', 'motors'); ?>
							</a>
						<?php endif; ?>
						<div class="dealer-location-label">
							<?php if(!empty($dealer_info['fields']['distance'])): ?>
								<div class="inner">
									<i class="stm-service-icon-pin_big"></i>
									<span class="heading-font"><?php echo esc_attr($dealer_info['fields']['distance']); ?></span>
									<?php if(!empty($dealer_info['fields']['user_location'])): ?>
										<div class="stm-label"><?php esc_html_e('From', 'motors'); echo ' ' . $dealer_info['fields']['user_location']; ?></div>
									<?php endif; ?>
								</div>
							<?php elseif(!empty($dealer_info['fields']['location'])): ?>
								<div class="inner">
									<i class="stm-service-icon-pin_big"></i>
									<span class="heading-font"><?php echo esc_attr($dealer_info['fields']['location']); ?></span>
								</div>
							<?php else: ?>
								<?php esc_html_e('N/A', 'motors'); ?>
							<?php endif; ?>
						</div>
					</div>
				</td>

			</tr>
			<tr class="dealer-single-divider"><td colspan="5"></td></tr>
		<?php
	}
} ?>