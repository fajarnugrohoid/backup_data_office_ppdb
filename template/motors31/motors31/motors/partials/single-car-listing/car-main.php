	<div class="row">
		<div class="col-md-9 col-sm-12 col-xs-12">
			<div class="single-listing-car-inner">
				<?php //Title and price
					get_template_part('partials/single-car-listing/car-price-title');
				?>

				<?php //Gallery
					get_template_part('partials/single-car-listing/car-gallery');
				?>

				<?php //CAR DATA
					$data = stm_get_single_car_listings();
					if(!empty($data)):
				?>
					<div class="stm-car-listing-data-single stm-border-top-unit">
						<div class="title heading-font"><?php esc_html_e('Car Details','motors'); ?></div>
					</div>

					<?php get_template_part('partials/single-car-listing/car-data'); ?>
				<?php endif; ?>


				<?php
					$features = get_post_meta(get_the_id(), 'additional_features', true);
					if(!empty($features)):
				?>
						<div class="stm-car-listing-data-single stm-border-top-unit ">
							<div class="title heading-font"><?php esc_html_e('Features', 'motors'); ?></div>
						</div>
						<?php get_template_part('partials/single-car-listing/car-features'); ?>

					<?php endif; ?>

				<?php the_content(); ?>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12">

			<?php if ( is_active_sidebar( 'stm_listing_car' )) { ?>
				<div class="stm-single-listing-car-sidebar">
					<?php dynamic_sidebar( 'stm_listing_car' ); ?>
				</div>
			<?php }; ?>

		</div>
	</div>