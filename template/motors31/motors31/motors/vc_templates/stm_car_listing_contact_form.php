<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

?>

<div class="stm_listing_car_form <?php echo esc_attr($css_class); ?>">
	<div class="stm-single-car-contact">

		<?php if ( ! empty( $title ) ): ?>
			<div class="title">
				<i class="fa fa-paper-plane"></i>
				<?php echo $title; ?>
			</div>
		<?php endif; ?>

		<?php if($form != '' and $form != 'none'): ?>
			<?php $cf7 = get_post($form); ?>
			<?php echo(do_shortcode('[contact-form-7 id="'.$cf7->ID.'" title="'.($cf7->post_title).'"]')); ?>
		<?php endif; ?>


	</div>
</div>

<?php
	$user_added_by = get_post_meta(get_the_id(), 'stm_car_user', true);
	if(!empty($user_added_by)):
	$user_data = get_userdata($user_added_by);
	if($user_data):
?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				var $ = jQuery;
				var inputAuthor = '<input type="hidden" value="<?php echo intval($user_added_by); ?>" name="stm_changed_recepient"/>';
				$('.stm_listing_car_form form').append(inputAuthor);
			})
		</script>
	<?php endif; ?>
<?php endif; ?>