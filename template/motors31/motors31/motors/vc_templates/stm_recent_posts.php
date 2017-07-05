<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( empty( $number_of_posts ) ) {
	$number_of_posts = 1;
}

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => $number_of_posts,
);

$r = new WP_Query( $args );

?>

<?php if ( $r->have_posts() ) :?>
	<div class="widget stm_widget_recent_entries">
		<?php if(!empty($title)): ?>
			<h4 class="widgettitle"><?php echo esc_attr($title); ?></h4>
		<?php endif; ?>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<div class="stm-last-post-widget">
				<?php echo wp_trim_words( get_the_excerpt(), 13, '...' ); ?>
				<?php $com_num = get_comments_number( get_the_id() ); ?>
				<?php if ( ! empty( $com_num ) ) { ?>
					<div class="comments-number">
						<a href="<?php echo esc_url(get_comments_link(get_the_ID())); ?>"><i
								class="stm-icon-message"></i><?php echo esc_attr( $com_num ) . ' ' . esc_html__( 'Comment', 'motors' ); ?>
						</a>
					</div>
				<?php } else { ?>
					<div class="comments-number">
						<a href="<?php the_permalink() ?>">
							<i class="stm-icon-message"></i><?php esc_html_e( 'No comments', 'motors' ); ?>
						</a>
					</div>
				<?php }; ?>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
<?php endif;