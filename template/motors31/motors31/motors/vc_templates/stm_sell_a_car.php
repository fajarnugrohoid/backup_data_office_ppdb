<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(!stm_is_boats() and !stm_is_motorcycle()):
	//Generating mail
	$required_fields = array(
		'make' => __('Make', 'motors'),
		'model' => __('Model', 'motors'),
		'first_name' => __('User details<br/>First name', 'motors'),
		'last_name' => __('Last name', 'motors'),
	);

	$non_required_fields = array(
		'transmission' => __('Transmission', 'motors'),
		'mileage' => __('Mileage', 'motors'),
		'vin' => __('Vin', 'motors'),
		'exterior_color' => __('Exterior color', 'motors'),
		'interior_color' => __('Interior color', 'motors'),
		'owner' => __('Owner', 'motors'),
		'exterior_condition' => __('Exterior condition', 'motors'),
		'interior_condition' => __('Interior condition', 'motors'),
		'accident' => __('Accident', 'motors'),
		'stm_year' => __('Year', 'motors'),
		'video_url' => __('Video url', 'motors'),
		'comments' => __('Comments', 'motors')
	);

	$body = '';
	$mail_send = false;

	$errors = array();

	// Sanitize required fields
	foreach($required_fields as $key => $field) {

		//Check default fields
		if(!empty($_POST[$key])) {
			$body .= $field . ' - ' . sanitize_text_field($_POST[$key]) . '<br/>';
		} else {
			$errors[$key] = __('Please fill', 'motors') . ' ' . $field . ' ' . __('field', 'motors') . '<br/>';
		}

	}

	// Check email
	if(!empty($_POST['email']) and is_email($_POST['email'])) {
		$body .= __('Email', 'motors') . ' - ' . sanitize_email($_POST['email']) . '<br/>';
	} else {
		$errors['email'] = __('Your E-mail address is invalid', 'motors') . '<br/>';
	}

	// Check phone
	if(!empty($_POST['phone']) and is_numeric($_POST['phone'])) {
		$body .= __('Phone', 'motors') . ' - ' . intval($_POST['phone']) . '<br/>';
	} else {
		$errors['phone'] = __('Your Phone is invalid', 'motors') . '<br/>';
	}

	// Non required fields
	foreach($non_required_fields as $key => $field) {
		if(!empty($_POST[$key])) {
			if($key == 'video_url') {
				$body .= $field . ' - ' . esc_url($_POST['video_url']) . '<br/>';
			} else {
				$body .= $field . ' - ' . sanitize_text_field($_POST[$key]) . '<br/>';
			}
		}
	}

	if( ! empty( $_FILES ) ) {
		$body .= __('Uploaded images', 'motors') .':<br/>';
		foreach( $_FILES as $file ) {
			if( is_array( $file ) ) {
				$attachment_id = stm_upload_user_file( $file );
				$url = wp_get_attachment_url($attachment_id);
				$body .= $url . '<br/>';
			}
		}
	}

	if(!empty($body) and empty($errors)) {

		$to      = get_bloginfo( 'admin_email' );
		$subject = esc_html__( 'Sell a car request', 'motors' );

		add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		wp_mail( $to, $subject, $body );

		remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		$mail_send = true;
		$_POST = array();
		$_FILES = array();
	}

	?>

	<!-- Load image on load preventing lags-->

	<?php if(!$mail_send): ?>
	<div class="stm-sell-a-car-form">
		<div class="form-navigation">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<a href="#step-one" class="form-navigation-unit active" data-tab="step-one">
						<div class="number heading-font">1.</div>
						<div class="title heading-font"><?php esc_html_e('Car Information', 'motors'); ?></div>
						<div class="sub-title"><?php esc_html_e('Add tour vehicle details', 'motors'); ?></div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4">
					<a href="#step-two" class="form-navigation-unit" data-tab="step-two">
						<div class="number heading-font">2.</div>
						<div class="title heading-font"><?php esc_html_e('Vehicle Condition', 'motors'); ?></div>
						<div class="sub-title"><?php esc_html_e('Add your vehicle details', 'motors'); ?></div>
					</a>
				</div>
				<div class="col-md-4 col-sm-4">
					<a href="#step-three" class="form-navigation-unit" data-tab="step-three">
						<div class="number heading-font">3.</div>
						<div class="title heading-font"><?php esc_html_e('Contact details', 'motors'); ?></div>
						<div class="sub-title"><?php esc_html_e('Your contact details', 'motors'); ?></div>
					</a>
				</div>
			</div>
		</div>
		<div class="form-content">
			<form method="POST" action="#error-fields" enctype="multipart/form-data">
				<!-- STEP ONE -->
				<div class="form-content-unit active" id="step-one">
					<input type="hidden" name="sell_a_car" value="filled"/>

					<div class="row">
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Make', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['make'])) echo $_POST['make']; ?>" name="make" data-need="true" required/>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Model', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['model'])) echo $_POST['model']; ?>" name="model"  data-need="true" required/>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Year', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['stm_year'])) echo $_POST['stm_year']; ?>" name="stm_year"/>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Transmission', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['transmission'])) echo $_POST['transmission']; ?>" name="transmission"/>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Mileage', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['mileage'])) echo $_POST['mileage']; ?>" name="mileage"/>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('VIN', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['vin'])) echo $_POST['vin']; ?>" name="vin" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-12">

							<div class="form-upload-files">
								<div class="clearfix">
									<div class="stm-unit-photos">
										<h5 class="stm-label-type-2"><?php esc_html_e('Upload your car Photos', 'motors'); ?></h5>
										<div class="upload-photos">
											<div class="stm-pseudo-file-input">
												<div class="stm-filename"><?php esc_html_e('Choose file...', 'motors'); ?></div>
												<div class="stm-plus"></div>
												<input class="stm-file-realfield" type="file" name="gallery_images_0"/>
											</div>
										</div>
									</div>
									<div class="stm-unit-url">
										<h5 class="stm-label-type-2">
											<?php esc_html_e('Provide a hosted video url of your car', 'motors'); ?>
										</h5>
										<input type="text" value="<?php if(!empty($_POST['video_url'])) echo $_POST['video_url']; ?>" name="video_url" />
									</div>
								</div>
							</div>
							<img src="<?php echo get_template_directory_uri().'/assets/images/radio.png'; ?>" style="opacity:0;width:0;height:0;"/>

						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Exterior color', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['exterior_color'])) echo $_POST['exterior_color']; ?>" name="exterior_color"/>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Interior color', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['interior_color'])) echo $_POST['interior_color']; ?>" name="interior_color" />
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<div class="contact-us-label"><?php esc_html_e('Owner', 'motors'); ?></div>
								<input type="text" value="<?php if(!empty($_POST['owner'])) echo $_POST['owner']; ?>" name="owner" />
							</div>
						</div>
					</div>

					<a href="#" class="button sell-a-car-proceed" data-step="2">
						<?php esc_html_e('Save and continue', 'motors'); ?>
					</a>
				</div>

				<!-- STEP TWO -->
				<div class="form-content-unit" id="step-two">
					<div class="vehicle-condition">
						<div class="vehicle-condition-unit">
							<div class="icon"><i class="stm-icon-car-relic"></i></div>
							<div class="title h5"><?php esc_html_e('What is the Exterior Condition?', 'motors'); ?></div>
							<label>
								<input type="radio" name="exterior_condition" value="<?php esc_html_e('Extra clean', 'motors'); ?>" checked/>
								<?php esc_html_e('Extra clean', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="exterior_condition" value="<?php esc_html_e('Clean', 'motors'); ?>"/>
								<?php esc_html_e('Clean', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="exterior_condition" value="<?php esc_html_e('Average', 'motors'); ?>"/>
								<?php esc_html_e('Average', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="exterior_condition" value="<?php esc_html_e('Below Average', 'motors'); ?>"/>
								<?php esc_html_e('Below Average', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="exterior_condition" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
								<?php esc_html_e('I don\'t know', 'motors'); ?>
							</label>
						</div>
						<div class="vehicle-condition-unit">
							<div class="icon buoy"><i class="stm-icon-buoy"></i></div>
							<div class="title h5"><?php esc_html_e('What is the Interior Condition?', 'motors'); ?></div>
							<label>
								<input type="radio" name="interior_condition" value="<?php esc_html_e('Extra clean', 'motors'); ?>" checked/>
								<?php esc_html_e('Extra clean', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="interior_condition" value="<?php esc_html_e('Clean', 'motors'); ?>"/>
								<?php esc_html_e('Clean', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="interior_condition" value="<?php esc_html_e('Average', 'motors'); ?>"/>
								<?php esc_html_e('Average', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="interior_condition" value="<?php esc_html_e('Below Average', 'motors'); ?>"/>
								<?php esc_html_e('Below Average', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="interior_condition" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
								<?php esc_html_e('I don\'t know', 'motors'); ?>
							</label>
						</div>
						<div class="vehicle-condition-unit">
							<div class="icon buoy-2"><i class="stm-icon-buoy-2"></i></div>
							<div class="title h5"><?php esc_html_e('Has vehicle been in accident', 'motors'); ?></div>
							<label>
								<input type="radio" name="accident" value="<?php esc_html_e('Yes', 'motors'); ?>"/>
								<?php esc_html_e('Yes', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="accident" value="<?php esc_html_e('No', 'motors'); ?>" checked/>
								<?php esc_html_e('No', 'motors'); ?>
							</label>
							<label>
								<input type="radio" name="accident" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
								<?php esc_html_e('I don\'t know', 'motors'); ?>
							</label>
						</div>
					</div>
					<a href="#" class="button sell-a-car-proceed" data-step="3">
						<?php esc_html_e('Save and continue', 'motors'); ?>
					</a>
				</div>

				<!-- STEP THREE -->
				<div class="form-content-unit" id="step-three">
					<div class="contact-details">
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('First name', 'motors'); ?>*</div>
									<input type="text" value="<?php if(!empty($_POST['first_name'])) echo $_POST['first_name']; ?>" name="first_name"/>
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Last name', 'motors'); ?>*</div>
									<input type="text" value="<?php if(!empty($_POST['last_name'])) echo $_POST['last_name']; ?>" name="last_name" />
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Email Address', 'motors'); ?>*</div>
									<input type="text" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" name="email" />
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Phone number', 'motors'); ?>*</div>
									<input type="text" value="<?php if(!empty($_POST['phone'])) echo $_POST['phone']; ?>" name="phone" />
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Comments', 'motors'); ?></div>
									<textarea name="comments"><?php if(!empty($_POST['comments'])) echo $_POST['comments']; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="pull-left">
							<input type="submit" value="<?php esc_html_e('Save and finish', 'motors'); ?>" />
						</div>
						<div class="disclaimer">
							<?php esc_html_e('By submitting this form, you will be requesting trade-in value at no obligation and
	will be contacted within 48 hours by a sales representative.', 'motors'); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php endif; ?>

	<?php if(!empty($errors) and !empty($_POST['sell_a_car'])): ?>
		<div class="wpcf7-response-output wpcf7-validation-errors" id="error-fields">
			<?php foreach($errors as $error): ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if($mail_send): ?>
		<div class="wpcf7-response-output wpcf7-mail-sent-ok" id="error-fields">
			<?php esc_html_e('Mail successfully sent', 'motors'); ?>
		</div>
	<?php endif; ?>


	<script type="text/javascript">
		(function($) {
		    "use strict";

		    $(document).ready(function() {
				$('.form-navigation-unit').click(function(e){
					e.preventDefault();
					validateFirstStep();
					if(!$(this).hasClass('active')) {
						$('.form-navigation-unit').removeClass('active');
						$(this).addClass('active');

						var tab = $(this).data('tab');

						$('.form-content-unit').slideUp();

						$('#'+tab).slideDown();
					}
				})

				var i = 1;

				$('.stm-plus').click(function(e){
					e.preventDefault();
					if(i < 5) {
						i++;
						$('.upload-photos').append('<div class="stm-pseudo-file-input generated"><div class="stm-filename"><?php esc_html_e('Choose file...', 'motors'); ?></div><div class="stm-plus"></div><input class="stm-file-realfield" type="file" name="gallery_images_' + i + '"/></div>');
					}
				})

				$('body').on('click', '.generated .stm-plus', function(){
					i--;
					$(this).closest('.stm-pseudo-file-input').remove();
				})
		    })

		})(jQuery);
	</script>
<?php elseif(stm_is_motorcycle()):
	//Generating mail
	$required_fields = array(
		'make' => __('Make', 'motors'),
		'model' => __('Model', 'motors'),
		'first_name' => __('User details<br/>First name', 'motors'),
		'last_name' => __('Last name', 'motors'),
	);

	$non_required_fields = array(
		'type' => __('Vehicle Type', 'motors'),
		'mileage' => __('Mileage', 'motors'),
		'vin' => __('Vin', 'motors'),
		'exterior_color' => __('Exterior color', 'motors'),
		'interior_color' => __('Interior color', 'motors'),
		'owner' => __('Owner', 'motors'),
		'exterior_condition' => __('Exterior condition', 'motors'),
		'interior_condition' => __('Interior condition', 'motors'),
		'accident' => __('Accident', 'motors'),
		'stm_year' => __('Year', 'motors'),
		'video_url' => __('Video url', 'motors'),
		'comments' => __('Comments', 'motors')
	);

	$body = '';
	$mail_send = false;

	$errors = array();

	// Sanitize required fields
	foreach($required_fields as $key => $field) {

		//Check default fields
		if(!empty($_POST[$key])) {
			$body .= $field . ' - ' . sanitize_text_field($_POST[$key]) . '<br/>';
		} else {
			$errors[$key] = __('Please fill', 'motors') . ' ' . $field . ' ' . __('field', 'motors') . '<br/>';
		}

	}

	// Check email
	if(!empty($_POST['email']) and is_email($_POST['email'])) {
		$body .= __('Email', 'motors') . ' - ' . sanitize_email($_POST['email']) . '<br/>';
	} else {
		$errors['email'] = __('Your E-mail address is invalid', 'motors') . '<br/>';
	}

	// Check phone
	if(!empty($_POST['phone']) and is_numeric($_POST['phone'])) {
		$body .= __('Phone', 'motors') . ' - ' . intval($_POST['phone']) . '<br/>';
	} else {
		$errors['phone'] = __('Your Phone is invalid', 'motors') . '<br/>';
	}

	// Non required fields
	foreach($non_required_fields as $key => $field) {
		if(!empty($_POST[$key])) {
			if($key == 'video_url') {
				$body .= $field . ' - ' . esc_url($_POST['video_url']) . '<br/>';
			} else {
				$body .= $field . ' - ' . sanitize_text_field($_POST[$key]) . '<br/>';
			}
		}
	}

	if( ! empty( $_FILES ) ) {
		$body .= __('Uploaded images', 'motors') .':<br/>';
		foreach( $_FILES as $file ) {
			if( is_array( $file ) ) {
				$attachment_id = stm_upload_user_file( $file );
				$url = wp_get_attachment_url($attachment_id);
				$body .= $url . '<br/>';
			}
		}
	}

	if(!empty($body) and empty($errors)) {

		$to      = get_bloginfo( 'admin_email' );
		$subject = esc_html__( 'Sell a car request', 'motors' );

		add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		wp_mail( $to, $subject, $body );

		remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		$mail_send = true;
		$_POST = array();
		$_FILES = array();
	}

	?>

	<!-- Load image on load preventing lags-->

	<?php if(!$mail_send): ?>
		<div class="stm-sell-a-car-form">
			<div class="form-navigation">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<a href="#step-one" class="form-navigation-unit active" data-tab="step-one">
							<div class="number heading-font">1.</div>
							<div class="title heading-font"><?php esc_html_e('Car Information', 'motors'); ?></div>
							<div class="sub-title"><?php esc_html_e('Add tour vehicle details', 'motors'); ?></div>
						</a>
					</div>
					<div class="col-md-4 col-sm-4">
						<a href="#step-two" class="form-navigation-unit" data-tab="step-two">
							<div class="number heading-font">2.</div>
							<div class="title heading-font"><?php esc_html_e('Vehicle Condition', 'motors'); ?></div>
							<div class="sub-title"><?php esc_html_e('Add your vehicle details', 'motors'); ?></div>
						</a>
					</div>
					<div class="col-md-4 col-sm-4">
						<a href="#step-three" class="form-navigation-unit" data-tab="step-three">
							<div class="number heading-font">3.</div>
							<div class="title heading-font"><?php esc_html_e('Contact details', 'motors'); ?></div>
							<div class="sub-title"><?php esc_html_e('Your contact details', 'motors'); ?></div>
						</a>
					</div>
				</div>
			</div>
			<div class="form-content">
				<form method="POST" action="#error-fields" enctype="multipart/form-data">
					<!-- STEP ONE -->
					<div class="form-content-unit active" id="step-one">
						<input type="hidden" name="sell_a_car" value="filled"/>

						<div class="row">
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Vehicle Type', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['type'])) echo $_POST['type']; ?>" name="type"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Make', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['make'])) echo $_POST['make']; ?>" name="make" data-need="true" required/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Model', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['model'])) echo $_POST['model']; ?>" name="model"  data-need="true" required/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Year', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['stm_year'])) echo $_POST['stm_year']; ?>" name="stm_year"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Mileage', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['mileage'])) echo $_POST['mileage']; ?>" name="mileage"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('VIN', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['vin'])) echo $_POST['vin']; ?>" name="vin" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 col-sm-12">

								<div class="form-upload-files">
									<div class="clearfix">
										<div class="stm-unit-photos">
											<h5 class="stm-label-type-2"><?php esc_html_e('Upload your car Photos', 'motors'); ?></h5>
											<div class="upload-photos">
												<div class="stm-pseudo-file-input">
													<div class="stm-filename"><?php esc_html_e('Choose file...', 'motors'); ?></div>
													<div class="stm-plus"></div>
													<input class="stm-file-realfield" type="file" name="gallery_images_0"/>
												</div>
											</div>
										</div>
										<div class="stm-unit-url">
											<h5 class="stm-label-type-2">
												<?php esc_html_e('Provide a hosted video url of your car', 'motors'); ?>
											</h5>
											<input type="text" value="<?php if(!empty($_POST['video_url'])) echo $_POST['video_url']; ?>" name="video_url" />
										</div>
									</div>
								</div>
								<img src="<?php echo get_template_directory_uri().'/assets/images/radio.png'; ?>" style="opacity:0;width:0;height:0;"/>

							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Exterior color', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['exterior_color'])) echo $_POST['exterior_color']; ?>" name="exterior_color"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Interior color', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['interior_color'])) echo $_POST['interior_color']; ?>" name="interior_color" />
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Owner', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['owner'])) echo $_POST['owner']; ?>" name="owner" />
								</div>
							</div>
						</div>

						<a href="#" class="button sell-a-car-proceed" data-step="2">
							<?php esc_html_e('Save and continue', 'motors'); ?>
						</a>
					</div>

					<!-- STEP TWO -->
					<div class="form-content-unit" id="step-two">
						<div class="vehicle-condition">
							<div class="vehicle-condition-unit">
								<div class="icon"><i class="stm-icon-car-relic"></i></div>
								<div class="title h5"><?php esc_html_e('What is the Exterior Condition?', 'motors'); ?></div>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Extra clean', 'motors'); ?>" checked/>
									<?php esc_html_e('Extra clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Clean', 'motors'); ?>"/>
									<?php esc_html_e('Clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Average', 'motors'); ?>"/>
									<?php esc_html_e('Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Below Average', 'motors'); ?>"/>
									<?php esc_html_e('Below Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
									<?php esc_html_e('I don\'t know', 'motors'); ?>
								</label>
							</div>
							<div class="vehicle-condition-unit">
								<div class="icon buoy"><i class="stm-icon-buoy"></i></div>
								<div class="title h5"><?php esc_html_e('What is the Interior Condition?', 'motors'); ?></div>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Extra clean', 'motors'); ?>" checked/>
									<?php esc_html_e('Extra clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Clean', 'motors'); ?>"/>
									<?php esc_html_e('Clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Average', 'motors'); ?>"/>
									<?php esc_html_e('Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Below Average', 'motors'); ?>"/>
									<?php esc_html_e('Below Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
									<?php esc_html_e('I don\'t know', 'motors'); ?>
								</label>
							</div>
							<div class="vehicle-condition-unit">
								<div class="icon buoy-2"><i class="stm-icon-buoy-2"></i></div>
								<div class="title h5"><?php esc_html_e('Has vehicle been in accident', 'motors'); ?></div>
								<label>
									<input type="radio" name="accident" value="<?php esc_html_e('Yes', 'motors'); ?>"/>
									<?php esc_html_e('Yes', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="accident" value="<?php esc_html_e('No', 'motors'); ?>" checked/>
									<?php esc_html_e('No', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="accident" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
									<?php esc_html_e('I don\'t know', 'motors'); ?>
								</label>
							</div>
						</div>
						<a href="#" class="button sell-a-car-proceed" data-step="3">
							<?php esc_html_e('Save and continue', 'motors'); ?>
						</a>
					</div>

					<!-- STEP THREE -->
					<div class="form-content-unit" id="step-three">
						<div class="contact-details">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('First name', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['first_name'])) echo $_POST['first_name']; ?>" name="first_name"/>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Last name', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['last_name'])) echo $_POST['last_name']; ?>" name="last_name" />
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Email Address', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" name="email" />
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Phone number', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['phone'])) echo $_POST['phone']; ?>" name="phone" />
									</div>
								</div>
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Comments', 'motors'); ?></div>
										<textarea name="comments"><?php if(!empty($_POST['comments'])) echo $_POST['comments']; ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix">
							<div class="pull-left">
								<input type="submit" value="<?php esc_html_e('Save and finish', 'motors'); ?>" />
							</div>
							<div class="disclaimer">
								<?php esc_html_e('By submitting this form, you will be requesting trade-in value at no obligation and
		will be contacted within 48 hours by a sales representative.', 'motors'); ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	<?php endif; ?>

	<?php if(!empty($errors) and !empty($_POST['sell_a_car'])): ?>
		<div class="wpcf7-response-output wpcf7-validation-errors" id="error-fields">
			<?php foreach($errors as $error): ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if($mail_send): ?>
		<div class="wpcf7-response-output wpcf7-mail-sent-ok" id="error-fields">
			<?php esc_html_e('Mail successfully sent', 'motors'); ?>
		</div>
	<?php endif; ?>


	<script type="text/javascript">
		(function($) {
			"use strict";

			$(document).ready(function() {
				$('.form-navigation-unit').click(function(e){
					e.preventDefault();
					validateFirstStep();
					if(!$(this).hasClass('active')) {
						$('.form-navigation-unit').removeClass('active');
						$(this).addClass('active');

						var tab = $(this).data('tab');

						$('.form-content-unit').slideUp();

						$('#'+tab).slideDown();
					}
				})

				var i = 1;

				$('.stm-plus').click(function(e){
					e.preventDefault();
					if(i < 5) {
						i++;
						$('.upload-photos').append('<div class="stm-pseudo-file-input generated"><div class="stm-filename"><?php esc_html_e('Choose file...', 'motors'); ?></div><div class="stm-plus"></div><input class="stm-file-realfield" type="file" name="gallery_images_' + i + '"/></div>');
					}
				})

				$('body').on('click', '.generated .stm-plus', function(){
					i--;
					$(this).closest('.stm-pseudo-file-input').remove();
				})
			})

		})(jQuery);
	</script>
<?php else:
	/*BOATS*/
	//Generating mail
	$required_fields = array(
		'make' => __('Make', 'motors'),
		'model' => __('Model', 'motors'),
		'first_name' => __('User details<br/>First name', 'motors'),
		'last_name' => __('Last name', 'motors'),
	);

	$non_required_fields = array(
		'boat_type' => __('Boat type', 'motors'),
		'length' => __('Length', 'motors'),
		'hull_material' => __('Hull material', 'motors'),
		'exterior_color' => __('Exterior color', 'motors'),
		'interior_color' => __('Interior color', 'motors'),
		'owner' => __('Owner', 'motors'),
		'exterior_condition' => __('Exterior condition', 'motors'),
		'interior_condition' => __('Interior condition', 'motors'),
		'accident' => __('Accident', 'motors'),
		'stm_year' => __('Year', 'motors'),
		'video_url' => __('Video url', 'motors'),
		'comments' => __('Comments', 'motors')
	);

	$body = '';
	$mail_send = false;

	$errors = array();

	// Sanitize required fields
	foreach($required_fields as $key => $field) {

		//Check default fields
		if(!empty($_POST[$key])) {
			$body .= $field . ' - ' . sanitize_text_field($_POST[$key]) . '<br/>';
		} else {
			$errors[$key] = __('Please fill', 'motors') . ' ' . $field . ' ' . __('field', 'motors') . '<br/>';
		}

	}

	// Check email
	if(!empty($_POST['email']) and is_email($_POST['email'])) {
		$body .= __('Email', 'motors') . ' - ' . sanitize_email($_POST['email']) . '<br/>';
	} else {
		$errors['email'] = __('Your E-mail address is invalid', 'motors') . '<br/>';
	}

	// Check phone
	if(!empty($_POST['phone']) and is_numeric($_POST['phone'])) {
		$body .= __('Phone', 'motors') . ' - ' . intval($_POST['phone']) . '<br/>';
	} else {
		$errors['phone'] = __('Your Phone is invalid', 'motors') . '<br/>';
	}

	// Non required fields
	foreach($non_required_fields as $key => $field) {
		if(!empty($_POST[$key])) {
			if($key == 'video_url') {
				$body .= $field . ' - ' . esc_url($_POST['video_url']) . '<br/>';
			} else {
				$body .= $field . ' - ' . sanitize_text_field($_POST[$key]) . '<br/>';
			}
		}
	}

	if( ! empty( $_FILES ) ) {
		$body .= __('Uploaded images', 'motors') .':<br/>';
		foreach( $_FILES as $file ) {
			if( is_array( $file ) ) {
				$attachment_id = stm_upload_user_file( $file );
				$url = wp_get_attachment_url($attachment_id);
				$body .= $url . '<br/>';
			}
		}
	}

	if(!empty($body) and empty($errors)) {

		$to      = get_bloginfo( 'admin_email' );
		$subject = esc_html__( 'Sell a boat request', 'motors' );

		add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		wp_mail( $to, $subject, $body );

		remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		$mail_send = true;
		$_POST = array();
		$_FILES = array();
	}

	?>

	<!-- Load image on load preventing lags-->

	<?php if(!$mail_send): ?>
		<div class="stm-sell-a-car-form">
			<div class="form-navigation">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<a href="#step-one" class="form-navigation-unit active" data-tab="step-one">
							<div class="number heading-font">1.</div>
							<div class="title heading-font"><?php esc_html_e('Boat Information', 'motors'); ?></div>
							<div class="sub-title"><?php esc_html_e('Add tour boat details', 'motors'); ?></div>
						</a>
					</div>
					<div class="col-md-4 col-sm-4">
						<a href="#step-two" class="form-navigation-unit" data-tab="step-two">
							<div class="number heading-font">2.</div>
							<div class="title heading-font"><?php esc_html_e('Boat Condition', 'motors'); ?></div>
							<div class="sub-title"><?php esc_html_e('Add your boat details', 'motors'); ?></div>
						</a>
					</div>
					<div class="col-md-4 col-sm-4">
						<a href="#step-three" class="form-navigation-unit" data-tab="step-three">
							<div class="number heading-font">3.</div>
							<div class="title heading-font"><?php esc_html_e('Contact details', 'motors'); ?></div>
							<div class="sub-title"><?php esc_html_e('Your contact details', 'motors'); ?></div>
						</a>
					</div>
				</div>
			</div>
			<div class="form-content">
				<form method="POST" action="#error-fields" enctype="multipart/form-data">
					<!-- STEP ONE -->
					<div class="form-content-unit active" id="step-one">
						<input type="hidden" name="sell_a_car" value="filled"/>

						<div class="row">
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Make', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['make'])) echo $_POST['make']; ?>" name="make" data-need="true" required/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Model', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['model'])) echo $_POST['model']; ?>" name="model"  data-need="true" required/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Year', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['stm_year'])) echo $_POST['stm_year']; ?>" name="stm_year"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Boat type', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['boat_type'])) echo $_POST['boat_type']; ?>" name="boat_type"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Length', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['length'])) echo $_POST['length']; ?>" name="length"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Hull material', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['hull_material'])) echo $_POST['hull_material']; ?>" name="hull_material" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 col-sm-12">

								<div class="form-upload-files">
									<div class="clearfix">
										<div class="stm-unit-photos">
											<h5 class="stm-label-type-2"><?php esc_html_e('Upload your boat Photos', 'motors'); ?></h5>
											<div class="upload-photos">
												<div class="stm-pseudo-file-input">
													<div class="stm-filename"><?php esc_html_e('Choose file...', 'motors'); ?></div>
													<div class="stm-plus"></div>
													<input class="stm-file-realfield" type="file" name="gallery_images_0"/>
												</div>
											</div>
										</div>
										<div class="stm-unit-url">
											<h5 class="stm-label-type-2">
												<?php esc_html_e('Provide a hosted video url of your boat', 'motors'); ?>
											</h5>
											<input type="text" value="<?php if(!empty($_POST['video_url'])) echo $_POST['video_url']; ?>" name="video_url" />
										</div>
									</div>
								</div>
								<img src="<?php echo get_template_directory_uri().'/assets/images/radio.png'; ?>" style="opacity:0;width:0;height:0;"/>

							</div>
						</div>

						<div class="row">
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Exterior color', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['exterior_color'])) echo $_POST['exterior_color']; ?>" name="exterior_color"/>
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Interior color', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['interior_color'])) echo $_POST['interior_color']; ?>" name="interior_color" />
								</div>
							</div>
							<div class="col-md-4 col-sm-4">
								<div class="form-group">
									<div class="contact-us-label"><?php esc_html_e('Owner', 'motors'); ?></div>
									<input type="text" value="<?php if(!empty($_POST['owner'])) echo $_POST['owner']; ?>" name="owner" />
								</div>
							</div>
						</div>

						<a href="#" class="button sell-a-car-proceed" data-step="2">
							<?php esc_html_e('Save and continue', 'motors'); ?>
						</a>
					</div>

					<!-- STEP TWO -->
					<div class="form-content-unit" id="step-two">
						<div class="vehicle-condition">
							<div class="vehicle-condition-unit">
								<div class="icon"><i class="stm-boats-icon-exterior"></i></div>
								<div class="title h5"><?php esc_html_e('What is the Exterior Condition?', 'motors'); ?></div>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Extra clean', 'motors'); ?>" checked/>
									<?php esc_html_e('Extra clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Clean', 'motors'); ?>"/>
									<?php esc_html_e('Clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Average', 'motors'); ?>"/>
									<?php esc_html_e('Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('Below Average', 'motors'); ?>"/>
									<?php esc_html_e('Below Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="exterior_condition" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
									<?php esc_html_e('I don\'t know', 'motors'); ?>
								</label>
							</div>
							<div class="vehicle-condition-unit">
								<div class="icon buoy"><i class="stm-boats-icon-interior"></i></div>
								<div class="title h5"><?php esc_html_e('What is the Interior Condition?', 'motors'); ?></div>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Extra clean', 'motors'); ?>" checked/>
									<?php esc_html_e('Extra clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Clean', 'motors'); ?>"/>
									<?php esc_html_e('Clean', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Average', 'motors'); ?>"/>
									<?php esc_html_e('Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('Below Average', 'motors'); ?>"/>
									<?php esc_html_e('Below Average', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="interior_condition" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
									<?php esc_html_e('I don\'t know', 'motors'); ?>
								</label>
							</div>
							<div class="vehicle-condition-unit">
								<div class="icon buoy-2"><i class="stm-boats-icon-accident"></i></div>
								<div class="title h5"><?php esc_html_e('Has boat been in accident', 'motors'); ?></div>
								<label>
									<input type="radio" name="accident" value="<?php esc_html_e('Yes', 'motors'); ?>"/>
									<?php esc_html_e('Yes', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="accident" value="<?php esc_html_e('No', 'motors'); ?>" checked/>
									<?php esc_html_e('No', 'motors'); ?>
								</label>
								<label>
									<input type="radio" name="accident" value="<?php esc_html_e('I don\'t know', 'motors'); ?>"/>
									<?php esc_html_e('I don\'t know', 'motors'); ?>
								</label>
							</div>
						</div>
						<a href="#" class="button sell-a-car-proceed" data-step="3">
							<?php esc_html_e('Save and continue', 'motors'); ?>
						</a>
					</div>

					<!-- STEP THREE -->
					<div class="form-content-unit" id="step-three">
						<div class="contact-details">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('First name', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['first_name'])) echo $_POST['first_name']; ?>" name="first_name"/>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Last name', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['last_name'])) echo $_POST['last_name']; ?>" name="last_name" />
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Email Address', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>" name="email" />
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Phone number', 'motors'); ?>*</div>
										<input type="text" value="<?php if(!empty($_POST['phone'])) echo $_POST['phone']; ?>" name="phone" />
									</div>
								</div>
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<div class="contact-us-label"><?php esc_html_e('Comments', 'motors'); ?></div>
										<textarea name="comments"><?php if(!empty($_POST['comments'])) echo $_POST['comments']; ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix">
							<div class="pull-left">
								<input type="submit" value="<?php esc_html_e('Save and finish', 'motors'); ?>" />
							</div>
							<div class="disclaimer">
								<?php esc_html_e('By submitting this form, you will be requesting trade-in value at no obligation and
		will be contacted within 48 hours by a sales representative.', 'motors'); ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	<?php endif; ?>

	<?php if(!empty($errors) and !empty($_POST['sell_a_car'])): ?>
		<div class="wpcf7-response-output wpcf7-validation-errors" id="error-fields">
			<?php foreach($errors as $error): ?>
				<?php echo $error; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if($mail_send): ?>
		<div class="wpcf7-response-output wpcf7-mail-sent-ok" id="error-fields">
			<?php esc_html_e('Mail successfully sent', 'motors'); ?>
		</div>
	<?php endif; ?>


	<script type="text/javascript">
		(function($) {
			"use strict";

			$(document).ready(function() {
				$('.form-navigation-unit').click(function(e){
					e.preventDefault();
					validateFirstStep();
					if(!$(this).hasClass('active')) {
						$('.form-navigation-unit').removeClass('active');
						$(this).addClass('active');

						var tab = $(this).data('tab');

						$('.form-content-unit').slideUp();

						$('#'+tab).slideDown();
					}
				})

				var i = 1;

				$('.stm-plus').click(function(e){
					e.preventDefault();
					if(i < 5) {
						i++;
						$('.upload-photos').append('<div class="stm-pseudo-file-input generated"><div class="stm-filename"><?php esc_html_e('Choose file...', 'motors'); ?></div><div class="stm-plus"></div><input class="stm-file-realfield" type="file" name="gallery_images_' + i + '"/></div>');
					}
				})

				$('body').on('click', '.generated .stm-plus', function(){
					i--;
					$(this).closest('.stm-pseudo-file-input').remove();
				})
			})

		})(jQuery);
	</script>
<?php endif; ?>