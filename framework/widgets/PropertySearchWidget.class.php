<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file contains the featured item widget.
	The featured item allows for the upload of
	an image, the specification of some text and
	a link to show as a featured item.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Featured Item Widget Class
		1.1 Constructor
		1.2 Backend Form
		1.3 Save Widget Options
		1.4 Frontend Widget Display

	2. Widget Registration

*/

/***********************************************/
/*       1. Featured Item Widget Class         */
/***********************************************/

class bshPropertySearchWidget extends WP_Widget {

    var $image_field = 'image';

	// 1.1 Constructor
	function bshPropertySearchWidget() {
        parent::__construct(
        	false,
        	__( 'Estatement: Property Search', THEMENAME ),
        	array(
        		'description' => __( 'This widget allows you to add advanced property search options to the sidebar', THEMENAME ),
        	),
        	array(
        		'width' => 400
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'              => 'Search Properties',
			'search_button_text' => 'Search',
			'search_terms_label' => 'Search Terms: ',
			'est_taxonomies'     => '',
			'est_customdata'     => '',
			'search_page'        => 'default'
		);
		$values = wp_parse_args( $instance, $defaults );
        $image  = new WidgetImageField( $this, $values['image'] );

		?>

        <p>
        	<label for='<?php echo $this->get_field_id( 'title' ); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'search_button_text' ); ?>'>
        		<?php _e( 'Search Button Text:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'search_button_text' ); ?>' name='<?php echo $this->get_field_name( 'search_button_text' ); ?>' type='text' value='<?php echo $values['search_button_text']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'search_terms_label' ); ?>'>
        		<?php _e( 'Search Terms Label:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'search_terms_label' ); ?>' name='<?php echo $this->get_field_name( 'search_terms_label' ); ?>' type='text' value='<?php echo $values['search_terms_label']; ?>' />
        	</label>
        </p>


        <p>


			<label for='<?php echo $this->get_field_id( 'search_page' ); ?>' class='sectionTitle'><?php _e( 'Target Search Page', THEMENAME ) ?>


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
			?><br>
			<select id='<?php echo $this->get_field_id( 'search_page' ); ?>' name='<?php echo $this->get_field_name( 'search_page' ); ?>'>
				<?php
					foreach( $choices as $name => $value ) :
					$selected = ( $instance['search_page'] == $value  ) ? 'selected="selected"' : '';
				?>
				<option value='<?php echo $value ?>' <?php echo $selected ?>>
				<?php echo $name ?>
				</option>
				<?php endforeach ?>
			</select>

        	</label>
		</p>

		<p class='info'>
			If this widget is shown on a List Page it will always display the results on that page, the chosen target search page will be overwritten.
		</p>





		<div class='option'>

			<h4><label for='_est_details' class='sectionTitle'><?php _e( 'Taxonomies To Show', THEMENAME ) ?></label></h4>

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


				<table width='100%'>
					<thead>
					<tr style='text-align:left;'>
						<th></th>
						<th class='text-left'><?php _e( 'Taxonomy', THEMENAME ) ?></th>
						<th class='text-left'><?php _e( 'Control Type', THEMENAME ) ?></th>
						<th><?php _e( 'Order', THEMENAME ) ?></th>
					</tr>
					</thead>
					<tbody>

    				<?php
    					$i = 0;
    					foreach( $taxonomies as $taxonomy => $data ) :
    					$checked = ( !empty( $instance['est_taxonomies'][$taxonomy]['show'] ) AND $instance['est_taxonomies'][$taxonomy]['show'] == 'yes' ) ? 'checked="checked"' : ''
    				?>
    				<tr>
        				<td class='checkbox'>
	        				<input <?php echo $checked ?> type='checkbox' id='<?php echo $this->get_field_id( 'est_taxonomies' ); ?>_<?php echo $i ?>' name='<?php echo $this->get_field_name( 'est_taxonomies][' . $taxonomy . '][show]' ) ?>' value='yes'>
        				</td>
        				<td>
	        				<label for='<?php echo $this->get_field_id( 'est_taxonomies' ); ?>_<?php echo $i ?>'><?php echo $data['labels']['name'] ?></label>
        				</td>
			        	<td>
							<select name='<?php echo $this->get_field_name( 'est_taxonomies][' . $taxonomy . '][field]' ) ?>'>
        				<?php
        					$fields = array(
        						'select' => __( 'Dropdown Box', THEMENAME ),
        						'slider' => __( 'Range Slider', THEMENAME ),
        						'checkbox' => __( 'Checkboxes', THEMENAME ),
								'radio'    => __( 'Radio Buttons', THEMENAME ),
        						'text' => __( 'Text Field', THEMENAME ),
        					);
        					foreach( $fields as $field => $name ) {
        						$selected = ( $instance['est_taxonomies'][$taxonomy]['field'] == $field ) ? 'selected="selected"' : '';
	        						echo '<option ' . $selected . ' value="' . $field . '">' . $name . '</option>';
        					}
        				?>
        				</td>
        				<td class='order'>
        					<?php
        						$order = ( !empty( $instance['est_taxonomies'][$taxonomy]['order'] ) ) ? $instance['est_taxonomies'][$taxonomy]['order'] : '';
        					?>
        					<input style='width:40px' type='text' name='<?php echo $this->get_field_name( 'est_taxonomies][' . $taxonomy . '][order]' ) ?>' value='<?php echo $order ?>'>
        				</td>

    				</tr>
    				<input type='hidden' name='<?php echo $this->get_field_name( 'est_taxonomies][' . $taxonomy . '][type]' ) ?>' value='taxonomy'>

    				<?php $i++; endforeach ?>
    				</tbody>
				</table>
			<div class='clear'></div>

		</div>


		<div class='option'>

			<h4><label for='_est_customdatas' class='sectionTitle'><?php _e( 'Custom Data To Show', THEMENAME ) ?></label></h4>

			<?php
				$details = get_option( 'est_customdata' );
				$selection = get_post_meta( $post->ID, '_est_customdatas', true );
				?>

				<table width='100%'>
					<thead>
					<tr style='text-align:left'>
						<th></th>
						<th class='text-left'><?php _e( 'Custom Field', THEMENAME ) ?></th>
						<th class='text-left'><?php _e( 'Control Type', THEMENAME ) ?></th>
						<th><?php _e( 'Order', THEMENAME ) ?></th>
					</tr>
					</thead>
					<tbody>

    				<?php
    					foreach( $details as $key => $datail ) :
    					$checked = ( !empty( $instance['est_customdata'][$key]['show'] ) AND $instance['est_customdata'][$key]['show'] == 'yes' ) ? 'checked="checked"' : '';
				?>
    				<tr>
        				<td class='checkbox'>
	        				<input <?php echo $checked ?> type='checkbox' id='<?php echo $this->get_field_id( 'est_customdata' ); ?>_<?php echo $i ?>' name='<?php echo $this->get_field_name( 'est_customdata][' . $key . '][show]' ) ?>' value='yes'>
        				</td>
        				<td>
	        				<label for='<?php echo $this->get_field_id( 'est_customdata' ); ?>_<?php echo $i ?>'><?php echo $datail['name'] ?></label>
        				</td>
			        	<td>
							<select name='<?php echo $this->get_field_name( 'est_customdata][' . $key . '][field]' ) ?>'>
        				<?php
        					$fields = array(
        						'select' => __( 'Dropdown Box', THEMENAME ),
        						'slider' => __( 'Range Slider', THEMENAME ),
        						'checkbox' => __( 'Checkboxes', THEMENAME ),
								'radio'    => __( 'Radio Buttons', THEMENAME ),
        						'text' => __( 'Text Field', THEMENAME ),
        					);
        					foreach( $fields as $field => $name ) {
        						$selected = ( $instance['est_customdata'][$key]['field'] == $field ) ? 'selected="selected"' : '';
	        						echo '<option ' . $selected . ' value="' . $field . '">' . $name . '</option>';
        					}
        				?>
        				</td>
        				<td class='order'>
        					<?php
        						$order = ( !empty( $instance['est_customdata'][$key]['order'] ) ) ? $instance['est_customdata'][$key]['order'] : '';
        					?>
        					<input style='width:40px' type='text' name='<?php echo $this->get_field_name( 'est_customdata][' . $key . '][order]' ) ?>' value='<?php echo $order ?>'>
        				</td>

        				<input type='hidden' name='<?php echo $this->get_field_name( 'est_customdata][' . $key . '][type]' ) ?>' value='customdata'>

    				</tr>
				<?php $i++; endforeach ?>
    				</tbody>
				</table>
			<div class='clear'></div>

		</div>


        <?php
    }

	// 1.3 Save Widget Options
	function update( $new_instance, $old_instance ) {
  		$new_instance[$this->image_field] = intval( strip_tags( $new_instance[$this->image_field] ) );
        return $new_instance;
    }

	// 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		global $post, $wpdb;
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];

		if( $instance['search_page'] == 'default' ) {
			$action = get_permalink();
		}
		else {
			$action = ( get_post_meta( $post->ID, '_wp_page_template', true ) == 'template-bshListingPage.php' ) ? '' : get_permalink( $instance['search_page'] );
		}

		?>

		<form class='custom inContentSearch' action='<?php echo $action ?>' method='get'>
			<?php
				$search = array( 'customdatas' => array(), 'custom_taxonomies' => array() );
				$search['customdatas'] = $instance['est_customdata'];
				$search['custom_taxonomies'] = $instance['est_taxonomies'];

				$details = get_search_options( $search );

				est_vertical_search( $details );
				$text = $instance['search_button_text'];
				$text = ( empty( $text ) ) ? 'Search' : $text;
			?>

				<div class='form-row row mt11'>
					<div class='small-12 large-12 columns text-right'>
						<input type='submit' class='button' value='<?php echo $text ?>'>
					</div>
				</div>

		</form>


		<?php

		echo $args['after_widget'];
    }
}


/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget('bshPropertySearchWidget');

?>
