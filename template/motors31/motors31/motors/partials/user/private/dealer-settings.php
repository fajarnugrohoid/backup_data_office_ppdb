<?php
	if(!is_user_logged_in()){
		die('You are not logged in');
	} else {
		$got_error_validation = false;
		$data_saved = false;
		$error_msg = esc_html__('Error, try again', 'motors');

		$user_page_id = get_queried_object();
		$user_page_id = $user_page_id->ID;

		$user_current = wp_get_current_user();
		$user_id = $user_current->ID;
		$user = stm_get_user_custom_fields($user_id);

		/*Get current editing values*/
		$user_first_name = (isset($_POST['stm_first_name'])) ? $_POST['stm_first_name'] : $user['name'];
		$user_last_name = (isset($_POST['stm_first_name'])) ? $_POST['stm_last_name'] : $user['last_name'];
		$user_phone = (!empty($_POST['stm_phone'])) ? $_POST['stm_phone'] : $user['phone'];
		$user_mail = (!empty($_POST['stm_email'])) ? $_POST['stm_email'] : $user['email'];
		$user_mail = sanitize_email($user_mail);

		/*Dealer*/
		$company_name = ( ! empty( $_POST['stm_company_name'] ) ) ? $_POST['stm_company_name'] : $user['stm_company_name'];
		$stm_website_url = ( ! empty( $_POST['stm_website_url'] ) ) ? $_POST['stm_website_url'] : $user['website'];
		$license      = ( ! empty( $_POST['stm_licence'] ) ) ? $_POST['stm_licence'] : $user['stm_company_license'];
		$location     = ( ! empty( $_POST['stm_location'] ) ) ? $_POST['stm_location'] : $user['location'];
		$location_lat = ( ! empty( $_POST['stm_lat'] ) ) ? $_POST['stm_lat'] : $user['location_lat'];
		$location_lng = ( ! empty( $_POST['stm_lng'] ) ) ? $_POST['stm_lng'] : $user['location_lng'];
		$sales_hours  = ( ! empty( $_POST['stm_sales_hours'] ) ) ? $_POST['stm_sales_hours'] : $user['stm_sales_hours'];
		$notes        = ( ! empty( $_POST['stm_notes'] ) ) ? $_POST['stm_notes'] : $user['stm_seller_notes'];


		/*Socials*/
		$socs = array('facebook', 'twitter', 'linkedin', 'youtube');
		$socials = array();
		foreach($socs as $soc) {
			if(empty($user['socials'][$soc])) {
				$user['socials'][$soc] = '';
			}
			$socials[$soc] = (!empty($_POST['stm_user_'.$soc])) ? $_POST['stm_user_'.$soc] : $user['socials'][$soc];
		}

		$show_email = '';
		if(!empty($user['show_mail']) and $user['show_mail'] == 'show') {
			$show_email = 'checked';
		}

		$password_check = false;
		if(!empty($_POST['stm_confirm_password'])) {
			$password_check = wp_check_password($_POST['stm_confirm_password'], $user_current->data->user_pass, $user_id );
		}

		if(!$password_check and !empty($_POST['stm_confirm_password'])) {
			$got_error_validation = true;
			$error_msg            = esc_html__( 'Confirmation password is wrong', 'motors' );
		}

		$demo = stm_is_site_demo_mode();

		if($user_id == $user_page_id and $password_check and !$demo) {


			//Editing/adding user filled fields

			/*Image changing*/
			$allowed = array( 'jpg', 'jpeg', 'png' );
			if ( ! empty( $_FILES['stm-avatar'] ) ) {
				$file = $_FILES['stm-avatar'];
				if ( is_array( $file ) and ! empty( $file['name'] ) ) {
					$ext = pathinfo( $file['name'] );
					$ext = $ext['extension'];
					if ( in_array( $ext, $allowed ) ) {

						$upload_dir  = wp_upload_dir();
						$upload_url  = $upload_dir['url'];
						$upload_path = $upload_dir['path'];


						/*Upload full image*/
						if ( ! function_exists( 'wp_handle_upload' ) ) {
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
						}
						$original_file = wp_handle_upload( $file, array( 'test_form' => false ) );

						if ( ! is_wp_error( $original_file ) ) {
							$image_user = $original_file['file'];
							/*Crop image to square from full image*/
							$image_cropped = image_make_intermediate_size( $image_user, 236, 60, true );

							/*Delete full image*/
							if ( file_exists( $image_user ) ) {
								unlink( $image_user );
							}

							/*Get path and url of cropped image*/
							$user_new_image_url  = $upload_url . '/' . $image_cropped['file'];
							$user_new_image_path = $upload_path . '/' . $image_cropped['file'];

							/*Delete from site old avatar*/

							$user_old_avatar = get_the_author_meta( 'stm_dealer_logo_path', $user_id );
							if ( ! empty( $user_old_avatar ) and $user_new_image_path != $user_old_avatar and file_exists( $user_old_avatar ) ) {

								/*Check if prev avatar exists in another users except current user*/
								$args = array(
									'meta_key' => 'stm_dealer_logo_path',
									'meta_value' => $user_old_avatar,
									'meta_compare' => '=',
									'exclude' => array($user_id),
								);
								$users_db = get_users($args);
								if(empty($users_db)) {
									unlink( $user_old_avatar );
								}
							}

							/*Set new image tmp*/
							$user['image'] = $user_new_image_url;


							/*Update user meta path and url image*/
							update_user_meta( $user_id, 'stm_dealer_logo', $user_new_image_url );
							update_user_meta( $user_id, 'stm_dealer_logo_path', $user_new_image_path );

							?>
							<script type="text/javascript">
								jQuery(document).ready(function () {
									jQuery('.stm-user-avatar').html('<img src="<?php echo esc_url($user_new_image_url); ?>" class="img-avatar img-responsive">');
								})
							</script>
						<?php

						}

					} else {
						$got_error_validation = true;
						$error_msg            = esc_html__( 'Please load image with right extension (jpg, jpeg, png)', 'motors' );
					}
				}
			}

			/*Dealer image*/
			if ( ! empty( $_FILES['stm-dealer-image'] ) ) {
				$file = $_FILES['stm-dealer-image'];
				if ( is_array( $file ) and ! empty( $file['name'] ) ) {
					$ext = pathinfo( $file['name'] );
					$ext = $ext['extension'];
					if ( in_array( $ext, $allowed ) ) {

						$upload_dir  = wp_upload_dir();
						$upload_url  = $upload_dir['url'];
						$upload_path = $upload_dir['path'];


						/*Upload full image*/
						if ( ! function_exists( 'wp_handle_upload' ) ) {
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
						}
						$original_file = wp_handle_upload( $file, array( 'test_form' => false ) );

						if ( ! is_wp_error( $original_file ) ) {
							$image_user = $original_file['file'];
							/*Crop image to square from full image*/
							$image_cropped = image_make_intermediate_size( $image_user, 500, 282, true );

							$proceed = true;
							if(!$image_cropped){
								$proceed = false;
								$got_error_validation = true;
								$error_msg = esc_html__( 'Seems like image too small, please load image with minimal dimensions 500x282', 'motors' );
							}

							if($proceed) {
								/*Delete full image*/
								if ( file_exists( $image_user ) ) {
									unlink( $image_user );
								}

								/*Get path and url of cropped image*/
								$user_new_image_url  = $upload_url . '/' . $image_cropped['file'];
								$user_new_image_path = $upload_path . '/' . $image_cropped['file'];

								/*Delete from site old avatar*/

								$user_old_avatar = get_the_author_meta( 'stm_dealer_image_path', $user_id );
								if ( ! empty( $user_old_avatar ) and $user_new_image_path != $user_old_avatar and file_exists( $user_old_avatar ) ) {

									/*Check if prev avatar exists in another users except current user*/
									$args     = array(
										'meta_key'     => 'stm_dealer_image_path',
										'meta_value'   => $user_old_avatar,
										'meta_compare' => '=',
										'exclude'      => array( $user_id ),
									);
									$users_db = get_users( $args );
									if ( empty( $users_db ) ) {
										unlink( $user_old_avatar );
									}
								}

								/*Set new image tmp*/
								$user['image'] = $user_new_image_url;


								/*Update user meta path and url image*/
								update_user_meta( $user_id, 'stm_dealer_image', $user_new_image_url );
								update_user_meta( $user_id, 'stm_dealer_image_path', $user_new_image_path );
							}

							?>
						<?php

						}

					} else {
						$got_error_validation = true;
						$error_msg            = esc_html__( 'Please load image with right extension (jpg, jpeg, png)', 'motors' );
					}
				}
			}

			/*Change email*/
			$new_user_data = array(
				'ID' => $user_id,
				'user_email' => $user_mail
			);

			/*Change email visiblity*/
			if(!empty($_POST['stm_show_mail']) and $_POST['stm_show_mail'] == 'on') {
				update_user_meta($user_id, 'stm_show_email', 'show');
			} else {
				update_user_meta($user_id, 'stm_show_email', '');
			}

			if(!empty($_POST['stm_new_password']) and !empty($_POST['stm_new_password_confirm'])) {
				if($_POST['stm_new_password_confirm'] == $_POST['stm_new_password']) {
					$new_user_data['user_pass'] = esc_attr($_POST['stm_new_password']);
				} else {
					$got_error_validation = true;
					$error_msg            = esc_html__( 'New password not saved, because of wrong confirmation.', 'motors' );
				}
			}

			$user_error = wp_update_user( $new_user_data );
			if ( is_wp_error( $user_error ) ) {
				$got_error_validation = true;
				$error_msg = $user_error->get_error_message();
				$user_mail = $user['email'];
			}

			/*Change fields with secondary privilegy*/
			/*POST key => user_meta_key*/
			$changed_info = array(
				'stm_first_name'    => 'first_name',
				'stm_last_name'     => 'last_name',
				'stm_phone'         => 'stm_phone',
				'stm_user_facebook' => 'stm_user_facebook',
				'stm_user_twitter'  => 'stm_user_twitter',
				'stm_user_linkedin' => 'stm_user_linkedin',
				'stm_user_youtube'  => 'stm_user_youtube',
			);

			foreach($changed_info as $change_to_key => $change_info) {
				if(isset($_POST[$change_to_key])) {
					$escaped_value = esc_attr($_POST[$change_to_key]);

					update_user_meta($user_id, $change_info, $escaped_value);
				}
			}

			/*Change socials*/
			foreach($socs as $soc) {
				if(!empty($_POST['stm_user_'.$soc])) {
					$escaped_value = esc_attr($_POST['stm_user_'.$soc]);

					update_user_meta($user_id, 'stm_user_'.$soc, $escaped_value);
				}
			}

			/*Saving company name*/
			if(!empty($_POST['stm_company_name'])) {
				update_user_meta( $user_id, 'stm_company_name', sanitize_text_field($_POST['stm_company_name']) );
			}

			/*Saving website URL*/
			if(!empty($_POST['stm_website_url'])) {
				update_user_meta( $user_id, 'stm_website_url', esc_url($_POST['stm_website_url']) );
			}

			/*Location*/
			if(!empty($_POST['stm_location'])) {
				update_user_meta( $user_id, 'stm_dealer_location', sanitize_text_field($_POST['stm_location']) );
				if(!empty($_POST['stm_lat'])) {
					update_user_meta( $user_id, 'stm_dealer_location_lat', floatval($_POST['stm_lat']) );
				}
				if(!empty($_POST['stm_lng'])) {
					update_user_meta( $user_id, 'stm_dealer_location_lng', floatval($_POST['stm_lng']) );
				}
			}

			if(isset($_POST['stm_sales_hours'])) {
				update_user_meta( $user_id, 'stm_sales_hours', sanitize_text_field($_POST['stm_sales_hours']) );
			}

			if(!empty($_POST['stm_notes'])) {
				update_user_meta( $user_id, 'stm_seller_notes', sanitize_text_field($_POST['stm_notes']) );
			}

			if(!$got_error_validation) {
				$data_saved = true;
				$error_msg  = esc_html__( 'Account data saved. Reloading the page.', 'motors' ); ?>
					<script type="text/javascript">
						window.location.href = window.location.href
					</script>
				<?php
			}

		} else {
			if($demo) {
				$error_msg            = esc_html__( 'Site is on demo mode', 'motors' );
				$got_error_validation = true;
			}
		}
	}
?>

<div class="stm-user-private-settings-wrapper stm-dealer-private-settings-unit">
	<?php if($got_error_validation): ?>
		<div class="stm-alert alert alert-danger"><?php echo $error_msg; ?></div>
	<?php endif; ?>

	<?php if($data_saved): ?>
		<div class="stm-alert alert alert-success"><?php echo $error_msg; ?></div>
	<?php endif; ?>


	<h4 class="stm-seller-title"><?php esc_html_e('Profile Settings', 'motors'); ?></h4>

	<div class="stm-my-profile-settings">
		<form action="<?php echo esc_url(add_query_arg(array('my_settings'=>1), stm_get_author_link(''))); ?>" method="post" enctype="multipart/form-data" id="stm_user_settings_edit">

			<!--Logo-->
			<div class="clearfix stm-image-unit">
				<?php if(!empty($user['logo'])): ?>
					<div class="image">
						<img src="<?php echo esc_url($user['logo']); ?>" class="img-responsive" />
					</div>
				<?php else: ?>
					<div class="image private-logo-dealer-placeholder">
						<img src="<?php stm_get_dealer_logo_placeholder(); ?>" class="img-responsive" />
					</div>
				<?php endif; ?>

				<div class="stm-upload-new-avatar">
					<div class="heading-font"><?php esc_html_e('Upload new logo', 'motors'); ?></div>
					<div class="stm-new-upload-area clearfix">
						<a href="#" class="button stm-choose-file"><?php esc_html_e('Choose file', 'motors'); ?></a>
						<div class="stm-new-file-label"><?php esc_html_e('No File Chosen', 'motors'); ?></div>
						<input type="file" name="stm-avatar" />

					</div>
					<div class="stm-label"><?php esc_html_e('JPEG or PNG minimal 236x60px', 'motors'); ?></div>
				</div>
			</div>

			<!--Dealer Image-->
			<div class="clearfix stm-image-unit stm-dealer-image-front">
				<div class="image">
					<?php if(!empty($user['dealer_image'])): ?>
						<img src="<?php echo esc_url($user['dealer_image']); ?>" class="img-responsive" />
					<?php else: ?>
						<div class="stm-empty-avatar-icon"><i class="stm-service-icon-user"></i></div>
					<?php endif; ?>
				</div>
				<div class="stm-upload-new-avatar">
					<div class="heading-font"><?php esc_html_e('Upload Dealer Image', 'motors'); ?></div>
					<div class="stm-new-upload-area clearfix">
						<a href="#" class="button stm-choose-file"><?php esc_html_e('Choose file', 'motors'); ?></a>
						<div class="stm-new-file-label"><?php esc_html_e('No File Chosen', 'motors'); ?></div>
						<input type="file" name="stm-dealer-image" />

					</div>
					<div class="stm-label"><?php esc_html_e('JPEG or PNG minimal 500x282', 'motors'); ?></div>
				</div>
			</div>


			<!--Main information-->
			<div class="stm-change-block">
				<div class="title">
					<div class="heading-font"><?php esc_html_e('Main Information', 'motors'); ?></div>
				</div>
				<div class="main-info-settings">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('Company Website URL', 'motors'); ?></div>
								<input type="text" name="stm_website_url" value="<?php echo esc_attr($stm_website_url); ?>" placeholder="<?php esc_html_e('Enter Website URL', 'motors') ?>" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('First name', 'motors'); ?></div>
								<input type="text" name="stm_first_name" value="<?php echo esc_attr($user_first_name); ?>" placeholder="<?php esc_html_e('Enter First Name', 'motors') ?>" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('Last name', 'motors'); ?></div>
								<input type="text" name="stm_last_name" value="<?php echo esc_attr($user_last_name); ?>" placeholder="<?php esc_html_e('Enter Last Name', 'motors'); ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('Phone', 'motors'); ?></div>
								<input type="text" name="stm_phone" value="<?php echo esc_attr($user_phone); ?>" placeholder="<?php esc_html_e('Enter Phone', 'motors'); ?>"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('Email*', 'motors'); ?></div>
								<input type="email" name="stm_email" value="<?php echo esc_attr($user_mail); ?>" placeholder="<?php esc_html_e('Enter E-mail', 'motors'); ?>" required/>
								<label>
									<input type="checkbox" name="stm_show_mail" <?php echo $show_email; ?>/>
									<span><?php esc_html_e('Show Email Address on my Profile', 'motors'); ?></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="stm-change-block">
				<div class="title">
					<div class="heading-font"><?php esc_html_e( 'Dealer Information', 'motors' ); ?></div>
				</div>
				<div class="main-info-settings">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Company name*', 'motors' ); ?></div>
								<input type="text" name="stm_company_name"
								       value="<?php echo esc_attr( $company_name ); ?>"
								       placeholder="<?php esc_html_e( 'Enter Company Name', 'motors' ) ?>"
								       required/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'License number*', 'motors' ); ?></div>
								<input type="text" name="stm_licence" value="<?php echo esc_attr( $license ); ?>"
								       placeholder="<?php esc_html_e( 'Enter License number', 'motors' ); ?>"
								       readonly/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Location*', 'motors' ); ?></div>
								<div class="stm-location-search-unit">
									<input type="text" id="stm_google_user_location_entry" name="stm_location"
									       value="<?php echo esc_attr( $location ); ?>"
									       placeholder="<?php esc_html_e( 'Enter Your location', 'motors' ); ?>"
									       required/>
									<input type="hidden" name="stm_lat"
									       value="<?php echo esc_attr( $location_lat ); ?>"/>
									<input type="hidden" name="stm_lng"
									       value="<?php echo esc_attr( $location_lng ); ?>"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Sales Hours', 'motors' ); ?></div>
								<input type="text" name="stm_sales_hours"
								       value="<?php echo esc_attr( $sales_hours ); ?>"
								       placeholder="<?php esc_html_e( 'Enter Your sales hours', 'motors' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Notes', 'motors' ); ?></div>
								<textarea name="stm_notes"><?php echo esc_attr( $notes ); ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Change password-->
			<div class="stm-change-block stm-change-password-form">
				<div class="title">
					<div class="heading-font"><?php esc_html_e('Change password', 'motors'); ?></div>
				</div>
				<div class="stm_change_password">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('New Password', 'motors'); ?></div>
								<input type="password" name="stm_new_password" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e('Re-enter New Password', 'motors'); ?></div>
								<input type="password" name="stm_new_password_confirm" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Socials-->
			<div class="stm-change-block stm-socials-form">
				<div class="title">
					<div class="heading-font"><?php esc_html_e('Your Social Networks', 'motors'); ?></div>
				</div>
				<div class="stm_socials_settings">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fa fa-facebook"></i>
									<?php esc_html_e('Facebook', 'motors'); ?>
								</div>
								<input type="text" name="stm_user_facebook" value="<?php echo esc_attr($socials['facebook']); ?>" placeholder="<?php esc_html_e('Enter your Facebook profile URL', 'motors'); ?>"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fa fa-twitter"></i>
									<?php esc_html_e('Twitter', 'motors'); ?>
								</div>
								<input type="text" name="stm_user_twitter" value="<?php echo esc_attr($socials['twitter']); ?>" placeholder="<?php esc_html_e('Enter your Twitter URL', 'motors'); ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fa fa-linkedin"></i>
									<?php esc_html_e('Linked In', 'motors'); ?>
								</div>
								<input type="text" name="stm_user_linkedin" value="<?php echo esc_attr($socials['linkedin']); ?>" placeholder="<?php esc_html_e('Enter Linkedin Public profile URL', 'motors'); ?>" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fa fa-youtube-play"></i>
									<?php esc_html_e('Youtube', 'motors'); ?>
								</div>
								<input type="text" name="stm_user_youtube" value="<?php echo esc_attr($socials['youtube']); ?>" placeholder="<?php esc_html_e('Enter Youtube channel URL', 'motors'); ?>"/>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Confirm Password-->
			<div class="stm-settings-confirm-password">
				<div class="heading-font"><?php esc_html_e('Enter your Current Password to confirm changes', 'motors'); ?></div>
				<div class="stm-show-password">
					<i class="fa fa-eye-slash"></i>
					<input type="password" name="stm_confirm_password" placeholder="<?php esc_html_e('Current Password', 'motors'); ?>" required/>
				</div>
				<input type="submit" value="<?php esc_html_e('Save Changes', 'motors'); ?>" />
			</div>

		</form>
	</div>
</div>




<script type="text/javascript">
	jQuery(document).ready(function(){
		var $ = jQuery;
		$('body').on('change', 'input[type="file"]', function() {
			var length = $(this)[0].files.length;

			if(length == 1) {
				$(this).closest('.stm-image-unit').find('.stm-new-file-label').text($(this).val());
			} else {
				$(this).closest('.stm-image-unit').find('.stm-new-file-label').text('<?php esc_html_e('No File Chosen', 'motors'); ?>');
			}

		});

		$('.stm-show-password .fa').mousedown(function(){
			$(this).closest('.stm-show-password').find('input').attr('type', 'text');
			$(this).addClass('fa-eye');
			$(this).removeClass('fa-eye-slash');
		});

		$(document).mouseup(function(){
			$('.stm-show-password').find('input').attr('type', 'password');
			$('.stm-show-password .fa').addClass('fa-eye-slash');
			$('.stm-show-password .fa').removeClass('fa-eye');
		});
	})
</script>