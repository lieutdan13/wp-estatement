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

class bshPropertyDetailsWidget extends WP_Widget {

    var $image_field = 'image';

	// 1.1 Constructor
	function bshPropertyDetailsWidget() {
        parent::WP_Widget(
        	false,
        	__( 'Estatement: Property Custom Fields', THEMENAME ),
        	array(
        		'description' => __( 'This widget allows you to show the custom fields for the current property. It will only be shown on single property pages', THEMENAME )
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'                => '',
			'shown_fields'         => 'all',
			'single_field_address' => 'yes'
		);
		$values = wp_parse_args( $instance, $defaults );

		?>
        <p>
        	<label for='<?php echo $this->get_field_id('title'); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id('shown_fields'); ?>'>
        		<?php _e( 'Shown Fields:', THEMENAME ); ?>
        		<?php
        			$current = $values['shown_fields'];
        			$options = array( 'all' => 'Show All', 'custom' => 'Show the ones I select below' )
        		?>
        		<select class='widefat' id='<?php echo $this->get_field_id( 'shown_fields' ); ?>' name='<?php echo $this->get_field_name( 'shown_fields' ); ?>'>
	        		<?php
	        			foreach( $options as $value => $option ) :
	        			$selected = ( $current == $value OR ( empty( $current ) AND $value == 'all' ) ) ? 'selected="selected"' : '';
	        		?>
	        			<option value='<?php echo $value ?>' <?php echo $selected ?>><?php echo $option ?></option>
	        		<?php endforeach ?>
        		</select>
        	</label>
        </p>

        <h3><?php _e( 'Address Display', THEMENAME ) ?></h3>
        <p class='description'>
        	<?php _e( 'If you select to show the location as a single field, all the location data will be condensed into one row. If you choose to show only selected fields only the location fields selected will be added to this single row.', THEMENAME ) ?>
        </p>


        <p>
        	<label for='<?php echo $this->get_field_id('single_field_address'); ?>'>
        		<?php $checked = ( empty( $values['single_field_address'] ) OR $values['single_field_address'] == 'yes' ) ? 'checked="checked"' : '' ?>
        		<input <?php echo $checked ?> id='<?php echo $this->get_field_id( 'single_field_address' ); ?>' name='<?php echo $this->get_field_name( 'single_field_address' ); ?>' type='checkbox' value='yes' />

        		<?php _e( 'Show Location as single field', THEMENAME ); ?>
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id('single_field_address_order'); ?>'>
        		<?php _e( 'Position of Location Field:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'single_field_address_order' ); ?>' name='<?php echo $this->get_field_name( 'single_field_address_order' ); ?>' type='text' value='<?php echo $values['single_field_address_order']; ?>' />
        	</label>
        </p>

		<?php
			$values['single_field_address_name'] = ( empty( $values['single_field_address_name'] ) ) ? 'Location: ' : $values['single_field_address_name'];
		?>
        <p>
        	<label for='<?php echo $this->get_field_id('single_field_address_name'); ?>'>
        		<?php _e( 'Name of Location Field:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'single_field_address_name' ); ?>' name='<?php echo $this->get_field_name( 'single_field_address_name' ); ?>' type='text' value='<?php echo $values['single_field_address_name']; ?>' />
        	</label>
        </p>




        <h3><?php _e( 'Select Custom Data', THEMENAME ) ?></h3>

        <p class='description'>
        	<?php _e( 'The following section allows you to set up which custom fields and taxonomies are shown. To create your own order make sure to select "custom" from the dropdown selector as well as setting up the order below.', THEMENAME ) ?>
        </p>

        <table style='width:100%'>
        	<tr>
        		<td></td>
        		<td><strong><?php _e( 'Custom Field', THEMENAME ) ?></strong></td>
        		<td><strong><?php _e( 'Order', THEMENAME ) ?></strong></td>
        	</tr>
        <?php
        	$customdata = get_option( 'est_customdata' );
        	foreach( $customdata as $field ) :
        		$checked = ( !empty( $values['est_customfields'][$field['key']] ) AND $values['est_customfields'][$field['key']]['show'] == 'yes' ) ? 'checked="checked"' : '';
        		$order = !empty( $values['est_customfields'][$field['key']]['order'] ) ? $values['est_customfields'][$field['key']]['order'] : ''
        ?>
        	<tr>
       			<td>
       				<input id='est_customfields_<?php echo $field['key'] ?>' <?php echo $checked ?> type='checkbox' name='<?php echo $this->get_field_name( 'est_customfields][' . $field['key'] . '][show]' ) ?>' value='yes'>
       			</td>
       			<td style='width:60%;'>
	       			<label for='est_customfields_<?php echo $field['key'] ?>'><?php echo $field['name'] ?></label>
	       		</td>
	       		<td>
	       			<input value='<?php echo $order ?>' type='text' style='width:40px;' name='<?php echo $this->get_field_name( 'est_customfields][' . $field['key'] . '][order]' ) ?>'>
	       		</td>
        	</tr>
        <?php endforeach ?>
        </table>



        <table style='width:100%; margin-top:22px;'>
        	<tr>
        		<td></td>
        		<td><strong><?php _e( 'Taxonomy', THEMENAME ) ?></strong></td>
        		<td><strong><?php _e( 'Order', THEMENAME ) ?></strong></td>
        	</tr>
        <?php
        	$taxonomies = get_option( 'est_taxonomies' );
        	foreach( $taxonomies as $taxonomy => $data ) :
        		$checked = ( !empty( $values['est_taxonomies'][$taxonomy] ) AND $values['est_taxonomies'][$taxonomy]['show'] == 'yes' ) ? 'checked="checked"' : '';
        		$order = !empty( $values['est_taxonomies'][$taxonomy]['order'] ) ? $values['est_taxonomies'][$taxonomy]['order'] : ''
        ?>
        	<tr>
       			<td>
       				<input id='est_taxonomies_<?php echo $taxonomy ?>' <?php echo $checked ?> type='checkbox' name='<?php echo $this->get_field_name( 'est_taxonomies][' . $taxonomy . '][show]' ) ?>' value='yes'>
       			</td>
       			<td style='width:60%;'>
	       			<label for='est_taxonomies_<?php echo $taxonomy ?>'><?php echo $data['labels']['name'] ?></label>
	       		</td>
	       		<td>
	       			<input value='<?php echo $order ?>' type='text' style='width:40px;' name='<?php echo $this->get_field_name( 'est_taxonomies][' . $taxonomy . '][order]' ) ?>'>
	       		</td>
        	</tr>
        <?php endforeach ?>
        </table>



        <?php
    }

	// 1.3 Save Widget Options
	function update( $new_instance, $old_instance ) {
		if( !empty( $new_instance['est_customfields'] ) ) {
	  		foreach( $new_instance['est_customfields'] as $key => $field ) {
	  			if( empty( $field['show'] ) ) {
	  				unset( $new_instance['est_customfields'][$key] );
	  			}
	  		}
  		}
  		$new_instance['single_field_address'] = empty( $new_instance['single_field_address'] ) ? 'no' : $new_instance['single_field_address'];
        return $new_instance;
    }

	// 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		global $post, $wpdb;
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];

		if( !empty( $post->post_excerpt ) ) : ?>
			<div class='content mb11'>
				<?php the_excerpt() ?>
			</div>
		<?php endif;

		$customdata = get_option( 'est_customdata' );
		$taxonomies = get_option( 'est_taxonomies' );

		$options = array();
		$options['single_address_order'] = $instance['single_field_address_order'];
		$options['single_address'] = $instance['single_field_address'];
		$options['_est_single_field_address_name'] = $instance['single_field_address_name'];

		$i = 0;
		if( $instance['shown_fields'] == 'all' ) {
			foreach( $taxonomies as $taxonomy => $data ) {

				$options['custom_taxonomies'][$taxonomy] = array(
					'show' => 'yes',
					'order' => $i
				);
				$i++;
			}
			foreach( $customdata as $key => $data ) {
				$options['customdatas'][$key] = array(
					'show' => 'yes',
					'order' => $i
				);
				$i++;
			}
		}
		else {
			$options['customdatas'] = $instance['est_customfields'];
			$options['custom_taxonomies'] = $instance['est_taxonomies'];
		}



		show_property_detail_table( get_property_detail_list( $options ) );



		echo $args['after_widget'];
    }
}


/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget('bshPropertyDetailsWidget');

?>