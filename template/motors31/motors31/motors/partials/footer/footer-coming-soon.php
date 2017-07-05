<?php $footer_copyright_enabled = get_theme_mod('footer_copyright', true); ?>

<?php if($footer_copyright_enabled): ?>
	<?php $footer_copyright_text = get_theme_mod('footer_copyright_text', '&copy; 2015 <a target="_blank" href="http://www.stylemixthemes.com/">Stylemix Themes</a><span class="divider"></span>Trademarks and brands are the property of their respective owners.'); ?>
	<div id="footer-copyright">
		<div class="container footer-copyright">
			<div class="row">
				<div class="col-md-8 col-sm-8">
					<div class="clearfix">
						<?php if($footer_copyright_text): ?>
							<div class="copyright-text"><?php echo balanceTags($footer_copyright_text, 'motors'); ?></div>
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