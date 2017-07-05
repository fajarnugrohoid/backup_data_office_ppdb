<?php $footer_copyright_enabled = get_theme_mod('footer_copyright', true); ?>

<?php
	$allowed_html = array(
		'a' => array(
			'href' => array(),
			'title' => array()
		),
		'span' => array(
			'class' => array()
		)
	);
?>

<?php
if(stm_is_listing()) {
	$footer_bg = '#153e4d';
} else {
	$footer_bg = '#232628';
}

$footer_bg = get_theme_mod('footer_bg_color', $footer_bg);
$style = '';

if(!empty($footer_bg)) {
	$style = 'style=background-color:'.$footer_bg;
}
?>

<?php if($footer_copyright_enabled): ?>
	<?php $footer_copyright_text = get_theme_mod('footer_copyright_text', '&copy; 2015 <a target="_blank" href="http://www.stylemixthemes.com/">Stylemix Themes</a><span class="divider"></span>Trademarks and brands are the property of their respective owners.'); ?>
	<?php if(stm_is_boats()): ?>
		<div id="footer-copyright" <?php echo esc_attr($style); ?>>

			<?php if(stm_is_listing()) {
				get_template_part('partials/listing-layout-parts/footer-copyright', 'top');
			} ?>

			<div class="container footer-copyright">
				<div class="row">
					<div class="col-md-12">
						<div class="clearfix">
							<?php if($footer_copyright_text): ?>
								<div class="copyright-text text-center"><?php echo wp_kses($footer_copyright_text, $allowed_html); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else: ?>
		<div id="footer-copyright" <?php echo esc_attr($style); ?>>

			<?php if(stm_is_listing()) {
				get_template_part('partials/listing-layout-parts/footer-copyright', 'top');
			} ?>

			<div class="container footer-copyright">
				<div class="row">
					<div class="col-md-8 col-sm-8">
						<div class="clearfix">
							<?php if($footer_copyright_text): ?>
								<div class="copyright-text"><?php echo wp_kses($footer_copyright_text, $allowed_html); ?></div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="clearfix">
							<div class="pull-right xs-pull-left">
								<?php $socials = stm_get_header_socials('footer_socials_enable'); ?>
								<!-- Header top bar Socials -->
								<?php if(!empty($socials)): ?>
									<div class="pull-right">
										<div class="copyright-socials">
											<ul class="clearfix">
												<?php foreach ( $socials as $key => $val ): ?>
													<li>
														<a href="<?php echo esc_url($val) ?>">
															<i class="fa fa-<?php echo esc_attr($key); ?>"></i>
														</a>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>