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

class bshBookingOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Booking Options', THEMENAME ),
			'post_type' => 'booking',
			'template'  => 'booking',
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
	        		<li class='active'><?php _e( 'Booking Details', THEMENAME ) ?></li>
	        		<li><?php _e( 'Contact Details', THEMENAME ) ?></li>
	        		<li><?php _e( 'Payment Details', THEMENAME ) ?></li>
	        		<li><?php _e( 'Help', THEMENAME) ?></l1>
	        		<li><?php _e( 'Shortcode Guide', THEMENAME) ?></l1>
	        		<li><?php _e( 'Get Support', THEMENAME) ?></l1>
	        	</ul>
	        	<div id='bshOptions'>
		        	<input id='bshSaveTop' name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Update">

	        		<section class='active'>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the number of people staying in your property for this booking', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_guests' class='sectionTitle'><?php _e( 'Guests', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_guests', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_guests' name='_est_guests' value='<?php echo $value ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the date of arrival for this booking', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_start' class='sectionTitle'><?php _e( 'Arrival Date', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_start', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_start' name='_est_start' value='<?php echo $value ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the date of departure for this booking', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_end' class='sectionTitle'><?php _e( 'Departure Date', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_end', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_end' name='_est_end' value='<?php echo $value ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the property to book', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_end' class='sectionTitle'><?php _e( 'Property', THEMENAME ) ?></label>
	        				<?php
	        					$current = get_post_meta( $post->ID, '_est_property_id', true );
	        					$properties = get_property_dropdown_options();
	        				?>
		        				<select class='widefat' id='_est_property_id' name='_est_property_id'>
		        					<option value=''>-- Select a Property --</option>
		        					<?php
		        						if( !empty( $properties ) ) :
		        						foreach( $properties as $value => $name ) :
										$selected = ( $value == $current ) ? 'selected="selected"' : '';
		        					?>
										<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
		        					<?php endforeach; endif; ?>
		        				</select>
	        			</div>


	        		</section>

	        		<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the name of the booking party', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_name' class='sectionTitle'><?php _e( 'Full Name', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_name', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_name' name='_est_name' value='<?php echo $value ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the email address of the booking party', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_email' class='sectionTitle'><?php _e( 'Email', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_email', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_email' name='_est_email' value='<?php echo $value ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the phone number of the booking party', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_phone' class='sectionTitle'><?php _e( 'Phone', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_phone', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_phone' name='_est_phone' value='<?php echo $value ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify any additional notes about this booking', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_notes' class='sectionTitle'><?php _e( 'Additional Notes', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_notes', true );
	        				?>
		        				<textarea class='widefat' style='height:120px;' id='_est_notes' name='_est_notes'><?php echo $value ?></textarea>
	        			</div>


	        		</section>


					<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select weather or not you have received the payment', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_paid' class='sectionTitle'><?php _e( 'Payment Received?', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_paid', true );

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( ( !empty( $current ) AND $current == $value ) OR ( empty( $current ) AND $value == 'no' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_paid-<?php echo $i ?>' name='_est_paid' value='<?php echo $value ?>'><label for='_est_paid-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Add the payment ID if you have one', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_payment_id' class='sectionTitle'><?php _e( 'Payment ID', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_payment_id', true );
	        				?>
		        				<input class='widefat' type='text' id='_payment_id' name='_payment_id' value='<?php echo $value ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Add the payment ID if you have one', THEMENAME ) ?>
        						</div>
        					</div>


	        				<label for='_est_paid_amount' class='sectionTitle'><?php _e( 'Received Payment', THEMENAME ) ?></label>
	        				<?php
	        					$value = get_post_meta( $post->ID, '_est_paid_amount', true );
	        				?>
		        				<input class='widefat' type='text' id='_est_paid_amount' name='_est_paid_amount' value='<?php echo $value ?>'>
	        			</div>



	        		</section>




	        		<section class='helpSection'>
	        			<?php
	        			_e('
	        				<p>
	        					Posts allow you to create simple blog-like content. They are shown on the main page by default and can be categorized and tagged for better organization. Musico offers a few special options for posts in addition to the numerous shortcodes which will help you format your content.
	        				</p>

							<ul>
								<li>
								Structure
							<ul>
								<li><strong>Layout</strong>: By default the layout of this post is inherited from the default layout which can be changed in the Theme Customizer. If you need a different layout for this post, you can override the default setting.
								</li>
								<li><strong>Post Metadata</strong>: By default posts show meta information like author, tag, categories and so on. If you would not like to show this information for this post, you can enable it with this setting.</li>
								<li><strong>Sidebar</strong>: If you are using a layout with a sidebar the default sidebar will be shown. You can set the default sidebar in the Theme Customizer. If you would like to use a different sidebar on this post, choose one here.
								</li>

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
    add_action( 'load-post.php', 'call_bshBookingOptions' );
    add_action( 'load-post-new.php', 'call_bshBookingOptions' );
}
function call_bshBookingOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'booking' ) {
    	return new bshBookingOptions();
    }

}




?>