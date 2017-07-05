<?php
	$list = 'active';
	$grid = '';

	if(!empty($_GET['view']) and $_GET['view'] == 'grid') {
		$list = '';
		$grid = 'active';
	}
?>

<div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
	<div class="stm-listing-directory-title">
		<h4 class="stm-seller-title"><?php esc_html_e('My Favorites', 'motors'); ?></h4>
	</div>
	<div class="stm-directory-listing-top__right">
		<div class="clearfix">
			<div class="stm-view-by">
				<a href="<?php echo esc_url( add_query_arg(array('my_favourites' => 1, 'view' => 'grid'), stm_get_author_link('')) ); ?>" class="view-grid view-type <?php echo esc_attr($grid); ?>">
					<i class="stm-icon-grid"></i>
				</a>
				<a href="<?php echo esc_url(add_query_arg(array('my_favourites' => 1, 'view' => 'list'), stm_get_author_link(''))); ?>" class="view-list view-type <?php echo esc_attr($list); ?>">
					<i class="stm-icon-list"></i>
				</a>
			</div>
		</div>
	</div>
</div>

<?php
	$user = wp_get_current_user();
	if(!empty($user->ID)) {


		$favourites = get_the_author_meta( 'stm_user_favourites', $user->ID );
		if ( ! empty( $favourites ) ) {

			$args = array(
				'post_type'      => stm_listings_post_type(),
				'post_status'         => 'any',
				'posts_per_page' => - 1,
				'post__in' => array_unique(explode(',',$favourites))
			);

			$fav = new WP_Query($args);

			$exist_adds = array();

			?>

			<?php if($fav->have_posts()): ?>
				<div class="<?php if($grid=='active'){ ?>row<?php } ?> car-listing-row clearfix">
					<?php while($fav->have_posts()): $fav->the_post(); ?>

						<?php
						$exist_adds[] = get_the_id();
							if($list == 'active') { ?>
								<div class="stm-listing-fav-loop">
									<?php
										if(get_post_status(get_the_ID()) == 'draft') { ?>
											<div class="stm-car-overlay-disabled"></div>
											<div class="stm_edit_pending_car">
												<h4><?php esc_html_e('Disabled', 'motors'); ?></h4>
												<div class="stm-dots"><span></span><span></span><span></span></div>
											</div>
										<?php } elseif(get_post_status(get_the_ID()) == 'pending') { ?>
											<div class="stm-car-overlay-disabled"></div>
											<div class="stm_edit_pending_car">
												<h4><?php esc_html_e('Under review', 'motors'); ?></h4>
												<div class="stm-dots"><span></span><span></span><span></span></div>
											</div>
										<?php }
										get_template_part( 'partials/listing-cars/listing-list-directory', 'loop' ); ?>
								</div>
								<?php
							} else {
								get_template_part( 'partials/listing-cars/listing-grid-directory', 'loop' );
							}
						?>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>

			<!--Get deleted adds-->
			<?php
				$my_adds = array_unique(explode(',', $favourites));
				$deleted_adds = array_diff($my_adds, $exist_adds);
			?>

			<?php if(!empty($deleted_adds)): ?>
				<div class="stm-deleted-adds">
					<?php foreach($deleted_adds as $deleted_add): ?>
						<?php if($deleted_add != 0): ?>
							<div class="stm-deleted-add">
								<div class="heading-font">
									<i class="fa fa-close stm-listing-favorite" data-id="<?php echo esc_attr($deleted_add); ?>"></i>
									<?php esc_html_e('the Item was removed', 'motors'); ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if(empty($my_adds) and empty($deleted_adds)): ?>
				<h4><?php esc_html_e('You have not added favorites yet', 'motors'); ?>.</h4>
			<?php endif; ?>

<?php
		} else { ?>

			<h4><?php esc_html_e( 'You have not added favorites yet', 'motors' ); ?>.</h4>
		<?php
		}
	}
?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var $ = jQuery;
		$('.stm-deleted-adds .stm-deleted-add .heading-font .fa-close').on('click', function(){
			$(this).closest('.stm-deleted-add').slideUp();
		});
	});
</script>