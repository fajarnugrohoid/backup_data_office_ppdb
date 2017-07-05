<?php
	$listing_list_sort_slug = get_theme_mod('listing_list_sort_slug', 'make');
	if(!empty($listing_list_sort_slug)) {
		$listing_list_sort_slug = stm_get_all_by_slug($listing_list_sort_slug);
	}
	$data = stm_get_car_archive_listings();
?>

<div class="stm-sort-list-params">
	<ul class="heading-font clearfix">
		<?php if(!empty($listing_list_sort_slug)): ?>
			<li class="main" data-sort="none" data-filter="<?php echo $listing_list_sort_slug['slug']; ?>">
				<span><?php echo esc_html_e($listing_list_sort_slug['single_name'], 'motors'); ?></span>
			</li>
		<?php endif; ?>

		<?php if(!empty($data)): ?>
			<?php foreach($data as $single_data): ?>
				<li class="<?php echo esc_html_e($single_data['slug'], 'motors'); ?>" data-sort="none" data-filter="<?php echo esc_html_e($single_data['slug'], 'motors'); ?>">
					<span><?php echo esc_html_e($single_data['single_name'], 'motors'); ?></span>
				</li>
			<?php endforeach; ?>
			<li class="location" data-sort="none" data-filter="stm_car_location">
				<span><?php esc_html_e('Location', 'motors'); ?></span>
			</li>
		<?php endif; ?>

		<li class="price-main" data-sort="none" data-filter="price">
			<span><?php esc_html_e('Price', 'motors'); ?></span>
		</li>
	</ul>
</div>

<script type="text/javascript">
	(function($) {
		"use strict";
		$(document).ready(function () {
			$('.stm-sort-list-params ul li').on('click', function (e) {
				var $sort = $(this).attr('data-sort');

				if($sort == 'none' || $sort == 'high') {
					stm_isotope_sort_function_boats($(this).attr('data-filter') + '_low');
					$('.stm-sort-list-params ul li').attr('data-sort', 'none');
					$(this).attr('data-sort', 'low');
				}

				if($sort == 'low') {
					stm_isotope_sort_function_boats($(this).attr('data-filter') + '_high');
					$('.stm-sort-list-params ul li').attr('data-sort', 'none');
					$(this).attr('data-sort', 'high');
				}
			});
		});

	})(jQuery);
	function stm_isotope_sort_function_boats(currentChoice) {
		var $ = jQuery;
		var stm_choice = currentChoice;
		var $container = $('.stm-isotope-sorting');
		switch(stm_choice){

			<?php
				if(!empty($listing_list_sort_slug)){ display_script_sort($listing_list_sort_slug);};
				if(!empty($data)){foreach($data as $single_data) {display_script_sort($single_data);}}
				display_script_sort(array('slug'=>'price', 'numeric' => 1));
			?>
			default:
				console.log('dont cheat');
		}

		$container.isotope('updateSortData').isotope();
	}
</script>