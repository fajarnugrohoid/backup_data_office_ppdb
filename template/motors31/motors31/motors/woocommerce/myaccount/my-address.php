<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$page_title    = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Addresses', 'motors' ) );
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing'  => __( 'Billing Address', 'motors' ),
		'shipping' => __( 'Shipping Address', 'motors' )
	), $customer_id );
} else {
	$page_title    = apply_filters( 'woocommerce_my_account_my_address_title', __( 'My Address', 'motors' ) );
	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
		'billing' => __( 'Billing Address', 'motors' )
	), $customer_id );
}
?>

<div class="colored-separator text-left">
	<div class="first-long"></div>
	<div class="last-short"></div>
</div>
<h4><?php echo balanceTags( $page_title, true ); ?></h4>

<p class="myaccount_address">
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'motors' ) ); ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	echo '<div class="row addresses">';
} ?>

<div class="row">
	<?php foreach ( $get_addresses as $name => $title ) : ?>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 address">
			<div class="colored-separator text-left">
				<div class="first-long"></div>
				<div class="last-short"></div>
			</div>
			<header class="title">
				<h4><?php echo balanceTags( $title, true ); ?></h4>
			</header>
			<?php
			$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
				'country'    => array(
					'title' => __( 'Country', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_country', true )
				),
				'first_name' => array(
					'title' => __( 'Fist Name', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_first_name', true )
				),
				'last_name'  => array(
					'title' => __( 'Last Name', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_last_name', true )
				),
				'company'    => array(
					'title' => __( 'Company', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_company', true )
				),
				'address'    => array(
					'title' => __( 'Address', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_address_1', true ) . ' / ' . get_user_meta( $customer_id, $name . '_address_2', true )
				),
				'city'       => array(
					'title' => __( 'City', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_city', true )
				),
				'state'      => array(
					'title' => __( 'State', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_state', true )
				),
				'postcode'   => array(
					'title' => __( 'Postcode', 'woocommerce' ),
					'value' => get_user_meta( $customer_id, $name . '_postcode', true )
				)

			), $customer_id, $name );


			if ( ! $address ) {
				_e( 'You have not set up this type of address yet.', 'motors' );
			} else {
				$output = '';
			}
			$output .= '<table class="address-table">';
			$output .= '<tbody>';
			foreach ( $address as $value ) {
				$placeholder = '&nbsp;';
				if ( ! empty( $value['value'] ) ) {
					$placeholder = '';
				}
				$output .= '<tr><th>' . esc_html( $value['title'] ) . '</th><td>' . $placeholder . esc_html( $value['value'] ) . '</td></tr>';
			}
			$output .= '</tbody>';
			$output .= '</table>';
			echo balanceTags( $output, true );
			?>
			<footer>
				<a href="<?php echo wc_get_endpoint_url( 'edit-address', $name ); ?>"
				   class="button edit"><?php _e( 'Edit', 'motors' ); ?></a>
			</footer>
		</div>

	<?php endforeach; ?>
</div>


<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	echo '</div>';
} ?>
