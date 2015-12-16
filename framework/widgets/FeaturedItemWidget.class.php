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

class bshFeaturedItemWidget extends WP_Widget {

    var $image_field = 'image';

	// 1.1 Constructor
	function bshFeaturedItemWidget() {
        parent::__construct(
        	false,
        	__( 'Estatement: Featured Item', THEMENAME ),
        	array(
        		'description' => __( 'This widget allows you to specify an image, some text and a link to show as a featured item', THEMENAME )
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'              => '',
			'image'              => '',
			'item_title'         => '',
			'text'               => '',
			'link_text'          => 'read on',
			'link_url'           => ''
		);
		$values = wp_parse_args( $instance, $defaults );
        $image  = new WidgetImageField( $this, $values['image'] );

		?>
        <p>
        	<label for='<?php echo $this->get_field_id('title'); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'item_title' ); ?>'>
        		<?php _e( 'Featured Item Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'item_title' ); ?>' name='<?php echo $this->get_field_name( 'item_title' ); ?>' type='text' value='<?php echo $values['item_title']; ?>' />
        	</label>
        </p>


        <p>
            <label><?php _e( 'Featured Item image:', THEMENAME ); ?></label>
            <?php echo $image->get_widget_field(); ?>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'text' ); ?>'>
        		<?php _e( 'Featured Item Text:', THEMENAME ); ?>
        		<textarea rows='9' cols='20' class='widefat' id='<?php echo $this->get_field_id( 'text' ); ?>' name='<?php echo $this->get_field_name( 'text' ); ?>'><?php echo $values['text']; ?></textarea>
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'link_url' ); ?>'>
        		<?php _e( 'Featured Item Link URL:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'link_url' ); ?>' name='<?php echo $this->get_field_name( 'link_url' ); ?>' type='text' value='<?php echo $values['link_url']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'link_text' ); ?>'>
        		<?php _e( 'Featured Item Link Text:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'link_text' ); ?>' name='<?php echo $this->get_field_name( 'link_text' ); ?>' type='text' value='<?php echo $values['link_text']; ?>' />
        	</label>
        </p>


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

		if( !empty( $instance['image'] ) ) {
			if( !empty( $instance['link_url'] ) ) {
				echo '<a class="hoverlink" href="' . $instance['link_url'] . '">';
			}
			echo wp_get_attachment_image( $instance['image'], 'columns-four' );
			if( !empty( $instance['link_url'] ) ) {
				echo '</a>';
			}
		}

		if( !empty( $instance['item_title'] ) ) {
			echo '<h1 class="title">' . $instance['item_title'] . '</h1>';
		}

		if( !empty( $instance['text'] ) ) {
			echo wpautop( $instance['text'] );
		}

		if( !empty( $instance['link_url'] ) ) {
			echo '<a class="primary" href="' . esc_url( $instance['link_url'] ) . '">' . $instance['link_text'] . '</a>';
		}


		echo $args['after_widget'];
    }
}


/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget('bshFeaturedItemWidget');

?>
