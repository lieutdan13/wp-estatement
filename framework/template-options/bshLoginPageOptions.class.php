<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file generates the options needed for
	the post template.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*

	1. Post Options Class
		1.1 Constructor
		1.2 Options Box Content

	2. Instantiating The Options

*/

/***********************************************/
/*       1. Post Options Class         */
/***********************************************/

class bshLoginPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Login Page Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshLoginPage.php',
			'context'   => 'normal',
			'priority'  => 'high'
		);
        parent::__construct( $args );
        $this->setup_options();
	}

	// 1.2 Options Box Content
    public function options_box_content( $post ) {
        ?>
        	<div id='bshLogo'></div>
        	<div id='optionsContainer'>
        		<div id='menuBackground'></div>

	        	<ul id='bshMenu'>
	        		<li class='active'><?php _e( 'Login Page Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Forgot Password Page Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Password Reset Page Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Slideshow Options', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Help', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Shortcode Guide', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Get Support', THEMENAME ) ?></l1>
	        	</ul>
	        	<div id='bshOptions'>
		        	<input id='bshSaveTop' name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Update">

	        		<section class='active'>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'This text will be used as the title for the login page', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_login_title', true );
        						$value = ( empty( $value ) ) ? 'Log In' : $value;
        					?>
	        				<label for='_est_login_title' class='sectionTitle'><?php _e( 'Login Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_login_title' name='_est_login_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Redirect the users to this url when they have logged in', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_login_redirect', true );
        						$value = ( empty( $value ) ) ? site_url() : $value;
        					?>
	        				<label for='_est_login_redirect' class='sectionTitle'><?php _e( 'After Login Redirect', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_login_redirect' name='_est_login_redirect' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>



						<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select the page used as the registration page. This must be a page which uses the Registration Page template. If no page is selected, the registration link will not be shown.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_register_page' class='sectionTitle'><?php _e( 'Registration Page', THEMENAME ) ?></label>

	        				<?php
	        					$search_lists = get_posts( array(
	        						'post_type'   => 'page',
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'meta_query'  => array(
										array(
											'key' => '_wp_page_template',
											'value' => 'template-bshRegisterPage.php',
											'compare' => '='
										)
	        						)
	        					));

	        					$choices = array(
	        						'No Registration Page' => '',
	        					);

								foreach( $search_lists as $page ) {
									$choices[$page->post_title] = $page->ID;
								}

	        					$current = get_post_meta( $post->ID, '_est_register_page', true );
	        				?>
	        				<select id='_est_register_page' name='_est_register_page'>
		        				<?php
		        					foreach( $choices as $name => $value ) :
		        					$selected = ( $current == $value ) ? 'selected="selected"' : '';
		        				?>
		        				<option value='<?php echo $value ?>' <?php echo $selected ?>>
		        				<?php echo $name ?>
		        				</option>
		        				<?php endforeach ?>
	        				</select>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The text you specify here will be shown in the username box as the placeholder text.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_username_placeholder', true );
        						$value = ( empty( $value ) ) ? 'Username' : $value;
        					?>
	        				<label for='_est_username_placeholder' class='sectionTitle'><?php _e( 'Username Placeholder', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_username_placeholder' name='_est_username_placeholder' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The text you specify here will be shown in the password box as the placeholder text.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_password_placeholder', true );
        						$value = ( empty( $value ) ) ? 'Password' : $value;
        					?>
	        				<label for='_est_password_placeholder' class='sectionTitle'><?php _e( 'Password Placeholder', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_password_placeholder' name='_est_password_placeholder' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'This field allows you to modify the text in the login button.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_button_text', true );
        						$value = ( empty( $value ) ) ? 'log in' : $value;
        					?>
	        				<label for='_est_button_text' class='sectionTitle'><?php _e( 'Button Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_button_text' name='_est_button_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text which is show when a user enters invalid login credentials.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_error_invalid', true );
        						$value = ( empty( $value ) ) ? 'Invalid username/password combination' : $value;
        					?>
	        				<label for='_est_error_invalid' class='sectionTitle'><?php _e( 'Invalid Login Message', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_error_invalid' name='_est_error_invalid' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the message shown if the user tried to log in with an account which hasn\'t been activated.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_error_activation', true );
        						$value = ( empty( $value ) ) ? 'Please activate your account before logging in. If you do not have an activation link please use the forgot password form to get a new one.' : $value;
        					?>
	        				<label for='_est_error_activation' class='sectionTitle'><?php _e( 'Inactive Account Message', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_error_activation' name='_est_error_activation' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text for the forgot password link.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_password_link_text', true );
        						$value = ( empty( $value ) ) ? 'forgot password' : $value;
        					?>
	        				<label for='_est_forgot_password_link_text' class='sectionTitle'><?php _e( 'Forgot Password Link Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_forgot_password_link_text' name='_est_forgot_password_link_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text for the register link.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_register_link_text', true );
        						$value = ( empty( $value ) ) ? 'register' : $value;
        					?>
	        				<label for='_est_register_link_text' class='sectionTitle'><?php _e( 'Register Link Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_register_link_text' name='_est_register_link_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text for the login link.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_login_link_text', true );
        						$value = ( empty( $value ) ) ? 'log in' : $value;
        					?>
	        				<label for='_est_login_link_text' class='sectionTitle'><?php _e( 'Login Link Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_login_link_text' name='_est_login_link_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        		</section>

					<section>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title for the forgot password page.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_password_title', true );
        						$value = ( empty( $value ) ) ? 'Forgot Password' : $value;
        					?>
	        				<label for='_est_forgot_password_title' class='sectionTitle'><?php _e( 'Forgot Password Page Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_forgot_password_title' name='_est_forgot_password_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the placeholder for the email field.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_email_placeholder', true );
        						$value = ( empty( $value ) ) ? 'Email' : $value;
        					?>
	        				<label for='_est_email_placeholder' class='sectionTitle'><?php _e( 'Email Placeholder', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_email_placeholder' name='_est_email_placeholder' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text for the submit button.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_button_text', true );
        						$value = ( empty( $value ) ) ? 'Retrieve Password' : $value;
        					?>
	        				<label for='_est_forgot_button_text' class='sectionTitle'><?php _e( 'Button Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_forgot_button_text' name='_est_forgot_button_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the subject of the password retrieval email.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_email_subject', true );
        						$value = ( empty( $value ) ) ? get_bloginfo() . ' - Reset Password' : $value;
        					?>
	        				<label for='_est_forgot_email_subject' class='sectionTitle'><?php _e( 'Email Subject', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_forgot_email_subject' name='_est_forgot_email_subject' value='<?php echo esc_attr( $value ) ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text you would like to use in the password retrieval email.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_email_message', true );
        						$value = ( empty( $value ) ) ? '<p>It looks like you would like to reset your password for ' . get_bloginfo() .'. If you did not initiate this request, please discard this email.</p><p>To reset your password please click on the link below, or paste it into your browser\'s URL bar.' : $value;
        					?>
	        				<label for='_est_forgot_email_message' class='sectionTitle'><?php _e( 'Email Message', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_forgot_email_message' name='_est_forgot_email_message'><?php echo $value ?></textarea>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title for the page displayed after the user has entered his email address.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_sent_title', true );
        						$value = ( empty( $value ) ) ? 'Check Your Inbox' : $value;
        					?>
	        				<label for='_est_forgot_sent_title' class='sectionTitle'><?php _e( 'Password Reset Sent Page Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_forgot_sent_title' name='_est_forgot_sent_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text to show on the page displayed after the user has entered his email address.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_forgot_sent_message', true );
        						$value = ( empty( $value ) ) ? '<p>An email has been sent to you with instructions for resetting your password</p> <p>Follow the steps outlined in the email and you should be able to log back in in no time.</p>' : $value;
        					?>
	        				<label for='_est_forgot_sent_message' class='sectionTitle'><?php _e( 'Password Reset Sent Page Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_forgot_sent_message' name='_est_forgot_sent_message'><?php echo $value ?></textarea>
	        			</div>





					</section>

					<section>
	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title for the page shown when an incorrect reset link is used.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_invalid_key_title', true );
        						$value = ( empty( $value ) ) ? 'Password Could Not Be Reset' : $value;
        					?>
	        				<label for='_est_invalid_key_title' class='sectionTitle'><?php _e( 'Password Reset Failed Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_invalid_key_title' name='_est_invalid_key_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text to show on the page if the password reset fails due to an invalid security key.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_invalid_key_message', true );
        						$value = ( empty( $value ) ) ? '<p>Your security key seems to be invalid so we can not reset your password. This usually happens if you try to reset your password twice with the same link.</p><p>If you want to reset your password again, please initiate a password reset via the login page</p>' : $value;
        					?>
	        				<label for='_est_invalid_key_message' class='sectionTitle'><?php _e( 'Password Reset Failed Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_invalid_key_message' name='_est_invalid_key_message'><?php echo $value ?></textarea>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title for the page shown when a users password has been reset and the new password has been sent.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_password_reset_success_title', true );
        						$value = ( empty( $value ) ) ? 'Your New Password Is Ready' : $value;
        					?>
	        				<label for='_est_password_reset_success_title' class='sectionTitle'><?php _e( 'Password Reset Success Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_password_reset_success_title' name='_est_password_reset_success_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text for the page shown when a users password has been reset and the new password has been sent.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_password_reset_success_message', true );
        						$value = ( empty( $value ) ) ? '<p>Your password has been reset and sent to your email address. When logging in again we suggest changing your password</p>' : $value;
        					?>
	        				<label for='_est_password_reset_success_message' class='sectionTitle'><?php _e( 'Password Reset Success Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_password_reset_success_message' name='_est_password_reset_success_message'><?php echo $value ?></textarea>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the subject for the email which contains the user\'s new password', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_password_reset_subject', true );
        						$value = ( empty( $value ) ) ? get_bloginfo() . ' - Your new password' : $value;
        					?>
	        				<label for='_est_password_reset_subject' class='sectionTitle'><?php _e( 'Password Reset Success Email Subject', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_password_reset_subject' name='_est_password_reset_subject' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text for the email which contains the user\'s new password. Make sure to use @password@ as a placeholder for the user\'s actual new password.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_password_reset_message', true );
        						$value = ( empty( $value ) ) ? '<p>Congratulations your password has been reset successfully. Your new password is: <strong>@password@</strong>.</p><p>You can now <a href="'.get_permalink( $post->ID ).'">log in</a> with your new password. We recommend changing it as soon as you log in again.</p>' : $value;
        					?>
	        				<label for='_est_password_reset_message' class='sectionTitle'><?php _e( 'Password Reset Success Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_password_reset_message' name='_est_password_reset_message'><?php echo $value ?></textarea>
	        			</div>





					</section>

	        		<section>
	        			<div class='option'>

		        		<?php _e(
		        			'
		        			<p>
		        			If you upload <strong>one image</strong> to this page that image will be used as the background for the search page. If you upload <strong>multiple images</strong> to this page you can set up a slideshow, or a different image to show up on each page load. The following options all apply to situations where you have uploaded more than one image.
		        			</p>
		        			',
		        			THEMENAME
		        		) ?>
		        		</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you have uploaded multiple images to the page you can choose to display them all using a fading transition effect or load a new one on each page load.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_search_background_type' class='sectionTitle'><?php _e( 'Background Type', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Slideshow' => 'slideshow',
	        						'New image on each page load' => 'pageload',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_search_background_type', true );
        							$current = ( empty( $current ) ) ? 'slideshow' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_search_background_type-<?php echo $i ?>' name='_est_search_background_type' value='<?php echo $value ?>'><label for='_est_search_background_type-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you\'ve selected the slideshow option above you can set the time each image is displayed for here.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_slideshow_speed', true );
        						$value = ( empty( $value ) ) ? '12' : $value;
        					?>
	        				<label for='_est_button_text' class='sectionTitle'><?php _e( 'Slideshow Speed (in seconds)', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_slideshow_speed' name='_est_slideshow_speed' value='<?php echo $value ?>'>
	        			</div>



		        	</section>




	        		<section class='helpSection'>
	        			<?php
	        			_e('

							<p>The search page template allows you to crearte a beautiful full screen search page to capture users. It is extremely customizable allowing you to specify how users can search and what parameters they can use.</p>
<p>To create the full size backgrounds for the search page all you need to do is upload one or more large image in the add media section. These will be used as the basis for the rotation of images.</p>
<p>Search pages allow you to modify the following settings:</p>
<ul>
	<li>Text Options
<ul>
	<li><strong>Search Placeholder</strong>: Specify the text shown inside the search box by default</li>
	<li><strong>Button Text</strong>: Specify the button text</li>
	<li><strong>Advanced Options Open Text</strong>: Specify the text in the advanced search tab when it is closed</li>
	<li><strong>Advanced Options Closed Text</strong>: Specify the text in the advanced search tab when it is open</li>
</ul>
</li>
	<li>Slideshow Options
<ul>
	<li><strong>Background Type</strong>: Select how you want to show your images. You can cycle through them or show a different one on each reload.</li>
	<li><strong>Slideshow Speed</strong>: Select how long each image is shown</li>
</ul>
</li>
	<li>Advanced Search
<ul>
	<li><strong>Enable Advanced Search</strong>: If enabled, users will be able to use the parameters you specify to narrow their search.</li>
	<li><strong>Built In Details To Show</strong>: This large table allows you to select which built in details you want to allow the user to use. You can select each detail and then select the control type it should use. In addition you can type a numeric order into the box to make them show up in the order you\'d like.</li>
	<li><strong>Custom In Details To Show</strong>: This large table allows you to select which custom details you want to allow the user to use. You can select each detail and then select the control type it should use. In addition you can type a numeric order into the box to make them show up in the order you\'d like</li>
</ul>
</li>
	<li>Structure
<ul>
	<li><strong>Search Height</strong>: This option allows you to choose between a full-page search or a search with a specific height. If a specific height is selected you will be able to add content into the editor, just like on other pages. This is great for creating some beautiful <a href="http://airbnb.com">airbnb</a> style pages.</li>
	<li><strong>Layout</strong>: The layout option applies to this page if a specific search height is selected. In this case you can choose a layout.</li>
	<li><strong>Sidebar</strong>: If a search height is specifically chosen and a layout with a sidebar is used you can select which sidebar should show up here.</li>
</ul>
</li>
</ul>

	        			', THEMENAME );
	        			?>
	        		</section>

	        		<section class='helpSection'>
	        			<?php echo bsh_docs_shortcodes() ?>
		        	</section>
		        	<section class='helpSection'>
			        	<?php echo bsh_docs_get_support() ?>
			   		</section>

	        	</div>
	        	<div class='clear'></div>
	        </div>

        <?php
    }


}


/***********************************************/
/*       2. Instantiating The Options          */
/***********************************************/

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_bshLoginPageOptions' );
    add_action( 'load-post-new.php', 'call_bshLoginPageOptions' );
}
function call_bshLoginPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshLoginPage.php' ) {
    	return new bshLoginPageOptions();
    }

}




?>