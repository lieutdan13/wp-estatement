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

class bshRegisterPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Register Page Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshRegisterPage.php',
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
	        		<li class='active'><?php _e( 'Register Page Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Form Fields', THEMENAME ) ?></li>
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
        						<?php _e( 'Specify the title of the registration successful page.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_register_success_title', true );
        						$value = ( empty( $value ) ) ? 'Registration Successful' : $value;
        					?>
	        				<label for='_est_register_success_title' class='sectionTitle'><?php _e( 'Registration Success Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_register_success_title' name='_est_register_success_title' value='<?php echo esc_attr( $value ) ?>'>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text shown one the user submits the registration form. The user will need to activate his/her account using his email account so you should say something about this here..', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_register_success_text', true );
        						$value = ( empty( $value ) ) ? '<p>Your registration was successful, all that\'s left is activating your account. We\'ve sent an activation link to your email address.</p><p>Click on the activation link, or paste it into the URL bar of your browser to activate your account</p>' : $value;
        					?>
	        				<label for='_est_register_success_text' class='sectionTitle'><?php _e( 'Registration Success Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_register_success_text' name='_est_register_success_text'><?php echo $value ?></textarea>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the subject of the account activation email.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_register_activate_subject', true );
        						$value = ( empty( $value ) ) ? get_bloginfo() . ' - Activate Your Account' : $value;
        					?>
	        				<label for='_est_register_activate_subject' class='sectionTitle'><?php _e( 'Activation Email Subject', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_register_activate_subject' name='_est_register_activate_subject' value='<?php echo esc_attr( $value ) ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text you would like to use in the account activation email.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_register_activate_message', true );
        						$value = ( empty( $value ) ) ? '<p>Thanks for creating an account at ' . get_bloginfo() .'. The last step is to activate your account by clicking on the link below. ' : $value;
        					?>
	        				<label for='_est_register_activate_message' class='sectionTitle'><?php _e( 'Activation Email Message', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_register_activate_message' name='_est_register_activate_message'><?php echo $value ?></textarea>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title for the page shown when an incorrect activation link is used.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_invalid_key_title', true );
        						$value = ( empty( $value ) ) ? 'Unable To Activate Account' : $value;
        					?>
	        				<label for='_est_invalid_key_title' class='sectionTitle'><?php _e( 'Activation Failed Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_invalid_key_title' name='_est_invalid_key_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text to show on the page if the account activation fails due to an invalid security key.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_invalid_key_title', true );
        						$value = ( empty( $value ) ) ? '<p>Your security key seems to be invalid so we can not activate your account. This usually happens if you copy paste the link and leave an extra character in it.</p>' : $value;
        					?>
	        				<label for='_est_invalid_key_message' class='sectionTitle'><?php _e( 'Activation Failed Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_invalid_key_message' name='_est_invalid_key_message'><?php echo $value ?></textarea>
	        			</div>




	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title for the page shown when an activation has been completed.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_account_active_success_title', true );
        						$value = ( empty( $value ) ) ? 'Your Account Is Now Active' : $value;
        					?>
	        				<label for='_est_account_active_success_title' class='sectionTitle'><?php _e( 'Activation Success Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_account_active_success_title' name='_est_account_active_success_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text to show on the page if the account activation was successful.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_account_active_success_message', true );
        						$value = ( empty( $value ) ) ? '<p>Your account is now active and you can now log in at any time.</p>' : $value;
        					?>
	        				<label for='_est_account_active_success_message' class='sectionTitle'><?php _e( 'Activation Success Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_account_active_success_message' name='_est_account_active_success_message'><?php echo $value ?></textarea>
	        			</div>



	        		</section>

					<section>
	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo _e( 'Select the profile fields you would like to use during registration', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_customdatas' class='sectionTitle'><?php _e( 'Profile Fields To Show', THEMENAME ) ?></label>

	        				<?php
	        					$details = get_option( 'est_profilefields' );
	        					$selection = get_post_meta( $post->ID, '_est_profilefields', true );
	        					?>

			        				<span class='checkAll'><?php _e( 'select all', THEMENAME ) ?></span>
			        				<span class='checkNone'><?php _e( 'select none', THEMENAME ) ?></span>

		        				<table class='choices'>
		        					<thead>
		        					<tr>
		        						<th></th>
		        						<th class='text-left'><?php _e( 'Profile Field', THEMENAME ) ?></th>
		        						<th><?php _e( 'Order', THEMENAME ) ?></th>
		        						<th><?php _e( 'Required', THEMENAME ) ?></th>
		        					</tr>
		        					</thead>
		        					<tbody>

			        				<?php
			        					foreach( $details as $key => $datail ) :
			        					if( empty( $selection ) ) {
			        						$checked = '';
			        					}
			        					else {
			        						$checked = ( !empty( $selection[$key]['show'] ) AND $selection[$key]['show'] == 'yes' ) ? 'checked="checked"' : '';
			        					};
		        				?>
			        				<tr>
				        				<td class='checkbox'>
					        				<input <?php echo $checked ?> type='checkbox' id='_est_profilefields-<?php echo $i ?>' name='_est_profilefields[<?php echo $key ?>][show]' value='yes'>
				        				</td>
				        				<td>
					        				<label for='_est_profilefields-<?php echo $i ?>'><?php echo $datail['name'] ?></label>
				        				</td>
				        				<td class='order'>
				        					<?php
				        						$order = ( !empty( $selection[$key]['order'] ) ) ? $selection[$key]['order'] : '';
				        					?>
				        					<input type='text' name='_est_profilefields[<?php echo $key ?>][order]' value='<?php echo $order ?>'>
				        				</td>
				        				<td class='checkbox'>
				        					<?php
				        						$required = ( !empty( $selection[$key]['required'] ) ) ? 'checked="checked"' : '';
				        					?>
					        				<input <?php echo $required ?> type='checkbox' id='_est_profilefields_required-<?php echo $i ?>' name='_est_profilefields[<?php echo $key ?>][required]' value='yes'>
				        				</td>

			        				</tr>
				        			<input type='hidden' name='_est_profilefields[<?php echo $key ?>][type]' value='profilefields'>
		        				<?php $i++; endforeach ?>
			        				</tbody>
		        				</table>
	        				<div class='clear'></div>

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
    add_action( 'load-post.php', 'call_bshRegisterPageOptions' );
    add_action( 'load-post-new.php', 'call_bshRegisterPageOptions' );
}
function call_bshRegisterPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshRegisterPage.php' ) {
    	return new bshRegisterPageOptions();
    }

}




?>