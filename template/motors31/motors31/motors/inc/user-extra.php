<?php

//Adding fields
add_action( 'show_user_profile', 'stm_show_user_extra_fields' );
add_action( 'edit_user_profile', 'stm_show_user_extra_fields' );

if(!function_exists('stm_show_user_extra_fields')) {
	function stm_show_user_extra_fields( $user ) { ?>

		<h3><?php esc_html_e( 'STM User/Dealer additional fields', 'motors' ); ?></h3>

		<table class="form-table">

			<tr>
				<th><label for="stm_show_email"><?php esc_html_e( 'Show email public', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_show_email" id="stm_show_email"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_show_email', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'Only "show" means that user mail is visible to public', 'motors' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_phone"><?php esc_html_e( 'Phone', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_phone" id="stm_phone"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_phone', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'User phone', 'motors' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_avatar"><?php esc_html_e( 'User Avatar', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_avatar" id="stm_user_avatar"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_avatar', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<input type="text" name="stm_user_avatar_path" id="stm_user_avatar_path"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_avatar_path', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'User avatar(stores URL and path to image)', 'motors' ); ?></span>
				</td>
			</tr>

			<tr>
				<h4><?php esc_html_e( 'STM User/Dealer additional fields (socials)', 'motors' ); ?></h4>
			</tr>

			<!--Socials-->
			<tr>
				<th><label for="stm_user_facebook"><?php esc_html_e( 'Facebook', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_facebook" id="stm_user_facebook"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_facebook', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_twitter"><?php esc_html_e( 'Twitter', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_twitter" id="stm_user_twitter"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_twitter', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_linkedin"><?php esc_html_e( 'Linked In', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_linkedin" id="stm_user_linkedin"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_linkedin', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_youtube"><?php esc_html_e( 'Youtube', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_youtube" id="stm_user_youtube"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_youtube', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_user_favourites"><?php esc_html_e( 'User favorite car ids', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_user_favourites" id="stm_user_favourites"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_user_favourites', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>


			<!--Dealer-->
			<tr>
				<th><h2><?php esc_html_e('Dealer Settings', 'motors'); ?></h2></th>
				<td><h3><?php esc_html_e('This settings will only be filled by dealers, and shown only on dealer page.', 'motors') ?></h3></td>
			</tr>

			<tr>
				<th><label for="stm_message_to_user"><?php esc_html_e( 'Message to pending user', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_message_to_user" id="stm_message_to_user"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_message_to_user', $user->ID ) ); ?>"
					       class="regular-text"/>
					<div>
					<span class="description"><?php esc_html_e('In case a user has entered incorrect details in Dealer submission, you can reject the request and add a notice.', 'motors') ?></span>
					</div>
				</td>
			</tr>

			<tr>
				<th><label for="stm_company_name"><?php esc_html_e( 'Company name', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_company_name" id="stm_company_name"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_company_name', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_website_url"><?php esc_html_e( 'Website URL', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_website_url" id="stm_website_url"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_website_url', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_company_license"><?php esc_html_e( 'License', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_company_license" id="stm_company_license"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_company_license', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_dealer_logo"><?php esc_html_e( 'Dealer Logo', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_dealer_logo" id="stm_dealer_logo"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_logo', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<input type="text" name="stm_dealer_logo_path" id="stm_dealer_logo_path"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_logo_path', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'Dealer logo(stores URL and path to image)', 'motors' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_dealer_image"><?php esc_html_e( 'Dealer Image', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_dealer_image" id="stm_dealer_image"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_image', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<input type="text" name="stm_dealer_image_path" id="stm_dealer_image_path"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_image_path', $user->ID ) ); ?>"
					       class="regular-text"/><br/>
					<span class="description"><?php esc_html_e( 'Dealer image(stores URL and path to image)', 'motors' ); ?></span>
				</td>
			</tr>

			<tr>
				<th><label for="stm_dealer_location"><?php esc_html_e( 'Dealer Location', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_dealer_location" id="stm_dealer_location"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_location', $user->ID ) ); ?>"
					       class="regular-text"/>
					<div class="description"><?php esc_html_e( 'Dealer location address', 'motors' ); ?></div>
					<input type="text" name="stm_dealer_location_lat" id="stm_dealer_location_lat"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_location_lat', $user->ID ) ); ?>"
					       class="regular-text"/>
					<div class="description"><?php esc_html_e( 'Dealer location latitude', 'motors' ); ?></div>
					<input type="text" name="stm_dealer_location_lng" id="stm_dealer_location_lng"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_dealer_location_lng', $user->ID ) ); ?>"
					       class="regular-text"/>
					<div class="description"><?php esc_html_e( 'Dealer location longitude', 'motors' ); ?></div>
				</td>
			</tr>

			<tr>
				<th><label for="stm_sales_hours"><?php esc_html_e( 'Sales Hours', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_sales_hours" id="stm_sales_hours"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_sales_hours', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<th><label for="stm_seller_notes"><?php esc_html_e( 'Seller Notes', 'motors' ); ?></label></th>

				<td>
					<textarea name="stm_seller_notes" id="stm_seller_notes"><?php echo esc_attr( get_the_author_meta( 'stm_seller_notes', $user->ID ) ); ?></textarea>
				</td>
			</tr>

			<tr>
				<th><label for="stm_payment_status"><?php esc_html_e( 'Payment status', 'motors' ); ?></label></th>

				<td>
					<input type="text" name="stm_payment_status" id="stm_payment_status"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_payment_status', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

			<tr>
				<td>
					<input type="hidden" name="stm_lost_password_hash" id="stm_lost_password_hash"
					       value="<?php echo esc_attr( get_the_author_meta( 'stm_lost_password_hash', $user->ID ) ); ?>"
					       class="regular-text"/>
				</td>
			</tr>

		</table>
	<?php }
}

//Updating fields
add_action( 'personal_options_update', 'stm_save_user_extra_fields' );
add_action( 'edit_user_profile_update', 'stm_save_user_extra_fields' );

if(!function_exists('stm_save_user_extra_fields')) {
	function stm_save_user_extra_fields( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		update_user_meta( $user_id, 'stm_phone', $_POST['stm_phone'] );

		update_user_meta( $user_id, 'stm_show_email', $_POST['stm_show_email'] );

		update_user_meta( $user_id, 'stm_user_avatar', $_POST['stm_user_avatar'] );
		update_user_meta( $user_id, 'stm_user_avatar_path', $_POST['stm_user_avatar_path'] );

		/*Socials*/
		update_user_meta( $user_id, 'stm_user_facebook', $_POST['stm_user_facebook'] );
		update_user_meta( $user_id, 'stm_user_twitter', $_POST['stm_user_twitter'] );
		update_user_meta( $user_id, 'stm_user_linkedin', $_POST['stm_user_linkedin'] );
		update_user_meta( $user_id, 'stm_user_youtube', $_POST['stm_user_youtube'] );

		//Favourites
		update_user_meta( $user_id, 'stm_user_favourites', $_POST['stm_user_favourites'] );


		/*Dealer settings*/
		update_user_meta( $user_id, 'stm_company_name', $_POST['stm_company_name'] );
		update_user_meta( $user_id, 'stm_website_url', $_POST['stm_website_url'] );
		update_user_meta( $user_id, 'stm_company_license', $_POST['stm_company_license'] );
		update_user_meta( $user_id, 'stm_message_to_user', $_POST['stm_message_to_user'] );


		/*Logos*/
		update_user_meta( $user_id, 'stm_dealer_logo', $_POST['stm_dealer_logo'] );
		update_user_meta( $user_id, 'stm_dealer_logo_path', $_POST['stm_dealer_logo_path'] );

		/*Dealer image*/
		update_user_meta( $user_id, 'stm_dealer_image', $_POST['stm_dealer_image'] );
		update_user_meta( $user_id, 'stm_dealer_image_path', $_POST['stm_dealer_image_path'] );

		/*Location*/
		update_user_meta( $user_id, 'stm_dealer_location', $_POST['stm_dealer_location'] );
		update_user_meta( $user_id, 'stm_dealer_location_lat', $_POST['stm_dealer_location_lat'] );
		update_user_meta( $user_id, 'stm_dealer_location_lng', $_POST['stm_dealer_location_lng'] );

		/*Sales Hours*/
		update_user_meta( $user_id, 'stm_sales_hours', $_POST['stm_sales_hours'] );

		update_user_meta( $user_id, 'stm_seller_notes', $_POST['stm_seller_notes'] );

		update_user_meta( $user_id, 'stm_payment_status', $_POST['stm_payment_status'] );

		update_user_meta( $user_id, 'stm_lost_password_hash', $_POST['stm_lost_password_hash'] );
	}
}

if(!function_exists('stm_stop_access_profile')) {
	add_action( 'admin_menu', 'stm_stop_access_profile' );
	function stm_stop_access_profile() {
		remove_menu_page( 'profile.php' );
		remove_submenu_page( 'users.php', 'profile.php' );
	}
}