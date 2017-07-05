<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! $messages ){
	return;
}

?>

<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-info"><i class="fa fa-info-circle"></i><span><?php _e('Informational', 'motors');?>.</span> <?php echo wp_kses_post( $message ); ?></div>
<?php endforeach; ?>
