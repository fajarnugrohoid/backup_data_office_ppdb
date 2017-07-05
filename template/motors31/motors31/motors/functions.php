<?php

    if(is_admin()) {
        require_once get_template_directory() . '/admin/admin.php';
    }

	define( 'STM_TEMPLATE_URI', get_template_directory_uri() );
	define( 'STM_TEMPLATE_DIR', get_template_directory() );
	define( 'STM_THEME_SLUG', 'stm' );
	define( 'STM_INC_PATH', get_template_directory() . '/inc' );
	define( 'STM_CUSTOMIZER_PATH', get_template_directory() . '/inc/customizer' );
	define( 'STM_CUSTOMIZER_URI', get_template_directory_uri() . '/inc/customizer' );

	//	Include path
	$inc_path = get_template_directory() . '/inc';

	//	Widgets path
	$widgets_path = get_template_directory() . '/inc/widgets';


	define('motors', 'motors');
	
		// Theme setups
		require_once STM_CUSTOMIZER_PATH . '/customizer.class.php';
		
		// Custom code and theme main setups
		require_once( $inc_path . '/setup.php' );
		
		// Enqueue scripts and styles for theme
		require_once( $inc_path . '/scripts_styles.php' );

		// Custom code for any outputs modifying
		require_once( $inc_path . '/custom.php' );

		// Required plugins for theme
		require_once( $inc_path . '/tgm/tgm-plugin-registration.php' );
		
		// Visual composer custom modules
		if ( defined( 'WPB_VC_VERSION' ) ) {
			require_once( $inc_path . '/visual_composer.php' );
		}

		// Custom code for any outputs modifying with ajax relation
		require_once( $inc_path . '/stm-ajax.php' );

		// Custom code for filter output
		//require_once( $inc_path . '/listing-filter.php' );
		require_once( $inc_path . '/user-filter.php' );

		//User
		if(stm_is_listing()) {
			require_once( $inc_path . '/user-extra.php' );
		}

		require_once( $inc_path . '/user-vc-register.php' );

		require_once( $inc_path . '/stm_single_dealer.php' );
		
		// Custom code for woocommerce modifying
		if( class_exists( 'WooCommerce' ) ) {
		    require_once( $inc_path . '/woocommerce_setups.php' );
		}

		//Widgets
		require_once( $widgets_path . '/socials.php' );
		require_once( $widgets_path . '/text-widget.php' );
		require_once( $widgets_path . '/latest-posts.php' );
		require_once( $widgets_path . '/address.php' );
		require_once( $widgets_path . '/dealer_info.php' );
        require_once( $widgets_path . '/car_location.php' );
		require_once( $widgets_path . '/similar_cars.php' );
		require_once( $widgets_path . '/car-contact-form.php' );
		require_once( $widgets_path . '/contacts.php' );
		if(stm_is_boats()) {
			require_once( $widgets_path . '/schedule_showing.php' );
			require_once( $widgets_path . '/car_calculator.php' );
		}