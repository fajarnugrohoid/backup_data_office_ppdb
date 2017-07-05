<?php $vc_status = get_post_meta( get_the_ID() , '_wpb_vc_js_status', true); ?>

<?php if( $vc_status != 'false' && $vc_status == true ): ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="">
			<div class="post-content post-content-vc">
				<?php the_content(); ?>
			</div>
			<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'motors' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'motors' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
			?>
		</div>
	</div>

<?php else: ?>

	<?php
		$sidebar_id = get_theme_mod('sidebar_blog', 'primary_sidebar');
		$sidebar_position = get_theme_mod('sidebar_position', 'left');

		if( !empty($sidebar_id) ) {
			$blog_sidebar = get_post( $sidebar_id );
		}
		
		if($sidebar_id == 'no_sidebar') {
			$sidebar_id = false;
		}
		
		

		$stm_sidebar_layout_mode = stm_sidebar_layout_mode($sidebar_position, $sidebar_id);

	?>

	<div class="row">
		<?php echo $stm_sidebar_layout_mode['content_before']; ?>

			<!--Title-->
			<h2 class="post-title"><?php the_title(); ?></h2>

			<!--Post thumbnail-->
			<?php if ( has_post_thumbnail() ): ?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail( 'stm-img-1110-577', array( 'class' => 'img-responsive' ) ); ?>
				</div>
			<?php endif; ?>

			<!--Blog meta-->
			<div class="blog-meta clearfix">
				<div class="left">
					<div class="clearfix">
						<div class="blog-meta-unit h6">
							<i class="stm-icon-date"></i>
							<span><?php echo get_the_date(); ?></span>
						</div>
						<div class="blog-meta-unit h6">
							<i class="stm-icon-author"></i>
							<span><?php esc_html_e( 'Posted by:', 'motors' ); ?></span>
							<span><?php the_author(); ?></span>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="blog-meta-unit h6">
						<a href="<?php comments_link(); ?>" class="post_comments h6">
							<i class="stm-icon-message"></i> <?php comments_number(); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="post-content">
				<?php the_content(); ?>
				<div class="clearfix"></div>
			</div>

			<?php
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'motors' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'motors' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>

			<div class="blog-meta-bottom">
				<div class="clearfix">
					<div class="left">
						<!--Categories-->
						<?php $cats = get_the_category( get_the_id() ); //print_r($cats); ?>
						<?php if ( ! empty( $cats ) ): ?>
							<div class="post-cat">
								<span class="h6"><?php esc_html_e( 'Category:', 'motors' ); ?></span>
								<?php foreach ( $cats as $cat ): ?>
									<span class="post-category">
										<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><span><?php echo $cat->name; ?></span></a><span class="divider">,</span>
									</span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<!--Tags-->
						<?php if( $tags = wp_get_post_tags( get_the_ID() ) ){ ?>
							<div class="post-tags">

								<span class="h6"><?php esc_html_e( 'Tags:', 'motors' ); ?></span>
								<span class="post-tag">
									<?php echo get_the_tag_list('', ', ', ''); ?>
								</span>
							</div>
						<?php } ?>
					</div>

					<div class="right">
						<div class="stm-shareble">
							<span class="st_sharethis_large" displaytext=""></span>
							<script type="text/javascript">var switchTo5x=true;</script>
							<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
							<script type="text/javascript">stLight.options({doNotHash: false, doNotCopy: false, hashAddressBar: false,onhover: false});</script>
							<a
								href="#"
								class="car-action-unit stm-share"
								title="<?php esc_html_e('Share this', 'motors'); ?>"
								download>
								<i class="stm-icon-share"></i>
								<?php esc_html_e('Share this', 'motors'); ?>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!--Author info-->
			<?php if ( get_the_author_meta('description') ) : ?>
				<div class="stm-author-box clearfix">
					<div class="author-image">
						<?php echo get_avatar( get_the_author_meta( 'email' ), 86 ); ?>
					</div>
					<div class="author-content">
						<h6><?php esc_html_e( 'Author:', 'motors' ); ?></h6>
						<h4><?php the_author_meta('nickname'); ?></h4>
						<div class="author-description"><?php echo get_the_author_meta( 'description' ); ?></div>
					</div>
				</div>
			<?php endif; ?>

			<!--Comments-->
			<?php if ( comments_open() || get_comments_number() ) { ?>
				<div class="stm_post_comments">
					<?php comments_template(); ?>
				</div>
			<?php } ?>

		<?php echo $stm_sidebar_layout_mode['content_after']; ?>


		<!--Sidebar-->
		<?php
			if($sidebar_id == 'primary_sidebar') {
				echo $stm_sidebar_layout_mode['sidebar_before'];
				get_sidebar();
				echo $stm_sidebar_layout_mode['sidebar_after'];
			}else if(!empty($sidebar_id)) {
				echo $stm_sidebar_layout_mode['sidebar_before'];
					echo apply_filters( 'the_content' , $blog_sidebar->post_content);
				echo $stm_sidebar_layout_mode['sidebar_after']; ?>
				<style type="text/css">
					<?php echo get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true ); ?>
				</style>
			<?php }
		?>
	</div>
<?php endif; ?>