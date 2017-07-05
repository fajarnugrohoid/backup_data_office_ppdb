<div class="clearfix stm-boats-single-top">
	<div class="pull-right">
		<!--Prices-->
		<div class="stm-boats-single-price">
			<?php get_template_part('partials/single-car-boats/boat', 'price'); ?>
		</div>
	</div>
	<h2 class="title"><?php echo stm_generate_title_from_slugs(get_the_id()); ?></h2>
</div>

<?php
$show_stock = get_theme_mod('show_stock', true);
$stock_number = get_post_meta(get_the_id(),'stock_number',true);
if($show_stock and !empty($stock_number)):
?>
	<div class="boats-stock">
		<?php esc_html_e('Stock#', 'motors'); ?>
		<strong><?php echo esc_attr($stock_number); ?></strong>
	</div>
<?php endif; ?>