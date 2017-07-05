<?php get_header(); ?>

	<div class="stm-error-page-unit">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><?php esc_html_e('The page you are looking for does not exist.', 'motors'); ?></h2>
					<a href="<?php echo esc_url(home_url('/')); ?>" alt="<?php esc_html_e('Home', 'motors'); ?>" class="button"><?php esc_html_e('Home Page', 'motors'); ?></a>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
