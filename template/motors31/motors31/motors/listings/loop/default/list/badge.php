<?php
$badge_text = get_post_meta(get_the_ID(),'badge_text',true);

if(!empty($badge_text)):
	$badge_style = '';
	$badge_bg_color = get_post_meta(get_the_ID(),'badge_bg_color',true);
	if(!empty($badge_bg_color)) {
		$badge_style = 'style=background-color:'.$badge_bg_color.';';
	} ?>
	<div class="special-label special-label-small h6" <?php echo esc_attr($badge_style); ?>>
		<?php echo esc_html__($badge_text, 'motors'); ?>
	</div>
<?php endif; ?>