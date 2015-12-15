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

class bshPropertyFilterPageOptions extends bshOptions {

	// 1.1 Constructor
	function __construct() {
		$args = array(
			'title'     => __( 'Property Filter Options', THEMENAME ),
			'post_type' => 'page',
			'template'  => 'template-bshPropertyFilterPage.php',
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
	        		<li class='active'><?php _e( 'Structure', THEMENAME ) ?></l1>
	        		<li ><?php _e( 'Properties Shown', THEMENAME ) ?></li>
	        		<li><?php _e( 'Filter Setup', THEMENAME ) ?></l1>
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
        						<?php _e( 'The filter area can be positioned on the left, the right (just like the sidebars) or on top.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_filter_location' class='sectionTitle'><?php _e( 'Filter Location', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Left' => 'left',
	        						'Right' => 'right'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_filter_location', true );

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'right' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_filter_location-<?php echo $i ?>' name='_est_filter_location' value='<?php echo $value ?>'><label for='_est_filter_location-<?php echo $i ?>'><?php echo $choice ?></label><br>
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
								$sidebars['none'] = 'Do not show sidebar';
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
		        					$selected = ( $current == $value OR ( empty( $current ) AND $value == 'none' ) ) ? 'selected="selected"' : '';
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

	        		<section>

	        			 <div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify the title of the search box. If left blank the title will be hidden', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_search_title', true );

        					?>
	        				<label for='_est_search_title' class='sectionTitle'><?php _e( 'Search Section Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_search_title' name='_est_search_title' value='<?php echo $value ?>'>

	        			</div>


	        			 <div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Specify how the properties should be ordered', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$customdata = get_option( 'est_customdata' );

        						$value = get_post_meta( $post->ID, '_est_orderby', true );
        						$value = ( empty( $value ) ) ? 'post_date' : $value;


        						$customdata['post_date'] = array( 'name' => __( 'Published Date' , THEMENAME ) );
        						$customdata['post_title'] = array( 'name' => __( 'Title' , THEMENAME ) );
        					?>
	        				<label for='_est_orderby' class='sectionTitle'><?php _e( 'Order Properties By', THEMENAME ) ?></label>
		        			<select name='_est_orderby' id='_est_orderby'>
		        				<?php foreach( $customdata as $key => $details ) : ?>
		        				<?php $selected = ( $value == $key ) ? 'selected="selected"' : ''; ?>
		        					<option <?php echo $selected ?> value='<?php echo $key ?>'><?php echo $details['name'] ?></option>
		        				<?php endforeach ?>
		        			</select>


        					<?php
        						$value = get_post_meta( $post->ID, '_est_order', true );
        						$value = ( empty( $value ) ) ? 'DESC' : $value;

								$orders = array(
									'DESC' => 'Descending',
									'ASC'  => 'Ascending'
								)
        					?>

		        			<select name='_est_order' id='_est_order'>
		        				<?php foreach( $orders as $key => $name ) : ?>
		        				<?php $selected = ( $value == $key ) ? 'selected="selected"' : ''; ?>
		        					<option <?php echo $selected ?> value='<?php echo $key ?>'><?php echo $name ?></option>
		        				<?php endforeach ?>
		        			</select>




	        			</div>


	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'The filter can either show all properties and filter using a smooth animation or it can paginate the results and then filter using ajax whenever a new parameter is selected.', THEMENAME ) ?>
        						</div>
        					</div>

	        				<label for='_est_filter_type' class='sectionTitle'><?php _e( 'Filter Type', THEMENAME ) ?></label>
	        				<?php
	        					$choices = array(
	        						'Show All Properties - Filter With Animation' => 'all',
	        						'Paginate Results - Filter Using AJAX' => 'paginate'
	        					)
	        				?>
	        				<ul class='choices'>
		        				<?php
		        					$current = get_post_meta( $post->ID,  '_est_filter_type', true );

		        					$i=1; foreach( $choices as $choice => $value ) :
		        					$checked = ( $current == $value OR ( empty( $current ) AND $value == 'all' ) ) ? 'checked="checked"' : '';
		        				?>
		        				<li>
		        				<input <?php echo $checked ?> type='radio' id='_est_filter_type-<?php echo $i ?>' name='_est_filter_type' value='<?php echo $value ?>'><label for='_est_filter_type-<?php echo $i ?>'><?php echo $choice ?></label><br>
		        				</li>
		        				<?php $i++; endforeach ?>
	        				</ul>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Determine the number of properties to show per page', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_posts_per_page', true );
        						$value = ( empty( $value ) ) ? get_option( 'posts_per_page' ) : $value;
        					?>
	        				<label for='_est_posts_per_page' class='sectionTitle'><?php _e( 'Properties Per Page', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_posts_per_page' name='_est_posts_per_page' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>



	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Define the title to be shown if there are no results.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_no_results_title', true );
        						$value = ( empty( $value ) ) ? 'Ooops, No Results!' : $value;
        					?>
	        				<label for='_est_no_results_title' class='sectionTitle'><?php _e( 'No Results Title', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_no_results_title' name='_est_no_results_title' value='<?php echo esc_attr( $value ) ?>'>
	        			</div>

	        			<div class='option'>
        					<div class='help'>
        						<span class='title'><?php _e( 'help', THEMENAME ) ?></span>
        						<div class='content'>
        						<?php _e( 'Define the message to be shown if there are no results.', THEMENAME ) ?>
        						</div>
        					</div>

        					<?php
        						$value = get_post_meta( $post->ID, '_est_no_results_message', true );
        						$value = ( empty( $value ) ) ? 'Try broadening your search using the filters' : $value;
        					?>
	        				<label for='_est_no_results_message' class='sectionTitle'><?php _e( 'No Results Message', THEMENAME ) ?></label>
		        			<input type='text' class='widefat' id='_est_no_results_message' name='_est_no_results_message' value='<?php echo esc_attr( $value ) ?>'>
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
		        						<th class='text-left'><?php _e( 'Filter Type', THEMENAME ) ?></th>
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
							        	<td>
											<select name='_est_taxonomies[<?php echo $taxonomy ?>][filter_type]'>
				        				<?php
				        					$fields = array(
				        						'and' => 'And Filter',
				        						'or' => 'Or Filter',
				        					);
				        					foreach( $fields as $field => $name ) {
				        						if( empty( $selection ) ) {
								        			$selected = '';
				        						}
				        						else {
					        						$selected = ( $selection[$taxonomy]['filter_type'] == $field ) ? 'selected="selected"' : '';
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
		        						<th class='text-left'><?php _e( 'Filter Type', THEMENAME ) ?></th>
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
				        						if( empty( $selection ) ) {
				        							$selected = '';
				        						}
				        						else {
				        							$selected = ( $selection[$key]['field'] == $field ) ? 'selected="selected"' : '';
				        						}
 				        						echo '<option ' . $selected . ' value="' . $field . '">' . $name . '</option>';
				        					}
				        				?>
				        				</td>
							        	<td>
											<select name='_est_customdatas[<?php echo $key ?>][filter_type]'>
				        				<?php
				        					$fields = array(
				        						'and' => 'And Filter',
				        						'or' => 'Or Filter',
				        					);
				        					foreach( $fields as $field => $name ) {
				        						if( empty( $selection ) ) {
								        			$selected = '';
				        						}
				        						else {
					        						$selected = ( $selection[$key]['filter_type'] == $field ) ? 'selected="selected"' : '';
				        						}
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
    add_action( 'load-post.php', 'call_bshPropertyFilterPageOptions' );
    add_action( 'load-post-new.php', 'call_bshPropertyFilterPageOptions' );
}
function call_bshPropertyFilterPageOptions() {
	global $bshPostOptions;
	if( $bshPostOptions->get_page_template() == 'template-bshPropertyFilterPage.php' ) {
    	return new bshPropertyFilterPageOptions();
    }

}




?>