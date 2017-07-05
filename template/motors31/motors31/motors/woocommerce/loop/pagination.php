<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="stm-blog-pagination">
			<?php if ( get_previous_posts_link() ) {
				echo '<div class="stm-prev-next stm-prev-btn">';
				previous_posts_link( '<i class="fa fa-angle-left"></i>' );
				echo '</div>';
			} else {
				echo '<div class="stm-prev-next stm-prev-btn disabled"><i class="fa fa-angle-left"></i></div>';
			}

			echo paginate_links( array(
				'type'      => 'list',
				'prev_next' => false
			) );

			if ( get_next_posts_link() ) {
				echo '<div class="stm-prev-next stm-next-btn">';
				next_posts_link( '<i class="fa fa-angle-right"></i>' );
				echo '</div>';
			} else {
				echo '<div class="stm-prev-next stm-next-btn disabled"><i class="fa fa-angle-right"></i></div>';
			} ?>
		</div>
	</div>
</div>
