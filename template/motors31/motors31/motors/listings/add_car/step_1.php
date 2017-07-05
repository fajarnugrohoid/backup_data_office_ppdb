<?php
$data = stm_get_single_car_listings();

$terms_args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	'fields'     => 'all',
	'pad_counts' => true,
);
?>

<div class="stm_add_car_form_1">
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="title heading-font"><?php esc_html_e( 'Car Details', 'motors' ); ?></div>
		<span class="step_number step_number_1 heading-font"><?php esc_html_e( 'step', 'motors' ); ?> 1</span>
	</div>

	<?php if(!empty($taxonomy)): ?>
		<div class="stm-form1-intro-unit">
			<div class="row">
				<?php foreach($taxonomy as $tax):
                    $terms = stm_get_category_by_slug_all($tax);
                    $has_selected = '';
                    if(!empty($id)) {
                        $post_terms = wp_get_post_terms($id, $tax);
                        if(!empty($post_terms[0])) {
                            $has_selected = $post_terms[0]->slug;
                        }
                    }
                    ?>
					<div class="col-md-3 col-sm-3 stm-form-1-selects">
						<div class="stm-label heading-font"><?php esc_html_e(stm_get_name_by_slug($tax), 'motors'); ?>*</div>
						<?php
						$number_field = false;
						if($use_inputs) {
							$tax_info = stm_get_all_by_slug($tax);
							if(!empty($tax_info['numeric']) and $tax_info['numeric']) {
								$number_field = true;
							}
						}
						?>
						<?php if($number_field): ?>
							<input min="0" type="number" name="stm_f_s[<?php echo esc_attr($tax); ?>]" required />
						<?php else: ?>
							<select data-class="stm_select_overflowed" name="stm_f_s[<?php echo esc_attr($tax); ?>]">
								<option value=""><?php esc_html_e('Select', 'motors'); ?> <?php echo esc_html__(stm_get_name_by_slug($tax), 'motors'); ?></option>
								<?php if(!empty($terms)):
									foreach($terms as $term): ?>
										<option
                                            value="<?php echo esc_attr($term->slug); ?>"
                                            <?php
                                            if(!empty($has_selected) and $term->slug == $has_selected) {echo 'selected';}
                                            ?>>
                                            <?php echo esc_attr($term->name); ?>
                                        </option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<style type="text/css">
			<?php foreach($taxonomy as $tax): ?>

			.stm-form1-intro-unit .select2-selection__rendered[title="<?php esc_html_e('Select', 'motors'); ?> <?php echo esc_html__(stm_get_name_by_slug($tax), 'motors'); ?>"] {
				background-color: transparent !important;
				border: 1px solid rgba(255,255,255,0.5);
				color: #fff !important;
			}
			.stm-form1-intro-unit .select2-selection__rendered[title="<?php esc_html_e('Select', 'motors'); ?> <?php echo esc_html__(stm_get_name_by_slug($tax), 'motors'); ?>"] + .select2-selection__arrow b {
				color: rgba(255,255,255,0.5);
			}
			<?php endforeach; ?>
		</style>
	<?php endif; ?>

	<div class="stm-form-1-end-unit clearfix">
		<?php if ( ! empty( $data ) ): ?>
			<?php foreach ( $data as $data_key => $data_unit ): ?>
			<?php $terms = get_terms( $data_unit['slug'], $terms_args ); ?>
			<div class="stm-form-1-quarter">
				<?php if ( ! empty( $data_unit['numeric'] ) and $data_unit['numeric'] ): ?>

					<?php $value = '';
					if(!empty($id)) {
						$value = get_post_meta($id, $data_unit['slug'], true);
					} ?>

					<input
						type="text"
						class="form-control <?php echo (!empty($value)) ? 'stm_has_value' : ''; ?>"
						name="stm_s_s_<?php echo esc_attr( $data_unit['slug'] ); ?>"
						value="<?php echo esc_attr($value); ?>"
						placeholder="<?php esc_html_e( 'Enter', 'motors' ); ?> <?php esc_html_e( $data_unit['single_name'], 'motors' ); ?> <?php if ( ! empty( $data_unit['number_field_affix'] ) ) {
							echo '(';
							esc_html_e( $data_unit['number_field_affix'], 'motors' );
							echo ')';
						} ?>"
					/>
				<?php else: ?>
					<select name="stm_s_s_<?php echo esc_attr( $data_unit['slug'] ) ?>">
						<?php $selected = '';
						if(!empty($id)) {
							$selected = get_post_meta($id, $data_unit['slug'], true);
						}
						?>
						<option
							value=""><?php esc_html_e( 'Select', 'motors' ) ?> <?php esc_html_e( $data_unit['single_name'], 'motors' ); ?></option>
						<?php if ( ! empty( $terms ) ):
							foreach ( $terms as $term ): ?>
								<?php
								echo $term->slug . ' - ' . $selected;
								$selected_opt = '';
								if($selected == $term->slug) {
									$selected_opt = 'selected';
								} ?>
								<option
									value="<?php echo esc_attr( $term->slug ); ?>" <?php echo esc_attr($selected_opt); ?>><?php echo esc_attr( $term->name ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				<?php endif; ?>
				<div class="stm-label">
					<?php if ( ! empty( $data_unit['font'] ) ): ?>
						<i class="<?php echo esc_attr( $data_unit['font'] ); ?>"></i>
					<?php endif; ?>
					<?php esc_html_e( $data_unit['single_name'], 'motors' ); ?>
				</div>
			</div>
		<?php endforeach; ?>

			<style type="text/css">
				<?php foreach($data as $data_unit): ?>

				.stm-form-1-end-unit .select2-selection__rendered[title="<?php esc_html_e('Select', 'motors'); ?> <?php echo esc_html__($data_unit['single_name'], 'motors'); ?>"] {
					background-color: transparent !important;
					border: 1px solid rgba(255, 255, 255, 0.5);
					color: #888 !important;
				}

				<?php endforeach; ?>
			</style>


		<?php stm_listings_load_template('add_car/step_1_additional_fields', array('stm_histories' => $stm_histories, 'id' => $id)); ?>

		<?php endif; ?>
	</div>
</div>