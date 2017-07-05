<?php
/**
 * Plugin Name: STM WP All Import Addon
 * Description: STM Listings import helper plugin for WP All Import. This plugin allows import Listing posts using WP All Import Plugin
 * Author: Stylemix WP Support
 * Author URI: http://stylemix-wp-support.com/
 * Version: 2.0
 */

include "rapid-addon.php";

/**
 * Helper function to convert image URLs to needed format
 */
function convertToLocalUrl($src) {
	parse_str(parse_url($src, PHP_URL_QUERY), $query);
	if (!empty($query['p'])) {
		$host = str_replace('.', '_', parse_url($src, PHP_URL_HOST));
		$p    = str_replace( '/', '--', $query['p'] );
		$url  = get_option( 'siteurl' ) . '/import-image/' . $host . '/' . $p . '.jpg';
		return $url;
	}
	return $src;
}

class STM_Import_Listing_Addon extends RapidAddon {

	public function __construct() {

		parent::__construct( 'STM Listing Add-On', 'stm_listing_addon' );

		$this->add_field( 'featured_image', 'Images, Featured first.', 'images' );
		$this->add_field( 'stm_images_sep', 'Images URL separator (By default - ",")', 'text' );

		$this->add_field( 'price', 'Price', 'text' );
		$this->add_field( 'sale_price', 'Sale Price', 'text' );
		$this->add_field( 'regular_price_label', 'Regular price label', 'text' );
		$this->add_field( 'regular_price_description', 'Regular price description', 'text' );
		$this->add_field( 'special_price_label', 'Special price label', 'text' );
		$this->add_field( 'instant_savings_label', 'Instant savings label', 'text' );
		$this->add_field( 'stock_number', 'Stock Number', 'text' );
		$this->add_field( 'vin_number', 'VIN', 'text' );
		$this->add_field( 'history', 'History', 'text' );
		$this->add_field( 'history_link', 'History link', 'text' );
		$this->add_field( 'city_mpg', 'City MPG', 'text' );
		$this->add_field( 'highway_mpg', 'Highway MPG', 'text' );
		
		$this->add_field( 'stm_car_location', 'Car location (Address)', 'text' );
		$this->add_field( 'stm_lat_car_admin', 'Car location lat', 'text' );
		$this->add_field( 'stm_lng_car_admin', 'Car location lng', 'text' );
		
		$this->add_field( 'gallery_video', 'Gallery video', 'text' );
		$this->add_field( 'additional_features', 'Additional features (Features, separated by comma)', 'text' );
		
		$this->add_field( 'stm_car_user', 'User added (User ID)', 'text' );
		
		$this->add_field( 'automanager_id', 'Automanager ID', 'text' );
		
		$filter_options = get_option( 'stm_vehicle_listing_options' );
		if ( is_array( $filter_options ) ) {
			foreach ( $filter_options as $filter_option ) {
				if ( ! empty( $filter_option['numeric'] ) ) {
					$this->add_field( $filter_option['slug'], $filter_option['single_name'], 'text' );
				}
			}
		}

		$this->set_import_function( array( $this, 'stm_import_generate_content' ) );
		$this->set_post_saved_function( array( $this, 'saved_post' ) );

		$this->admin_notice();

		$this->run( array(
			'post_types' => array( 'listings' ),
		) );
	}

	public function stm_import_generate_content( $post_id, $data, $import_options, $postData, $logger ) {

		update_post_meta( $post_id, '_wpb_vc_js_status', 'false' );
		update_post_meta( $post_id, 'title', 'hide' );

		$keys = array(
			'stock_number',
			'price',
			'regular_price_label',
			'regular_price_description',
			'regular_price_description',
			'special_price_label',
			'instant_savings_label',
			'vin_number',
			'history',
			'history_link',
			'city_mpg',
			'highway_mpg',
			'stm_car_location',
			'stm_lat_car_admin',
			'stm_lng_car_admin',
			'gallery_video',
			'additional_features',
			'stm_car_user',
			'automanager_id'
		);

		foreach ( $keys as $meta_key ) {
			if ( $this->can_update_meta( $meta_key, $import_options ) ) {
				update_post_meta( $post_id, $meta_key, $data[ $meta_key ] );
			}
		}

		if ( $this->can_update_meta( 'sale_price', $import_options ) ) {
			if ( floatval( $data['sale_price'] ) > 0 ) {
				update_post_meta( $post_id, 'sale_price', $data['sale_price'] );
			} else {
				delete_post_meta( $post_id, 'sale_price' );
			}
		}

		// Update post meta values from attributes
		$filter_options = get_option( 'stm_vehicle_listing_options' );
		foreach ( $filter_options as $filter_option ) {
			$slug = $filter_option['slug'];
			if ( ! empty( $data[ $slug ] ) && update_post_meta( $post_id, $slug, $data[ $slug ] ) ) {
				$logger and call_user_func( $logger, "- Attribute saved: `{$slug}`: {$data[ $slug ]}" );
			}
		}

		if(!empty($data['featured_image'])) {
			$gallery = array();

			$post_thumbnail_id = $data['featured_image'][0]['attachment_id'];

			set_post_thumbnail($post_id, $post_thumbnail_id);

			foreach ( $data['featured_image'] as $image ) {
				if($image['attachment_id'] != $post_thumbnail_id) {
					$gallery[] = $image['attachment_id'];
				}
			}

			update_post_meta( $post_id, 'gallery', $gallery );
			$logger and call_user_func( $logger, "<p><b>Gallery: </b>" . json_encode( $gallery ) . '</p>' );
		}
	}


	public function saved_post( $post_id, $import = null, $logger = null ) {

		// Update post meta values from attributes
		$filter_options = get_option( 'stm_vehicle_listing_options' );
		foreach ( $filter_options as $filter_option ) {
			if ( $filter_option['numeric'] ) {
				continue;
			}

			$old_value = get_post_meta( $post_id, $filter_option['slug'], true );
			$meta_value = null;
			$terms = wp_get_post_terms( $post_id, $filter_option['slug'] );
			if ( ! empty( $terms ) ) {
				$meta_value = reset( $terms )->slug;
			}

			if ( ! empty( $meta_value ) ) {
				if ( $meta_value != $old_value && update_post_meta( $post_id, $filter_option['slug'], $meta_value ) ) {
					$logger and call_user_func( $logger, "- Attribute saved: `{$filter_option['slug']}`: {$meta_value}" );
				}
			} elseif ( ! empty( $old_value ) && delete_post_meta( $post_id, $filter_option['slug'] ) ) {
				$logger and call_user_func( $logger, "- Attribute deleted: `{$filter_option['slug']}`" );
			}
		}




		$gallery = array();
		$images  = get_attached_media( 'image', $post_id );
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );

		if(!empty($images)) {
			foreach ( $images as $image ) {
				if ( $image->ID != $post_thumbnail_id ) {
					$gallery[] = $image->ID;
				}
			}

			update_post_meta( $post_id, 'gallery', $gallery );
			$logger and call_user_func( $logger, "<p><b>Gallery: </b>" . json_encode( $gallery ) . '</p>' );
		}



		$taxonomy = 'media_category';
		$term     = get_term_by( 'slug', 'listings', $taxonomy );

		if ( ! $term ) {
			$new = wp_insert_term( 'Listings', $taxonomy, array( 'slug' => 'listings' ) );
			if ( ! is_wp_error( $new ) ) {
				$term = get_term( $new['term_id'] );
			}
		}

		if ( $term ) {
			foreach ( $gallery as $id ) {
				wp_set_object_terms( $id, $term->term_id, $taxonomy );
			}
		}
	}
}


$stm_import_listing_addon = new STM_Import_Listing_Addon();

