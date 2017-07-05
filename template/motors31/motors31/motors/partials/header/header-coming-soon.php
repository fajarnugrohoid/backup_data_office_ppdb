<?php $logo_main = get_theme_mod('logo', get_template_directory_uri() . '/assets/images/tmp/logo.png'); ?>

<?php if(!empty($logo_main)): ?>
	<div class="container">
		<div class="coming-soon-header">
			<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php esc_html_e('Home', 'motors'); ?>">
				<img src="<?php echo esc_url($logo_main); ?>" style="width: <?php echo get_theme_mod( 'logo_width', '138' ); ?>px;" alt="Logo"/>
			</a>
		</div>
	</div>
<?php endif; ?>