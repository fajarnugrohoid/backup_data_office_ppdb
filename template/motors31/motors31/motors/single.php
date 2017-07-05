<?php get_header();?>
	<?php get_template_part('partials/page_bg'); ?>
	<?php get_template_part('partials/title_box'); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="stm-single-post">
			<div class="container">
				<?php if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part('partials/blog/content');
					endwhile;
				endif; ?>
			</div>
		</div>
	</div>
<?php get_footer();?>