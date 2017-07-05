<?php
$page_bg_color = get_post_meta(get_the_ID(), 'page_bg_color', true);

if(!empty($page_bg_color)): ?>
	<style type="text/css">
		#wrapper {
			background-color: <?php echo esc_attr($page_bg_color); ?>;
		}
	</style>
<?php endif;