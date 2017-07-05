<?php
	get_header();

		get_template_part('partials/title_box');

		$recaptcha_enabled = get_theme_mod('enable_recaptcha',0);
		$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
		$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
		if(!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) {
			wp_enqueue_script( 'stm_grecaptcha' );
		}

	stm_listings_load_template('filter/inventory/main');

	get_footer();