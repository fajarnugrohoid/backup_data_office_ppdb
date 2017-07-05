			</div> <!--main-->
		</div> <!--wrapper-->
		<?php if(!is_404() and !is_page_template('coming-soon.php')){ ?>
			<footer id="footer">
				<?php get_template_part('partials/footer/footer'); ?>
				<?php get_template_part('partials/footer/copyright'); ?>

				<?php get_template_part('partials/global', 'alerts'); ?>
				<!-- Searchform -->
				<?php get_template_part('partials/modals/searchform'); ?>
			</footer>
		<?php }elseif(is_page_template('coming-soon.php')) {
			get_template_part('partials/footer/footer-coming','soon');
		}; ?>

		<?php
			if ( get_theme_mod( 'frontend_customizer' ) ) {
				get_template_part( 'partials/frontend_customizer' );
			}
		?>
		
	<?php wp_footer(); ?>
	
	<?php get_template_part('partials/modals/test', 'drive'); ?>
	<?php get_template_part('partials/modals/get-car', 'price'); ?>
	<?php get_template_part('partials/modals/car', 'calculator'); ?>
	<?php get_template_part('partials/modals/trade', 'offer'); ?>
	<?php get_template_part('partials/single-car/single-car-compare-modal'); ?>
	<?php
		if(stm_pricing_enabled()) {
			get_template_part( 'partials/modals/limit_exceeded' );
			get_template_part( 'partials/modals/subscription_ended' );
		}
	?>
	
	</body>
</html>