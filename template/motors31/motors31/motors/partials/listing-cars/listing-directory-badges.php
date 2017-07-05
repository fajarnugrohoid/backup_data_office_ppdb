<?php
	$special_car = get_post_meta(get_the_ID(), 'special_car', true);
	$badge_text = get_post_meta(get_the_ID(), 'badge_text', true);
	$badge_bg_color = get_post_meta(get_the_ID(), 'badge_bg_color', true);
	if(!empty($badge_bg_color)) {
		$badge_bg_color = 'style="background-color:' . $badge_bg_color . '";';
	} else {
		$badge_bg_color = '';
	}

	if(!empty($special_car) and $special_car == 'on' and !empty($badge_text)): ?>
		<div class="stm-badge-directory heading-font" <?php echo sanitize_text_field($badge_bg_color); ?>>
			<?php echo esc_attr($badge_text); ?>
		</div>
	<?php endif; ?>