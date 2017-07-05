<?php
	$user = wp_get_current_user();
	$user_id = $user->ID;
	$user_fields = stm_get_user_custom_fields($user_id);
	$query = stm_user_listings_query($user_id, 'any');

	$main = 'active';
	$fav = '';
	$settings = '';
	$become_dealer = '';

	if(!empty($_GET['my_favourites']) and $_GET['my_favourites']) {
		$main = '';
		$fav = 'active';
		$settings = '';
		$become_dealer = '';
	}

	if(!empty($_GET['my_settings']) and $_GET['my_settings']) {
		$main = '';
		$fav = '';
		$settings = 'active';
		$become_dealer = '';
	}

	if(!empty($_GET['become_dealer']) and $_GET['become_dealer']) {
		$main = '';
		$fav = '';
		$settings = '';
		$become_dealer = 'active';
	}

?>

<div class="stm-user-private">
	<div class="container">
		<div class="row">

			<div class="col-md-3 col-sm-3 hidden-sm hidden-xs stm-sticky-user-sidebar">
				<div class="stm-user-private-sidebar">

					<div class="clearfix stm-user-top">

						<div class="stm-user-avatar">
							<?php
							$link = add_query_arg(array('page_admin' => 'settings'), stm_get_author_link(''));

							$hide_empty = '';
							if(!empty($user_fields['image'])) {
								$hide_empty = 'hide-empty';
							} else {
								$hide_empty = 'hide-photo';
							} ?>

							<a href="<?php echo esc_url($link); ?>" class="stm-image-avatar image <?php echo esc_attr($hide_empty); ?>">
								<img class="img-responsive img-avatar" src="<?php echo esc_url($user_fields['image']); ?>" />
								<div class="stm-empty-avatar-icon"><i class="fa fa-camera"></i></div>
							</a>
						</div>

						<div class="stm-user-profile-information">
							<a href="<?php echo esc_url($link); ?>" class="title heading-font"><?php echo esc_attr(stm_display_user_name($user->ID)); ?></a>
							<div class="title-sub"><?php esc_html_e('Private Seller', 'motors'); ?></div>
							<?php if(!empty($user_fields['socials'])): ?>
								<div class="socials clearfix">
									<?php foreach($user_fields['socials'] as $social_key => $social): ?>
										<a href="<?php echo esc_url($social); ?>">
											<?php
												if($social_key == 'youtube') {
													$social_key = 'youtube-play';
												}
											?>
											<i class="fa fa-<?php echo esc_attr($social_key); ?>"></i>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>

					</div>

					<?php if(!stm_pricing_enabled()): ?>
						<div class="stm-became-dealer">
							<a href="<?php echo esc_url(add_query_arg(array('become_dealer' => 1), stm_get_author_link(''))); ?>" class="button stm-dp-in"><?php esc_html_e('Become a dealer', 'motors'); ?></a>
						</div>
					<?php endif; ?>

					<div class="stm-actions-list heading-font">

						<a
							href="<?php echo esc_url(stm_get_author_link('')); ?>" class="<?php echo esc_attr($main); ?>">
							<i class="stm-service-icon-inventory"></i><?php esc_html_e('My Inventory','motors') ?>
						</a>

						<a
							href="<?php echo esc_url(add_query_arg(array('my_favourites' => 1), stm_get_author_link(''))); ?>"
							class="<?php echo esc_attr($fav); ?>">
							<i class="stm-service-icon-star-o"></i>
							<?php esc_html_e('My Favorites','motors') ?>
						</a>

						<a
							href="<?php echo esc_url(add_query_arg(array('my_settings' => 1), stm_get_author_link(''))); ?>"
							class="<?php echo esc_attr($settings); ?>">
							<i class="fa fa-cog"></i>
							<?php esc_html_e('Profile Settings','motors') ?>
						</a>

					</div>

					<?php if(!empty($user_fields['phone'])): ?>
						<div class="stm-dealer-phone">
							<i class="stm-service-icon-phone"></i>
							<div class="phone-label heading-font"><?php esc_html_e('Seller Contact Phone', 'motors'); ?></div>
							<div class="phone"><?php echo esc_attr($user_fields['phone']); ?></div>
						</div>
					<?php endif; ?>

					<div class="stm-dealer-mail">
						<i class="fa fa-envelope-o"></i>
						<div class="mail-label heading-font"><?php esc_html_e('Seller Email', 'motors'); ?></div>
						<div class="mail"><a href="mailto:<?php echo esc_attr($user->data->user_email); ?>">
								<?php echo esc_attr($user->data->user_email); ?>
						</a></div>
					</div>


					<?php if(stm_pricing_enabled()): ?>
						<?php $stm_user_active_subscriptions = stm_user_active_subscriptions(); ?>
						<div class="stm-user-current-plan-info heading-font">
							<?php if(!empty($stm_user_active_subscriptions)): ?>
								<?php
									$day_left = false;
									$date_expires = strtotime($stm_user_active_subscriptions['expires']);
									$date_now = time();
									$date_diff = ($date_expires - $date_now) / (60*60*24);

									if($date_diff < 1) {
										$day_left = true;
									}
								?>


								<div class="sub-title"><?php esc_html_e('Current Plan', 'motors'); ?></div>
								<div class="stm-plan-name"><?php echo $stm_user_active_subscriptions['plan_name']; ?></div>
								<div class="sub-title"><?php esc_html_e('Subscription renewal', 'motors'); ?></div>
								<?php if($day_left): ?>
									<div class="days-left stm-start-countdown"></div>

									<script type="text/javascript">
										jQuery(document).ready(function(){
											var $ = jQuery;
											$(".stm-start-countdown")
												.countdown("<?php echo $stm_user_active_subscriptions['expires']; ?>", function (event) {
													$(this).text(
														event.strftime('%H:%M:%S')
													);
												});
										})
									</script>

								<?php else: ?>
									<div class="days-left"><?php echo date('m.d.Y', $date_expires); ?></div>
								<?php endif; ?>
								<?php $stm_pricing_link = stm_pricing_link();
								if(!empty($stm_pricing_link)): ?>
									<div class="stm-plan-renew">
										<a href="<?php echo esc_url($stm_pricing_link); ?>" class="button stm-dp-in"><?php esc_html_e('Get new plan', 'motors'); ?></a>
									</div>
								<?php endif; ?>
							<?php else: ?>
								<div class="sub-title"><?php esc_html_e('Current Plan', 'motors'); ?></div>
								<div class="stm-plan-name stm-free-plan"><?php esc_html_e('Free', 'motors'); ?></div>
								<?php $stm_pricing_link = stm_pricing_link();
								if(!empty($stm_pricing_link)): ?>
									<div class="stm-plan-renew">
										<a href="<?php echo esc_url($stm_pricing_link); ?>" class="button stm-dp-in"><?php esc_html_e('Upgrade plan', 'motors'); ?></a>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					<?php else: ?>
						<div class="show-my-profile">
							<a href="<?php echo esc_url(stm_get_author_link('myself-view')); ?>" target="_blank"><i class="fa fa-external-link"></i><?php esc_html_e('Show my Public Profile', 'motors'); ?></a>
						</div>
					<?php endif; ?>

				</div>
			</div>

			<div class="col-md-9 col-sm-12">
				<div class="stm-user-private-main">
					<?php if($fav == 'active'): ?>
						<div class="archive-listing-page">
							<?php get_template_part('partials/user/private/user', 'favourite'); ?>
						</div>
					<?php elseif($settings == 'active'): ?>
						<?php get_template_part('partials/user/private/user', 'settings'); ?>
					<?php elseif($become_dealer == 'active'): ?>
						<?php get_template_part('partials/user/private/become', 'dealer'); ?>
					<?php else: ?>
						<?php if($query->have_posts()): ?>
							<?php get_template_part('partials/user/private/user', 'inventory'); ?>
							<div class="archive-listing-page">
								<?php while($query->have_posts()): $query->the_post(); ?>
									<?php get_template_part('partials/listing-cars/listing-list-directory-edit', 'loop'); ?>
								<?php endwhile; ?>
							</div>
						<?php else: ?>
							<h4 class="stm-seller-title"><?php esc_html_e('No Inventory yet', 'motors'); ?></h4>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
</div>