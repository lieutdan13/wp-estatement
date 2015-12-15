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

class bshBookingPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Booking Page Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshBookingPage.php',
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
	        		<li class='active'><?php _e( 'Booking Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Structure', THEMENAME ) ?></li>
	        		<li><?php _e( 'Payment Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Text Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Email Settings', THEMENAME ) ?></li>
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
        						<?php _e( 'Select how you want the bookings to be performed', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_booking_type' class='sectionTitle'><?php _e( 'Booking Type', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Booking Only' => 'booking',
	        						'Booking &amp; Payment' => 'payment',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_booking_type', true );

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( ( !empty( $current ) AND $current == $value ) OR ( empty( $current ) AND $value == 'booking' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_booking_type-<?php echo $i ?>' name='_est_booking_type' value='<?php echo $value ?>'><label for='_est_booking_type-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>



					</section>
					<section>
						        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the slider (if any) to use on the page', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$slider = get_post_meta( $post->ID, '_est_slider', true );
        						$slider_shortcode = get_post_meta( $post->ID, '_est_slider_shortcode', true );

        						$checked_default = ( empty( $slider ) OR $slider == 'default' ) ? 'checked="checked"' : '';
        						$checked_specify = ( !empty( $slider ) AND $slider == 'specify' ) ? 'checked="checked"' : '';

        					?>
	        				<label for='_est_slider' class='sectionTitle'><?php _e( 'Slider To Use', THEMENAME ) ?></label>

	        				<p>
	        				<input id='_est_slider_0' <?php echo $checked_default ?> type='radio' name='_est_slider' value='default'> <label for='_est_slider_0'><?php _e( 'Use Default Slider', THEMENAME ) ?></label><br>
	        				<input id='_est_slider_1' <?php echo $checked_specify ?> type='radio' name='_est_slider' value='specify'> <label for='_est_slider_1'><?php _e( 'Specify Slider:', THEMENAME ) ?></label><br>
	        				</p>
		        			<input type='text' class='widefat' id='_est_slider_shortcode' name='_est_slider_shortcode' value='<?php echo $slider_shortcode ?>'></p>
	        			</div>

					</section>

	        		<section>

	       				<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Enter your PayPal email or merchant ID here.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_paypal_id', true );
        					?>
	        				<label for='_est_paypal_id' class='sectionTitle'><?php _e( 'PayPal Email or Merchant ID', THEMENAME ) ?></label>
		        			<input class='widefat' type='text' id='_est_paypal_id' name='_est_paypal_id' value='<?php echo $value ?>'>
	        			</div>


	       				<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Enter the three-letter currency code to use for payments here.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_currency_code', true );
        						$value = ( empty( $value ) ) ? 'USD' : $value;
        					?>
	        				<label for='_est_currency_code' class='sectionTitle'><?php _e( 'Currency Code', THEMENAME ) ?></label>
		        			<input class='widefat' type='text' id='_est_currency_code' name='_est_currency_code' value='<?php echo $value ?>'>
	        			</div>



					</section>


					<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify some text for the review your booking section. This is the text which appears just before the submit button in the booking form.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_review_text', true );
        					?>
	        				<label for='_est_review_text' class='sectionTitle'><?php _e( 'Review Your Booking Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_review_text' name='_est_review_text'><?php echo $value ?></textarea>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The text on the final review button. This is the first submit button for the booking form', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_review_button', true );
        						$value = ( empty( $value ) ) ? 'Final Review' : $value;
        					?>
	        				<label for='_est_review_button' class='sectionTitle'><?php _e( 'Final Review Button Text', THEMENAME ) ?></label>
		        			<input class='widefat' type='text' id='_est_review_button' name='_est_review_button' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify some additional details which will be shown at the end of the booking process, before the user finalizes the booking. This is great for some quick terms and services text.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_additional_details', true );
        					?>
	        				<label for='_est_additional_details' class='sectionTitle'><?php _e( 'Additional Details', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_additional_details' name='_est_additional_details'><?php echo $value ?></textarea>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify some text for the Complete your booking section. This is the text which appears just before the last submit button on the booking overview.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_complete_text', true );
        					?>
	        				<label for='_est_complete_text' class='sectionTitle'><?php _e( 'Complete Your Booking Text', THEMENAME ) ?></label>
		        			<textarea class='widefat redactor' style='height:120px;' id='_est_complete_text' name='_est_complete_text'><?php echo $value ?></textarea>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The text on the complete your booking button. This is the last submit button on the booking overview', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_complete_button', true );
        						$value = ( empty( $value ) ) ? 'Complete Booking' : $value;
        					?>
	        				<label for='_est_complete_button' class='sectionTitle'><?php _e( 'Complete Booking Button Text', THEMENAME ) ?></label>
		        			<input class='widefat' type='text' id='_est_complete_button' name='_est_complete_button' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>







	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The text shown in the flag on the top left of the thank you page', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_thankyou_flag', true );
        						$value = ( empty( $value ) ) ? 'Thank You' : $value;
        					?>
	        				<label for='_est_thankyou_flag' class='sectionTitle'><?php _e( 'Thank You Page Flag Text', THEMENAME ) ?></label>
		        			<input class='widefat' type='text' id='_est_thankyou_flag' name='_est_thankyou_flag' value='<?php echo $value ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The title shown next to the thank you flag', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_thankyou_title', true );
        						$value = ( empty( $value ) ) ? 'Your Booking Is Complete' : $value;
        					?>
	        				<label for='_est_thankyou_title' class='sectionTitle'><?php _e( 'Thank You Page Title', THEMENAME ) ?></label>
		        			<input class='widefat' type='text' id='_est_thankyou_title' name='_est_thankyou_title' value='<?php echo $value ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Post-booking thank you text', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_thankyou_text', true );
        					?>
	        				<label for='_est_thankyou_text' class='sectionTitle'><?php _e( 'Thank You Text', THEMENAME ) ?></label>
		        			<textarea class='redactor widefat' style='height:120px;' id='_est_thankyou_text' name='_est_thankyou_text'><?php echo $value ?></textarea>
	        			</div>



	        		</section>

	        		<section>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select which email addresses should receive the confirmation email', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_recipients' class='sectionTitle'><?php _e( 'Booking Confirmation Email Recipients', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Site Admin' => 'admin',
	        						'Property Agents' => 'agents',
	        						'Booker'  => 'booker',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_recipients', true );
		        					$current = ( empty( $current ) ) ? array() : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( in_array( $value, $current ) OR ( empty( $current ) ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='checkbox' id='_est_recipients-<?php echo $i ?>' name='_est_recipients[]' value='<?php echo $value ?>'><label for='_est_recipients-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>


					</section>


	        		<section class='helpSection'>
	        			<?php
	        			_e('

							<p>The map search page template allows you to crearte a beautiful full screen map search page. The page supports searching nearby the users location with a customizable distance</p>
<p>To create a map page first go to the Page section and add a new page. On the right, select “Map Page” from the template selector. You should see that specific options for this page type are loaded. Once done, you can add a title, some content, and choose your options.</p>
<p>Map pages allow you to modify the following settings:</p>
<ul>
<li>Text Options
<ul>
<li><strong>Search Placeholder</strong>: Specify the text shown inside the search box by default</li>
<li><strong>Button Text</strong>: Specify the button text</li>
<li><strong>Advanced Options Open Text</strong>: Specify the text in the advanced search tab when it is closed</li>
<li><strong>Advanced Options Closed Text</strong>:&nbsp;Specify the text in the advanced search tab when it is open</li>
<li><strong>No Results Message</strong>: Specify the message shown to users when no properties are found near the area they searched for.</li>
</ul>
</li>
<li>Map Options
<ul>
<li><strong>Map Type</strong>: Allows you to specify the map type.</li>
<li><strong>Initial Map Location</strong>: Specify the area the map should show when it loads. A search for nearby properties is performed when the page loads. You can also specify the user’s current location to be the initial position.</li>
<li><strong> Error Behavior</strong>: Select how the map should behave if there are no search results near the user’s location or search</li>
<li><strong>Map Marker Image</strong>: This setting allows you to select a different map marker image.</li>
</ul>
</li>
<li>Advanced Search
<ul>
<li><strong>Enable Advanced Search</strong>: If enabled, users will be able to use the parameters you specify to narrow their search.</li>
<li><strong>Built In Details To Show</strong>: This large table allows you to select which built in details you want to allow the user to use. You can select each detail and then select the control type it should use. In addition you can type a numeric order into the box to make them show up in the order you’d like.</li>
<li><strong>Custom In Details To Show</strong>: This large table allows you to select which custom details you want to allow the user to use. You can select each detail and then select the control type it should use. In addition you can type a numeric order into the box to make them show up in the order you’d like</li>
</ul>
</li>
<li>Structure
<ul>
<li><strong>Map Height</strong>: This option allows you to choose between a full-page map or a map with a specific height. If a specific height is selected you will be able to add content into the editor, just like on other pages. This is great for creating some beautiful <a href="http://airbnb.com">airbnb</a> style pages.</li>
<li><strong>Layout</strong>: The layout option applies to this page if a specific map height is selected. In this case you can choose a layout.</li>
<li><strong>Sidebar</strong>: If a map height is specifically chosen and a layout with a sidebar is used you can select which sidebar should show up here.</li>
</ul>
</li>
</ul>
<p>Don’t forget that help is available inline inside the options box. You can read the text of this article there, as well as reading inline help for each specific option next to the option itself. Simply hover over the help link.</p>

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
    add_action( 'load-post.php', 'call_bshBookingPageOptions' );
    add_action( 'load-post-new.php', 'call_bshBookingPageOptions' );
}
function call_bshBookingPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshBookingPage.php' ) {
    	return new bshBookingPageOptions();
    }

}




?>