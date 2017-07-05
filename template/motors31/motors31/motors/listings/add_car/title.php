<?php
if(!empty($show_car_title) and $show_car_title == 'yes'):
	$value = '';
	if(!empty($id)) {
		$value = get_the_title($id);
	} ?>
	<div class="stm-car-listing-data-single stm-border-top-unit ">
		<div class="stm_add_car_title_form">
			<div class="title heading-font"><?php esc_html_e('Car title', 'motors'); ?></div>
			<input type="text" name="stm_car_main_title" value="<?php echo esc_attr($value); ?>" placeholder="<?php esc_html_e('Title', 'motors'); ?>">
		</div>
	</div>
<?php endif; ?>