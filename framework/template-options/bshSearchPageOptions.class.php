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

class bshSearchPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Search Page Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshSearchPage.php',
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
	        		<li class='active'><?php _e( 'Basic Setup', THEMENAME ) ?></li>
	        		<li><?php _e( 'Text Options', THEMENAME ) ?></li>
	        		<li><?php _e( 'Slideshow Options', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Advanced Search', THEMENAME ) ?></l1>
	        		<li><?php _e( 'Structure', THEMENAME ) ?></l1>
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
        						<?php _e( 'By default the search results are shown using the default WordPress search page. By using a dedicated post listing page you can narrow the search to a specific subset of items', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_page' class='sectionTitle'><?php _e( 'Used Search Page', THEMENAME ) ?></label>

	        				<?php
	        					$search_lists = get_posts( array(
	        						'post_type'   => 'page',
									'post_status' => 'publish',
									'posts_per_page' => -1,
									'meta_query'  => array(
										array(
											'key' => '_wp_page_template',
											'value' => array('template-bshListingPage.php','template-bshCustomListingPage.php',),
											'compare' => 'IN'
										),
	        						)
	        					));

	        					if( empty( $search_lists ) ) {
	        						?>

									<p>To make sure your search page works you MUST create a property list page and use it as the results page. Create a property list page and come back here to select it.</p>
	        						<?php

	        					}
	        					else {

	        						echo '<p>You MUST select a result page for your search page to work!</p>';

		        					$choices = array(
		        						'-- Select a Results Page --' => 'default',
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

								<?php 
								}

								?>

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



	        		</section>

	        		<section>

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




	        		</section>
	        		<section>
	        			<div class='option'>

		        		<?php _e(
		        			'
		        			<p>
		        			If you upload <strong>one image</strong> to this page that image will be used as the background for the search page. If you upload <strong>multiple images</strong> to this page you can set up a slideshow, or a different image to show up on each page load. The following options all apply to situations where you have uploaded more than one image.
		        			</p>
		        			<p>
		        			    If you would like to specify images to use in the slider instead of using all the attached ones use the Image Ids field to add a comma separated list of image Ids.
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

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'If you would like to show only specific images, add their ids here.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_slideshow_images', true );
        						$value = ( empty( $value ) ) ? '' : $value;
        					?>
	        				<label for='_est_slideshow_images' class='sectionTitle'><?php _e( 'Image Ids (comma separated)', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_slideshow_images' name='_est_slideshow_images' value='<?php echo $value ?>'>
	        			</div>



		        	</section>

	        		<section>


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
			        					if( empty( $selection ) ) {
			        						$checked = '';
			        					}
			        					else {
			        						$checked = ( !empty( $selection[$taxonomy]['show'] ) AND $selection[$taxonomy]['show'] == 'yes' ) ? 'checked="checked"' : '';
			        					}
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
					        					if( empty( $selection ) ) {
					        						$selected = '';
					        					}
					        					else {
					        						$selected = ( $selection[$taxonomy]['field'] == $field ) ? 'selected="selected"' : '';
					        					}
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
			        					if( empty( $selection ) ) {
			        						$checked = '';
			        					}
			        					else {
			        						$checked = ( !empty( $selection[$key]['show'] ) AND $selection[$key]['show'] == 'yes' ) ? 'checked="checked"' : '';
			        					};
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
				        						$selected = ( !empty( $selection[$key]['field'] ) AND  $selection[$key]['field'] == $field ) ? 'selected="selected"' : '';
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
        						<?php _e( 'Select between a full page search or specify the height to be able to add some content', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$full_value = get_post_meta( $post->ID, '_est_full_page_search', true );
        						$height_value = get_post_meta( $post->ID, '_est_search_height', true );
        						$height_value = ( empty( $height_value ) ) ? '400px' : $height_value;
        						$checked_yes = ( empty( $full_value ) OR $full_value == 'yes' ) ? 'checked="checked"' : '';
        						$checked_no = ( $full_value == 'no' ) ? 'checked="checked"' : '';

        					?>
	        				<label for='_est_full_page_search' class='sectionTitle'><?php _e( 'Search Height', THEMENAME ) ?></label>

	        				<p>
	        				<input id='_est_full_page_search_0' <?php echo $checked_yes ?> type='radio' name='_est_full_page_search' value='yes'> <label for='_est_full_page_search_0'><?php _e( 'Full Page Search', THEMENAME ) ?></label><br>
	        				<input id='_est_full_page_search_1' <?php echo $checked_no ?> type='radio' name='_est_full_page_search' value='no'> <label for='_est_full_page_search_1'><?php _e( 'Specific Search Height:', THEMENAME ) ?></label><br>
	        				</p>
		        			<input type='text' class='widefat' id='_est_search_height' name='_est_search_height' value='<?php echo esc_attr( $height_value ) ?>'></p>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Show or hide the title bar', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_show_title_bar' class='sectionTitle'><?php _e( 'Show Title Bar?', THEMENAME ) ?></label>

	        				<?php
	        					$choices = array(
	        						'Yes' => 'show',
	        						'No' => 'hide',
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
        							$current = get_post_meta( $post->ID, '_est_show_title_bar', true );
        							$current = ( empty( $current ) ) ? 'show' : $current;

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'show' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_show_title_bar-<?php echo $i ?>' name='_est_show_title_bar' value='<?php echo $value ?>'><label for='_est_show_title_bar-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>


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
    add_action( 'load-post.php', 'call_bshSearchPageOptions' );
    add_action( 'load-post-new.php', 'call_bshSearchPageOptions' );
}
function call_bshSearchPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshSearchPage.php' ) {
    	return new bshSearchPageOptions();
    }

}




?>