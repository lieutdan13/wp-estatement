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

class bshMapPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Map Page Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshMapPage.php',
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
	        		<li class='active'><?php _e( 'Text Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Map Options', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Structure', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Proximity Options', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Advanced Search', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Properties Shown', THEMENAME ) ?></l1>
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
        						<?php _e( 'The text you specify here will be shown in the search input box as the placeholder text.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_input_placeholder', true );
        						$value = ( empty( $value ) ) ? 'Where would you like to live?' : $value;
        					?>
	        				<label for='_est_input_placeholder' class='sectionTitle'><?php _e( 'Search Placeholder', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_input_placeholder' name='_est_input_placeholder' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'This field allows you to modify the text in the search button.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_button_text', true );
        						$value = ( empty( $value ) ) ? 'search' : $value;
        					?>
	        				<label for='_est_button_text' class='sectionTitle'><?php _e( 'Button Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_button_text' name='_est_button_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text used for opening the advanced section. This is only visible to the user if you have enabled advanced options in the advanced search section', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_advanced_search_text', true );
        						$value = ( empty( $value ) ) ? 'more options' : $value;
        					?>
	        				<label for='_est_advanced_search_text' class='sectionTitle'><?php _e( 'Advanced Options Open Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_advanced_search_text' name='_est_advanced_search_text' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text used for closing the advanced section. This is only visible to the user if you have enabled advanced options in the advanced search section', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_advanced_search_text_open', true );
        						$value = ( empty( $value ) ) ? 'less options' : $value;
        					?>
	        				<label for='_est_advanced_search_text_open' class='sectionTitle'><?php _e( 'Advanced Options Close Text', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_advanced_search_text_open' name='_est_advanced_search_text_open' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the text used when there are no properties found for the given location', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_no_results_message', true );
        						$value = ( empty( $value ) ) ? 'There are no results near that location. Please try a different location, or increase the distance in the additional options' : $value;
        					?>
	        				<label for='_est_no_results_message' class='sectionTitle'><?php _e( 'No Results Message', THEMENAME ) ?></label>
		        			<textarea class='widefat' id='_est_no_results_message' name='_est_no_results_message'><?php echo esc_attr( $value ) ?></textarea>
	        			</div>



	        		</section>


	        		<section>




	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select the type of map you would like to use in the map page', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_map_type' class='sectionTitle'><?php _e( 'Map Type', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Roadmap' => 'roadmap',
	        						'Satellite' => 'satellite',
	        						'Hybrid' => 'hybrid',
	        						'Terrain' => 'terrain',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_map_type', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'roadmap' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_map_type-<?php echo $i ?>' name='_est_map_type' value='<?php echo $value ?>'><label for='_est_map_type-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Set the markers to open a popup or go directly to the property', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_marker_action' class='sectionTitle'><?php _e( 'Marker Action', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show Popup' => 'popup',
	        						'Link To Property Page' => 'link'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_marker_action', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'popup' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_marker_action-<?php echo $i ?>' name='_est_marker_action' value='<?php echo $value ?>'><label for='_est_marker_action-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Set an initial zoom for the map.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_map_initial_zoom', true );
        						$value = ( empty( $value ) ) ? '12' : $value;
        					?>
	        				<label for='_est_map_initial_zoom' class='sectionTitle'><?php _e( 'Initial Map Zoom', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_map_initial_zoom' name='_est_map_initial_zoom' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the initial location of the map. Use any text you would enter into Google Maps', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_initial_location', true );
        						$auto = get_post_meta( $post->ID, '_est_initial_location_auto', true );
        						$autoChecked_on = ( $auto == 'yes' ) ? 'checked="checked"' : '';
        						$autoChecked_off = ( $auto == 'no' ) ? 'checked="checked"' : '';
        						$autoChecked_coord = ( $auto == 'coord' ) ? 'checked="checked"' : '';
        						if( empty( $autoChecked_on ) AND empty( $autoChecked_off ) ) {
        							$autoChecked_on = 'checked="checked"';
        						}
        					?>
	        				<label for='_est_initial_location' class='sectionTitle'><?php _e( 'Initial Map Location', THEMENAME ) ?></label>

	        				<p>
	        				<input id='_est_initial_location_auto_0' <?php echo $autoChecked_on ?> type='radio' name='_est_initial_location_auto' value='yes'> <label for='_est_initial_location_auto_0'><?php _e( 'Use the viewer\'s location', THEMENAME ) ?></label><br>
	        				<input id='_est_initial_location_auto_1' <?php echo $autoChecked_off ?> type='radio' name='_est_initial_location_auto' value='no'> <label for='_est_initial_location_auto_1'><?php _e( 'Use the specified address below', THEMENAME ) ?></label><br>
	        				<input id='_est_initial_location_auto_2' <?php echo $autoChecked_coord ?> type='radio' name='_est_initial_location_auto' value='coord'> <label for='_est_initial_location_auto_2'><?php _e( 'Use coordinates specified below (use the format: lat,lng)', THEMENAME ) ?></label><br>

	        				</p>
		        			<input type='text' class='widefat' id='_est_initial_location' name='_est_initial_location' value='<?php echo esc_attr( $value ) ?>'></p>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The string you enter here will be added to every request sent to the map. If a user searches for "London" and you have entered "USA" into this field, the request sent to Google Maps will be: "London USA".', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_location_bias', true );
        						$value = ( empty( $value ) ) ? '' : $value;
        					?>
	        				<label for='_est_location_bias' class='sectionTitle'><?php _e( 'Location Bias', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_location_bias' name='_est_location_bias' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select what should happen if there are no properties near the users location or search', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_error_behavior' class='sectionTitle'><?php _e( 'Error Behavior', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show Error Message' => 'show_error',
	        						'Don\'t Show Error Message' => 'no_error'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID, '_est_error_behavior', true );
		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show_error' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_error_behavior-<?php echo $i ?>' name='_est_error_behavior' value='<?php echo $value ?>'><label for='_est_error_behavior-<?php echo $i ?>'><?php echo $choice ?></label><br>
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
		        			<input type='hidden' name='_est_marker' id='_est_marker'>

	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Set a horizontal offset for the map.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_map_offset_x', true );
        						$value = ( empty( $value ) ) ? '0' : $value;
        					?>
	        				<label for='_est_map_offset_x' class='sectionTitle'><?php _e( 'Horizontal Map Offset', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_map_offset_x' name='_est_map_offset_x' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Set a vertical offset for the map.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_map_offset_y', true );
        						$value = ( empty( $value ) ) ? '0' : $value;
        					?>
	        				<label for='_est_map_offset_y' class='sectionTitle'><?php _e( 'Vertical Map Offset', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_map_offset_y' name='_est_map_offset_y' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        		</section>

	        		<section>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select between a full page map or specify the height to be able to add some content', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$full_value = get_post_meta( $post->ID, '_est_full_page_map', true );
        						$height_value = get_post_meta( $post->ID, '_est_map_height', true );
        						$height_value = ( empty( $height_value ) ) ? '400px' : $height_value;
        						$checked_yes = ( empty( $full_value ) OR $full_value == 'yes' ) ? 'checked="checked"' : '';
        						$checked_no = ( $full_value == 'no' ) ? 'checked="checked"' : '';

        					?>
	        				<label for='_est_full_page_map' class='sectionTitle'><?php _e( 'Map Height', THEMENAME ) ?></label>

	        				<p>
	        				<input id='_est_full_page_map_0' <?php echo $checked_yes ?> type='radio' name='_est_full_page_map' value='yes'> <label for='_est_full_page_map_0'><?php _e( 'Full Page Map', THEMENAME ) ?></label><br>
	        				<input id='_est_full_page_map_1' <?php echo $checked_no ?> type='radio' name='_est_full_page_map' value='no'> <label for='_est_full_page_map_1'><?php _e( 'Specific Map Height:', THEMENAME ) ?></label><br>
	        				</p>
		        			<input type='text' class='widefat' id='_est_map_height' name='_est_map_height' value='<?php echo esc_attr( $height_value ) ?>'></p>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'By default the layout of this page is inherited from the default layout which can be changed in the <a href="%s">Theme Customizer</a>. If you need a different layout on this page, you can override the default setting.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='_est_layout' class='sectionTitle'><?php _e( 'Layout', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Global Setting' => 'default',
	        						'2 Columns - Sidebar on the Right' => '2col_right',
	        						'2 Columns - Sidebar on the Left'  => '2col_left',
	        						'1 Column' => '1col'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_layout', true );

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_layout-<?php echo $i ?>' name='_est_layout' value='<?php echo $value ?>'><label for='_est_layout-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'If you are using a layout with a sidebar the default sidebar will be shown. You can set the default sidebar in the <a href="%s">Theme Customizer</a>. If you would like to use a different sidebar on this page, choose one here.', THEMENAME ), esc_url( admin_url( 'customize.php' ) ) ) ?>
        						</div>
        					</div>

	        				<label for='_est_sidebar' class='sectionTitle'><?php _e( 'Sidebar', THEMENAME ) ?></label>

	        				<?php
		        				$current = get_post_meta( $post->ID,  '_est_sidebar', true );
								$choices = explode(',', get_theme_mod( 'sidebars' ) );
								$sidebars['default'] = 'Default';
								$sidebars['Sidebar'] = 'Sidebar';
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
        						<?php _e( 'If enabled users can choose to search for properties near their area. If disabled the default proximity value will be used', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_proximity' class='sectionTitle'><?php _e( 'Enable Proximity Search?', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_show_proximity', true );
        							$current = ( empty( $current ) ) ? 'yes' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_proximity-<?php echo $i ?>' name='_est_show_proximity' value='<?php echo $value ?>'><label for='_est_show_proximity-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Define a label for the proximity field.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_proximity_label', true );
        						$value = ( empty( $value ) ) ? 'Distance' : $value;
        					?>
	        				<label for='_est_proximity_label' class='sectionTitle'><?php _e( 'Proximity Field Label', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_proximity_label' name='_est_proximity_label' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select a default proximity for searches. If proximity is disabled this value is used, otherwise this value is selected by default.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_default_proximity', true );
        						$value = ( empty( $value ) ) ? '100' : $value;
        					?>
	        				<label for='_est_default_proximity' class='sectionTitle'><?php _e( 'Default Proximity', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_default_proximity' name='_est_default_proximity' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select the unit of measurement to use for proximity', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_proximity_unit' class='sectionTitle'><?php _e( 'Proximity Unit', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Miles' => 'mi',
	        						'Kilometers' => 'km',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_proximity_unit', true );
        							$current = ( empty( $current ) ) ? 'mi' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_proximity_unit-<?php echo $i ?>' name='_est_proximity_unit' value='<?php echo $value ?>'><label for='_est_proximity_unit-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Enter a comma separated list of values to use in the proximity dropdown, if enabled', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_proximity_options', true );
        						$value = ( empty( $value ) ) ? '25,50,100,200,500' : $value;
        					?>
	        				<label for='_est_proximity_options' class='sectionTitle'><?php _e( 'Selectable Proximity Values', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_proximity_options' name='_est_proximity_options' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>


					</section>

	        		<section>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'By default the search results are shown using the default WordPress search page. By using a dedicated post listing page you can narrow the search to a specific subset of items', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_page' class='sectionTitle'><?php _e( 'Used Search Page', THEMENAME ) ?></label>

	        				<?php
	        					$search_lists = get_posts( array(
	        						'post_type'   => 'page',
									'post_status' => 'publish',
									'meta_query'  => array(
										array(
											'key' => '_wp_page_template',
											'value' => array( 'template-bshListingPage.php' ),
											'compare' => 'IN'
										)
	        						)
	        					));

	        					$choices = array(
	        						'Default Search' => 'default',
	        					);

								foreach( $search_lists as $page ) {
									$choices[$page->post_title] = $page->ID;
								}

	        					$current = get_post_meta( $post->ID, '_est_search_page', true );
	        				?>
	        				<select id='_est_search_page' name='_est_search_page'>
		        				<?php
		        					foreach( $choices as $name => $value ) :
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
        						<?php _e( 'If you dont\'t want to enable searching on the map at all then you can disable the search functionality altogether here. Note that advanced search is only shown if this setting is set to yes.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_advanced_search' class='sectionTitle'><?php _e( 'Enable Search?', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_search', true );
        							$current = ( empty( $current ) ) ? 'yes' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'yes' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_search-<?php echo $i ?>' name='_est_search' value='<?php echo $value ?>'><label for='_est_search-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Make sure the "Enable Advanced Search" box is checked if you want to enable searching based on custom parameters, taxonomies and such. You can find all the options for this below', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_advanced_search' class='sectionTitle'><?php _e( 'Enable Advanced Search?', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_advanced_search', true );
        							$current = ( empty( $current ) ) ? 'no' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'default' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_advanced_search-<?php echo $i ?>' name='_est_advanced_search' value='<?php echo $value ?>'><label for='_est_advanced_search-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you\'d like the search options to be visible by default choose the appropriate option below', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_advanced' class='sectionTitle'><?php _e( 'Show Options By Default?', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Yes' => 'yes',
	        						'No' => 'no',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_show_advanced', true );
        							$current = ( empty( $current ) ) ? 'no' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'no' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_advanced-<?php echo $i ?>' name='_est_show_advanced' value='<?php echo $value ?>'><label for='_est_show_advanced-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo _e( 'Select the taxonomies you would like to add to this search page', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_details' class='sectionTitle'><?php _e( 'Built In Taxonomies To Show', THEMENAME ) ?></label>

	        				<?php
								$args = array(
								  'public'   => true,
								  '_builtin' => false

								);
								$output = 'names'; // or objects
								$operator = 'and'; // 'and' or 'or'
								$taxonomies = get_option( 'est_taxonomies' );
	        					$selection = get_post_meta( $post->ID, '_est_taxonomies', true );


	        					?>

			        				<span class='checkAll'><?php _e( 'select all', THEMENAME ) ?></span>
			        				<span class='checkNone'><?php _e( 'select none', THEMENAME ) ?></span>

		        				<table class='choices'>
		        					<thead>
		        					<tr>
		        						<th></th>
		        						<th class='text-left'><?php _e( 'Taxonomy', THEMENAME ) ?></th>
		        						<th class='text-left'><?php _e( 'Control Type', THEMENAME ) ?></th>
		        						<th><?php _e( 'Order', THEMENAME ) ?></th>
		        					</tr>
		        					</thead>
		        					<tbody>

			        				<?php
			        					foreach( $taxonomies as $taxonomy => $data ) :
			        					$checked = ( !empty( $selection[$taxonomy]['show'] ) AND $selection[$taxonomy]['show'] == 'yes' ) ? 'checked="checked"' : ''
			        				?>
			        				<tr>
				        				<td class='checkbox'>
					        				<input <?php echo $checked ?> type='checkbox' id='_est_taxonomies-<?php echo $i ?>' name='_est_taxonomies[<?php echo $taxonomy ?>][show]' value='yes'>
				        				</td>
				        				<td>
					        				<label for='_est_taxonomies-<?php echo $i ?>'><?php echo $data['labels']['name'] ?></label>
				        				</td>
							        	<td>
											<select name='_est_taxonomies[<?php echo $taxonomy ?>][field]'>
				        				<?php
				        					$fields = array(
				        						'select' => 'Dropdown Box',
				        						'slider' => 'Range Slider',
				        						'checkbox' => 'Checkboxes',
												'radio'    => 'Radio Buttons',
				        						'text' => 'Text Field',
				        					);
				        					foreach( $fields as $field => $name ) {
				        						$selected = ( !empty( $selection[$taxonomy]['field'] ) AND $selection[$taxonomy]['field'] == $field ) ? 'selected="selected"' : '';
 				        						echo '<option ' . $selected . ' value="' . $field . '">' . $name . '</option>';
				        					}
				        				?>
				        				</td>
				        				<td class='order'>
				        					<?php
				        						$order = ( !empty( $selection[$taxonomy]['order'] ) ) ? $selection[$taxonomy]['order'] : '';
				        					?>
				        					<input type='text' name='_est_taxonomies[<?php echo $taxonomy ?>][order]' value='<?php echo $order ?>'>
				        				</td>

			        				</tr>
			        				<input type='hidden' name='_est_taxonomies[<?php echo $taxonomy ?>][type]' value='taxonomy'>

			        				<?php $i++; endforeach ?>
			        				</tbody>
		        				</table>
	        				<div class='clear'></div>

	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo _e( 'Select the default in details you would like to add to this search page', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_customdatas' class='sectionTitle'><?php _e( 'Built In Details To Show', THEMENAME ) ?></label>

	        				<?php
	        					$details = get_option( 'est_customdata' );
	        					$selection = get_post_meta( $post->ID, '_est_customdatas', true );
	        					?>

			        				<span class='checkAll'><?php _e( 'select all', THEMENAME ) ?></span>
			        				<span class='checkNone'><?php _e( 'select none', THEMENAME ) ?></span>

		        				<table class='choices'>
		        					<thead>
		        					<tr>
		        						<th></th>
		        						<th class='text-left'><?php _e( 'Custom Field', THEMENAME ) ?></th>
		        						<th class='text-left'><?php _e( 'Control Type', THEMENAME ) ?></th>
		        						<th><?php _e( 'Order', THEMENAME ) ?></th>
		        					</tr>
		        					</thead>
		        					<tbody>

			        				<?php
			        					foreach( $details as $key => $datail ) :
			        					$checked = ( !empty( $selection[$key]['show'] ) AND $selection[$key]['show'] == 'yes' ) ? 'checked="checked"' : '';
		        				?>
			        				<tr>
				        				<td class='checkbox'>
					        				<input <?php echo $checked ?> type='checkbox' id='_est_customdatas-<?php echo $i ?>' name='_est_customdatas[<?php echo $key ?>][show]' value='yes'>
				        				</td>
				        				<td>
					        				<label for='_est_customdatas-<?php echo $i ?>'><?php echo $datail['name'] ?></label>
				        				</td>
							        	<td>
											<select name='_est_customdatas[<?php echo $key ?>][field]'>
				        				<?php
				        					$fields = array(
				        						'select' => 'Dropdown Box',
				        						'slider' => 'Range Slider',
				        						'checkbox' => 'Checkboxes',
												'radio'    => 'Radio Buttons',
				        						'text' => 'Text Field',
				        					);
				        					foreach( $fields as $field => $name ) {
				        						$selected = ( !empty( $selection[$key]['field'] ) AND $selection[$key]['field'] == $field ) ? 'selected="selected"' : '';
 				        						echo '<option ' . $selected . ' value="' . $field . '">' . $name . '</option>';
				        					}
				        				?>
				        				</td>
				        				<td class='order'>
				        					<?php
				        						$order = ( !empty( $selection[$key]['order'] ) ) ? $selection[$key]['order'] : '';
				        					?>
				        					<input type='text' name='_est_customdatas[<?php echo $key ?>][order]' value='<?php echo $order ?>'>
				        				</td>

			        				</tr>
				        			<input type='hidden' name='_est_customdatas[<?php echo $key ?>][type]' value='customdata'>
		        				<?php $i++; endforeach ?>
			        				</tbody>
		        				</table>
	        				<div class='clear'></div>

	        			</div>

		        	</section>

					<section>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Select which custom field value to show in the map when users click on a map makrker', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_field' class='sectionTitle'><?php _e( 'Field To Show', THEMENAME ) ?></label>
	        				<?php
	        					$customdata = get_option( 'est_customdata' );
								foreach( $customdata as $key => $data ) {
									$choices[$data['name']] = $key;
								}
	        				?>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_field', true );

		        				?>
		        				<select <?php echo $selected ?> id='_est_field' name='_est_field'>
		        					<option value=''><?php _e( 'Select a Field', THEMENAME ) ?></option>

		        				<?php
		        					$i=1; foreach( $choices as $name => $value ) :
		        					$selected = ( $current == $value ) ? 'selected="selected"' : '';
		        				?>
		        					<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
		        				<?php endforeach ?>
		        				</select>
	        				</ul>
	        			</div>



						<?php
						    $taxonomies = get_option( 'est_taxonomies' );
							foreach( $taxonomies as $taxonomy ) :

						?>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php echo sprintf( __( 'By Selecting a number of %s you can narrow the properties shown to only the selected types. If no types are selected all properties will be shown.', THEMENAME ), $taxonomy['labels']['name'] ) ?>
        						</div>
        					</div>

	        				<label for='_est_taxonomy_<?php echo $taxonomy['slug'] ?>' class='sectionTitle'><?php echo $taxonomy['labels']['name'] ?></label>

	        				<?php
	        					$terms = get_terms( $taxonomy['slug'] );
	        					if( empty( $terms ) ) {
	        						echo sprintf( __( 'You haven\'t created any %s yet. You can do so by clicking on any property item (or creating one) and adding one on the fly using the taxonomy box on the right.', THEMENAME ), $taxonomy['labels']['name'] );
	        					}
	        					else {

	        					?>

			        				<span class='checkAll'>select all</span>
			        				<span class='checkNone'>select none</span>

			        				<div class='clear'></div>


	        					<?php
		        					$terms_1 = array_slice( $terms, 0, ceil( count( $terms ) / 2 ) );
		        					$terms_2 = array_slice( $terms, ceil( count( $terms ) / 2 ) );
		        				?>
		        				<ul class='choices half-left'>
			        				<?php
			        					$current = get_post_meta( $post->ID,  '_est_taxonomy_' . $taxonomy['slug'], true );

			        					$i=1; foreach( $terms_1 as $term ) :
			        					$checked = ( is_array( $current ) AND in_array( $term->term_id, $current ) ) ? 'checked="checked"' : '';
			        				?>
			        				<li>
			        				<input <?php echo $checked ?> type='checkbox' id='_est_taxonomy_<?php echo $taxonomy['slug'] ?>-<?php echo $i ?>' name='_est_taxonomy_<?php echo $taxonomy['slug'] ?>[]' value='<?php echo $term->term_id ?>'><label for='_est_taxonomy_<?php echo $taxonomy['slug'] ?>-<?php echo $i ?>'><?php echo $term->name ?></label><br>
			        				</li>
			        				<?php $i++; endforeach ?>
		        				</ul>
		        				<ul class='choices half-right'>
			        				<?php

			        					foreach( $terms_2 as $term ) :
			        					$checked = ( is_array( $current ) AND in_array( $term->term_id, $current ) ) ? 'checked="checked"' : '';
			        				?>
			        				<li>
			        				<input <?php echo $checked ?> type='checkbox' id='_est_taxonomy_<?php echo $taxonomy['slug'] ?>-<?php echo $i ?>' name='_est_taxonomy_<?php echo $taxonomy['slug'] ?>[]' value='<?php echo $term->term_id ?>'><label for='_est_taxonomy_<?php echo $taxonomy['slug'] ?>-<?php echo $i ?>'><?php echo $term->name ?></label><br>
			        				</li>
			        				<?php $i++; endforeach ?>
		        				</ul>
		        			<?php } ?>

		        			<input type='hidden' id='_est_taxonomy_<?php echo $taxonomy['slug'] ?>-<?php echo $i ?>' name='_est_taxonomy_<?php echo $taxonomy['slug'] ?>[]' value='none'>
	        				<div class='clear'></div>

	        			</div>



						<?php endforeach ?>

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
    add_action( 'load-post.php', 'call_bshMapPageOptions' );
    add_action( 'load-post-new.php', 'call_bshMapPageOptions' );
}
function call_bshMapPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshMapPage.php' ) {
    	return new bshMapPageOptions();
    }

}




?>