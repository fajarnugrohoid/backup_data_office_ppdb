<?php
	//Get sidebar settings

	$sidebar_id = get_theme_mod('sidebar', 'primary_sidebar');
	$sidebar_position = get_theme_mod('sidebar_position', 'right');

	if(!empty($_GET['sidebar-position']) and $_GET['sidebar-position'] == 'left') {
		$sidebar_position = 'left';
	}

	if(!empty($_GET['sidebar-position']) and $_GET['sidebar-position'] == 'right') {
		$sidebar_position = 'right';
	}

	if(!empty($_GET['sidebar-position']) and $_GET['sidebar-position'] == 'none') {
		$sidebar_id = false;
	}
	
	if($sidebar_id == 'no_sidebar') {
		$sidebar_id = false;
	}

	$view_type = get_theme_mod('view_type', 'grid');

	if(!empty($_GET['view-type']) and $_GET['view-type'] == 'grid') {
		$view_type = 'grid';
	}

	if(!empty($_GET['view-type']) and $_GET['view-type'] == 'list') {
		$view_type = 'list';
	}

	if( !empty($sidebar_id) ) {
		$blog_sidebar = get_post( $sidebar_id );
	}

	$stm_sidebar_layout_mode = stm_sidebar_layout_mode($sidebar_position, $sidebar_id);

?>

<?php get_header(); ?>

	<?php get_template_part('partials/title_box'); ?>

	<div class="stm-archives stm-view-type-<?php echo esc_attr($view_type); ?>">
		<div class="container">
			<div class="row">
				<?php if(have_posts()): ?>
					<?php echo $stm_sidebar_layout_mode['content_before']; ?>
						<?php echo $stm_sidebar_layout_mode['show_title']; ?>

						<?php if($view_type == 'grid'): ?>
						<div class="row row-<?php echo esc_attr($stm_sidebar_layout_mode['default_row']); ?>">
						<?php endif; ?>

						<?php while(have_posts()): the_post(); ?>
							<?php if($view_type == 'grid'): ?>
								<?php get_template_part('partials/blog/content-grid', 'loop'); ?>
							<?php else: ?>
								<?php get_template_part('partials/blog/content-list', 'loop'); ?>
							<?php endif; ?>
						<?php endwhile; ?>

						<?php if($view_type == 'grid'): ?>
						</div>
						<?php endif; ?>

						<!--Pagination-->
						<?php stm_custom_pagination(); ?>

					<?php echo $stm_sidebar_layout_mode['content_after']; ?>

					<!--Sidebar-->
					<?php
						if($sidebar_id == 'primary_sidebar') {
							echo $stm_sidebar_layout_mode['sidebar_before'];
							get_sidebar();
							echo $stm_sidebar_layout_mode['sidebar_after']; 
						} else if(!empty($sidebar_id)) {
							echo $stm_sidebar_layout_mode['sidebar_before'];
							echo apply_filters( 'the_content' , $blog_sidebar->post_content);
							echo $stm_sidebar_layout_mode['sidebar_after']; ?>
							<style type="text/css">
								<?php echo get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true ); ?>
							</style>
					<?php }
					?>
				<?php else: ?>
					<div class="col-md-12">
						<h3 class="text-transform nothing found"><?php esc_html_e('No Results', 'motors'); ?></h3>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>