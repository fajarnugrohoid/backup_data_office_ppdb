<?php
$id = get_the_ID();
$history_link = get_post_meta($id, 'history_link', true);
$show_share = get_theme_mod('show_share', true);
$show_test_drive = get_theme_mod( 'show_test_drive', true );
$stm_car_link_quote = get_theme_mod('stm_car_link_quote', '#1471332454395-0e51ff9f-8682');


$links                       = array();

if(!empty($stm_car_link_quote)) {
	$links['stm-moto-icon-chat'] = array(
		'link' => $stm_car_link_quote,
		'target' => '_self',
		'text' => esc_html__( 'Request a quote', 'motors' )
	);
}

if ( $show_test_drive ) {
	$links['stm-moto-icon-helm'] = array(
		'link' => '#test-drive',
		'modal' => 'data-toggle="modal" data-target="#test-drive"',
		'text' => esc_html__( 'Schedule test drive', 'motors' )
	);
}

$links['stm-moto-icon-phone-chat'] = array(
	'link' => '#get-a-call',
	'modal' => 'data-toggle="modal" data-target="#get-car-price"',
	'text' => esc_html__( 'Quote by Phone', 'motors' )
);

$links['stm-moto-icon-trade'] = array(
	'link' => '#trade-offer',
	'modal' => 'data-toggle="modal" data-target="#trade-offer"',
	'text' => esc_html__( 'Trade Your Value', 'motors' )
);

$links['stm-moto-icon-cash'] = array(
	'link' => '#calc',
	'modal' => 'data-toggle="modal" data-target="#get-car-calculator"',
	'text' => esc_html__( 'Сalculate Payment', 'motors' )
);

if($show_share) {
	$links['stm-moto-icon-share'] = array(
		'link' => '#calculator',
		'text' => esc_html__( 'Share this', 'motors' )
	);
}

if(!empty($history_link)) {
	$links['stm-moto-icon-report'] = array(
		'link' => esc_url($history_link),
		'text' => esc_html__( 'History report', 'motors' )
	);
}

?>


<div class="stm-single-car-links">
	<?php foreach($links as $icon => $link): ?>
		<?php
			$target = '_blank';
			if(!empty($link['target'])) {
				$target = $link['target'];
			}
		?>
		<div class="stm-single-car-link unit-<?php echo esc_attr($icon); ?> heading-font">
			<a href="<?php echo esc_url($link['link']) ?>" target="<?php echo esc_attr($target); ?>" <?php if(!empty($link['modal'])) echo $link['modal']; ?>>
				<i class="<?php echo esc_attr($icon) ?>"></i>
				<?php echo $link['text']; ?>
			</a>
			<?php if($icon == 'stm-moto-icon-share'): ?>
				<span class="st_sharethis_large" displaytext=""></span>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">if (typeof stLight != 'undefined') { stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false, onhover: false}); }</script>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>

<?php if($show_share): ?>
	<?php
	if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) && ! get_post_meta( get_the_ID(), 'sharing_disabled', true ) ) { ?>
		<div class="share_buttons">
			<label><?php esc_html_e( 'Share', 'motors' ); ?></label>
			<?php
			$addtoany_options = get_option( 'addtoany_options' );
			if ( isset( $addtoany_options['header'] ) && '' != $addtoany_options['header'] ) { ?>
				<div class="addtoany_header"><?php echo stripslashes( esc_html( $addtoany_options['header'] ) ); ?></div>
			<?php }
			ADDTOANY_SHARE_SAVE_KIT( array( "use_current_page" => true ) ); ?>
		</div>
	<?php } ?>
<?php endif; ?>