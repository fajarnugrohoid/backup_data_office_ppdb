<?php get_header(); ?>
<?php
	$shop_sidebar_id = get_theme_mod('shop_sidebar', 768);
	$shop_sidebar_position = get_theme_mod('shop_sidebar_position', 'left');


	if(!empty($shop_sidebar_id)) {
		$shop_sidebar = get_post( $shop_sidebar_id );
	}

	$stm_sidebar_layout_mode = stm_sidebar_layout_mode($shop_sidebar_position, $shop_sidebar_id);
?>

		<?php get_template_part( 'partials/title_box' ); ?>

		<div class="container">
			<div class="row">

				<?php echo $stm_sidebar_layout_mode['content_before']; ?>
				<?php
					if( have_posts() ){
						woocommerce_content();
					}
				?>
				<?php echo $stm_sidebar_layout_mode['content_after']; ?>



				<?php echo $stm_sidebar_layout_mode['sidebar_before']; ?>
					<div class="stm-shop-sidebar-area">
						<?php
						if(!empty($shop_sidebar_id)) {
							echo apply_filters( 'the_content' , $shop_sidebar->post_content);
						}
						?>
					</div>
				<?php echo $stm_sidebar_layout_mode['sidebar_after']; ?>

			</div> <!--row-->
		</div> <!--container-->

	
<?php get_footer(); ?>