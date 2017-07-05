<?php $compare_page = get_theme_mod( 'compare_page', 156); ?>
<div class="single-add-to-compare">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<div class="single-add-to-compare-left">
					<i class="add-to-compare-icon stm-icon-speedometr2"></i>
					<span class="stm-title h5"></span>
				</div>
			</div>
			<div class="col-md-3 col-sm-3">
				<a href="<?php echo esc_url(get_the_permalink($compare_page)); ?>" class="compare-fixed-link pull-right heading-font">
					<?php echo esc_html__('Compare', 'motors'); ?>
				</a>
			</div>
		</div>
	</div>
</div>