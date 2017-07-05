<?php

$post_id = get_the_id();
$user_added_by = get_post_meta($post_id, 'stm_car_user', true);

if(!empty($user_added_by)):

	$user_data = get_userdata($user_added_by);

	if($user_data):

		$user_fields = stm_get_user_custom_fields($user_added_by);
		$is_dealer = stm_get_user_role($user_added_by);

		if($is_dealer):
			$ratings = stm_get_dealer_marks($user_added_by);
			?>

			<div class="stm-listing-car-dealer-info">
				<a class="stm-no-text-decoration" href="<?php echo esc_url(stm_get_author_link($user_added_by)); ?>"><h3 class="title"><?php stm_display_user_name($user_added_by); ?></h3></a>
				<div class="clearfix">
					<div class="dealer-image">
						<div class="stm-dealer-image-custom-view">
							<a href="<?php echo esc_url(stm_get_author_link($user_added_by)); ?>">
								<?php if(!empty($user_fields['logo'])): ?>
									<img src="<?php echo esc_url($user_fields['logo']); ?>" />
								<?php else: ?>
									<img src="<?php stm_get_dealer_logo_placeholder(); ?>" />
								<?php endif; ?>
							</a>
						</div>
					</div>
					<?php if(!empty($ratings['average'])): ?>
						<div class="dealer-rating">
							<div class="stm-rate-unit">
								<div class="stm-rate-inner">
									<div class="stm-rate-not-filled"></div>
									<div class="stm-rate-filled" style="width:<?php echo esc_attr($ratings['average_width']); ?>"></div>
								</div>
							</div>
							<div class="stm-rate-sum">(<?php esc_html_e('Reviews', 'motors'); ?> <?php echo esc_attr($ratings['count']); ?>)</div>
						</div>
					<?php endif; ?>
				</div>

				<div class="dealer-contacts">
					<?php if(!empty($user_fields['phone'])): ?>
						<div class="dealer-contact-unit phone">
							<i class="stm-service-icon-phone_2"></i>
							<div class="phone heading-font"><?php echo esc_attr($user_fields['phone']); ?></div>
							<?php /*<div class="phone-label"><?php esc_html_e('Call Free 24/7', 'motors'); ?></div>*/ ?>
						</div>
					<?php endif; ?>
					<?php if(!empty($user_fields['location'])): ?>
						<div class="dealer-contact-unit address">
							<i class="stm-service-icon-pin_2"></i>
							<div class="address"><?php echo esc_attr($user_fields['location']); ?></div>
						</div>
					<?php endif; ?>
					<?php if(!empty($user_fields['email']) and !empty($user_fields['show_mail']) and $user_fields['show_mail'] == 'show'): ?>
						<div class="dealer-contact-unit mail">
							<i class="fa fa-envelope-o"></i>
							<div class="stm-label"><?php esc_html_e('Seller Email', 'motors'); ?></div>
							<div class="address"><a class="heading-font" href="mailto:<?php echo esc_attr($user_fields['email']); ?>"><?php echo esc_attr($user_fields['email']); ?></a></div>
						</div>
					<?php endif; ?>
				</div>
			</div>

		<?php else: ?>
			<div class="stm-listing-car-dealer-info stm-common-user">

				<div class="clearfix stm-user-main-info-c">
					<div class="image">
						<a href="<?php echo esc_url(stm_get_author_link($user_added_by)); ?>">
							<?php if(!empty($user_fields['image'])): ?>
								<img src="<?php echo esc_url($user_fields['image']); ?>" />
							<?php else: ?>
								<div class="no-avatar">
									<i class="stm-service-icon-user"></i>
								</div>
							<?php endif; ?>
						</a>
					</div>
					<a class="stm-no-text-decoration" href="<?php echo esc_url(stm_get_author_link($user_added_by)); ?>">
						<h3 class="title"><?php stm_display_user_name($user_added_by); ?></h3>
						<div class="stm-label"><?php esc_html_e('Private Seller', 'motors'); ?></div>
					</a>
				</div>

				<div class="dealer-contacts">
					<?php if(!empty($user_fields['phone'])): ?>
						<div class="dealer-contact-unit phone">
							<i class="stm-service-icon-phone_2"></i>
							<div class="phone heading-font"><?php echo esc_attr($user_fields['phone']); ?></div>
							<?php /*<div class="phone-label"><?php esc_html_e('Call Free 24/7', 'motors'); ?></div>*/ ?>
						</div>
					<?php endif; ?>
					<?php if(!empty($user_fields['email']) and !empty($user_fields['show_mail']) and $user_fields['show_mail'] == 'show'): ?>
						<div class="dealer-contact-unit mail">
							<i class="fa fa-envelope-o"></i>
							<div class="stm-label"><?php esc_html_e('Seller Email', 'motors'); ?></div>
							<div class="address"><a class="heading-font" href="mailto:<?php echo esc_attr($user_fields['email']); ?>"><?php echo esc_attr($user_fields['email']); ?></a></div>
						</div>
					<?php endif; ?>
				</div>
			</div>

		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>