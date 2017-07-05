<?php
// Add svg support
function stm_svg_mime( $mimes ) {
	$mimes['ico'] = 'image/icon';
	$mimes['svg'] = 'image/svg+xml';
	$mimes['xml'] = 'application/xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'stm_svg_mime' );


// Comments
if ( ! function_exists( 'stm_comment' ) ) {
	function stm_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		if ( 'div' == $args['style'] ) {
			$tag       = 'div ';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo $tag ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) { ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">
		<?php } ?>
		<?php if ( $args['avatar_size'] != 0 ) { ?>
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 80 ); ?>
			</div>
		<?php } ?>
		<div class="comment-info-wrapper">
			<div class="comment-info">
				<div class="clearfix">
					<div class="comment-author pull-left"><span
							class="h5"><?php echo get_comment_author_link(); ?></span></div>
					<div class="comment-meta commentmetadata pull-right">
						<a class="comment-date"
						   href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
							<?php printf( __( '%1$s', 'motors' ), get_comment_date() ); ?>
						</a>
						<span class="comment-meta-data-unit">
							<?php comment_reply_link( array_merge( $args, array(
								'reply_text' => __( '<span class="comment-divider">/</span><i class="fa fa-reply"></i> Reply', 'motors' ),
								'add_below'  => $add_below,
								'depth'      => $depth,
								'max_depth'  => $args['max_depth']
							) ) ); ?>
						</span>
						<span class="comment-meta-data-unit">
							<?php edit_comment_link( __( '<span class="comment-divider">/</span><i class="fa fa-pencil-square-o"></i> Edit', 'motors' ), '  ', '' ); ?>
						</span>
					</div>
				</div>
				<?php if ( $comment->comment_approved == '0' ) { ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'motors' ); ?></em>
				<?php } ?>
			</div>
			<div class="comment-text">
				<?php comment_text(); ?>
			</div>
		</div>

		<?php if ( 'div' != $args['style'] ) { ?>
			</div>
		<?php } ?>
		<?php
	}
}


add_filter( 'comment_form_default_fields', 'stm_bootstrap3_comment_form_fields' );

if ( ! function_exists( 'stm_bootstrap3_comment_form_fields' ) ) {
	function stm_bootstrap3_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$fields    = array(
			'author' => '<div class="row stm-row-comments">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="form-group comment-form-author">
			            			<input placeholder="' . __( 'Name', 'motors' ) . ( $req ? ' *' : '' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
		                        </div>
		                    </div>',
			'email'  => '<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group comment-form-email">
								<input placeholder="' . __( 'E-mail', 'motors' ) . ( $req ? ' *' : '' ) . '" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
							</div>
						</div>',
			'url'    => '<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="form-group comment-form-url">
							<input placeholder="' . __( 'Website', 'motors' ) . '" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
						</div>
					</div></div>'
		);

		return $fields;
	}
}

add_filter( 'comment_form_defaults', 'stm_bootstrap3_comment_form' );

if ( ! function_exists( 'stm_bootstrap3_comment_form' ) ) {
	function stm_bootstrap3_comment_form( $args ) {
		$args['comment_field'] = '<div class="form-group comment-form-comment">
			<textarea placeholder="' . _x( 'Message', 'noun', 'motors' ) . ' *" name="comment" rows="9" aria-required="true"></textarea>
	    </div>';

		return $args;
	}
}

if ( ! function_exists( 'stm_body_class' ) ) {
	function stm_body_class( $classes ) {
		$macintosh = strpos( $_SERVER["HTTP_USER_AGENT"], 'Macintosh' ) ? true : false;
		global $wp_customize;

		if ( $macintosh ) {
			$classes[] = 'stm-macintosh';
		}

		$boxed    = get_theme_mod( 'site_boxed', false );
		$bg_image = get_theme_mod( 'bg_image', false );

		if ( $boxed ) {
			$classes[] = 'stm-boxed';
			if ( $bg_image ) {
				$classes[] = $bg_image;
			}
		}

		$frontend_customizer = get_theme_mod( 'frontend_customizer', false );
		if ( $frontend_customizer ) {
			$classes[] = 'stm_frontend_customizer';
		}


		// Layout class
		$layout = stm_get_current_layout();

		if ( empty( $layout ) ) {
			$layout = 'car_dealer';
		}

		$classes[] = 'stm-template-' . $layout;

		if ( is_singular( stm_listings_post_type() ) ) {
			global $post;
			$has_id = get_post_meta( $post->ID, 'automanager_id', true );
			if ( ! empty( $has_id ) ) {
				$classes[] = 'automanager-listing-page';
			}
		}

		if ( ! is_user_logged_in() ) {
			$classes[] = 'stm-user-not-logged-in';
		}


		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
			if ( strlen( strstr( $agent, 'Firefox' ) ) > 0 ) {
				$classes[] = 'stm-firefox';
			}
		}

		if ( isset( $wp_customize ) ) {
			$classes[] = 'stm-customize-page';
			$classes[] = 'stm-customize-layout-' . $layout;
		}

		if ( stm_is_boats() ) {
			global $post;
			if ( ! empty( $post->ID ) ) {
				$transparent = get_post_meta( $post->ID, 'transparent_header', true );
				if ( ! empty( $transparent ) and $transparent == 'on' ) {
					$transparent = 'stm-boats-transparent';
				} else {
					$transparent = 'stm-boats-default';
				}
				$classes[] = $transparent;
			}
		}

		if ( ! get_theme_mod( 'header_compare_show', true ) ) {
			$classes[] = 'header_remove_compare';
		}

		if ( ! get_theme_mod( 'header_cart_show', true ) ) {
			$classes[] = 'header_remove_cart';
		}

		return $classes;
	}
}

add_filter( 'body_class', 'stm_body_class' );

add_filter( 'language_attributes', 'stm_preloader_html_class' );

function stm_preloader_html_class( $output ) {
	$enable_preloader = get_theme_mod( 'enable_preloader', false );

	$preloader_class = '';

	if ( $enable_preloader ) {
		$preloader_class = ' class="stm-site-preloader"';
	}

	return $output . $preloader_class;
}

if ( ! function_exists( 'stm_print_styles' ) ) {
	function stm_print_styles() {

		$site_css = get_theme_mod( 'custom_css' );
		if ( $site_css ) {
			$site_css .= preg_replace( '/\s+/', ' ', $site_css );
		}

		wp_add_inline_style( 'stm-theme-style', $site_css );
	}
}

add_action( 'wp_enqueue_scripts', 'stm_print_styles' );

//Hex to rgba
if ( ! function_exists( 'stm_hex2rgb' ) ) {
	function stm_hex2rgb( $colour ) {
		if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		return $r . ',' . $g . ',' . $b;
	}
}

//Get price currency
if ( ! function_exists( 'stm_get_price_currency' ) ) {
	function stm_get_price_currency() {
		return get_theme_mod( 'price_currency', '$' );
	}
}

//Limit content by chars
if ( ! function_exists( 'stm_limit_content' ) ) {
	function stm_limit_content( $limit ) {
		$content = explode( ' ', get_the_content(), $limit );
		if ( count( $content ) >= $limit ) {
			array_pop( $content );
			$content = implode( " ", $content ) . '...';
		} else {
			$content = implode( " ", $content );
		}
		$content = preg_replace( '/\[.+\]/', '', $content );
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $content;
	}
}

//Get socials
if ( ! function_exists( 'stm_get_header_socials' ) ) {
	function stm_get_header_socials( $socials_pos = 'header_socials_enable' ) {
		$socials_array = array();

		$header_socials_enable = get_theme_mod( $socials_pos );
		$header_socials_enable = explode( ',', $header_socials_enable );

		$socials        = get_theme_mod( 'socials_link' );
		$socials_values = array();
		if ( ! empty( $socials ) ) {
			parse_str( $socials, $socials_values );
		}

		if ( $header_socials_enable ) {
			foreach ( $header_socials_enable as $social ) {
				if ( ! empty( $socials_values[ $social ] ) ) {
					$socials_array[ $social ] = $socials_values[ $social ];
				}
			}
		}

		return $socials_array;
	}
}

//Sidebar layout
if ( ! function_exists( 'stm_sidebar_layout_mode' ) ) {
	function stm_sidebar_layout_mode( $position = 'left', $sidebar_id = false ) {
		$content_before = $content_after = $sidebar_before = $sidebar_after = $show_title = $default_row = $default_col = '';

		if ( get_post_type() == 'post' ) {
			if ( ! empty( $_GET['show-title-box'] ) and $_GET['show-title-box'] == 'hide' ) {
				$blog_archive_id = get_option( 'page_for_posts' );
				if ( ! empty( $blog_archive_id ) ) {

					$get_the_title = get_the_title( $blog_archive_id );

					if ( ! empty( $get_the_title ) ) {
						$show_title = '<h2 class="stm-blog-main-title">' . $get_the_title . '</h2>';
					}
				}
			}
		}

		if ( ! $sidebar_id ) {
			$content_before .= '<div class="col-md-12">';

			$content_after .= '</div>';

			$default_row = 3;
			$default_col = 'col-md-4 col-sm-4 col-xs-12';
		} else {
			if ( $position == 'right' ) {
				$content_before .= '<div class="col-md-9 col-sm-12 col-xs-12"><div class="sidebar-margin-top clearfix"></div>';
				$sidebar_before .= '<div class="col-md-3 hidden-sm hidden-xs">';

				$sidebar_after .= '</div>';
				$content_after .= '</div>';
			} elseif ( $position == 'left' ) {
				$content_before .= '<div class="col-md-9 col-md-push-3 col-sm-12"><div class="sidebar-margin-top clearfix"></div>';
				$sidebar_before .= '<div class="col-md-3 col-md-pull-9 hidden-sm hidden-xs">';

				$sidebar_after .= '</div>';
				$content_after .= '</div>';
			}
			$default_row = 2;
			$default_col = 'col-md-6 col-sm-6 col-xs-12';
		}

		$return                   = array();
		$return['content_before'] = $content_before;
		$return['content_after']  = $content_after;
		$return['sidebar_before'] = $sidebar_before;
		$return['sidebar_after']  = $sidebar_after;
		$return['show_title']     = $show_title;
		$return['default_row']    = $default_row;
		$return['default_col']    = $default_col;

		return $return;
	}
}

//Add empty gravatar
function stm_default_avatar( $avatar_defaults ) {
	$stm_avatar                     = get_template_directory_uri() . '/assets/images/gravataricon.png';
	$avatar_defaults[ $stm_avatar ] = esc_html__( 'Motors Theme Default', 'motors' );

	return $avatar_defaults;
}

add_filter( 'avatar_defaults', 'stm_default_avatar' );

//Crop title
if ( ! function_exists( 'stm_trim_title' ) ) {
	function stm_trim_title( $number = 35, $after = '...' ) {
		$response = '';
		$response = esc_attr( trim( preg_replace( '/\s+/', ' ', substr( get_the_title(), 0, $number ) ) ) );
		if ( strlen( get_the_title() ) > $number ) {
			$response .= esc_attr( $after );
		}

		return $response;
	}
}

//Get link
if ( ! function_exists( 'stm_listings_user_defined_filter_page' ) ) {
	function stm_listings_user_defined_filter_page() {
		return apply_filters( 'stm_listings_inventory_page_id', get_theme_mod( 'listing_archive', false ) );
	}
}

if ( ! function_exists( 'stm_get_listing_archive_link' ) ) {
	function stm_get_listing_archive_link() {
		$listing_link = stm_listings_user_defined_filter_page();

		if ( ! empty( $listing_link ) ) {
			$listing_link = get_permalink( $listing_link );
		} else {
			$listing_link = get_post_type_archive_link( stm_listings_post_type() );
		}

		return $listing_link;
	}
}

//After crop chars
if ( ! function_exists( 'stm_excerpt_more_new' ) ) {
	function stm_excerpt_more_new( $more ) {
		return '...';
	}

	add_filter( 'excerpt_more', 'stm_excerpt_more_new' );
}

if ( ! function_exists( 'stm_custom_pagination' ) ) {
	function stm_custom_pagination() {

		global $wp_query;
		$show_pagination = true;
		if ( ! empty( $wp_query->found_posts ) and ! empty( $wp_query->query_vars['posts_per_page'] ) ) {
			if ( $wp_query->found_posts <= $wp_query->query_vars['posts_per_page'] ) {
				$show_pagination = false;
			}
		}
		if ( $show_pagination ): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="stm-blog-pagination">
						<?php if ( get_previous_posts_link() ) { ?>
							<div class="stm-prev-next stm-prev-btn">
								<?php previous_posts_link( '<i class="fa fa-angle-left"></i>' ); ?>
							</div>
						<?php } else { ?>
							<div class="stm-prev-next stm-prev-btn disabled"><i class="fa fa-angle-left"></i></div>
						<?php }

						echo paginate_links( array(
							'type'      => 'list',
							'prev_next' => false
						) );

						if ( get_next_posts_link() ) { ?>
							<div class="stm-prev-next stm-next-btn">
								<?php next_posts_link( '<i class="fa fa-angle-right"></i>' ); ?>
							</div>
						<?php } else { ?>
							<div class="stm-prev-next stm-next-btn disabled"><i class="fa fa-angle-right"></i></div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php endif;
	}
}

// STM Updater
if ( ! function_exists( 'stm_updater' ) ) {
	function stm_updater() {

		$envato_username = get_theme_mod( 'envato_username' );
		$envato_api_key  = get_theme_mod( 'envato_api' );

		if ( ! empty( $envato_username ) && ! empty( $envato_api_key ) ) {
			$envato_username = trim( $envato_username );
			$envato_api_key  = trim( $envato_api_key );
			if ( ! empty( $envato_username ) && ! empty( $envato_api_key ) ) {
				load_template( get_template_directory() . '/inc/updater/envato-theme-update.php' );

				if ( class_exists( 'Envato_Theme_Updater' ) ) {
					Envato_Theme_Updater::init( $envato_username, $envato_api_key, 'StylemixThemes' );
				}
			}
		}
	}

	add_action( 'after_setup_theme', 'stm_updater' );
}

//Add default taxonomies for the first theme activating
//Only if user dont have them already
function stm_update_listing_options_listing_layout() {
	$stm_listings_update_options = array(
		1  => array(
			'single_name'                          => 'Condition',
			'plural_name'                          => 'Conditions',
			'slug'                                 => 'condition',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
		),
		2  => array(
			'single_name'                          => 'Body',
			'plural_name'                          => 'Bodies',
			'slug'                                 => 'body',
			'font'                                 => 'stm-service-icon-body_type',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'listing_rows_numbers'                 => 'two_cols',
			'enable_checkbox_button'               => false,
		),
		3  => array(
			'single_name'                          => 'Make',
			'plural_name'                          => 'Makes',
			'slug'                                 => 'make',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => true,
		),
		5  => array(
			'single_name'                          => 'Model',
			'plural_name'                          => 'Models',
			'slug'                                 => 'serie',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => true,
		),
		6  => array(
			'single_name'                          => 'Mileage',
			'plural_name'                          => 'Mileages',
			'slug'                                 => 'mileage',
			'font'                                 => 'stm-icon-road',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'number_field_affix'                   => 'mi',
			'enable_checkbox_button'               => false,
		),
		7  => array(
			'single_name'                          => 'Fuel type',
			'plural_name'                          => 'Fuel types',
			'slug'                                 => 'fuel',
			'font'                                 => 'stm-icon-fuel',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
		),
		8  => array(
			'single_name'                          => 'Engine',
			'plural_name'                          => 'Engines',
			'slug'                                 => 'engine',
			'font'                                 => 'stm-icon-engine_fill',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		9  => array(
			'single_name'                          => 'Year',
			'plural_name'                          => 'Years',
			'slug'                                 => 'ca-year',
			'font'                                 => 'stm-icon-road',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		10 => array(
			'single_name'                          => 'Price',
			'plural_name'                          => 'Prices',
			'slug'                                 => 'price',
			'font'                                 => 'stm-icon-road',
			'numeric'                              => true,
			'slider'                               => true,
			'use_on_single_listing_page'           => true,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		11 => array(
			'single_name'                          => 'Fuel consumption',
			'plural_name'                          => 'Fuel consumptions',
			'slug'                                 => 'fuel-consumption',
			'font'                                 => 'stm-icon-fuel',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		12 => array(
			'single_name'                          => 'Transmission',
			'plural_name'                          => 'Transmission',
			'slug'                                 => 'transmission',
			'font'                                 => 'stm-icon-transmission_fill',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
		),
		13 => array(
			'single_name'                          => 'Drive',
			'plural_name'                          => 'Drives',
			'slug'                                 => 'drive',
			'font'                                 => 'stm-icon-drive_2',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
		),
		14 => array(
			'single_name'                          => 'Fuel economy',
			'plural_name'                          => 'Fuel economy',
			'slug'                                 => 'fuel-economy',
			'font'                                 => '',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		15 => array(
			'single_name'                          => 'Exterior Color',
			'plural_name'                          => 'Exterior Colors',
			'slug'                                 => 'exterior-color',
			'font'                                 => 'stm-service-icon-color_type',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		16 => array(
			'single_name'                          => 'Interior Color',
			'plural_name'                          => 'Interior Colors',
			'slug'                                 => 'interior-color',
			'font'                                 => 'stm-service-icon-color_type',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
		),
		17 => array(
			'single_name'                          => 'Features',
			'plural_name'                          => 'Features',
			'slug'                                 => 'features',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'listing_rows_numbers'                 => 'one_col',
			'enable_checkbox_button'               => true,
		),
	);
	update_option( 'stm_vehicle_listing_options', $stm_listings_update_options );
}

function stm_update_motorcycle_options_listing_layout() {
	$stm_listings_update_options = array(
		1  => array(
			'single_name'                          => 'Condition',
			'plural_name'                          => 'Conditions',
			'slug'                                 => 'condition',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		2  => array(
			'single_name'                          => 'Type',
			'plural_name'                          => 'Types',
			'slug'                                 => 'body',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_tabs'                          => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		3  => array(
			'single_name'                          => 'Category',
			'plural_name'                          => 'Categories',
			'slug'                                 => 'category_type',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		4  => array(
			'single_name'                          => 'Brand',
			'plural_name'                          => 'Brands',
			'slug'                                 => 'make',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => true,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		5  => array(
			'single_name'                          => 'Model',
			'plural_name'                          => 'Models',
			'slug'                                 => 'serie',
			'font'                                 => 'icomoon-settings',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		6  => array(
			'single_name'                          => 'Mileage',
			'plural_name'                          => 'Mileages',
			'slug'                                 => 'mileage',
			'font'                                 => '',
			'numeric'                              => true,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'number_field_affix'                   => 'ml',
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		7  => array(
			'single_name'                          => 'Engine',
			'plural_name'                          => 'Engines',
			'slug'                                 => 'engine',
			'font'                                 => '',
			'numeric'                              => true,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		8  => array(
			'single_name'                          => 'Year',
			'plural_name'                          => 'Years',
			'slug'                                 => 'ca-year',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		9  => array(
			'single_name'                          => 'Price',
			'plural_name'                          => 'Prices',
			'slug'                                 => 'price',
			'font'                                 => '',
			'numeric'                              => true,
			'slider'                               => true,
			'use_on_single_listing_page'           => true,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		10 => array(
			'single_name'                          => 'Color',
			'plural_name'                          => 'Colors',
			'slug'                                 => 'exterior-color',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_tabs'                          => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
	);
	update_option( 'stm_vehicle_listing_options', $stm_listings_update_options );
}

function stm_update_boats_options_listing_layout() {
	$stm_listings_update_options = array(
		1 => array(
			'single_name'                          => 'Make',
			'plural_name'                          => 'Makes',
			'slug'                                 => 'make',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter'                    => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		2 => array(
			'single_name'                          => 'Model',
			'plural_name'                          => 'Models',
			'slug'                                 => 'serie',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		3 => array(
			'single_name'                          => 'Condition',
			'plural_name'                          => 'Conditions',
			'slug'                                 => 'condition',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		4 => array(
			'single_name'                          => 'Length',
			'plural_name'                          => 'Length',
			'slug'                                 => 'length_range',
			'font'                                 => 'stm-boats-icon-size',
			'numeric'                              => true,
			'slider'                               => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'number_field_affix'                   => '',
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		5 => array(
			'single_name'                          => 'Year',
			'plural_name'                          => 'Years',
			'slug'                                 => 'ca-year',
			'font'                                 => 'stm-icon-date',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		6 => array(
			'single_name'                          => 'Price',
			'plural_name'                          => 'Prices',
			'slug'                                 => 'price',
			'font'                                 => '',
			'numeric'                              => true,
			'slider'                               => true,
			'use_on_single_listing_page'           => true,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		7 => array(
			'single_name'                          => 'Boat type',
			'plural_name'                          => 'Boat types',
			'slug'                                 => 'boat-type',
			'font'                                 => '',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		8 => array(
			'single_name'                          => 'Fuel type',
			'plural_name'                          => 'Fuel types',
			'slug'                                 => 'fuel',
			'font'                                 => 'stm-icon-fuel',
			'numeric'                              => false,
			'slider'                               => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
		9 => array(
			'single_name'                          => 'Hull material',
			'plural_name'                          => 'Hull materials',
			'slug'                                 => 'hull_material',
			'font'                                 => 'stm-boats-icon-sail',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter'                    => true,
			'use_on_car_filter_links'              => false,
			'use_on_directory_filter_title'        => false,
			'enable_checkbox_button'               => false,
			'use_in_footer_search'                 => false,
		),
	);
	update_option( 'stm_vehicle_listing_options', $stm_listings_update_options );
}

function stm_setup_listing_options() {
	$stm_listings = array(
		1  => array(
			'single_name'                          => 'Condition',
			'plural_name'                          => 'Conditions',
			'slug'                                 => 'condition',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		2  => array(
			'single_name'                          => 'Body',
			'plural_name'                          => 'Bodies',
			'slug'                                 => 'body',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		3  => array(
			'single_name'                          => 'Make',
			'plural_name'                          => 'Makes',
			'slug'                                 => 'make',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => true,
			'use_on_car_filter_links'              => false,
		),
		5  => array(
			'single_name'                          => 'Model',
			'plural_name'                          => 'Models',
			'slug'                                 => 'serie',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		6  => array(
			'single_name'                          => 'Mileage',
			'plural_name'                          => 'Mileages',
			'slug'                                 => 'mileage',
			'font'                                 => 'stm-icon-road',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		7  => array(
			'single_name'                          => 'Fuel type',
			'plural_name'                          => 'Fuel types',
			'slug'                                 => 'fuel',
			'font'                                 => 'stm-icon-fuel',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		8  => array(
			'single_name'                          => 'Engine',
			'plural_name'                          => 'Engines',
			'slug'                                 => 'engine',
			'font'                                 => 'stm-icon-engine_fill',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		9  => array(
			'single_name'                          => 'Year',
			'plural_name'                          => 'Years',
			'slug'                                 => 'ca-year',
			'font'                                 => 'stm-icon-road',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		10 => array(
			'single_name'                          => 'Price',
			'plural_name'                          => 'Prices',
			'slug'                                 => 'price',
			'font'                                 => '',
			'numeric'                              => true,
			'use_on_single_listing_page'           => true,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		11 => array(
			'single_name'                          => 'Fuel consumption',
			'plural_name'                          => 'Fuel consumptions',
			'slug'                                 => 'fuel-consumption',
			'font'                                 => 'stm-icon-fuel',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => false,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		12 => array(
			'single_name'                          => 'Transmission',
			'plural_name'                          => 'Transmission',
			'slug'                                 => 'transmission',
			'font'                                 => 'stm-icon-transmission_fill',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => true,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		13 => array(
			'single_name'                          => 'Drive',
			'plural_name'                          => 'Drives',
			'slug'                                 => 'drive',
			'font'                                 => 'stm-icon-drive_2',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => true,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => true,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		14 => array(
			'single_name'                          => 'Fuel economy',
			'plural_name'                          => 'Fuel economy',
			'slug'                                 => 'fuel-economy',
			'font'                                 => '',
			'numeric'                              => true,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => false,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		15 => array(
			'single_name'                          => 'Exterior Color',
			'plural_name'                          => 'Exterior Colors',
			'slug'                                 => 'exterior-color',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
		16 => array(
			'single_name'                          => 'Interior Color',
			'plural_name'                          => 'Interior Colors',
			'slug'                                 => 'interior-color',
			'font'                                 => '',
			'numeric'                              => false,
			'use_on_single_listing_page'           => false,
			'use_on_car_listing_page'              => false,
			'use_on_car_archive_listing_page'      => false,
			'use_on_single_car_page'               => true,
			'use_on_car_filter'                    => true,
			'use_on_car_modern_filter'             => false,
			'use_on_car_modern_filter_view_images' => false,
			'use_on_car_filter_links'              => false,
		),
	);
	if ( ! get_option( 'stm_vehicle_listing_options' ) ) {
		update_option( 'stm_vehicle_listing_options', $stm_listings );
	}
}

add_action( 'after_switch_theme', 'stm_setup_listing_options' );
add_action( 'load-themes.php', 'stm_setup_listing_options' );

// After import hook and add menu, home page. slider, blog page
if ( ! function_exists( 'stm_importer_done_function' ) ) {
	function stm_importer_done_function() {

		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$locations = get_theme_mod( 'nav_menu_locations' );
		$menus     = wp_get_nav_menus();

		if ( ! empty( $menus ) ) {
			foreach ( $menus as $menu ) {
				if ( is_object( $menu ) ) {
					switch ( $menu->name ) {
						case 'Primary menu':
							$locations['primary'] = $menu->term_id;
							break;
						case 'Top bar menu':
							$locations['top_bar'] = $menu->term_id;
							break;
						case 'Bottom menu':
							$locations['bottom_menu'] = $menu->term_id;
							break;
					}
				}
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations );

		update_option( 'show_on_front', 'page' );

		$chosen_template = get_option( 'stm_motors_chosen_template', 'car_dealer' );

		$inventory_page = get_page_by_title( 'Inventory' );
		if ( isset( $inventory_page->ID ) ) {
			set_theme_mod( 'listing_archive', $inventory_page->ID );
		}

		// Car dealer
		if ( $chosen_template == 'car_dealer' ) {
			$front_page = get_page_by_title( 'Front page' );
			if ( isset( $front_page->ID ) ) {
				update_option( 'page_on_front', $front_page->ID );
			}

			$blog_page = get_page_by_title( 'Newsroom' );
			if ( isset( $blog_page->ID ) ) {
				update_option( 'page_for_posts', $blog_page->ID );
			}

			if ( class_exists( 'RevSlider' ) ) {
				$main_slider = get_template_directory() . '/inc/demo/home_slider.zip';

				if ( file_exists( $main_slider ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $main_slider );
				}
			}
		}

		// Service
		if ( $chosen_template == 'service' ) {
			$front_page = get_page_by_title( 'Home page' );
			if ( isset( $front_page->ID ) ) {
				update_option( 'page_on_front', $front_page->ID );
			}

			if ( class_exists( 'RevSlider' ) ) {
				$main_slider = get_template_directory() . '/inc/demo/service_home_slider.zip';

				if ( file_exists( $main_slider ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $main_slider );
				}
			}
		}

		// Listing
		if ( $chosen_template == 'listing' ) {
			/*Widgets*/
			$widgets_file = get_template_directory() . '/inc/demo/widget_data_listing.json';
			if ( file_exists( $widgets_file ) ) {
				$encode_widgets_array = $wp_filesystem->get_contents( $widgets_file );
				stm_import_widgets( $encode_widgets_array );
			}
			stm_update_listing_options_listing_layout();
			$front_page = get_page_by_title( 'Home page' );
			if ( isset( $front_page->ID ) ) {
				update_option( 'page_on_front', $front_page->ID );
			}

			$blog_page = get_page_by_title( 'Blog' );
			if ( isset( $blog_page->ID ) ) {
				update_option( 'page_for_posts', $blog_page->ID );
			}

			if ( class_exists( 'RevSlider' ) ) {
				$main_slider = get_template_directory() . '/inc/demo/home_slider.zip';

				if ( file_exists( $main_slider ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $main_slider );
				}
			}
		}

		// Boats
		if ( $chosen_template == 'boats' ) {
			/*Widgets*/
			$widgets_file = get_template_directory() . '/inc/demo/widget_data_boats.json';
			if ( file_exists( $widgets_file ) ) {
				$encode_widgets_array = $wp_filesystem->get_contents( $widgets_file );
				stm_import_widgets( $encode_widgets_array );
			}
			stm_update_boats_options_listing_layout();
			$front_page = get_page_by_title( 'Home' );
			if ( isset( $front_page->ID ) ) {
				update_option( 'page_on_front', $front_page->ID );
			}

			$blog_page = get_page_by_title( 'Newsroom' );
			if ( isset( $blog_page->ID ) ) {
				update_option( 'page_for_posts', $blog_page->ID );
			}

			if ( class_exists( 'RevSlider' ) ) {
				$main_slider = get_template_directory() . '/inc/demo/boats_home_slider.zip';

				if ( file_exists( $main_slider ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $main_slider );
				}
			}
		}

		// Motorcycle
		if ( $chosen_template == 'motorcycle' ) {
			stm_update_motorcycle_options_listing_layout();
			$front_page = get_page_by_title( 'Home' );
			if ( isset( $front_page->ID ) ) {
				update_option( 'page_on_front', $front_page->ID );
			}

			$blog_page = get_page_by_title( 'Newsroom' );
			if ( isset( $blog_page->ID ) ) {
				update_option( 'page_for_posts', $blog_page->ID );
			}

			if ( class_exists( 'RevSlider' ) ) {
				$main_slider = get_template_directory() . '/inc/demo/motorcycle_home_slider.zip';

				if ( file_exists( $main_slider ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $main_slider );
				}
			}

			$theme_mods_file = get_template_directory() . '/inc/demo/motorcycle_mods.json';
			if ( file_exists( $theme_mods_file ) ) {
				$encode_theme_mods = $wp_filesystem->get_contents( $theme_mods_file );
				$import_theme_mods = json_decode( $encode_theme_mods, true );
				foreach ( $import_theme_mods as $key => $value ) {
					set_theme_mod( $key, $value );
				}
			}
		}
	}
}

add_action( 'stm_importer_done', 'stm_importer_done_function' );

if ( ! function_exists( 'stm_upload_user_file' ) ) {
	function stm_upload_user_file( $file = array() ) {

		require_once( ABSPATH . 'wp-admin/includes/admin.php' );

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$file_return = wp_handle_upload( $file, array( 'test_form' => false ) );

		if ( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
			return false;
		} else {
			$filename   = $file_return['file'];
			$attachment = array(
				'post_mime_type' => $file_return['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
				'guid'           => $file_return['url']
			);

			$attachment_id = wp_insert_attachment( $attachment, $file_return['file'] );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
			wp_update_attachment_metadata( $attachment_id, $attachment_data );
			if ( 0 < intval( $attachment_id ) ) {
				return $attachment_id;
			}
		}

		return false;
	}
}


// Price delimeter
if ( ! function_exists( 'stm_listing_price_view' ) ) {
	function stm_listing_price_view( $price ) {
		if ( ! empty( $price ) ) {
			$price_label          = stm_get_price_currency();
			$price_label_position = get_theme_mod( 'price_currency_position', 'left' );
			$price_delimeter      = get_theme_mod( 'price_delimeter', ' ' );

			if ( $price_label_position == 'left' ) {
				$response = $price_label . number_format( $price, 0, '', $price_delimeter );
			} else {
				$response = number_format( $price, 0, '', $price_delimeter ) . $price_label;
			}

			return $response;
		}
	}
}

if ( ! function_exists( 'stm_get_current_layout' ) ) {
	function stm_get_current_layout() {
		$layout = get_option( 'stm_motors_chosen_template' );

		if ( empty( $layout ) ) {
			$layout = 'car_dealer';
		}

		return $layout;
	}
}

if ( ! function_exists( 'stm_dev_array_print' ) ) {
	function stm_dev_array_print( $array ) {
		echo '<pre>';
		print_r( $array );
		echo '</pre>';
	}
}

if ( ! function_exists( 'stm_enable_location' ) ) {
	function stm_enable_location() {
		$enable_location = get_theme_mod( 'enable_location', true );

		return $enable_location;
	}
}

if ( ! function_exists( 'stm_distance_measure_unit' ) ) {
	function stm_distance_measure_unit() {
		$distance_measure = get_theme_mod( 'distance_measure_unit', 'miles' );
		$distance_affix   = esc_html__( 'mi', 'motors' );

		if ( $distance_measure == 'kilometers' ) {
			$distance_affix = esc_html__( 'km', 'motors' );
		}

		return $distance_affix;
	}
}

if ( ! function_exists( 'stm_calculate_distance_between_two_points' ) ) {
	function stm_calculate_distance_between_two_points( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo ) {
		$distance_measure = get_theme_mod( 'distance_measure_unit', 'miles' );

		$latitudeFrom  = esc_attr( floatval( $latitudeFrom ) );
		$longitudeFrom = esc_attr( floatval( $longitudeFrom ) );

		$distance_affix = stm_distance_measure_unit();

		$theta = $longitudeFrom - $longitudeTo;
		$dist  = sin( deg2rad( $latitudeFrom ) ) * sin( deg2rad( $latitudeTo ) ) + cos( deg2rad( $latitudeFrom ) ) * cos( deg2rad( $latitudeTo ) ) * cos( deg2rad( $theta ) );
		$dist  = acos( $dist );
		$dist  = rad2deg( $dist );
		$dist  = $dist * 60 * 1.515;
		if ( $distance_measure == 'kilometers' ) {
			$dist = $dist * 1.609344;
		}

		return round( $dist, 1 ) . ' ' . $distance_affix;
	}
}


//Location Filter hook
if ( ! function_exists( 'stm_edit_join_posts' ) ) {
	function stm_edit_join_posts( $join_paged_statement ) {

		global $wpdb;
		$table_prefix = $wpdb->prefix;


		$join_paged_statement .= " INNER JOIN " . $table_prefix . "postmeta stm_lat_prefix ON (" . $table_prefix . "posts.ID = stm_lat_prefix.post_id AND stm_lat_prefix.meta_key = 'stm_lat_car_admin')";
		$join_paged_statement .= " INNER JOIN " . $table_prefix . "postmeta stm_lng_prefix ON (" . $table_prefix . "posts.ID = stm_lng_prefix.post_id AND stm_lng_prefix.meta_key = 'stm_lng_car_admin') ";

		return $join_paged_statement;

		remove_filter( 'posts_join_paged', 'stm_edit_join_posts' );
	}
}

if ( ! function_exists( 'stm_show_filter_by_location' ) ) {
	function stm_show_filter_by_location( $orderby ) {

		$lat_from = esc_attr( floatval( $_GET['stm_lat'] ) );
		$lng_from = esc_attr( floatval( $_GET['stm_lng'] ) );


		$orderby = "(6378.137 * ACOS(COS(RADIANS(stm_lat_prefix.meta_value))*COS(RADIANS(" . $lat_from . "))*COS(RADIANS(stm_lng_prefix.meta_value)-RADIANS(" . $lng_from . "))+SIN(RADIANS(stm_lat_prefix.meta_value))*SIN(RADIANS(" . $lat_from . "))))*1.3 ASC";

		return $orderby;

		remove_filter( 'posts_orderby', 'stm_show_filter_by_location' );
	}
}

if ( ! function_exists( 'stm_location_validates' ) ) {
	function stm_location_validates() {
		if ( isset( $_GET['stm_lng'] ) and isset( $_GET['stm_lat'] ) and ! empty( $_GET['ca_location'] ) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'stm_modify_query_location' ) ) {
	function stm_modify_query_location() {
		if ( stm_location_validates() ) {
			add_filter( 'posts_join_paged', 'stm_edit_join_posts' );
			add_filter( 'posts_orderby', 'stm_show_filter_by_location' );
		}
	}
}

if ( ! function_exists( 'stm_generate_title_from_slugs' ) ) {
	function stm_generate_title_from_slugs( $post_id, $show_labels = false ) {
		$title_from = get_theme_mod( 'listing_directory_title_frontend', '{make} {serie} {ca-year}' );

		$title_return = '';

		if ( ! empty( $title_from ) and stm_is_listing() ) {
			$title = stm_replace_curly_brackets( $title_from );

			$title_counter = 0;

			if ( ! empty( $title ) ) {
				foreach ( $title as $title_part ) {
					$term = wp_get_post_terms( $post_id, strtolower( $title_part ), array( 'orderby' => 'none' ) );
					if ( ! empty( $term ) ) {
						if ( ! empty( $term[0] ) ) {
							if ( ! empty( $term[0]->name ) ) {
								$title_counter ++;

								if ( $title_counter == 1 ) {
									if ( $show_labels ) {
										$title_return .= '<div class="labels">';
									}
									$title_return .= $term[0]->name;
								} else {
									$title_return .= ' ' . $term[0]->name;
									if ( $show_labels and $title_counter == 2 ) {
										$title_return .= '</div>';
									}
								}
							} else {
								$number_affix = get_post_meta( $post_id, strtolower( $title_part ), true );
								if ( ! empty( $number_affix ) ) {
									$title_return .= ' ' . $number_affix;
								}
							}
						}
					} else {
						$number_affix = get_post_meta( $post_id, strtolower( $title_part ), true );
						if ( ! empty( $number_affix ) ) {
							$title_return .= ' ' . $number_affix;
						}
					}
				}
			}
		} elseif ( ! empty( $title_from ) and stm_is_boats() ) {
			$title = stm_replace_curly_brackets( $title_from );

			if ( ! empty( $title ) ) {
				foreach ( $title as $title_part ) {
					$value = get_post_meta( $post_id, $title_part, true );
					if ( ! empty( $value ) ) {
						$cat = get_term_by( 'slug', $value, $title_part );
						if ( ! is_wp_error( $cat ) and ! empty( $cat->name ) ) {
							$title_return .= $cat->name . ' ';
						} else {
							$title_return .= $value . ' ';
						}
					}
				}
			}
		} elseif ( ! empty( $title_from ) and stm_is_motorcycle() ) {
			$title = stm_replace_curly_brackets( $title_from );

			$title_counter = 0;

			if ( ! empty( $title ) ) {
				foreach ( $title as $title_part ) {
					$value = get_post_meta( $post_id, $title_part, true );
					$title_counter ++;

					if ( ! empty( $value ) ) {
						$cat = get_term_by( 'slug', $value, $title_part );
						if ( ! is_wp_error( $cat ) and ! empty( $cat->name ) ) {
							if ( $title_counter == 1 and $show_labels ) {
								$title_return .= '<span class="stm-label-title">';
							}
							$title_return .= $cat->name . ' ';
							if ( $title_counter == 1 and $show_labels ) {
								$title_return .= '</span>';
							}
						} else {
							if ( $title_counter == 1 and $show_labels ) {
								$title_return .= '<span class="stm-label-title">';
							}
							$title_return .= $value . ' ';
							if ( $title_counter == 1 and $show_labels ) {
								$title_return .= '</span>';
							}
						}
					}
				}
			}
		}

		if ( empty( $title_return ) ) {
			$title_return = get_the_title( $post_id );
		}

		return $title_return;
	}
}

if ( ! function_exists( 'stm_replace_curly_brackets' ) ) {
	function stm_replace_curly_brackets( $string ) {
		$matches = array();
		preg_match_all( '/{(.*?)}/', $string, $matches );

		return $matches[1];
	}
}

if ( ! function_exists( 'stm_check_if_car_imported' ) ) {
	function stm_check_if_car_imported( $id ) {
		$return = false;
		if ( ! empty( $id ) ) {
			$has_id = get_post_meta( $id, 'automanager_id', true );
			if ( ! empty( $has_id ) ) {
				$return = true;
			} else {
				$return = false;
			}
		}

		return $return;
	}
}

if ( ! function_exists( 'stm_get_car_medias' ) ) {
	function stm_get_car_medias( $post_id ) {
		if ( ! empty( $post_id ) ) {

			$image_limit = '';

			if ( stm_pricing_enabled() ) {
				$user_added = get_post_meta( $post_id, 'stm_car_user', true );
				if ( ! empty( $user_added ) ) {
					$limits      = stm_get_post_limits( $user_added );
					$image_limit = $limits['images'];
				}
			}
			$car_media = array();

			//Photo
			$car_photos  = array();
			$car_gallery = get_post_meta( $post_id, 'gallery', true );

			if ( has_post_thumbnail( $post_id ) ) {
				$car_photos[] = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
			}

			if ( ! empty( $car_gallery ) ) {
				$i = 0;
				foreach ( $car_gallery as $car_gallery_image ) {
					if ( empty( $image_limit ) ) {
						$car_photos[] = wp_get_attachment_url( $car_gallery_image );
					} else {
						$i ++;
						if ( $i < $image_limit ) {
							$car_photos[] = wp_get_attachment_url( $car_gallery_image );
						}
					}
				}
			}

			$car_media['car_photos']       = $car_photos;
			$car_media['car_photos_count'] = count( $car_photos );

			//Video
			$car_video      = array();
			$car_video_main = get_post_meta( $post_id, 'gallery_video', true );
			$car_videos     = get_post_meta( $post_id, 'gallery_videos', true );

			if ( ! empty( $car_video_main ) ) {
				$car_video[] = $car_video_main;
			}

			if ( ! empty( $car_videos ) ) {
				foreach ( $car_videos as $car_video_single ) {
					$car_video[] = $car_video_single;
				}
			}

			$car_media['car_videos']       = $car_video;
			$car_media['car_videos_count'] = count( $car_video );

			return $car_media;
		}
	}
}

if ( ! function_exists( 'stm_get_footer_terms' ) ) {
	function stm_get_footer_terms() {
		$taxonomies        = stm_get_footer_taxonomies();
		$terms             = array();
		$terms_slugs       = array();
		$tax_slug          = array();
		$tax_names         = array();
		$input_placeholder = esc_html__( 'Enter', 'motors' );


		$response = array();

		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $tax_key => $taxonomy ) {
				if ( ! empty( $taxonomy['slug'] ) ) {
					if ( $tax_key < 2 ) {
						$tax_names[] = $taxonomy['single_name'];
					}
					$tmp_terms = get_terms( $taxonomy['slug'] );
					foreach ( $tmp_terms as $tmp_term ) {
						if ( ! empty( $tmp_term->name ) ) {
							$terms[]       = $tmp_term->name;
							$terms_slugs[] = $tmp_term->slug;
							$tax_slug[]    = $taxonomy['slug'];
						}
					}
				}
			}
		}

		$input_placeholder .= ' ' . implode( ' ' . esc_html__( 'or', 'motors' ) . ' ', $tax_names );

		$response['names']       = $terms;
		$response['slugs']       = $terms_slugs;
		$response['tax']         = $tax_slug;
		$response['placeholder'] = $input_placeholder;

		return $response;
	}
}

if ( ! function_exists( 'stm_get_author_link' ) ) {
	function stm_get_author_link( $id = 'register' ) {

		if ( $id == 'register' ) {
			$login_page = get_theme_mod( 'login_page', 1718 );
			if ( function_exists( 'icl_object_id' ) ) {
				$id = icl_object_id( $login_page, 'page', false, ICL_LANGUAGE_CODE );
				if ( is_page( $id ) ) {
					$login_page = $id;
				}
			}

			$link = get_permalink( $login_page );
		} else {
			if ( empty( $id ) or $id == 'myself-view' ) {
				$user = wp_get_current_user();
				if ( ! is_wp_error( $user ) ) {
					$link = get_author_posts_url( $user->data->ID );
					if ( $id == 'myself-view' ) {
						$link = add_query_arg( array( 'view-myself' => 1 ), $link );
					}
				} else {
					$link = '';
				}
			} else {
				$link = get_author_posts_url( $id );
			}
		}

		return $link;
	}
}

if ( ! function_exists( 'stm_user_listings_query' ) ) {
	function stm_user_listings_query( $user_id, $status = "publish", $per_page = - 1, $popular = false, $offset = 0, $data_desc = false ) {
		$args = array(
			'post_type'      => stm_listings_post_type(),
			'post_status'    => $status,
			'posts_per_page' => $per_page,
			'offset'         => $offset,
			'meta_query'     => array(
				array(
					'key'     => 'stm_car_user',
					'value'   => $user_id,
					'compare' => '='
				)
			)
		);

		if ( $popular ) {
			$args['order']   = 'ASC';
			$args['orderby'] = 'stm_car_views';
		}

		$query = new WP_Query( $args );
		wp_reset_postdata();

		return $query;

	}
}

if ( ! function_exists( 'stm_get_user_role' ) ) {
	function stm_get_user_role( $user_id ) {
		$response = false;

		$user_data = get_userdata( $user_id );

		if ( ! empty( $user_data ) ) {
			$roles = $user_data->roles;


			if ( in_array( 'stm_dealer', $roles ) ) {
				$response = true;
			}
		}

		return $response;
	}
}

if ( ! function_exists( 'stm_get_user_custom_fields' ) ) {
	function stm_get_user_custom_fields( $user_id ) {
		$response = array();

		if ( empty( $user_id ) ) {
			$user_current = wp_get_current_user();
			$user_id      = $user_current->ID;
		}

		//Phone
		$user_phone = '';
		$user_phone = get_the_author_meta( 'stm_phone', $user_id );

		$user_mail = '';
		$user_mail = get_the_author_meta( 'email', $user_id );

		$user_show_mail = '';
		$user_show_mail = get_the_author_meta( 'stm_show_email', $user_id );

		$user_name = '';
		$user_name = get_the_author_meta( 'first_name', $user_id );

		$user_last_name = '';
		$user_last_name = get_the_author_meta( 'last_name', $user_id );

		//Image
		$user_image = '';
		$user_image = get_the_author_meta( 'stm_user_avatar', $user_id );


		//Socials
		$socials      = array( 'facebook', 'twitter', 'linkedin', 'youtube' );
		$user_socials = array();
		foreach ( $socials as $social ) {
			$user_soc = get_the_author_meta( 'stm_user_' . $social, $user_id );
			if ( ! empty( $user_soc ) ) {
				$user_socials[ $social ] = $user_soc;
			}
		}

		$response['user_id']   = $user_id;
		$response['phone']     = $user_phone;
		$response['image']     = $user_image;
		$response['name']      = $user_name;
		$response['last_name'] = $user_last_name;
		$response['socials']   = $user_socials;
		$response['email']     = $user_mail;
		$response['show_mail'] = $user_show_mail;

		/*Dealer fields*/
		$logo = '';
		$logo = get_the_author_meta( 'stm_dealer_logo', $user_id );

		$dealer_image = '';
		$dealer_image = get_the_author_meta( 'stm_dealer_image', $user_id );

		$license = '';
		$license = get_the_author_meta( 'stm_company_license', $user_id );

		$website = '';
		$website = get_the_author_meta( 'stm_website_url', $user_id );

		$location = '';
		$location = get_the_author_meta( 'stm_dealer_location', $user_id );

		$location_lat = '';
		$location_lat = get_the_author_meta( 'stm_dealer_location_lat', $user_id );

		$location_lng = '';
		$location_lng = get_the_author_meta( 'stm_dealer_location_lng', $user_id );

		$stm_company_name = '';
		$stm_company_name = get_the_author_meta( 'stm_company_name', $user_id );

		$stm_company_license = '';
		$stm_company_license = get_the_author_meta( 'stm_company_license', $user_id );

		$stm_message_to_user = '';
		$stm_message_to_user = get_the_author_meta( 'stm_message_to_user', $user_id );

		$stm_sales_hours = '';
		$stm_sales_hours = get_the_author_meta( 'stm_sales_hours', $user_id );

		$stm_seller_notes = '';
		$stm_seller_notes = get_the_author_meta( 'stm_seller_notes', $user_id );

		$stm_payment_status = '';
		$stm_payment_status = get_the_author_meta( 'stm_payment_status', $user_id );


		$response['logo']                = $logo;
		$response['dealer_image']        = $dealer_image;
		$response['license']             = $license;
		$response['website']             = $website;
		$response['location']            = $location;
		$response['location_lat']        = $location_lat;
		$response['location_lng']        = $location_lng;
		$response['stm_company_name']    = $stm_company_name;
		$response['stm_company_license'] = $stm_company_license;
		$response['stm_message_to_user'] = $stm_message_to_user;
		$response['stm_sales_hours']     = $stm_sales_hours;
		$response['stm_seller_notes']    = $stm_seller_notes;
		$response['stm_payment_status']  = $stm_payment_status;


		return $response;


	}
}

function stm_send_cf7_message_to_user( $wpcf ) {

	if ( ! empty( $_POST['stm_changed_recepient'] ) ) {

		$mail = $wpcf->prop( 'mail' );

		$mail_to = get_the_author_meta( 'email', intval( $_POST['stm_changed_recepient'] ) );

		if ( ! empty( $mail_to ) ) {
			$mail['recipient'] = sanitize_email( $mail_to );
			$wpcf->set_properties( array( 'mail' => $mail ) );
		}

	}

	return $wpcf;
}

add_action( "wpcf7_before_send_mail", "stm_send_cf7_message_to_user", 8, 1 );

function stm_single_car_counter() {
	if ( is_singular( stm_listings_post_type() ) ) {
		//Views
		$cookies = '';

		if ( empty( $_COOKIE['stm_car_watched'] ) ) {
			$cookies = get_the_ID();
			setcookie( 'stm_car_watched', $cookies, time() + ( 86400 * 30 ), '/' );
			stm_increase_rating( get_the_ID() );
		}

		if ( ! empty( $_COOKIE['stm_car_watched'] ) ) {
			$cookies = $_COOKIE['stm_car_watched'];
			$cookies = explode( ',', $cookies );

			if ( ! in_array( get_the_ID(), $cookies ) ) {
				$cookies[] = get_the_ID();

				$cookies = implode( ',', $cookies );

				stm_increase_rating( get_the_ID() );
				setcookie( 'stm_car_watched', $cookies, time() + ( 86400 * 30 ), '/' );
			}
		}

		if ( ! empty( $_COOKIE['stm_car_watched'] ) ) {
			$watched = explode( ',', $_COOKIE['stm_car_watched'] );
		}
	}
}

function stm_increase_rating( $post_id ) {
	$current_rating = intval( get_post_meta( $post_id, 'stm_car_views', true ) );
	if ( empty( $current_rating ) ) {
		update_post_meta( $post_id, 'stm_car_views', 1 );
	} else {
		$current_rating = $current_rating + 1;
		update_post_meta( $post_id, 'stm_car_views', $current_rating );
	}
}

add_action( 'wp', 'stm_single_car_counter', 10, 1 );

if ( ! function_exists( 'stm_force_favourites' ) ) {
	function stm_force_favourites( $user_id ) {

		$user_exist_fav = get_the_author_meta( 'stm_user_favourites', $user_id );
		if ( ! empty( $user_exist_fav ) ) {
			$user_exist_fav = explode( ',', $user_exist_fav );
		} else {
			$user_exist_fav = array();
		}

		if ( ! empty( $_COOKIE['stm_car_favourites'] ) ) {
			$cookie_fav = explode( ',', $_COOKIE['stm_car_favourites'] );
			setcookie( 'stm_car_favourites', '', time() - 3600, '/' );
		} else {
			$cookie_fav = array();
		}

		if ( ! empty( $user_exist_fav ) or ! empty( $cookie_fav ) ) {
			$new_fav = implode( ',', array_unique( array_merge( $user_exist_fav, $cookie_fav ) ) );
			if ( ! empty( $new_fav ) ) {
				update_user_meta( $user_id, 'stm_user_favourites', $new_fav );
			}
		}
	}
}

if ( ! function_exists( 'stm_edit_delete_user_car' ) ) {
	function stm_edit_delete_user_car() {

		$demo = stm_is_site_demo_mode();
		if ( ! $demo ) {


			if ( ! empty( $_GET['stm_disable_user_car'] ) ) {
				$car = intval( $_GET['stm_disable_user_car'] );

				$author = get_post_meta( $car, 'stm_car_user', true );
				$user   = wp_get_current_user();

				if ( intval( $author ) == intval( $user->ID ) ) {
					$status = get_post_status( $car );
					if ( $status == 'publish' ) {
						$disabled_car = array(
							'ID'          => $car,
							'post_status' => 'draft'
						);

						wp_update_post( $disabled_car );
					}
				}
			}

			if ( ! empty( $_GET['stm_enable_user_car'] ) ) {
				$car = intval( $_GET['stm_enable_user_car'] );

				$author = get_post_meta( $car, 'stm_car_user', true );
				$user   = wp_get_current_user();

				if ( intval( $author ) == intval( $user->ID ) ) {
					$status = get_post_status( $car );
					if ( $status == 'draft' ) {
						$disabled_car = array(
							'ID'          => $car,
							'post_status' => 'publish'
						);

						$can_update = true;

						if ( stm_pricing_enabled() ) {
							$user_limits = stm_get_post_limits( $user->ID );
							if ( ! $user_limits['posts'] ) {
								$can_update = false;
							}
						}

						if ( $can_update ) {
							wp_update_post( $disabled_car );
						} else {
							add_action( 'wp_enqueue_scripts', 'stm_user_out_of_limit' );
							function stm_user_out_of_limit() {
								$field_limit = 'jQuery(document).ready(function(){';
								$field_limit .= 'jQuery(".stm-no-available-adds-overlay, .stm-no-available-adds").removeClass("hidden");';
								$field_limit .= 'jQuery(".stm-no-available-adds-overlay").click(function(){';
								$field_limit .= 'jQuery(".stm-no-available-adds-overlay, .stm-no-available-adds").addClass("hidden")';
								$field_limit .= '});';
								$field_limit .= '});';
								wp_add_inline_script( 'stm-theme-scripts', $field_limit );
							}
						}
					}
				}
			}

			if ( ! empty( $_GET['stm_move_trash_car'] ) ) {
				$car = intval( $_GET['stm_move_trash_car'] );

				$author = get_post_meta( $car, 'stm_car_user', true );
				$user   = wp_get_current_user();

				if ( intval( $author ) == intval( $user->ID ) ) {
					if ( get_post_status( $car ) == 'draft' or get_post_status( $car ) == 'pending' ) {

						wp_trash_post( $car, false );

					}
				}
			}
		}
	}
}

add_action( 'wp', 'stm_edit_delete_user_car' );

if ( ! function_exists( 'stm_filter_display_name' ) ) {
	function stm_filter_display_name( $display_name, $user_id, $user_login = '', $f_name = '', $l_name = '' ) {
		$user = get_userdata( $user_id );

		if ( empty( $user_login ) ) {
			$login = $user->data->user_login;
		} else {
			$login = $user_login;
		}
		if ( empty( $f_name ) ) {
			$first_name = get_the_author_meta( 'first_name', $user_id );
		} else {
			$first_name = $f_name;
		}

		if ( empty( $l_name ) ) {
			$last_name = get_the_author_meta( 'last_name', $user_id );
		} else {
			$last_name = $l_name;
		}

		$display_name = $login;

		if ( ! empty( $first_name ) ) {
			$display_name = $first_name;
		}

		if ( ! empty( $first_name ) and ! empty( $last_name ) ) {
			$display_name .= ' ' . $last_name;
		}

		if ( empty( $first_name ) and ! empty( $last_name ) ) {
			$display_name = $last_name;
		}

		if ( in_array( 'stm_dealer', $user->roles ) ) {
			$company_name = get_the_author_meta( 'stm_company_name', $user_id );
			if ( ! empty( $company_name ) ) {
				return ( $company_name );
			} else {
				return ( $display_name );
			}
		} else {
			return ( $display_name );
		}
	}

	add_filter( 'stm_filter_display_user_name', 'stm_filter_display_name', 20, 5 );
}

if ( ! function_exists( 'stm_get_add_page_url' ) ) {
	function stm_get_add_page_url( $edit = '', $post_id = '' ) {
		$page_id   = get_theme_mod( 'user_add_car_page', 1755 );
		$page_link = '';

		if ( ! empty( $page_id ) ) {
			if ( function_exists( 'icl_object_id' ) ) {
				$id = icl_object_id( $page_id, 'page', false, ICL_LANGUAGE_CODE );
				if ( is_page( $id ) ) {
					$page_id = $id;
				}
			}

			$page_link = get_permalink( $page_id );
		}


		if ( $edit == 'edit' and ! empty( $post_id ) ) {
			return esc_url( add_query_arg( array( 'edit_car' => '1', 'item_id' => intval( $post_id ) ), $page_link ) );
		} else {
			return esc_url( $page_link );
		}
	}
}


//Add car helpers
if ( ! function_exists( 'stm_add_a_car_addition_fields' ) ) {
	function stm_add_a_car_addition_fields( $get_params = false, $histories = '', $post_id = '' ) {
		$show_registered = get_theme_mod( 'show_registered', true );
		$show_vin        = get_theme_mod( 'show_vin', true );
		$show_history    = get_theme_mod( 'show_history', true );
		$enable_location = get_theme_mod( 'enable_location', true );

		if ( ! $get_params ) {
			if ( $show_registered ) { ?>
				<?php
				$data_value = get_post_meta( $post_id, 'registration_date', true );
				?>
				<div class="stm-form-1-quarter stm_registration_date">
					<input type="text" name="stm_registered"
						   class="stm-years-datepicker<?php if ( ! empty( $data_value ) ) {
							   echo ' stm_has_value';
						   } ?>"
						   placeholder="<?php esc_html_e( 'Enter date', 'motors' ); ?>"
						   value="<?php echo esc_attr( $data_value ); ?>"/>
					<div class="stm-label">
						<i class="stm-icon-key"></i>
						<?php esc_html_e( 'Registered', 'motors' ); ?>
					</div>
				</div>
			<?php }
			if ( $show_vin ) { ?>
				<?php
				$data_value = get_post_meta( $post_id, 'vin_number', true );
				?>
				<div class="stm-form-1-quarter stm_vin">
					<input type="text"
						   name="stm_vin"
						<?php if ( ! empty( $data_value ) ) { ?> class="stm_has_value" <?php } ?>
						   value="<?php echo esc_attr( $data_value ); ?>"
						   placeholder="<?php esc_html_e( 'Enter VIN', 'motors' ); ?>"/>

					<div class="stm-label">
						<i class="stm-service-icon-vin_check"></i>
						<?php esc_html_e( 'VIN', 'motors' ); ?>
					</div>
				</div>
			<?php }
			if ( $show_history ) { ?>
				<?php
				$data_value      = get_post_meta( $post_id, 'history', true );
				$data_value_link = get_post_meta( $post_id, 'history_link', true );
				?>
				<div class="stm-form-1-quarter stm_history">
					<input type="text"
						   name="stm_history_label"
						   class="<?php echo ( ! empty( $data_value ) ) ? 'stm_has_value' : ''; ?>"
						   value="<?php echo esc_attr( $data_value ) ?>"
						   placeholder="<?php esc_html_e( 'Vehicle History Report', 'motors' ); ?>"/>
					<div class="stm-label">
						<i class="stm-icon-time"></i>
						<?php esc_html_e( 'History', 'motors' ); ?>
					</div>

					<div class="stm-history-popup stm-invisible">
						<div class="inner">
							<i class="fa fa-remove"></i>
							<h5><?php esc_html_e( 'Vehicle history', 'motors' ); ?></h5>
							<?php if ( ! empty( $histories ) ):
								$histories = explode( ',', $histories );
								if ( ! empty( $histories ) ):
									echo '<div class="labels-units">';
									foreach ( $histories as $history ): ?>
										<label>
											<input type="radio" name="stm_chosen_history"
												   value="<?php echo esc_attr( $history ); ?>"/>
											<span><?php echo esc_attr( $history ); ?></span>
										</label>
									<?php endforeach;
									echo '</div>';
								endif;
							endif; ?>
							<input type="text" name="stm_history_link"
								   placeholder="<?php esc_html_e( 'Insert link', 'motors' ) ?>"
								   value="<?php echo esc_url( $data_value_link ); ?>"/>
							<a href="#" class="button"><?php esc_html_e( 'Apply', 'motors' ); ?></a>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function () {
						var $ = jQuery;
						var $stm_handler = $('.stm-form-1-quarter.stm_history input[name="stm_history_label"]');
						$stm_handler.focus(function () {
							$('.stm-history-popup').removeClass('stm-invisible');
						});

						$('.stm-history-popup .button').click(function (e) {
							e.preventDefault();
							$('.stm-history-popup').addClass('stm-invisible');

							if ($('input[name=stm_chosen_history]:radio:checked').length > 0) {
								$stm_checked = $('input[name=stm_chosen_history]:radio:checked').val();
							} else {
								$stm_checked = '';
							}

							$stm_handler.val($stm_checked);
						})

						$('.stm-history-popup .fa-remove').click(function () {
							$('.stm-history-popup').addClass('stm-invisible');
						});
					});
				</script>
			<?php }
			if ( $enable_location ) { ?>
				<?php
				$data_value     = get_post_meta( $post_id, 'stm_car_location', true );
				$data_value_lat = get_post_meta( $post_id, 'stm_lat_car_admin', true );
				$data_value_lng = get_post_meta( $post_id, 'stm_lng_car_admin', true );
				?>
				<div class="stm-form-1-quarter stm_location stm-location-search-unit">
					<input type="text"
						   name="stm_location_text"
						<?php if ( ! empty( $data_value ) ) { ?> class="stm_has_value" <?php } ?>
						   id="stm-add-car-location"
						   value="<?php echo esc_attr( $data_value ); ?>"
						   placeholder="<?php esc_html_e( 'Enter ZIP or Address', 'motors' ); ?>"/>

					<input type="hidden" name="stm_lat" value="<?php echo esc_attr( $data_value_lat ); ?>"/>
					<input type="hidden" name="stm_lng" value="<?php echo esc_attr( $data_value_lng ); ?>"/>

					<div class="stm-label">
						<i class="stm-service-icon-pin_2"></i>
						<?php esc_html_e( 'Location', 'motors' ); ?>
					</div>
				</div>
			<?php }
		} else {

			$additional_fields = array();
			if ( $show_registered ) {
				$additional_fields[] = 'stm_registered';
			}
			if ( $show_vin ) {
				$additional_fields[] = 'stm_vin';
			}
			if ( $show_history ) {
				$additional_fields[] = 'stm_history';
			}
			if ( $enable_location ) {
				$additional_fields[] = 'stm_location';
			}

			return $additional_fields;
		}
	}
}

if ( ! function_exists( 'stm_add_a_car_features' ) ) {
	function stm_add_a_car_features( $user_features, $get_params = false, $post_id = '' ) {
		if ( ! empty( $user_features ) ) {
			if ( ! $get_params ) {
				if ( ! empty( $post_id ) ) {
					$features_car = get_post_meta( $post_id, 'additional_features', true );
					$features_car = explode( ',', $features_car );

				} else {
					$features_car = array();
				}
				foreach ( $user_features as $user_feature ) { ?>
					<div class="stm-single-feature">
						<div class="heading-font"><?php echo $user_feature['tab_title_single']; ?></div>
						<?php $features = explode( ',', $user_feature['tab_title_labels'] ); ?>
						<?php if ( ! empty( $features ) ): ?>
							<?php foreach ( $features as $feature ): ?>
								<?php
								$checked = '';
								if ( in_array( $feature, $features_car ) ) {
									$checked = 'checked';
								};
								?>
								<div class="feature-single">
									<label>
										<input type="checkbox" value="<?php echo esc_attr( $feature ); ?>"
											   name="stm_car_features_labels[]" <?php echo $checked; ?>/>
										<span><?php echo esc_attr( $feature ); ?></span>
									</label>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				<?php }
			}
		}
	}
}


if ( ! function_exists( 'stm_get_dealer_marks' ) ) {
	function stm_get_dealer_marks( $dealer_id = '' ) {
		if ( ! empty( $dealer_id ) ) {
			$args = array(
				'post_type'      => 'dealer_review',
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'     => 'stm_review_added_on',
						'value'   => intval( $dealer_id ),
						'compare' => '='
					)
				)
			);

			$query = new WP_Query( $args );

			$ratings = array(
				'average'     => 0,
				'rate1'       => 0,
				'rate1_label' => get_theme_mod( 'dealer_rate_1', esc_html__( 'Customer Service', 'motors' ) ),
				'rate2'       => 0,
				'rate2_label' => get_theme_mod( 'dealer_rate_2', esc_html__( 'Buying Process', 'motors' ) ),
				'rate3'       => 0,
				'rate3_label' => get_theme_mod( 'dealer_rate_3', esc_html__( 'Overall Experience', 'motors' ) ),
				'likes'       => 0,
				'dislikes'    => 0,
				'count'       => 0
			);

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$rate1           = get_post_meta( get_the_id(), 'stm_rate_1', true );
					$rate2           = get_post_meta( get_the_id(), 'stm_rate_2', true );
					$rate3           = get_post_meta( get_the_id(), 'stm_rate_3', true );
					$stm_recommended = get_post_meta( get_the_id(), 'stm_recommended', true );

					if ( ! empty( $rate1 ) ) {
						$ratings['rate1'] = intval( $ratings['rate1'] ) + intval( $rate1 );
					}
					if ( ! empty( $rate2 ) ) {
						$ratings['rate2'] = intval( $ratings['rate2'] ) + intval( $rate2 );
					}
					if ( ! empty( $rate1 ) ) {
						$ratings['rate3'] = intval( $ratings['rate3'] ) + intval( $rate3 );
					}

					if ( $stm_recommended == 'yes' ) {
						$ratings['likes'] ++;
					}

					if ( $stm_recommended == 'no' ) {
						$ratings['dislikes'] ++;
					}
				}
				$total            = $query->found_posts;
				$ratings['count'] = $total;

				$average_num = 0;

				if ( empty( $ratings['rate1_label'] ) ) {
					$ratings['rate1'] = 0;
				} else {
					$ratings['rate1'] = round( $ratings['rate1'] / $ratings['count'], 1 );

					$ratings['rate1_width'] = ( ( $ratings['rate1'] * 100 ) / 5 ) . '%';

					$ratings['average'] = $ratings['average'] + $ratings['rate1'];

					$average_num ++;
				}

				if ( empty( $ratings['rate2_label'] ) ) {
					$ratings['rate2'] = 0;
				} else {
					$ratings['rate2'] = round( $ratings['rate2'] / $ratings['count'], 1 );

					$ratings['rate2_width'] = ( ( $ratings['rate2'] * 100 ) / 5 ) . '%';

					$ratings['average'] = $ratings['average'] + $ratings['rate2'];

					$average_num ++;
				}

				if ( empty( $ratings['rate3_label'] ) ) {
					$ratings['rate3'] = 0;
				} else {
					$ratings['rate3'] = round( $ratings['rate3'] / $ratings['count'], 1 );

					$ratings['rate3_width'] = ( ( $ratings['rate3'] * 100 ) / 5 ) . '%';

					$ratings['average'] = $ratings['average'] + $ratings['rate3'];

					$average_num ++;
				}

				$ratings['average']       = number_format( round( $ratings['average'] / $average_num, 1 ), '1', '.', '' );
				$ratings['average_width'] = ( ( $ratings['average'] * 100 ) / 5 ) . '%';

				if ( empty( $ratings['rate1_label'] ) and empty( $ratings['rate2_label'] ) and empty( $ratings['rate3_label'] ) ) {
					$ratings['average'] = 0;
				}

				wp_reset_postdata();
			}


			return $ratings;
		}
	}
}

if ( ! function_exists( 'stm_dealer_gmap' ) ) {
	function stm_dealer_gmap( $lat, $lng ) {
		?>

		<div id="stm-dealer-gmap"></div>

		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				google.maps.event.addDomListener(window, 'load', init);

				var center, map;

				function init() {
					center = new google.maps.LatLng(<?php echo esc_js( $lat ); ?>, <?php echo esc_js( $lng ); ?>);
					var mapOptions = {
						zoom: 15,
						center: center,
						fullscreenControl: true,
						scrollwheel: false
					};
					var mapElement = document.getElementById('stm-dealer-gmap');
					map = new google.maps.Map(mapElement, mapOptions);
					var marker = new google.maps.Marker({
						position: center,
						icon: '<?php echo get_template_directory_uri(); ?>/assets/images/stm-map-marker-green.png',
						map: map
					});
				}

				$(window).resize(function () {
					if (typeof map != 'undefined' && typeof center != 'undefined') {
						setTimeout(function () {
							map.setCenter(center);
						}, 1000);
					}
				})
			});
		</script>

		<?php
	}
}

if ( ! function_exists( 'stm_get_dealer_reviews' ) ) {
	function stm_get_dealer_reviews( $dealer_id = '', $per_page = 6, $offset = 0 ) {
		if ( ! empty( $dealer_id ) ) {
			$args = array(
				'post_type'      => 'dealer_review',
				'posts_per_page' => intval( $per_page ),
				'offset'         => intval( $offset ),
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'     => 'stm_review_added_on',
						'value'   => intval( $dealer_id ),
						'compare' => '='
					)
				)
			);

			$query = new WP_Query( $args );

			return $query;
		}
	}
}

if ( ! function_exists( 'stm_get_user_reviews' ) ) {
	function stm_get_user_reviews( $dealer_id = '', $dealer_id_from = '' ) {
		if ( ! empty( $dealer_id ) and ! empty( $dealer_id_from ) ) {
			$args = array(
				'post_type'   => 'dealer_review',
				'post_status' => 'publish',
				'meta_query'  => array(
					array(
						'key'     => 'stm_review_added_by',
						'value'   => intval( $dealer_id ),
						'compare' => '='
					),
					array(
						'key'     => 'stm_review_added_on',
						'value'   => intval( $dealer_id_from ),
						'compare' => '='
					)
				)
			);

			$query = new WP_Query( $args );

			return $query;
		}
	}
}

if ( ! function_exists( 'stm_get_dealer_logo_placeholder' ) ) {
	function stm_get_dealer_logo_placeholder() {
		echo esc_url( get_template_directory_uri() . '/assets/images/empty_dealer_logo.png' );
	}
}

if ( ! function_exists( 'stm_filter_post_limits' ) ) {
	function stm_filter_post_limits( $restrictions, $user_id ) {
		$user_id = intval( $user_id );

		$restrictions = array(
			'posts'  => 0,
			'images' => 0,
		);

		if ( ! empty( $user_id ) ) {
			$dealer = stm_get_user_role( $user_id );

			$created_posts = 0;

			$post_status = 'any';
			if ( stm_pricing_enabled() ) {
				$post_status = 'publish';
			}

			$args = array(
				'post_type'      => stm_listings_post_type(),
				'post_status'    => $post_status,
				'posts_per_page' => - 1,
				'meta_query'     => array(
					array(
						'key'     => 'stm_car_user',
						'value'   => $user_id,
						'compare' => '='
					)
				)
			);

			$query = new WP_Query( $args );

			if ( ! empty( $query->found_posts ) ) {
				$created_posts = intval( $query->found_posts );
			}


			if ( ! $dealer ) {
				$posts_allowed                 = get_theme_mod( 'user_post_limit', '3' );
				$restrictions['posts_allowed'] = intval( $posts_allowed );
				$restrictions['premoderation'] = get_theme_mod( 'user_premoderation', true );
				$restrictions['images']        = get_theme_mod( 'user_post_images_limit', '5' );
				$restrictions['role']          = 'user';
			} else {
				$posts_allowed                 = get_theme_mod( 'dealer_post_limit', '50' );
				$restrictions['posts_allowed'] = intval( $posts_allowed );
				$restrictions['premoderation'] = get_theme_mod( 'dealer_premoderation', false );
				$restrictions['images']        = get_theme_mod( 'dealer_post_images_limit', '10' );
				$restrictions['role']          = 'dealer';
			}

			if ( stm_pricing_enabled() ) {
				$current_quota = stm_user_active_subscriptions();
				if ( ! empty( $current_quota['post_limit'] ) and ! empty( $current_quota['image_limit'] ) ) {
					$posts_allowed          = $current_quota['post_limit'];
					$restrictions['images'] = $current_quota['image_limit'];
				}
			}

			$user_can_create = intval( $posts_allowed ) - intval( $created_posts );

			if ( $user_can_create < 1 ) {
				$user_can_create = 0;
			}

			$restrictions['posts'] = intval( $user_can_create );
		} else {
			$restrictions['premoderation'] = get_theme_mod( 'user_premoderation', true );
			$restrictions['posts']         = get_theme_mod( 'user_post_limit', '3' );
			$restrictions['images']        = get_theme_mod( 'user_post_images_limit', '5' );
			$restrictions['role']          = 'user';
		}

		/*IF is admin, set all */
		if ( user_can( $user_id, 'manage_options' ) ) {
			$restrictions['premoderation'] = false;
			$restrictions['posts']         = '9999';
			$restrictions['images']        = '9999';
			$restrictions['role']          = 'user';
		}

		return $restrictions;

	}

	add_filter( 'stm_filter_user_restrictions', 'stm_filter_post_limits', 10, 2 );
}


if ( ! function_exists( 'stm_delete_media' ) ) {
	function stm_delete_media( $media_id ) {
		$current_user = wp_get_current_user();
		$media_id     = intval( $media_id );
		if ( ! empty( $current_user->ID ) ) {
			$current_user_id = $current_user->ID;

			$args = array(
				'author'      => intval( $current_user_id ),
				'post_status' => 'any',
				'post__in'    => array( $media_id ),
				'post_type'   => 'attachment'
			);

			$query = new WP_Query( $args );

			if ( $query->found_posts == 1 ) {
				wp_delete_attachment( $media_id, true );
			}
		}
	}
}

if ( ! function_exists( 'stm_data_binding' ) ) {
	function stm_data_binding() {
		$stm_get_car_parent_exist = stm_get_car_parent_exist();
		$bind_tax                 = array();
		foreach ( $stm_get_car_parent_exist as $stm_get_car_parent_exist_single ) {
			$parent_slug                             = $stm_get_car_parent_exist_single['listing_taxonomy_parent'];
			$current_slug                            = $stm_get_car_parent_exist_single['slug'];
			$categories                              = stm_get_category_by_slug_all( $current_slug );
			$bind_tax[ $parent_slug ]                = array();
			$bind_tax[ $parent_slug ]['dependency']  = $current_slug;
			$bind_tax[ $current_slug ]               = array();
			$bind_tax[ $current_slug ]['dependency'] = $parent_slug;
			foreach ( $categories as $category ) {
				$option_name  = 'stm_parent_taxonomy_' . $category->term_id;
				$option_value = get_option( $option_name );
				if ( ! empty( $option_value ) ) {
					if ( empty( $bind_tax[ $parent_slug ][ $option_value ] ) ) {
						$bind_tax[ $parent_slug ][ $option_value ] = array();
					}
					$bind_tax[ $parent_slug ][ $option_value ][]  = $category->slug;
					$bind_tax[ $current_slug ][ $category->slug ] = $option_value;
				}
			}
		}

		$bind_tax = json_encode( $bind_tax );

		return $bind_tax;
	}
}

if ( ! function_exists( 'stm_is_site_demo_mode' ) ) {
	function stm_is_site_demo_mode() {

		$site_demo_mode = get_theme_mod( 'site_demo_mode', false );

		return $site_demo_mode;
	}
}


if ( ! function_exists( 'stm_payment_enabled' ) ) {
	function stm_payment_enabled() {
		$paypal_options = array(
			'enabled' => false
		);

		$paypal_email    = get_theme_mod( 'paypal_email', '' );
		$paypal_currency = get_theme_mod( 'paypal_currency', 'USD' );
		$paypal_mode     = get_theme_mod( 'paypal_mode', 'sandbox' );
		$membership_cost = get_theme_mod( 'membership_cost', '' );


		if ( ! empty( $paypal_email ) and ! empty( $paypal_currency ) and ! empty( $paypal_mode ) and ! empty( $membership_cost ) ) {
			$paypal_options['enabled'] = true;
		}

		$paypal_options['email']    = $paypal_email;
		$paypal_options['currency'] = $paypal_currency;
		$paypal_options['mode']     = $paypal_mode;
		$paypal_options['price']    = $membership_cost;


		return $paypal_options;
	}
}

if ( ! function_exists( 'stm_paypal_url' ) ) {
	function stm_paypal_url() {
		$paypal_mode = get_theme_mod( 'paypal_mode', 'sandbox' );
		$paypal_url  = ( $paypal_mode == 'live' ) ? 'www.paypal.com' : 'www.sandbox.paypal.com';

		return $paypal_url;
	}
}

if ( ! function_exists( 'generatePayment' ) ) {

	function generatePayment() {

		$user = wp_get_current_user();

		if ( ! empty( $user->ID ) ) {

			$user_id = $user->ID;

			$return['result'] = true;

			$base = 'https://' . stm_paypal_url() . '/cgi-bin/webscr';

			$return_url = add_query_arg( array( 'become_dealer' => 1 ), stm_get_author_link( $user_id ) );

			$url_args = array(
				'cmd'           => '_xclick',
				'business'      => get_theme_mod( 'paypal_email', '' ),
				'item_name'     => $user->data->user_login,
				'item_number'   => $user_id,
				'amount'        => get_theme_mod( 'membership_cost', '' ),
				'no_shipping'   => '1',
				'no_note'       => '1',
				'currency_code' => get_theme_mod( 'paypal_currency', 'USD' ),
				'bn'            => 'PP%2dBuyNowBF',
				'charset'       => 'UTF%2d8',
				'invoice'       => $user_id,
				'return'        => $return_url,
				'rm'            => '2',
				'notify_url'    => home_url()
			);

			$return = add_query_arg( $url_args, $base );
		}

		return $return;

	}
}

function stm_set_html_content_type_mail() {
	return 'text/html';
}

if ( ! function_exists( 'stm_check_payment' ) ) {

	function stm_check_payment( $data ) {

		if ( ! empty( $data['invoice'] ) ) {

			$invoice = $data['invoice'];

			$req = 'cmd=_notify-validate';

			foreach ( $data as $key => $value ) {
				$value = urlencode( stripslashes( $value ) );
				$req .= "&$key=$value";
			}

			echo 'https://' . stm_paypal_url() . '/cgi-bin/webscr';
			$ch = curl_init( 'https://' . stm_paypal_url() . '/cgi-bin/webscr' );
			curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $req );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
			curl_setopt( $ch, CURLOPT_FORBID_REUSE, 1 );
			curl_setopt( $ch, CURLOPT_SSLVERSION, 6 );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Connection: Close' ) );

			if ( ! ( $res = curl_exec( $ch ) ) ) {
				echo( "Got " . curl_error( $ch ) . " when processing IPN data" );

				curl_close( $ch );

				return false;
			}
			curl_close( $ch );

			if ( strcmp( $res, "VERIFIED" ) == 0 ) {

				update_user_meta( intval( $invoice ), 'stm_payment_status', 'completed' );

				$member_admin_email_subject = esc_html__( 'New Payment received', 'motors' );
				$member_admin_email_message = esc_html__( 'User paid for submission. User ID:', 'motors' ) . ' ' . $invoice;

				add_filter( 'wp_mail_content_type', 'stm_set_html_content_type_mail' );

				$headers[] = 'From: ' . get_bloginfo( 'blogname' ) . ' <' . get_bloginfo( 'admin_email' ) . '>';

				wp_mail( get_bloginfo( 'admin_email' ), $member_admin_email_subject, nl2br( $member_admin_email_message ), $headers );

				remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type_mail' );


			}
		}
	}
}

if ( ! empty( $_GET['stm_check_membership_payment'] ) ) {

	header( 'HTTP/1.1 200 OK' );
	stm_check_payment( $_REQUEST );

	exit;

}


if ( ! function_exists( 'stm_get_dealer_list_page' ) ) {
	function stm_get_dealer_list_page() {
		$dealer_list_page = get_theme_mod( 'dealer_list_page', 2173 );
		if ( function_exists( 'icl_object_id' ) ) {
			$id = icl_object_id( $dealer_list_page, 'page', false, ICL_LANGUAGE_CODE );
			if ( is_page( $id ) ) {
				$dealer_list_page = $id;
			}
		}

		$link = get_permalink( $dealer_list_page );

		return $link;
	}
}

function motors_pa( $arr ) {
	echo '<pre>';
	print_r( $arr );
	echo '</pre>';
}

//Add user custom color styles
if ( ! function_exists( 'stm_print_styles_color' ) ) {
	function stm_print_styles_color() {
		$css         = "";
		$css_listing = '';

		$layout = stm_get_current_layout();

		if ( get_theme_mod( 'site_style' ) == 'site_style_custom' ) {

			$colors_differences = false;
			$colors_arr         = array();

			global $wp_filesystem;

			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}

			$theme_path = get_template_directory_uri() . '/assets/';

			if ( $layout == 'motorcycle' ) {
				$custom_style_css = $wp_filesystem->get_contents( get_template_directory() . '/assets/css/motorcycle/app.css' );
				$base_color       = get_theme_mod( 'site_style_base_color', '#df1d1d' );
				$secondary_color  = get_theme_mod( 'site_style_secondary_color', '#2f3c40' );

				$colors_arr[] = $base_color;
				$colors_arr[] = $secondary_color;

				$custom_style_css = str_replace(
					array(
						'#df1d1d', //1
						'#2f3c40', //2
						'#243136', //3
						'#1d282c', //4
						'#272e36', //5
						'#27829e',
						'#1b92a8',
						'36,49,54',
						'36, 49, 54',
						'../../',
						'#b11313',
						'#d11717',
						'#b01b1c'
					),
					array(
						$base_color, //1
						$secondary_color, //2
						$secondary_color, //3
						'rgba(' . stm_hex2rgb( $secondary_color ) . ', 0.8)', //4
						$secondary_color, //5
						'rgba(' . stm_hex2rgb( $base_color ) . ', 0.75)',
						'rgba(' . stm_hex2rgb( $secondary_color ) . ', 0.8)',
						stm_hex2rgb( $secondary_color ),
						stm_hex2rgb( $secondary_color ),
						$theme_path,
						'rgba(' . stm_hex2rgb( $base_color ) . ', 0.75)',
						'rgba(' . stm_hex2rgb( $base_color ) . ', 0.75)',
						$base_color, //1
					),
					$custom_style_css
				);
				$css .= $custom_style_css;
			} else {
				if ( $layout !== 'boats' ) {
					$custom_style_css = $wp_filesystem->get_contents( get_template_directory() . '/assets/css/app.css' );
					$base_color       = get_theme_mod( 'site_style_base_color', '#183650' );
					$secondary_color  = get_theme_mod( 'site_style_secondary_color', '#34ccff' );

					$colors_arr[] = $base_color;
					$colors_arr[] = $secondary_color;

					$custom_style_css = str_replace(
						array(
							'#cc6119',
							'#6c98e1',
							'#6c98e1',
							'#1b92a8',
							'204, 97, 25',
							'../'
						),
						array(
							$base_color,
							$secondary_color,
							'rgba(' . stm_hex2rgb( $secondary_color ) . ', 0.75)',
							'rgba(' . stm_hex2rgb( $secondary_color ) . ', 0.8)',
							stm_hex2rgb( $base_color ),
							$theme_path,
						),
						$custom_style_css
					);
					$css .= $custom_style_css;

					$custom_style_css        = $wp_filesystem->get_contents( get_template_directory() . '/assets/css/listing/app.css' );
					$base_color_listing      = get_theme_mod( 'site_style_base_color_listing', '#1bc744' );
					$secondary_color_listing = get_theme_mod( 'site_style_secondary_color_listing', '#153e4d' );

					$colors_arr[] = $base_color_listing;
					$colors_arr[] = $secondary_color_listing;

					$custom_style_css = str_replace(
						array(
							'#1bc744',
							'#153e4d',
							'#169f36',
							'#4e90cc',
							'51,51,51,0.9',
							'../../',
							'#32cd57',
							'#19b33e',
							'#609bd1',
							'#4782b8',
							'27, 199, 68',
							'#11323e',
							'#133340'
						),
						array(
							$base_color_listing,
							$secondary_color_listing,
							'rgba(' . stm_hex2rgb( $base_color_listing ) . ', 0.75)',
							$base_color,
							stm_hex2rgb( $secondary_color_listing ) . ',0.8',
							$theme_path,
							'rgba(' . stm_hex2rgb( $base_color_listing ) . ', 1)',
							'rgba(' . stm_hex2rgb( $base_color_listing ) . ', 0.8)',
							'rgba(' . stm_hex2rgb( $secondary_color_listing ) . ', 1)',
							'rgba(' . stm_hex2rgb( $secondary_color_listing ) . ', 0.8)',
							stm_hex2rgb( $base_color_listing ),
							'rgba(' . stm_hex2rgb( $secondary_color_listing ) . ', 0.8)',
							'rgba(' . stm_hex2rgb( $secondary_color_listing ) . ', 1)',
						),
						$custom_style_css
					);
					$css_listing .= $custom_style_css;

					$css .= $css_listing;
				} else {
					$custom_style_css = $wp_filesystem->get_contents( get_template_directory() . '/assets/css/boats/app.css' );
					$base_color       = get_theme_mod( 'site_style_base_color', '#31a3c6' );
					$secondary_color  = get_theme_mod( 'site_style_secondary_color', '#ceac61' );
					$third_color      = get_theme_mod( 'site_style_base_color_listing', '#002568' );

					$colors_arr[] = $base_color;
					$colors_arr[] = $secondary_color;
					$colors_arr[] = $third_color;

					$custom_style_css = str_replace(
						array(
							'#31a3c6',
							'#ceac61',
							'#002568',
							'#27829e',
							'#1b92a8',
							'204, 97, 25',
							'../../',
						),
						array(
							$base_color,
							$secondary_color,
							$third_color,
							'rgba(' . stm_hex2rgb( $base_color ) . ', 0.75)',
							'rgba(' . stm_hex2rgb( $secondary_color ) . ', 0.8)',
							stm_hex2rgb( $base_color ),
							$theme_path,
						),
						$custom_style_css
					);
					$css .= $custom_style_css;
				}
			}

			$upload_dir = wp_upload_dir();

			if ( ! $wp_filesystem->is_dir( $upload_dir['basedir'] . '/stm_uploads' ) ) {
				$wp_filesystem->mkdir( $upload_dir['basedir'] . '/stm_uploads', FS_CHMOD_DIR );
			}

			if ( $custom_style_css ) {
				$css_to_filter = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
				$css_to_filter = str_replace( array(
					"\r\n",
					"\r",
					"\n",
					"\t",
					'  ',
					'    ',
					'    '
				), '', $css_to_filter );

				$custom_style_file = $upload_dir['basedir'] . '/stm_uploads/skin-custom.css';

				if ( $custom_style_file ) {
					$custom_style_content = $wp_filesystem->get_contents( $custom_style_file );

					if ( is_array( $colors_arr ) && ! empty( $colors_arr ) ) {
						foreach ( $colors_arr as $color ) {
							$color_find = strpos( $custom_style_content, $color );
							if ( ! $color_find && ! $colors_differences ) {
								$colors_differences = true;
							}
						}
					}

					if ( $colors_differences ) {
						$wp_filesystem->put_contents( $custom_style_file, $css_to_filter, FS_CHMOD_FILE );
					}
				} else {
					$wp_filesystem->put_contents( $custom_style_file, $css_to_filter, FS_CHMOD_FILE );
				}
			}
		}
	}
}

add_action( 'customize_save_after', 'stm_print_styles_color' );

if ( ! function_exists( 'stm_boats_styles' ) ) {
	function stm_boats_styles() {
		$front_css = '';

		if ( stm_is_boats() ) {
			$header_bg_color  = get_theme_mod( 'header_bg_color', '#002568' );
			$top_bar_bg_color = get_theme_mod( 'top_bar_bg_color', '#002568' );

			$front_css .= '
				#stm-boats-header #top-bar:after {
					background-color: ' . $top_bar_bg_color . ';
				}
				#stm-boats-header #header:after {
					background-color: ' . $header_bg_color . ';
				}
			';
		}

		if ( stm_is_motorcycle() ) {
			$header_bg_color = get_theme_mod( 'header_bg_color', '#002568' );


			$front_css .= '
				.stm_motorcycle-header {
					background-color: ' . $header_bg_color . ';
				}
			';

			$site_bg = get_theme_mod( 'site_bg_color', '#0e1315' );

			$front_css .= '
				#wrapper {
					background-color: ' . $site_bg . ' !important;
				}
				.stm-single-car-page:before,
				.stm-simple-parallax .stm-simple-parallax-gradient:before {
					background: -moz-linear-gradient(left, rgba(' . stm_hex2rgb( $site_bg ) . ',1) 0%, rgba(' . stm_hex2rgb( $site_bg ) . ',0) 100%);
					background: -webkit-linear-gradient(left, rgba(' . stm_hex2rgb( $site_bg ) . ',1) 0%,rgba(' . stm_hex2rgb( $site_bg ) . ',0) 100%);
					background: linear-gradient(to right, rgba(' . stm_hex2rgb( $site_bg ) . ',1) 0%,rgba(' . stm_hex2rgb( $site_bg ) . ',0) 100%);
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#0e1315\', endColorstr=\'#000e1315\',GradientType=1 ); /* IE6-9 */
				}
				.stm-single-car-page:after,
				.stm-simple-parallax .stm-simple-parallax-gradient:after {
					background: -moz-linear-gradient(left, rgba(' . stm_hex2rgb( $site_bg ) . ',0) 0%, rgba(' . stm_hex2rgb( $site_bg ) . ',1) 99%, rgba(' . stm_hex2rgb( $site_bg ) . ',1) 100%);
					background: -webkit-linear-gradient(left, rgba(' . stm_hex2rgb( $site_bg ) . ',0) 0%,rgba(' . stm_hex2rgb( $site_bg ) . ',1) 99%,rgba(' . stm_hex2rgb( $site_bg ) . ',1) 100%);
					background: linear-gradient(to right, rgba(' . stm_hex2rgb( $site_bg ) . ',0) 0%,rgba(' . stm_hex2rgb( $site_bg ) . ',1) 99%,rgba(' . stm_hex2rgb( $site_bg ) . ',1) 100%);
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#000e1315\', endColorstr=\'#0e1315\',GradientType=1 );
				}
			';

			$stm_single_car_page = get_theme_mod( 'stm_single_car_page' );

			if ( ! empty( $stm_single_car_page ) ) {
				$front_css .= '
				.stm-single-car-page {
					background-image: url(" ' . $stm_single_car_page . ' ");
				}
			';
			}
			wp_add_inline_style( 'stm-theme-style', $front_css );
		}

		if ( get_theme_mod( 'site_style', 'site_style_default' ) == 'site_style_default' ) {
			wp_add_inline_style( 'stm-theme-style', $front_css );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'stm_boats_styles' );

if ( ! function_exists( 'stm_get_boats_image_hover' ) ) {
	function stm_get_boats_image_hover( $id ) {
		$car_media = stm_get_car_medias( $id );
		echo '<div class="boats-image-unit">';
		if ( ! empty( $car_media['car_photos_count'] ) ): ?>
			<div class="stm-listing-photos-unit stm-car-photos-<?php echo get_the_id(); ?>">
				<i class="stm-boats-icon-camera"></i>
				<span><?php echo $car_media['car_photos_count']; ?></span>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function () {

					jQuery(".stm-car-photos-<?php echo get_the_id(); ?>").click(function (e) {
						e.preventDefault();
						jQuery.fancybox.open([
							<?php foreach($car_media['car_photos'] as $car_photo): ?>
							{
								href: "<?php echo esc_url( $car_photo ); ?>"
							},
							<?php endforeach; ?>
						], {
							padding: 0
						}); //open
					});
				});

			</script>
		<?php endif; ?>
		<?php if ( ! empty( $car_media['car_videos_count'] ) ): ?>
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_id(); ?>">
				<i class="stm-boats-icon-movie"></i>
				<span><?php echo $car_media['car_videos_count']; ?></span>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function () {

					jQuery(".stm-car-videos-<?php echo get_the_id(); ?>").click(function (e) {
						e.preventDefault();
						jQuery.fancybox.open([
							<?php foreach($car_media['car_videos'] as $car_video): ?>
							{
								href: "<?php echo esc_url( $car_video ); ?>"
							},
							<?php endforeach; ?>
						], {
							type: 'iframe',
							padding: 0
						}); //open
					}); //click
				}); //ready

			</script>
		<?php endif;
		echo '</div>';
	}
}

if ( ! function_exists( 'stm_get_boats_comapre' ) ) {
	function stm_get_boats_compare( $id ) {
		if ( ! empty( $show_compare ) and $show_compare ): ?>
			<div
				class="stm-listing-compare stm-compare-directory-new <?php echo esc_attr( $car_already_added_to_compare ); ?>"
				data-id="<?php echo esc_attr( get_the_id() ); ?>"
				data-title="<?php echo stm_generate_title_from_slugs( get_the_id(), false ); ?>"
				data-toggle="tooltip" data-placement="left" title="<?php echo esc_attr( $car_compare_status ); ?>"
			>
				<i class="stm-service-icon-compare-new"></i>
			</div>
		<?php endif;
	}
}

function display_script_sort( $tax_info ) {
	?>case '<?php echo $tax_info['slug']; ?>_low':
	<?php
	$slug      = sanitize_title( str_replace( '-', '_', $tax_info['slug'] ) );
	$sort_asc  = 'true';
	$sort_desc = 'false';
	if ( ! empty( $tax_info['numeric'] ) and $tax_info['numeric'] ) {
		$sort_asc  = 'false';
		$sort_desc = 'true';
	}
	?>
	$container.isotope({
	getSortData: {
	<?php echo $slug; ?>: function( itemElem ) {
	<?php if ( ! empty( $tax_info['numeric'] ) and $tax_info['numeric'] ): ?>
		var <?php echo $slug; ?> = $(itemElem).data('<?php echo $tax_info['slug']; ?>');
		if(typeof(<?php echo $slug; ?>) == 'undefined') {
		<?php echo $slug; ?> = '0';
		}
		return parseFloat(<?php echo $slug; ?>);
	<?php else: ?>
		var <?php echo $slug; ?> = $(itemElem).data('<?php echo $tax_info['slug']; ?>');
		if(typeof(<?php echo $slug; ?>) == 'undefined') {
		<?php echo $slug; ?> = 'zzzzzzz';
		}
		return <?php echo $slug; ?>;
	<?php endif; ?>

	}
	},
	sortBy: '<?php echo $slug ?>',
	sortAscending: <?php echo $sort_asc; ?>
	});
	break
	case '<?php echo $tax_info['slug']; ?>_high':
	$container.isotope({
	getSortData: {
	<?php echo $slug; ?>: function( itemElem ) {
	<?php if ( ! empty( $tax_info['numeric'] ) and $tax_info['numeric'] ): ?>
		var <?php echo $slug; ?> = $(itemElem).data('<?php echo $tax_info['slug']; ?>');
		if(typeof(<?php echo $slug; ?>) == 'undefined') {
		<?php echo $slug; ?> = '0';
		}
		return parseFloat(<?php echo $slug; ?>);
	<?php else: ?>
		var <?php echo $slug; ?> = $(itemElem).data('<?php echo $tax_info['slug']; ?>');
		if(typeof(<?php echo $slug; ?>) == 'undefined') {
		<?php echo $slug; ?> = 'zzzzzzzz';
		}
		return <?php echo $slug; ?>;
	<?php endif; ?>

	}
	},
	sortBy: '<?php echo $tax_info['slug']; ?>',
	sortAscending: <?php echo $sort_desc; ?>
	});
	break
	<?php
}

if ( ! function_exists( 'stm_theme_add_body_class' ) ) {
	function stm_theme_add_body_class( $classes ) {
		return "$classes stm-template-" . stm_get_current_layout();
	}
}

add_filter( 'stm_listings_admin_body_class', 'stm_theme_add_body_class' );

function stm_import_widgets( $widget_data ) {
	$json_data = $widget_data;
	$json_data = json_decode( $json_data, true );

	$sidebar_data = $json_data[0];
	$widget_data  = $json_data[1];

	$menu_object = wp_get_nav_menu_object( 'Widget menu' );

	if ( ! empty( $menu_object )
		 and ! empty( $menu_object->term_id )
			 and ! empty( $widget_data['nav_menu'] )
				 and ! empty( $widget_data['nav_menu'][2] )
					 and ! empty( $widget_data['nav_menu'][2]['nav_menu'] )
	) {
		$widget_data['nav_menu'][2]['nav_menu'] = $menu_object->term_id;
	}

	foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
		$widgets[ $widget_data_title ] = '';
		foreach ( $widget_data_value as $widget_data_key => $widget_data_array ) {
			if ( is_int( $widget_data_key ) ) {
				$widgets[ $widget_data_title ][ $widget_data_key ] = 'on';
			}
		}
	}
	unset( $widgets[""] );

	foreach ( $sidebar_data as $title => $sidebar ) {
		$count = count( $sidebar );
		for ( $i = 0; $i < $count; $i ++ ) {
			$widget               = array();
			$widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
			$widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
			if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
				unset( $sidebar_data[ $title ][ $i ] );
			}
		}
		$sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
	}

	foreach ( $widgets as $widget_title => $widget_value ) {
		foreach ( $widget_value as $widget_key => $widget_value ) {
			$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
		}
	}

	$sidebar_data = array( array_filter( $sidebar_data ), $widgets );

	stm_widget_parse_import_data( $sidebar_data );
}


function stm_widget_parse_import_data( $import_array ) {
	global $wp_registered_sidebars;
	$sidebars_data    = $import_array[0];
	$widget_data      = $import_array[1];
	$current_sidebars = get_option( 'sidebars_widgets' );
	$new_widgets      = array();

	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

		foreach ( $import_widgets as $import_widget ) :
			//if the sidebar exists
			if ( isset( $wp_registered_sidebars[ $import_sidebar ] ) ) :
				$title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name     = stm_get_new_widget_name( $title, $index );
				$new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

				if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
						$new_index ++;
					}
				}
				$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
					$multiwidget                         = $new_widgets[ $title ]['_multiwidget'];
					unset( $new_widgets[ $title ]['_multiwidget'] );
					$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
					$current_multiwidget               = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : false;
					$new_multiwidget                   = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
					$multiwidget                       = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[ $title ]               = $current_widget_data;
				}

			endif;
		endforeach;
	endforeach;

	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
		update_option( 'sidebars_widgets', $current_sidebars );

		foreach ( $new_widgets as $title => $content ) {
			update_option( 'widget_' . $title, $content );
		}

		return true;
	}

	return false;
}

function stm_get_new_widget_name( $widget_name, $widget_index ) {
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array();
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( ! empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index ++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;

	return $new_widget_name;
}

if ( ! function_exists( 'stm_display_wpml_switcher' ) ) {
	function stm_display_wpml_switcher( $langs = array() ) {
		if ( ! empty( $_SERVER ) and ! empty( $_SERVER['HTTP_HOST'] ) ) {
			$server_uri = $_SERVER['HTTP_HOST'];
			if ( $server_uri == 'motors.stm' or $server_uri == 'motors.stylemixthemes.com' ) {
				$langs = array(
					'en' => array(
						'active'      => 1,
						'url'         => '#',
						'native_name' => esc_html__( 'English', 'motors' )
					),
					'fr' => array(
						'active'      => 0,
						'url'         => '#',
						'native_name' => esc_html__( 'Français', 'motors' )
					),
				);

				$lang_name = esc_html__( 'English', 'motors' );
			}
		}

		if ( ! empty( $langs ) ): ?>
			<!--LANGS-->
			<?php
			if ( count( $langs ) > 1 ) {
				$langs_exist = 'dropdown_toggle';
			} else {
				$langs_exist = 'no_other_langs';
			}
			if ( defined( 'ICL_LANGUAGE_NAME' ) ) {
				$lang_name = ICL_LANGUAGE_NAME;
			}
			?>
			<div class="pull-left language-switcher-unit">
				<div
					class="stm_current_language <?php echo esc_attr( $langs_exist ); ?>" <?php if ( count( $langs ) > 1 ) { ?> id="lang_dropdown" data-toggle="dropdown" <?php } ?>><?php echo esc_attr( $lang_name ); ?><?php if ( count( $langs ) > 1 ) { ?>
						<i class="fa fa-angle-down"></i><?php } ?></div>
				<?php if ( count( $langs ) > 1 ): ?>
					<ul class="dropdown-menu lang_dropdown_menu" role="menu" aria-labelledby="lang_dropdown">
						<?php foreach ( $langs as $lang ): ?>
							<?php if ( ! $lang['active'] ): ?>
								<li role="presentation"><a role="menuitem" tabindex="-1"
														   href="<?php echo esc_url( $lang['url'] ); ?>"><?php echo esc_attr( $lang['native_name'] ); ?></a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endif;
	}
}

if ( ! function_exists( 'stm_listing_filter_get_selects' ) ) {
	function stm_listing_filter_get_selects( $select_strings, $tab_name = '', $words = array() ) {

		if ( ! empty( $select_strings ) ) {
			$select_strings = explode( ',', $select_strings );

			if ( ! empty( $select_strings ) ) {
				$output = '';
				$output .= '<div class="row">';
				foreach ( $select_strings as $select_string ) {

					$output .= '<div class="col-md-3 col-sm-6 col-xs-12 stm-select-col">';
					//if price
					if ( $select_string == 'price' ) {
						$args = array(
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => false,
							'fields'     => 'all',
						);

						$prices = array();

						$terms = get_terms( 'price', $args );

						if ( ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$prices[] = intval( $term->name );
							}
							sort( $prices );
						}

						$number_string = '';

						if ( ! empty( $words['number_prefix'] ) ) {
							$number_string .= $words['number_prefix'] . ' ';
						} else {
							$number_string = esc_html__( 'Max', 'motors' ) . ' ';
						}

						$number_string .= esc_html__( stm_get_name_by_slug( $select_string ), 'motors' );

						if ( ! empty( $words['number_affix'] ) ) {
							$number_string .= ' ' . $words['number_affix'];
						}

						$output .= '<select class="stm-filter-ajax-disabled-field" name="max_price" data-class="stm_select_overflowed">';
						$output .= '<option value="">' . $number_string . '</option>';
						if ( ! empty( $terms ) ) {
							foreach ( $prices as $price ) {
								$output .= '<option value="' . $price . '">' . stm_listing_price_view( $price ) . '</option>';
							}
						}
						$output .= '</select>';
					} else {
						$taxonomy_info = stm_get_taxonomies_with_type( $select_string );
						//If numeric
						if ( ! empty( $taxonomy_info['numeric'] ) and $taxonomy_info['numeric'] ) {
							$args    = array(
								'orderby'    => 'name',
								'order'      => 'ASC',
								'hide_empty' => false,
								'fields'     => 'all',
							);
							$numbers = array();

							$terms = get_terms( $select_string, $args );

							if ( ! empty( $terms ) ) {
								foreach ( $terms as $term ) {
									$numbers[] = intval( $term->name );
								}
							}
							sort( $numbers );

							if ( ! empty( $numbers ) ) {


								$output .= '<select name="max_' . $select_string . '" data-class="stm_select_overflowed">';
								$output .= '<option value="">' . esc_html__( stm_get_name_by_slug( $select_string ), 'motors' ) . '</option>';
								foreach ( $numbers as $number_key => $number_value ) {
									if ( $number_key == 0 ) {
										$output .= '<option value=">' . $number_value . '">> ' . $number_value . '</option>';
									} elseif ( count( $numbers ) - 1 == $number_key ) {
										$output .= '<option value="<' . $number_value . '">< ' . $number_value . '</option>';
									} else {
										$option_value = $numbers[ ( $number_key - 1 ) ] . '-' . $number_value;
										$option_name  = $numbers[ ( $number_key - 1 ) ] . '-' . $number_value;
										$output .= '<option value="' . $option_value . '"> ' . $option_name . '</option>';
									}
								}
								$output .= '</select>';
							}
							//other default values
						} else {
							if ( $select_string == 'location' ) {
								$output .= '<div class="stm-location-search-unit">';
								$output .= '<input type="text" class="stm_listing_filter_text stm_listing_search_location" id="stm-car-location-' . $tab_name . '" name="ca_location" />';
								$output .= '<input type="hidden" name="stm_lat"/>';
								$output .= '<input type="hidden" name="stm_lng"/>';
								$output .= '</div>';
							} else {
								$terms = stm_get_category_by_slug_all( $select_string );


								$select_main = '';
								if ( ! empty( $words['select_prefix'] ) ) {
									$select_main .= $words['select_prefix'] . ' ';
								} else {
									$select_main .= esc_html__( "Choose", "motors" ) . ' ';
								}

								$select_main .= esc_html__( stm_get_name_by_slug( $select_string ), 'motors' );

								if ( ! empty( $words['select_affix'] ) ) {
									$select_main .= ' ' . $words['select_affix'];
								}

								$output .= '<div class="stm-ajax-reloadable">';
								$output .= '<select name="' . $select_string . '" data-class="stm_select_overflowed">';
								$output .= '<option value="">' . $select_main . '</option>';
								if ( ! empty( $terms ) ) {
									foreach ( $terms as $term ) {
										$output .= '<option value="' . $term->slug . '">' . $term->name . ' (' . $term->count . ') </option>';
									}
								}
								$output .= '</select>';
								$output .= '</div>';
							}
						}
					}
					$output .= '</div>';
				}
				$output .= '</div>';

				if ( ! empty( $output ) ) {
					echo $output;
				}
			}
		}
	}
}

function stm_pricing_enabled() {
	$enabled = get_theme_mod( 'enable_plans', false );
	if ( $enabled and class_exists( 'Subscriptio' ) ) {
		$enabled = true;
	} else {
		$enabled = false;
	}

	return ( $enabled );
}

function stm_pricing_link() {
	$pricing_link = get_theme_mod( 'pricing_link', '' );
	if ( ! empty( $pricing_link ) ) {
		if ( function_exists( 'icl_object_id' ) ) {
			$id = icl_object_id( $pricing_link, 'page', false, ICL_LANGUAGE_CODE );
			if ( is_page( $id ) ) {
				$pricing_link = $id;
			}
		}
	}

	return get_permalink( $pricing_link );
}

//Filters from new plugin
if ( ! function_exists( 'stm_filter_add_links' ) ) {
	function stm_filter_add_links( $taxes ) {

		/*Filter links*/
		$filter_links = stm_get_car_filter_links();
		if ( ! empty( $filter_links ) and ! empty( $taxes ) ) {
			foreach ( $filter_links as $key => $tax ) {
				if ( ! array_key_exists( $key, $taxes ) ) {
					$taxes[] = $key;
				}
			}
		}

		/*Filter checkboxes*/
		$filter_checkboxes = stm_get_car_filter_checkboxes();
		if ( ! empty( $filter_checkboxes ) and ! empty( $taxes ) ) {
			foreach ( $filter_checkboxes as $key => $tax ) {
				if ( ! array_key_exists( $key, $taxes ) ) {
					$taxes[] = $key;
				}
			}
		}


		return $taxes;
	}

	add_filter( 'stm_listings_filter_taxonomies', 'stm_filter_add_links' );
}

if ( ! function_exists( 'stm_listings_filter_classified_title' ) ) {
	function stm_listings_filter_classified_title( $params ) {

		$title_default           = get_theme_mod( 'listing_directory_title_default', esc_html__( 'Cars for sale', 'motors' ) );
		$title_generated_postfix = get_theme_mod( 'listing_directory_title_generated_affix', esc_html__( ' for sale', 'motors' ) );

		$title_response = '';

		$titles_args             = stm_get_filter_title();
		$title_generated_counter = 0;
		foreach ( $titles_args as $title_arg ) {
			if ( ! empty( $_GET[ $title_arg['slug'] ] ) ) {
				$title_generated_counter ++;
				if ( ! is_array( $_GET[ $title_arg['slug'] ] ) ) {
					$category = get_term_by( 'slug', $_GET[ $title_arg['slug'] ], $title_arg['slug'] );
					if ( ! empty( $category ) and ! is_wp_error( $category ) ) {
						$title_response .= ' ' . $category->name;
					}
				}
			}
		}

		if ( empty( $title_response ) ) {
			$title_response = $title_default;
		} else {
			if ( $title_generated_counter == 1 ) {
				$title_response .= ' ' . strtolower( $title_default );
			} else {
				$title_response .= $title_generated_postfix;
			}
		}

		$params['listing_title'] = $title_response;

		return $params;
	}

	if ( stm_is_listing() or stm_is_motorcycle() ) {
		add_filter( 'stm_listings_filter', 'stm_listings_filter_classified_title' );
	}
}

function stm_listing_pre_get_vehicles( $query_vars ) {
	if ( ! empty( $_GET['featured_top'] ) ) {
		$query_vars['meta_query'][] = array(
			'key'     => 'special_car',
			'value'   => 'on',
			'compare' => '='
		);
	}

	$posts_per_page = intval( stm_listings_input( 'posts_per_page' ) );

	if ( empty( $posts_per_page ) ) {
		$posts_per_page = get_theme_mod( 'listing_grid_choice', 9 );
	}

	$query_vars['posts_per_page'] = intval( $posts_per_page );

	if ( ! empty( $_GET['stm-footer-search-name'] ) ) {
		$query_vars['s'] = $_GET['stm-footer-search-name'];
	}

	return $query_vars;
}

add_filter( 'stm_listings_query_vars', 'stm_listing_pre_get_vehicles', 20 );

if ( ! function_exists( 'stm_get_sidebar_position' ) ) {
	function stm_get_sidebar_position() {
		$listing_filter_position = get_theme_mod( 'listing_filter_position', 'left' );
		if ( ! empty( $_GET['filter_position'] ) and $_GET['filter_position'] == 'right' ) {
			$listing_filter_position = 'right';
		}

		$sidebar_pos_classes = '';
		$content_pos_classes = '';

		if ( $listing_filter_position == 'right' ) {
			$sidebar_pos_classes = 'col-md-push-9 col-sm-push-0';
			$content_pos_classes = 'col-md-pull-3 col-sm-pull-0';
		}

		$position = array(
			'sidebar' => $sidebar_pos_classes,
			'content' => $content_pos_classes
		);

		return $position;
	}
}

//Media upload limit
if ( ! function_exists( 'stm_filter_media_upload_size' ) ) {
	function stm_filter_media_upload_size( $size ) {
		$size = get_theme_mod( 'user_image_size_limit', '4000' ) * 1024;

		return $size;
	}

	add_filter( 'stm_listing_media_upload_size', 'stm_filter_media_upload_size' );
}

/**
 * Listings post type identifier
 *
 * @return string
 */
if ( ! function_exists( 'stm_listings_post_type' ) ) {
	function stm_listings_post_type() {
		return apply_filters( 'stm_listings_post_type', 'listings' );
	}
}

if ( ! function_exists( 'stm_display_user_name' ) ) {
	/**
	 * User display name
	 *
	 * @param $user_id
	 * @param string $user_login
	 * @param string $f_name
	 * @param string $l_name
	 */
	function stm_display_user_name( $user_id, $user_login = '', $f_name = '', $l_name = '' ) {
		$user = get_userdata( $user_id );

		if ( empty( $user_login ) ) {
			$login = $user->data->user_login;
		} else {
			$login = $user_login;
		}
		if ( empty( $f_name ) ) {
			$first_name = get_the_author_meta( 'first_name', $user_id );
		} else {
			$first_name = $f_name;
		}

		if ( empty( $l_name ) ) {
			$last_name = get_the_author_meta( 'last_name', $user_id );
		} else {
			$last_name = $l_name;
		}

		$display_name = $login;

		if ( ! empty( $first_name ) ) {
			$display_name = $first_name;
		}

		if ( ! empty( $first_name ) and ! empty( $last_name ) ) {
			$display_name .= ' ' . $last_name;
		}

		if ( empty( $first_name ) and ! empty( $last_name ) ) {
			$display_name = $last_name;
		}


		echo apply_filters( 'stm_filter_display_user_name', $display_name, $user_id, $user_login, $f_name, $l_name );

	}
}

if ( ! function_exists( 'stm_theme_clauses_filter' ) ) {

	function stm_theme_clauses_filter( $clauses ) {
		$radius = get_theme_mod( 'distance_search', '' );
		if ( ! empty( $radius ) ) {
			global $wpdb;
			if ( trim( $clauses['groupby'] ) == '' ) {
				$clauses['groupby'] = $wpdb->posts . '.ID';
			}

			$distance = floatval( $radius );
			$clauses['groupby'] .= " HAVING stm_distance <= $distance";
		}

		return $clauses;
	}

	add_filter( 'stm_listings_clauses_filter', 'stm_theme_clauses_filter' );
}

function stm_theme_image_sizes_js( $response, $attachment, $meta ) {

	$size_array = array( 'stm-img-796-466', 'stm-img-350-205' );

	foreach ( $size_array as $size ):

		if ( isset( $meta['sizes'][ $size ] ) ) {
			$attachment_url = wp_get_attachment_url( $attachment->ID );
			$base_url       = str_replace( wp_basename( $attachment_url ), '', $attachment_url );
			$size_meta      = $meta['sizes'][ $size ];

			$response['sizes'][ $size ] = array(
				'height'      => $size_meta['height'],
				'width'       => $size_meta['width'],
				'url'         => $base_url . $size_meta['file'],
				'orientation' => $size_meta['height'] > $size_meta['width'] ? 'portrait' : 'landscape',
			);
		}

	endforeach;

	return $response;
}

add_filter( 'wp_prepare_attachment_for_js', 'stm_theme_image_sizes_js', 10, 3 );

if ( ! function_exists( 'stm_listings_archive_inventory_page_id' ) ) {
	function stm_listings_archive_inventory_page_id( $id ) {
		if ( $id ) {
			/*Polylang*/
			if ( function_exists( 'pll_current_language' ) ) {
				$id = pll_current_language();
			}
		}

		return $id;
	}

	;

	add_filter( 'stm_listings_inventory_page_id', 'stm_listings_archive_inventory_page_id' );
}

if ( ! function_exists( 'stm_verify_motors_theme' ) ) {
	function stm_verify_motors_theme( $v ) {
		return true;
	}

	add_filter( 'stm_listing_is_motors_theme', 'stm_verify_motors_theme' );
}