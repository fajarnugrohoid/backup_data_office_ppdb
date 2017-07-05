<?php

// Compare
$show_compare = get_theme_mod('show_listing_compare', true);
if(empty($_COOKIE['compare_ids'])) {
	$_COOKIE['compare_ids'] = array();
}
$cars_in_compare = $_COOKIE['compare_ids'];

if(!empty($show_compare) and $show_compare): ?>
	<div class="stm_compare_unit">
		<?php if(in_array(get_the_ID(), $cars_in_compare)): ?>
			<a
				href="#"
				class="add-to-compare active"
				title="<?php esc_html_e('Remove from compare', 'motors'); ?>"
				data-id="<?php echo esc_attr(get_the_ID()); ?>"
				data-title="<?php echo esc_attr(get_the_title()); ?>">
				<i class="fa fa-plus"></i>
			</a>
		<?php else: ?>
			<a
				href="#"
				class="add-to-compare"
				title="<?php esc_html_e('Add to compare', 'motors'); ?>"
				data-id="<?php echo esc_attr(get_the_ID()); ?>"
				data-title="<?php echo esc_attr(get_the_title()); ?>">
				<i class="fa fa-plus"></i>
			</a>
		<?php endif; ?>
	</div>
<?php endif; ?>