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
/*       1. Post Options Class                 */
/***********************************************/

class bshPropertyOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Property Options', THEMENAME ),
			'post_type' => 'property',
			'template'  => 'property',
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
	        		<li class='active'><?php _e( 'Structure', THEMENAME ) ?></li>
	        		<li><?php _e( 'Location', THEMENAME ) ?></li>
	        		<li><?php _e( 'Details', THEMENAME ) ?></li>
	        		<li><?php _e( 'Contact Options', THEMENAME ) ?></li>
					<li><?php _e( 'Booking Options', THEMENAME ) ?></li>
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
        						<?php _e( 'By default the title of this page is shown under the header. If you would like to hide this title, check the radio button next to  "Hide"', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_title' class='sectionTitle'><?php _e( 'Page Title', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_title', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_title-<?php echo $i ?>' name='_est_title' value='<?php echo $value ?>'><label for='_est_title-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'If you are using a layout with a sidebar the default sidebar will be shown. You can set the default sidebar in the <a href="%s">Theme Customizer</a>. If you would like to use a different sidebar on this post, choose one here.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='bsh_sidebar' class='sectionTitle'><?php _e( 'Sidebar', THEMENAME ) ?></label>

	        				<?php
		        				$current = get_post_meta( $post->ID,  '_est_sidebar', true );
								$choices = explode(',', get_theme_mod( 'sidebars' ) );
								$sidebars['default'] = 'Default';
								$sidebars['Sidebar'] = 'Sidebar';
								$sidebars['Property Page Sidebar'] = 'Property Page Sidebar';
								foreach( $choices as $choice ) {
									$choice = trim( $choice );
									if( !empty( $choice ) ) {
										$sidebars[$choice] = $choice;
									}
								}
	        					$current = get_post_meta( $post->ID, '_est_sidebar', true );
	        				?>
	        				<select id='_est_sidebar' name='_est_sidebar'>
		        				<?php
		        					foreach( $sidebars as $value => $name ) :
		        					$selected = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'selected="selected"' : '';
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
        						<?php _e( 'Select what you would like to use at the top of the single apartment page', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_top_element' class='sectionTitle'><?php _e( 'Element At The Top Of The Page', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Image Slider'   => 'slider',
	        						'Featured Image' => 'thumbnail',
	        						'Nothing'        => 'none'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_top_element', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'slider' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_top_element-<?php echo $i ?>' name='_est_top_element' value='<?php echo $value ?>'><label for='_est_top_element-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If "image slider" is chosen for the element at the top of the page you can choose specific image IDs to make sure not all images are shown.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_slider_image_ids', true );
        					?>
	        				<label for='_est_slider_image_ids' class='sectionTitle'><?php _e( 'Slider Image IDs (comma separated, empty for all)', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_slider_image_ids' name='_est_slider_image_ids' value='<?php echo $value ?>'>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Set the id of the picasa album for this property here', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_picasa_album', true );
        					?>
	        				<label for='_est_picasa_album' class='sectionTitle'><?php _e( 'Picasa Album ID', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_picasa_album' name='_est_picasa_album' value='<?php echo $value ?>'>

	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'The default data to put in the ribbon can be set in the <a href="%s">theme customizer</a>. If you want to override it for this property, simply select a different field.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='_est_ribbon_field' class='sectionTitle'><?php _e( 'Ribbon Custom Field', THEMENAME ) ?></label>

	        				<?php
		        				$current = get_post_meta( $post->ID, '_est_ribbon_field', true );
		        				$choices = array();
		        				$choices['default'] = '-- Use The Default --';
								$choices = array_merge( $choices, get_custom_detail_array() );
	        				?>
	        				<select id='_est_ribbon_field' name='_est_ribbon_field'>
		        				<?php
		        					foreach( $choices as $value => $name ) :
		        					$selected = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'selected="selected"' : '';
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
        						<?php _e( 'If you would like this property to remain in the system but be hidden from the map, you can set this option to hide', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_on_map' class='sectionTitle'><?php _e( 'Geolocation', THEMENAME ) ?></label>
							<?php
								$geolocation = get_post_meta( $post->ID, '_est_geocode', true );
								if( empty( $geolocation ) ) {
									_e( 'The coordinates of this property are not set. Please fill out the location details below, or the latitude and longitude fields at the bottom. If you have filled out the location fields but you do not get coordinates here you will need to ask your web host to enable curl or file_get_contents()' , THEMENAME );
								}
								else {
									$lat = get_post_meta( $post->ID, '_est_meta_latitude', true );
									$lng = get_post_meta( $post->ID, '_est_meta_longitude', true );
									if( empty( $lat ) OR empty( $lng ) ) {
										echo sprintf( __( 'The coordinates of this property have been geocoded by Google using the location fields. The coordinates are the following: <br> %s', THEMENAME ), $geolocation );

									}
									else {
										echo sprintf( __( 'The coordinates of this property have been entered manually in the latitude and longitude field. They are the following: <br> %s', THEMENAME ), $geolocation );
									}
								}
							?>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you would like this property to remain in the system but be hidden from the map, you can set this option to hide', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_on_map' class='sectionTitle'><?php _e( 'Show On Map?', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show' => 'show',
	        						'Hide' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_show_on_map', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_on_map-<?php echo $i ?>' name='_est_show_on_map' value='<?php echo $value ?>'><label for='_est_show_on_map-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'By specifying a new image you can change the way the markers look on the map', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_marker', true );
        						$value = ( empty( $value ) ) ? get_template_directory_uri() . '/images/marker.png': $value;
        					?>
	        				<label for='_est_marker' class='sectionTitle'><?php _e( 'Map Marker Image', THEMENAME ) ?></label>
		        			<img src='<?php echo $value ?>' data-id='_est_marker'><br><br>
		        			<span class='button primary bshUpload' data-id='_est_marker'>Select an Image</span>
		        			<input type='hidden' name='_est_marker' id='_est_marker' value='<?php echo $value ?>'>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select the country the property is located in.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_country', true );
        					?>
	        				<label for='_est_meta_country' class='sectionTitle'><?php _e( 'Country', THEMENAME ) ?></label>
	        				<select id='_est_meta_country' name='_est_meta_country'>
	        					<?php echo bsh_get_country_dropdown_options( $value ) ?>
	        				</select>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the state this property is located in', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_state', true );
        					?>
	        				<label for='_est_meta_state' class='sectionTitle'><?php _e( 'State', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_meta_state' name='_est_meta_state' value='<?php echo $value ?>'>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the city this property is located in', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_city', true );
        					?>
	        				<label for='_est_meta_city' class='sectionTitle'><?php _e( 'City', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_meta_city' name='_est_meta_city' value='<?php echo $value ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the street level address', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_address', true );
        					?>
	        				<label for='_est_meta_address' class='sectionTitle'><?php _e( 'Street Address', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_meta_address' name='_est_meta_address' value='<?php echo $value ?>'>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the zip/postal code', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_zipcode', true );
        					?>
	        				<label for='_est_meta_zipcode' class='sectionTitle'><?php _e( 'Zip/Postal Code', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_meta_zipcode' name='_est_meta_zipcode' value='<?php echo $value ?>'>

	        			</div>


	        			<div class='option'>
        					<?php _e( 'The following fields can be used to add the latitude and longitude manually. This can be useful if you have some properties in remote locations. Beware as this overwrites andy previous locations settings on Google Maps.', THEMENAME ) ?>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the latitude of this location manually', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_latitude', true );
        					?>
	        				<label for='_est_meta_latitude' class='sectionTitle'><?php _e( 'Latitude', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_meta_latitude' name='_est_meta_latitude' value='<?php echo $value ?>'>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the longitude of this location manually', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_meta_longitude', true );
        					?>
	        				<label for='_est_meta_longitude' class='sectionTitle'><?php _e( 'Longitude', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_meta_longitude' name='_est_meta_longitude' value='<?php echo $value ?>'>

	        			</div>


	        		</section>

	        		<section>

		        		<?php
		        			$fields = get_option( 'est_customdata' );
		        			foreach( $fields as $field ) :
		        			if( in_array( $field['key'], est_get_builtins() ) ) {
		        				continue;
		        			}
		        		?>
			        		<div class='option'>
<!--
	        					<div class='help'>
	        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
	        						<div class='content'>
	        						<?php _e( 'Specify the price of this property here.', THEMENAME ) ?>
	        						</div>
	        					</div>
-->

		        				<label for='_est_price' class='sectionTitle'><?php echo $field['name'] ?></label>

		        				<?php show_customdata_field( $post, $field ) ?>

		        				<?php
			        				$info = array();
		        					if( !empty( $field['prefix'] ) ) {
			        					$info[] = sprintf( __( 'Prefix: %s', THEMENAME ), $field['prefix'] );
			        				}
		        					if( !empty( $field['suffix'] ) ) {
			        					$info[] = sprintf( __( 'Suffix: %s', THEMENAME ), $field['suffix'] );
			        				}

			        				if( !empty( $info ) ) :
		        				?>
				        			<p class='description'>
				        				<?php echo implode( ', ', $info ) ?>
				        			</p>
		        				<?php endif ?>
		        			</div>


		        		<?php endforeach ?>





	        		</section>

	        		<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the agent this property belongs to', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label class='sectionTitle'><?php _e( 'Agents', THEMENAME ) ?></label>

							<div id='est_agents'>
        					<?php
								$users['administrator'] = @get_users( array( 'role' => 'administrator' ) );
								$users['agent'] = @get_users( array( 'role' => 'agent' ) );
								$users['agent'] = @get_users( array( 'role' => 'agent' ) );
								$users = array_merge( $users['administrator'], $users['agent'] );
        						$values = get_post_meta( $post->ID, '_est_agent' );

        						if( empty( $values ) ) {
        							$values[0] = $post->post_author;
        						}
        					?>

			        			<?php $i=0; foreach( $values as $user_id ) : ?>
								<div class='est_agent'>
								<label><?php _e( 'Agent', THEMENAME ) ?> <span class='agent_count'><?php echo ( $i + 1 ) ?></span></label>
			        			<select class='widefat' id='_est_agent_<?php echo $i ?>' name='_est_agent[<?php echo $i ?>]'>
		        					<option value='0'><?php _e( '-- Select an Agent --', THEMENAME ) ?></option>
			        				<?php
			        					foreach( $users as $user ) :
				        				$selected = ( $user->data->ID == $user_id ) ? 'selected="selected"' : '';
			        				?>
			        					<option <?php echo $selected ?> value='<?php echo $user->data->ID ?>'><?php echo $user->data->display_name ?></option>
			        				<?php endforeach ?>
			        			</select>
								<br><br>

			        			</div>
			        			<?php $i++; endforeach ?>


							</div>

		        			<a href='#' class='primary button' id='add-agent'><?php _e( '+ add another agent', THEMENAME ) ?></a>



	        			</div>


	        			<div class='option'>
		        			<?php
		        				echo sprintf( __( '
		        				<p>
		        				The following fields let you customize the automatic reply messages that get sent to users sending contact messages. You only need to fill this out if you would like something different than the global settings defined in the <a href="%s">Theme Customizer</a>.
		        				</p>
								<p>
									For the subject and message fields below you can use a couple of placeholders which signify the title and the link for the property. If you use <strong>!url</strong> it will be replaced by the url of the property. If you use <strong>!title</strong> it will be replaced with the title of the property.
								</p>

		        				', THEMENAME ), admin_url() . '/customize.php' )
		        			?>
		        		</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the subject of the auto-reply email', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_contact_reply_subject', true );
        					?>
	        				<label for='_est_contact_reply_subject' class='sectionTitle'><?php _e( 'Contact Auto-Reply Subject', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_contact_reply_subject' name='_est_contact_reply_subject' value='<?php echo $value ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the message of the auto-reply email', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_contact_reply_message', true );
        					?>
	        				<label for='_est_contact_reply_message' class='sectionTitle'><?php _e( 'Contact Auto-Reply Message', THEMENAME ) ?></label>
		        			<textarea rows='12' class='widefat' id='_est_contact_reply_message' name='_est_contact_reply_message'><?php echo $value ?></textarea>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the email address the contact email is sent to', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_contact_email', true );
        					?>
	        				<label for='_est_contact_email' class='sectionTitle'><?php _e( 'Send The Contact Email To This Address', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_contact_email' name='_est_contact_email' value='<?php echo $value ?>'>

	        			</div>

	        		</section>


					<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If this property is rentable users will be able to book online and view availiblitiy and so on.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_bookable' class='sectionTitle'><?php _e( 'Is This Property Bookable?', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Yes, booking is allowed' => 'yes',
	        						'No, no bookings can be made' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_bookable', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'no' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_bookable-<?php echo $i ?>' name='_est_bookable' value='<?php echo $value ?>'><label for='_est_bookable-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you would like to have a separate PayPal email/ID associated with this property, add it here. A PayPal ID can also be added to book now pages. That serves as the default, you only need to add it here if you want it to be different from the default.', THEMENAME ) ?>
        						</div>
        					</div>
	        					<?php
	        						$value = get_post_meta( $post->ID, '_est_property_paypal', true );
	        					?>
	        				<label for='_est_property_paypal' class='sectionTitle'><?php _e( 'PayPal email/ID', THEMENAME ) ?></label>
			        			<input type='text' class='widefat' id='_est_property_paypal' name='_est_property_paypal' value='<?php echo $value ?>' placeholder='<?php _e( 'Enter your PayPal email or ID here', THEMENAME ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Type the currency you want to use for rental prices', THEMENAME ) ?>
        						</div>
        					</div>
	        					<?php
	        						$value = get_post_meta( $post->ID, '_est_rent_currency', true );
	        						$value = ( empty( $value ) ) ? '$' : $value;
	        					?>
	        				<label for='_est_rent_currency' class='sectionTitle'><?php _e( 'Rental Price Currency', THEMENAME ) ?></label>
			        			<input type='text' class='widefat' id='_est_rent_currency' name='_est_rent_currency' value='<?php echo $value ?>' placeholder='<?php _e( 'Rental Currency', THEMENAME ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select the position of the rental currency symbol.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_rent_currency_position' class='sectionTitle'><?php _e( 'Currency Symbol Position?', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Before' => 'before',
	        						'After' => 'after',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_rent_currency_position', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'before' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_rent_currency_position-<?php echo $i ?>' name='_est_rent_currency_position' value='<?php echo $value ?>'><label for='_est_rent_currency_position-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the minimum and maximum amount of people allowed to book this property', THEMENAME ) ?>
        						</div>
        					</div>

							<div class='half-left'>
	        					<?php
	        						$value = get_post_meta( $post->ID, '_est_min_guests', true );
	        					?>
		        				<label for='_est_min_guests' class='sectionTitle'><?php _e( 'Minimum Guests', THEMENAME ) ?></label>
			        			<input type='text' class='widefat' id='_est_min_guests' name='_est_min_guests' value='<?php echo $value ?>' placeholder='<?php _e( 'Minimum number of guests', THEMENAME ) ?>'>
		        			</div>

							<div class='half-right'>
	        					<?php
	        						$value = get_post_meta( $post->ID, '_est_max_guests', true );
	        					?>
		        				<label for='_est_max_guests' class='sectionTitle'><?php _e( 'Maximum Guests', THEMENAME ) ?></label>
			        			<input type='text' class='widefat' id='_est_max_guests' name='_est_max_guests' value='<?php echo $value ?>' placeholder='<?php _e( 'Maximum number of guests', THEMENAME ) ?>'>
		        			</div>


	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the minimum and maximum length of time booking is allowed', THEMENAME ) ?>
        						</div>
        					</div>

							<div class='half-left'>
	        					<?php
	        						$value = get_post_meta( $post->ID, '_est_min_nights', true );
	        					?>
		        				<label for='_est_min_nights' class='sectionTitle'><?php _e( 'Minimum Stay', THEMENAME ) ?></label>
			        			<input type='text' class='widefat' id='_est_min_nights' name='_est_min_nights' value='<?php echo $value ?>' placeholder='<?php _e( 'Minimum stay in days', THEMENAME ) ?>'>
		        			</div>

							<div class='half-right'>
	        					<?php
	        						$value = get_post_meta( $post->ID, '_est_max_nights', true );
	        					?>
		        				<label for='_est_max_nights' class='sectionTitle'><?php _e( 'Maximum Stay', THEMENAME ) ?></label>
			        			<input type='text' class='widefat' id='_est_max_nights' name='_est_max_nights' value='<?php echo $value ?>' placeholder='<?php _e( 'Maximum stay in days', THEMENAME ) ?>'>
		        			</div>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the booking interval to allow. If days are selected users can choose their stay in days. If weeks is selected, users may only book weekly stays', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_booking_interval' class='sectionTitle'><?php _e( 'Booking Intervals', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Daily bookings' => 'day',
	        						'Only weekly stays allowed' => 'week',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_booking_interval', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'day' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_booking_interval-<?php echo $i ?>' name='_est_booking_interval' value='<?php echo $value ?>'><label for='_est_booking_interval-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify weather the price is calculated per room/property or per person', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_price_type' class='sectionTitle'><?php _e( 'Price Type', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Per Night' => 'night',
	        						'Per Person Per Night' => 'person',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_price_type', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'night' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_price_type-<?php echo $i ?>' name='_est_price_type' value='<?php echo $value ?>'><label for='_est_price_type-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The daily price of renting the property', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_rent_daily_price', true );
        					?>
	        				<label for='_est_rent_daily_price' class='sectionTitle'><?php _e( 'Daily Price', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_rent_daily_price' name='_est_rent_daily_price' value='<?php echo $value ?>' placeholder='<?php _e( 'The daily price', THEMENAME ) ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The weekly price of renting the property. If not specified, the daily price will be used to calculate the total cost.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_rent_weekly_price', true );
        					?>
	        				<label for='_est_rent_weekly_price' class='sectionTitle'><?php _e( 'Weekly Price', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_rent_weekly_price' name='_est_rent_weekly_price' value='<?php echo $value ?>' placeholder='<?php _e( 'The weekly price', THEMENAME ) ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The monthly price of renting the property. If not specified, the daily price and weekly price (if specified) will be used to calculate the total cost.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_rent_monthly_price', true );
        					?>
	        				<label for='_est_rent_monthly_price' class='sectionTitle'><?php _e( 'Monthly Price', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_rent_monthly_price' name='_est_rent_monthly_price' value='<?php echo $value ?>' placeholder='<?php _e( 'The monthly price', THEMENAME ) ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The following controls allow you to specify date based discounts or increased prices.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_rent_seasonal_price', true );
        						if( empty( $value ) ) {
        							$value = array( array(
        								'start'   => '',
        								'end'     => '',
        								'price' => array(
        									'daily'  => '',
        									'weekly' => '',
        									'monthly'=> ''
        								)
        							));
        						}
        					?>

	        				<label for='_est_rent_seasonal_price' class='sectionTitle'><?php _e( 'Seasonal Prices', THEMENAME ) ?></label>

		        				<table class='choices'>
		        					<thead>
		        					<tr>
		        						<th class='text-left'><?php _e( 'Name', THEMENAME ) ?></th>
		        						<th class='text-left'><?php _e( 'Start Date', THEMENAME ) ?></th>
		        						<th class='text-left'><?php _e( 'End Date', THEMENAME ) ?></th>
		        						<th class='text-left'><?php _e( 'Price', THEMENAME ) ?></th>
		        						<th class='text-left'><?php _e( 'Remove', THEMENAME ) ?></th>
		        					</tr>
		        					</thead>
		        					<tbody>

			        				<?php
			        					$i = 0;
			        					foreach( $value as $season ) :
			        				?>
			        				<tr class='est-seasonal-price'>
				        				<td>
				        				<?php _e( 'Season Name', THEMENAME ) ?><br> <input class='name' style='width:100px' name='_est_rent_seasonal_price[<?php echo $i ?>][name]' value='<?php echo $season['name'] ?>' type='text' placeholder='name'>
				        				</td>
				        				<td>
				        				<?php _e( 'From', THEMENAME ) ?><br> <input class='from small monthdaypicker' name='_est_rent_seasonal_price[<?php echo $i ?>][start]' value='<?php echo $season['start'] ?>' type='text' placeholder='Start Date'>
				        				</td>
				        				<td>
				        				<?php _e( 'Until', THEMENAME ) ?><br> <input class='until monthdaypicker small' name='_est_rent_seasonal_price[<?php echo $i ?>][end]' value='<?php echo $season['end'] ?>' type='text' placeholder='End Date'>
				        				</td>
				        				<td>
				        				<?php _e( 'The new prices are', THEMENAME ) ?><br>
				        				<input class='daily small' name='_est_rent_seasonal_price[<?php echo $i ?>][price][daily]' value='<?php echo $season['price']['daily'] ?>' type='text' placeholder='Daily'>
				        				<input name='_est_rent_seasonal_price[<?php echo $i ?>][price][weekly]' class='weekly small' value='<?php echo $season['price']['weekly'] ?>' type='text' placeholder='Weekly'>
				        				<input name='_est_rent_seasonal_price[<?php echo $i ?>][price][monthly]' class='monthly small' value='<?php echo $season['price']['monthly'] ?>' type='text' placeholder='Monthly'>
				        				</td>

				        				<td><br><a href='#' class='remove-seasonal-price'><?php _e( 'remove', THEMENAME ) ?></a></td>
									</tr>
									<?php $i++; endforeach ?>
								</table>
								<br>
								<a href='#' id='add-seasonal-price'><?php _e( '+ add another', THEMENAME ) ?></a>

						</div>



	        			<div class='option'>
		        			<?php
		        				echo sprintf( __( '
		        				<p>
		        				The following fields let you customize the automatic booking confirmation that gets sent to users when they finalize a booking. You only need to fill this out if you would like something different than the global settings defined in the <a href="%s">Theme Customizer</a>.
		        				</p>
								<p>
									For the subject and message fields below you can use a couple of placeholders which signify the title and the link for the property. If you use <strong>!url</strong> it will be replaced by the url of the property. If you use <strong>!title</strong> it will be replaced with the title of the property.
								</p>

		        				', THEMENAME ), admin_url() . '/customize.php' )
		        			?>
		        		</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the subject of the confimation email', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_booking_email_subject', true );
        					?>
	        				<label for='_est_booking_email_subject' class='sectionTitle'><?php _e( 'Booking Confirmation Subject', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_booking_email_subject' name='_est_booking_email_subject' value='<?php echo $value ?>'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the message of the booking confirmation email', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_booking_email_message', true );
        					?>
	        				<label for='_est_booking_email_message' class='sectionTitle'><?php _e( 'Booking Confirmation Message', THEMENAME ) ?></label>
		        			<textarea rows='12' class='widefat' id='_est_booking_email_message' name='_est_booking_email_message'><?php echo $value ?></textarea>

	        			</div>




					</section>





	        		<section class='helpSection'>
	        			<?php
	        			_e('
<div class="post-content">

							<p>Properties can be created and managed in the "Properties" section of the admin. They work quite like regular posts. In addition to the standard things like a title, content, being able to schedule them and so on, they give you a lot of property-specific options, let\'s take a look at those.</p>
<p>First of all, there are two custom taxonomies available. Property Type and Property Category. You can add as many entries as you want into each. You can later let users search based on these parameters, and you can use them in property lists to narrow what you show to users.</p>
<p>In the <a href="bonsaished.com/estatement/">Estatement Demo</a> &nbsp;we\'ve used the property types to add categories like "Apartment", "Detached House" and so on. We\'ve used the property categories to add building types like "Highrise", "Victorian", "Colonial" and so on.</p>
<p>Note that the media uploaded to properties is used in the slider for the property page. If you only add one image it is shown as a featured image, if more are added, a slider is created for you.</p>
<p>All the other property-specific settings can be found in the Estatement options box underneath the content editor. :</p>
<ul>
<li>Structure
<ul>
<li><strong><strong>Page Title</strong>: Allows you to show or hide the page title</strong></li>
<li><strong>Sidebar</strong>: Allows you ro show a specific sidebar for this page</li>
<li><strong>Element At The Top Of The Page</strong>: Allows you to select which element is shown at the top of the page.</li>
<li><strong>Ribbon Custom Field</strong>: Allows you to choose which custom field should be shown in the ribbon. A global default can be set for this in the theme customizer.</li>
</ul>
</li>
<li>Location
<ul>
<li><strong>Country</strong>: Allows you to select the country the property is located in</li>
<li><strong>State</strong>: Select the state the property is located in</li>
<li><strong>City</strong>: Add the city the property is in</li>
<li><strong>Street Address</strong>: Add the specific street address if the property.</li>
<li><strong>Zip/Postal Code</strong>: Add the zip or postal code of the property</li>
<li><strong>Latitude</strong>: Allows you to manually set the latitude for a property</li>
<li><strong>Longitude</strong>: Allows you to manually set the longitude for a property</li>
</ul>
</li>
<li>Details
<ul>
<li><b>Global Details</b>: All your global details should be shown in the top part of this section. To modify these global details go to the "Custom Fields" page. To learn more about managing custom fields read our knowledgebase article on <a href="http://bonsaished.com/blog/kb/managing-custom-fields/">Managing Custom Fields</a>.</li>
<li><strong>Custom Details</strong>: Below the global details you can add any ad-hoc details you would like to show for only this property.</li>
</ul>
</li>
<li>Contact Options
<ul>
<li><strong>Agents</strong>: This section allows you to assign agents to a property. By default the post author will be the agent but this can be changed here, and other agents can also be added. Refer to our article on <a href="http://bonsaished.com/blog/kb/managing-agents/">Managing Agents</a> for more information</li>
<li><strong>Contact Auto-Reply Subject</strong>: This setting is set globally in the theme customizer. If you want to specify a different auto-reply subject for a specific property you can do so here.</li>
<li><strong>Contact Auto-Reply Message</strong>: This setting is set globally in the theme customizer. If you want to specify a different auto-reply message for a specific property you can do so here.</li>
<li><strong>Send The Contact Email To This Address</strong>: This setting is set globally in the theme customizer. If you would like contact messages sent about a specific property to go to a different email address you can specify it here.</li>
</ul>
</li>
</ul>
<p>Don\'t forget that help is available inline inside the options box. You can read the text of this article there, as well as reading inline help for each specific option next to the option itself. Simply hover over the help link.</p>

						</div>
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
    add_action( 'load-post.php', 'call_bshPropertyOptions' );
    add_action( 'load-post-new.php', 'call_bshPropertyOptions' );
}
function call_bshPropertyOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'property' ) {
    	return new bshPropertyOptions();
    }

}




?>