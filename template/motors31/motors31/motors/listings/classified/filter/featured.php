<?php
$args                   = stm_listings_query()->query;
$args['posts_per_page'] = 3;
$args['meta_query'][]   = array(
	'key'     => 'special_car',
	'value'   => 'on',
	'compare' => '='
);

$featured = new WP_Query( $args );

$view_type = stm_listings_input('view_type', 'list'); ?>

<?php if ( $featured->have_posts() ): ?>
	<div class="stm-featured-top-cars-title">
		<div class="heading-font"><?php esc_html_e( 'Featured Classified', 'motors' ); ?></div>
		<a href="<?php echo esc_url( stm_get_listing_archive_link() . '?featured_top=true' ); ?>">
			<?php esc_html_e( 'Show all', 'motors' ); ?>
		</a>
	</div>

	<?php if(!stm_listings_input('featured_top')): ?>
		<?php if ( $view_type == 'grid' ): ?>
			<div class="row row-3 car-listing-row car-listing-modern-grid">
		<?php endif; ?>


			<div class="stm-isotope-sorting stm-isotope-sorting-featured-top">

				<?php
					$template = 'partials/listing-cars/listing-' . $view_type . '-directory-loop';
					while ( $featured->have_posts() ): $featured->the_post();
						get_template_part('partials/listing-cars/listing-' . $view_type . '-directory-loop');
					endwhile;
				?>

			</div>

		<?php if ( $view_type == 'grid' ): ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>