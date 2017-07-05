<?php
if ( ! is_user_logged_in() ) {
	die( 'You are not logged in' );
} else {
	/*Here we check user fields and send mail to boss*/

	$user_data    = wp_get_current_user();
	$user_current = get_queried_object();
	$user_id      = $user_data->ID;
	$user         = stm_get_user_custom_fields( $user_id );
	$applied_before = $user['stm_message_to_user'];
	if ( $applied_before == esc_html__( 'Your review is under submission', 'motors' ) ) { ?>
		<?php $stm_payment_enabled = stm_payment_enabled();
		/*If payment enabled and user hasn't already paid, set status as pending*/
		if(!empty($stm_payment_enabled['enabled'])) {
			$payment_status = $user['stm_payment_status'];
			$user_submission_message = esc_html__( 'Your review is under submission', 'motors');

			if($payment_status == 'completed') {
				$user_submission_message = esc_html__('Your review is under submission. Paypal status - Completed', 'motors');
			} elseif ($payment_status == 'pending') {
				$user_submission_message = esc_html__('Your review is under submission. Paypal status - Pending', 'motors');
			}

			if(!empty($_GET['stm_payment'])) {
				$user_submission_message = esc_html__('Your review is under submission. Redirecting to Paypal', 'motors');
				$payment_status = 'pending';
				?>
				<script type="text/javascript">
					jQuery(window).load(function(){
						window.location.href = "<?php echo generatePayment(); ?>";
					})
				</script>
				<?php
			}

			update_user_meta( $user_id, 'stm_payment_status', $payment_status ); ?>

			<div class="alert alert-info heading-font"><i class="fa fa-check"></i><?php echo esc_attr($user_submission_message); ?></div>
			<?php
		} else { ?>
			<div class="alert alert-info heading-font"><i class="fa fa-check"></i><?php esc_html_e( 'Your review is under submission', 'motors' ); ?></div>
		<?php }
		?>
	<?php } else { ?>
		<?php if ( ! empty( $applied_before ) ): ?>
			<div class="alert alert-warning heading-font"><i class="fa fa-info"></i><?php echo esc_attr( $applied_before ); ?></div>
		<?php endif; ?>

		<?php
		/*Checking*/
		$errors         = false;
		$errors_message = '';


		$company_name = ( ! empty( $_POST['stm_company_name'] ) ) ? $_POST['stm_company_name'] : $user['stm_company_name'];
		$license      = ( ! empty( $_POST['stm_licence'] ) ) ? $_POST['stm_licence'] : $user['stm_company_license'];
		$location     = ( ! empty( $_POST['stm_location'] ) ) ? $_POST['stm_location'] : $user['location'];
		$location_lat = ( ! empty( $_POST['stm_lat'] ) ) ? $_POST['stm_lat'] : $user['location_lat'];
		$location_lng = ( ! empty( $_POST['stm_lng'] ) ) ? $_POST['stm_lng'] : $user['location_lng'];
		$sales_hours  = ( ! empty( $_POST['stm_sales_hours'] ) ) ? $_POST['stm_sales_hours'] : $user['stm_sales_hours'];
		$notes        = ( ! empty( $_POST['stm_notes'] ) ) ? $_POST['stm_notes'] : $user['stm_seller_notes'];

		$required_fields = array(
			'stm_company_name' => esc_html__('Company name', 'motors'),
			'stm_licence' => esc_html__('Company license', 'motors'),
			'stm_location' => esc_html__('Location', 'motors'),
		);

		foreach($required_fields as $required_fields_key => $required_field) {
			if(empty($_POST[$required_fields_key])) {
				$errors = true;
			}
		}

		$demo = stm_is_site_demo_mode();
		if($demo) {
			$errors = true;
			$errors_message = esc_html__('Site is on demo mode', 'motors');
		}

		if(!$errors and empty($errors_message)) {

			/*Saving company name*/
			if(!empty($_POST['stm_company_name'])) {
				update_user_meta( $user_id, 'stm_company_name', sanitize_text_field($_POST['stm_company_name']) );
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

			if(!empty($_POST['stm_licence'])) {
				update_user_meta( $user_id, 'stm_company_license', sanitize_text_field($_POST['stm_licence']) );
			}

			if(!empty($_POST['stm_sales_hours'])) {
				update_user_meta( $user_id, 'stm_sales_hours', sanitize_text_field($_POST['stm_sales_hours']) );
			}

			if(!empty($_POST['stm_notes'])) {
				update_user_meta( $user_id, 'stm_seller_notes', sanitize_text_field($_POST['stm_notes']) );
			}

			update_user_meta( $user_id, 'stm_message_to_user', esc_html__('Your review is under submission', 'motors') );


			if ( $user_id == $user_current->ID ) {
				if ( empty( $_FILES['stm-avatar'] ) ) {
					$errors         = true;
					$errors_message = esc_html__( 'Logo is required field', 'motors' );
				} else {
					$file    = $_FILES['stm-avatar'];
					$allowed = array( 'jpg', 'jpeg', 'png' );
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
									$args     = array(
										'meta_key'     => 'stm_dealer_logo_path',
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
								update_user_meta( $user_id, 'stm_dealer_logo', $user_new_image_url );
								update_user_meta( $user_id, 'stm_dealer_logo_path', $user_new_image_path );

								?>
							<?php

							}

						} else {
							$errors         = true;
							$errors_message = esc_html__( 'Please load image with right extension (jpg, jpeg, png)', 'motors' );
						}
					}
				}

				//Sending Mail to admin
				add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

				$to      = get_bloginfo( 'admin_email' );
				$subject = esc_html__( 'Request for a dealer', 'motors' );
				$user_login = $user_current->data->user_login;
				$body = esc_html__('User Login:', 'motors') . ' ' . $user_login;

				wp_mail( $to, $subject, $body );

				remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

			}
			?>
			<div class="alert alert-success" style="margin:bottom:30px;">
				<?php esc_html_e( 'Account data saved. Reloading the page.', 'motors' ); ?>
			</div>
			<script type="text/javascript">
				window.location.href += '&stm_payment=1';
			</script>
		<?php
		}

		if ( $errors and ! empty( $errors_message ) ) { ?>
			<div class="alert alert-danger"><?php echo esc_html( $errors_message ); ?></div>
		<?php }

		?>

		<h4 class="stm-seller-title"><?php esc_html_e( 'Become a dealer', 'motors' ); ?></h4>


		<div class="stm-my-profile-settings stm-become-a-dealer">
			<form
				action="<?php echo esc_url( add_query_arg( array( 'become_dealer' => 1 ), stm_get_author_link( '' ) ) ); ?>"
				method="post" enctype="multipart/form-data" autocomplete="off" id="stm_user_settings_edit">

				<!--Logo-->
				<div class="clearfix stm-image-unit">
					<div class="image">
						<?php if ( ! empty( $user['logo'] ) ): ?>
							<img src="<?php echo esc_url( $user['logo'] ); ?>" class="img-responsive"/>
						<?php else: ?>
							<div class="stm-empty-avatar-icon"><i class="stm-service-icon-user"></i></div>
						<?php endif; ?>
					</div>
					<div class="stm-upload-new-avatar">
						<div class="heading-font"><?php esc_html_e( 'Upload your company logo*', 'motors' ); ?></div>
						<div class="stm-new-upload-area clearfix">
							<a href="#"
							   class="button stm-choose-file"><?php esc_html_e( 'Choose file', 'motors' ); ?></a>

							<div class="stm-new-file-label"><?php esc_html_e( 'No File Chosen', 'motors' ); ?></div>
							<input type="file" name="stm-avatar"/>

						</div>
						<div class="stm-label"><?php esc_html_e( 'JPEG or PNG minimal 236x60px', 'motors' ); ?></div>
					</div>
				</div>

				<!--Main information-->
				<div class="stm-change-block">
					<div class="title">
						<div class="heading-font"><?php esc_html_e( 'Main Information', 'motors' ); ?></div>
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
									       required/>
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


				<input type="submit" value="<?php esc_html_e( 'Submit for review', 'motors' ); ?>"/>

			</form>
		</div>
	<?php }
} ?>

<script type="text/javascript">
	jQuery(document).ready(function () {
		var $ = jQuery;
		$('body').on('change', 'input[name="stm-avatar"]', function () {
			var length = $(this)[0].files.length;

			if (length == 1) {
				$('.stm-new-file-label').text($(this).val());
			} else {
				$('.stm-new-file-label').text('<?php esc_html_e('No File Chosen', 'motors'); ?>');
			}

		});
	})
</script>