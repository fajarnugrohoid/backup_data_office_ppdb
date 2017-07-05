<?php
	if ( ! isset( $content_width ) ) $content_width = 1170;
	
	add_action( 'after_setup_theme', 'stm_local_theme_setup' );
	function stm_local_theme_setup(){

		//Adding user role
		if(stm_is_listing()) {
			$exist_dealer_role = get_role('dealer');
			if(empty($exist_dealer_role)) {
				add_role( 'stm_dealer', 'STM Dealer', array( 'read' => true, 'level_0' => true ) );
			}
		}

		add_editor_style();
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'video' ) );
		add_post_type_support( 'page', 'excerpt' );


		add_image_size( 'stm-img-1110-577', 1110, 577, true );
		add_image_size( 'stm-img-796-466', 798, 466, true );
		add_image_size( 'stm-img-350-205', 350, 205, true );
		add_image_size( 'stm-img-350-356', 350, 356, true );
		add_image_size( 'stm-img-350-181', 350, 181, true );
		add_image_size( 'stm-img-398-206', 398, 206, true );
		add_image_size( 'stm-img-255-135', 255, 135, true );
		add_image_size( 'stm-img-190-132', 190, 132, true );

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		
		
		load_theme_textdomain( 'motors', get_template_directory() . '/languages' );
		
		register_nav_menus( array(
			'primary'   => __( 'Top primary menu', 'motors' ),
			'top_bar'   => __( 'Top bar menu', 'motors' ),
			'bottom_menu'   => __( 'Bottom menu', 'motors' ),
		) );

		register_sidebar( array(
			'name'          => __( 'Primary Sidebar', 'motors' ),
			'id'            => 'default',
			'description'   => __( 'Main sidebar that appears on the right or left.', 'motors' ),
			'before_widget' => '<aside id="%1$s" class="widget widget-default %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title"><h4>',
			'after_title'   => '</h4></div>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer', 'motors' ),
			'id'            => 'footer',
			'description'   => __( 'Footer Widgets Area', 'motors' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-wrapper">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<div class="widget-title"><h6>',
			'after_title'   => '</h6></div>',
		) );

		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar( array(
				'name'          => __( 'Shop', 'motors' ),
				'id'            => 'shop',
				'description'   => __( 'Woocommerce pages sidebar', 'motors' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<div class="widget_title"><h3>',
				'after_title'   => '</h3></div>',
			) );
		}

		//if ( stm_is_listing() ) {
			register_sidebar( array(
				'name'          => __( 'STM Listing Car Sidebar', 'motors' ),
				'id'            => 'stm_listing_car',
				'description'   => __( 'Default sidebar for Single Car Page (Listing layout)', 'motors' ),
				'before_widget' => '<aside id="%1$s" class="single-listing-car-sidebar-unit %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<div class="stm-border-bottom-unit"><div class="title heading-font">',
				'after_title'   => '</div></div>',
			) );
		//}

		//if ( stm_is_boats() ) {
			register_sidebar( array(
				'name'          => __( 'STM Single Boat Sidebar', 'motors' ),
				'id'            => 'stm_boats_car',
				'description'   => __( 'Default sidebar for Single Boat Page (Boats layout)', 'motors' ),
				'before_widget' => '<aside id="%1$s" class="single-listing-car-sidebar-unit %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<div class="stm-border-bottom-unit"><h4 class="title heading-font">',
				'after_title'   => '</h4></div>',
			) );
		//}
		
	}