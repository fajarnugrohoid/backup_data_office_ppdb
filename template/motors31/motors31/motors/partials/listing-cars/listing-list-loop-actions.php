<?php
if(empty($_COOKIE['compare_ids'])) {
	$_COOKIE['compare_ids'] = array();
}
$cars_in_compare = $_COOKIE['compare_ids'];

$stock_number = get_post_meta(get_the_id(),'stock_number',true);
$car_brochure = get_post_meta(get_the_ID(),'car_brochure',true);

$certified_logo_1 = get_post_meta(get_the_ID(),'certified_logo_1',true);
$history_link_1 = get_post_meta(get_the_ID(),'history_link',true);

$certified_logo_2 = get_post_meta(get_the_ID(),'certified_logo_2',true);
$certified_logo_2_link = get_post_meta(get_the_ID(),'certified_logo_2_link',true);

//Show car actions
$show_stock = get_theme_mod('show_listing_stock', true);
$show_test_drive = get_theme_mod('show_listing_test_drive', false);
$show_compare = get_theme_mod('show_listing_compare', true);
$show_share = get_theme_mod('show_listing_share', false);
$show_pdf = get_theme_mod('show_listing_pdf', false);
$show_certified_logo_1 = get_theme_mod('show_listing_certified_logo_1', true);
$show_certified_logo_2 = get_theme_mod('show_listing_certified_logo_2', true);

if(stm_is_listing()){
	$show_compare = false;
}

/*If automanager, and no image in admin, set default image carfax*/

if(stm_check_if_car_imported(get_the_ID()) and empty($certified_logo_1) and !empty($history_link_1)) {
	$certified_logo_1 = 'automanager_default';
}
?>

<div class="single-car-actions">
	<ul class="list-unstyled clearfix">

		<!--Stock num-->
		<?php if(!empty($stock_number) and !empty($show_stock) and $show_stock): ?>
			<li>
				<div class="stock-num heading-font"><span><?php esc_html_e('stock', 'motors'); ?># </span><?php echo esc_attr($stock_number); ?></div>
			</li>
		<?php endif; ?>

		<!--Schedule-->
		<?php if(!empty($show_test_drive) and $show_test_drive): ?>
			<li>
				<a href="#" class="car-action-unit stm-schedule" data-toggle="modal" data-target="#test-drive" onclick="stm_test_drive_car_title(<?php echo esc_js(get_the_ID()); ?>, '<?php echo esc_js(get_the_title(get_the_ID())) ?>')">
					<i class="stm-icon-steering_wheel"></i>
					<?php esc_html_e('Schedule Test Drive', 'motors'); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--COmpare-->
		<?php if(!empty($show_compare) and $show_compare): ?>
			<li>
				<?php if(in_array(get_the_ID(), $cars_in_compare)): ?>
					<a
						href="#"
						class="car-action-unit add-to-compare stm-added"
						data-id="<?php echo esc_attr(get_the_ID()); ?>"
						data-action="remove">
						<i class="stm-icon-added stm-unhover"></i>
						<span class="stm-unhover"><?php esc_html_e('in compare list', 'motors'); ?></span>
						<div class="stm-show-on-hover">
							<i class="stm-icon-remove"></i>
							<?php esc_html_e('Remove from list', 'motors'); ?>
						</div>
					</a>
				<?php else: ?>
					<a
						href="#"
						class="car-action-unit add-to-compare"
						data-id="<?php echo esc_attr(get_the_ID()); ?>"
						data-action="add">
						<i class="stm-icon-add"></i>
						<?php esc_html_e('Add to compare', 'motors'); ?>
					</a>
				<?php endif; ?>
			</li>
		<?php endif; ?>

		<!--PDF-->
		<?php if(!empty($show_pdf) and $show_pdf): ?>
			<?php if(!empty($car_brochure)): ?>
				<li>
					<a
						href="<?php echo esc_url(wp_get_attachment_url($car_brochure)); ?>"
						class="car-action-unit stm-brochure"
						title="<?php esc_html_e('Download brochure', 'motors'); ?>"
						download>
						<i class="stm-icon-brochure"></i>
						<?php esc_html_e('Car brochure', 'motors'); ?>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>


		<!--Share-->
		<?php if(!empty($show_share) and $show_share): ?>
			<li class="stm-shareble">
				<span class="st_sharethis_large" displaytext=""></span>
				<script type="text/javascript">var switchTo5x=true;</script>
				<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">if (typeof stLight != 'undefined') { stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false,onhover: false}); }</script>
				<a
					href="#"
					class="car-action-unit stm-share"
					data-url="<?php echo get_the_permalink( get_the_ID() ); ?>"
					title="<?php esc_html_e('Share this', 'motors'); ?>"
					download>
					<i class="stm-icon-share"></i>
					<?php esc_html_e('Share this', 'motors'); ?>
				</a>
			</li>
		<?php endif; ?>

		<!--Certified Logo 1-->
		<?php if(!empty($certified_logo_1) and !empty($show_certified_logo_1) and $show_certified_logo_1): 
			if($certified_logo_1 == 'automanager_default') {
				$certified_logo_1 = array();
				$certified_logo_1[0] = get_template_directory_uri() . '/assets/images/carfax.png';
			} else {
				$certified_logo_1 = wp_get_attachment_image_src($certified_logo_1, 'stm-img-255-135');
			}
			if(!empty($certified_logo_1[0])){
				$certified_logo_1 = $certified_logo_1[0]; 
				
			?>

				<li class="certified-logo-1">
					<?php if(!empty($history_link_1)): ?>
					<a href="<?php echo esc_url($history_link_1); ?>" target="_blank">
						<?php endif; ?>
						<img src="<?php echo esc_url($certified_logo_1); ?>" alt="<?php esc_html_e('Logo 1', 'motors'); ?>"/>
						<?php if(!empty($history_link_1)): ?>
					</a>
				<?php endif; ?>
				</li>



			<?php } ?>
		<?php endif; ?>

		<!--Certified Logo 2-->
		<?php if(!empty($certified_logo_2) and !empty($show_certified_logo_2) and $show_certified_logo_2): ?>
			<?php
			$certified_logo_2 = wp_get_attachment_image_src($certified_logo_2, 'stm-img-255-135');
			if(!empty($certified_logo_2[0])){
				$certified_logo_2 = $certified_logo_2[0]; ?>


				<li class="certified-logo-2">
					<?php if(!empty($certified_logo_2_link)): ?>
					<a href="<?php echo esc_url($certified_logo_2_link); ?>" target="_blank">
						<?php endif; ?>
						<img src="<?php echo esc_url($certified_logo_2); ?>"  alt="<?php esc_html_e('Logo 2', 'motors'); ?>"/>
						<?php if(!empty($certified_logo_2_link)): ?>
					</a>
				<?php endif; ?>
				</li>

			<?php } ?>
		<?php endif; ?>

	</ul>
</div>