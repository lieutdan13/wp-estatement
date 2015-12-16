<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file contains the latest posts widget.
	It allows you to specify a number of posts
	to list in the widget and which items to
	show from the post elements.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Latest Posts Widget Class
		1.1 Constructor
		1.2 Backend Form
		1.3 Save Widget Options
		1.4 Frontend Widget Display
		1.5 Excerpt Length

	2. Widget Registration

*/

/***********************************************/
/*        1. Latest Posts Widget Class         */
/***********************************************/

class bshLatestPostsWidget extends WP_Widget {

    var $image_field = 'image';
    var $excerpt_length = 55;

	// 1.1 Constructor
	function bshLatestPostsWidget() {
        parent::__construct(
        	false,
        	__( 'Estatement: Latest Posts', THEMENAME ),
        	array(
        		'description' => __( 'This widget enables you to create a post list in the sidebar with more flexibility than the regular WordPress widget. You can show images and order posts in different ways', THEMENAME )
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'               => '',
			'show_thumbnails'     => 'yes',
			'post_type'           => 'post',
			'post_order'          => 'post_date',
			'custom_order'        => '',
			'only_with_thumbnail' => 'yes',
			'show_excerpt'        => 'yes',
			'excerpt_length'      => '55',
			'show_link'           => 'yes',
			'post_count'          => 3,
		);
		$values = wp_parse_args( $instance, $defaults );
		?>
        <p>
        	<label for='<?php echo $this->get_field_id( 'title' ); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'post_type' ); ?>'>
        		<?php _e( 'Post Type:', THEMENAME ); ?><br>
        		<?php $supported_types = array( 'post' => 'Posts', 'property' => 'Properties' ) ?>
        		<select id='<?php echo $this->get_field_id( 'post_type' ); ?>' name='<?php echo $this->get_field_name( 'post_type' ); ?>' >
        			<?php
        				foreach( $supported_types as $value => $name ) :
        				$selected = ( $values['post_type'] == $value ) ? 'selected="selected"' : '';
        			?>
        				<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
        			<?php endforeach ?>
        		</select>
        	</label>
        </p>


        <p>
        	<label for='<?php echo $this->get_field_id( 'post_order' ); ?>'>
        		<?php _e( 'Order items:', THEMENAME ); ?><br>
        		<?php $supported_orders = array( 'post_date' => 'By Post Date', 'comment_count' => 'By Comment Count', 'rand' => 'Random', 'custom' => 'Custom Order' ) ?>
        		<select id='<?php echo $this->get_field_id( 'post_order' ); ?>' name='<?php echo $this->get_field_name( 'post_order' ); ?>' >
        			<?php
        				foreach( $supported_orders as $value => $name ) :
        				$selected = ( $values['post_order'] == $value ) ? 'selected="selected"' : '';
        			?>
        				<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
        			<?php endforeach ?>
        		</select>
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'custom_order' ); ?>'>
        		<?php _e( 'Post IDs for custom order:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'custom_order' ); ?>' name='<?php echo $this->get_field_name( 'custom_order' ); ?>' type='text' value='<?php echo $values['custom_order']; ?>'' />
        		<p class='description'><?php _e( 'Separate post IDs with commas', THEMENAME ) ?></p>
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'post_count' ); ?>'>
        		<?php _e( 'Number of posts to show:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'post_count' ); ?>' name='<?php echo $this->get_field_name( 'post_count' ); ?>' type='text' value='<?php echo $values['post_count']; ?>' />
        	</label>
        </p>

        <p>
        	<?php $checked = ( $values['only_with_thumbnail'] == 'yes' ) ? 'checked="checked"' : '' ?>
			<input class='checkbox' <?php echo $checked ?> type='checkbox' value='yes' id='<?php echo $this->get_field_id( 'only_with_thumbnail' ); ?>' name='<?php echo $this->get_field_name( 'only_with_thumbnail' ); ?>'>
			<label for="<?php echo $this->get_field_id('only_with_thumbnail'); ?>"><?php _e( 'only show posts with featured images', THEMENAME ) ?></label>
		</p>

        <p>
        	<?php $checked = ( $values['show_thumbnails'] == 'yes' ) ? 'checked="checked"' : '' ?>
			<input class='checkbox' <?php echo $checked ?> type='checkbox' value='yes' id='<?php echo $this->get_field_id( 'show_thumbnails' ); ?>' name='<?php echo $this->get_field_name( 'show_thumbnails' ); ?>'>
			<label for='<?php echo $this->get_field_id('show_thumbnails'); ?>'><?php _e( 'show featured images', THEMENAME ) ?></label>
		</p>

        <p>
        	<?php $checked = ( $values['show_excerpt'] == 'yes' ) ? 'checked="checked"' : '' ?>
			<input class='checkbox' <?php echo $checked ?> type='checkbox' value='yes' id='<?php echo $this->get_field_id( 'show_excerpt' ); ?>' name='<?php echo $this->get_field_name( 'show_excerpt' ); ?>'>
			<label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'show excerpt', THEMENAME ) ?></label>
		</p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'excerpt_length' ); ?>'>
        		<?php _e( 'Excerpt length (number of words):', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'excerpt_length' ); ?>' name='<?php echo $this->get_field_name( 'excerpt_length' ); ?>' type='text' value='<?php echo $values['excerpt_length']; ?>' />
        	</label>
        </p>


        <p>
        	<?php $checked = ( $values['show_link'] == 'yes' ) ? 'checked="checked"' : '' ?>
			<input class='checkbox' <?php echo $checked ?> type='checkbox' value='yes' id='<?php echo $this->get_field_id( 'show_link' ); ?>' name='<?php echo $this->get_field_name( 'show_link' ); ?>'>
			<label for='<?php echo $this->get_field_id( 'show_link' ); ?>'><?php _e( 'show read more links', THEMENAME ) ?></label>
		</p>


        <?php
    }


	// 1.3 Save Widget Options
	function update($new_instance, $old_instance) {

		$new_instance['only_with_thumbnail'] = ( isset( $new_instance['only_with_thumbnail'] ) AND $new_instance['only_with_thumbnail'] == 'yes' ) ? 'yes' : 'no';
		$new_instance['show_thumbnails']      = ( isset( $new_instance['show_thumbnails'] ) AND $new_instance['show_thumbnails'] == 'yes' ) ? 'yes' : 'no';
		$new_instance['show_excerpt']         = ( isset( $new_instance['show_excerpt'] ) AND $new_instance['show_excerpt'] == 'yes' ) ? 'yes' : 'no';
		$new_instance['show_link']            = ( isset( $new_instance['show_link'] ) AND $new_instance['show_link'] == 'yes' ) ? 'yes' : 'no';
		$new_instance['post_type']            = ( empty( $new_instance['post_type'] ) ) ? 'post' : $new_instance['post_type'];
		$new_instance['excerpt_length']            = ( empty( $new_instance['excerpt_length'] ) ) ? '55' : $new_instance['excerpt_length'];

        return $new_instance;
    }

	// 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		global $post, $wpdb;
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];

		$atts = array(
			'post_status'      => 'publish',
			'posts_per_page'   => $instance['post_count'],
			'orderby'          => $instance['post_order'],
			'order'            => 'DESC',
			'post_type'        => $instance['post_type']
		);

		if( $instance['only_with_thumbnail'] == 'yes' ) {
		   $atts['meta_query'] = array(
		       array(
		           'key'     => '_thumbnail_id',
		           'value'   => '',
		           'compare' => '!=',
		       )
		   );
		}

		if( $instance['post_order'] == 'custom' ) {
			$atts['orderby'] == 'post_date';
			$custom_order = explode( ',', $instance['custom_order'] );
			if( is_array( $custom_order ) AND !empty( $custom_order ) ) {
				$custom_order = array_map( 'trim', $custom_order );
				$atts['post__in'] = $custom_order;
			}
		}


		$latest_posts = new WP_Query( $atts );
		if( $latest_posts->have_posts() ) {
			echo '<ul>';
			while( $latest_posts->have_posts() ) {
				$latest_posts->the_post();
				echo '<li>';
				if( !empty( $instance['show_thumbnails'] ) AND $instance['show_thumbnails'] == 'yes' AND has_post_thumbnail() ) {
					echo '<a href="' . get_permalink() . '" class="hoverlink">';
					the_post_thumbnail( 'est_card' );
					echo '</a>';
					echo '<div class="clear"></div>';
				}

				the_title( '<h1 class="title"><a href="' . get_permalink() . '">', '</a></h1>' );

				$this->excerpt_length = $instance['excerpt_length'];
				add_filter( 'excerpt_length', array( $this, 'excerpt_length' ), 999 );

				if( !empty( $instance['show_excerpt'] ) AND $instance['show_excerpt'] == 'yes' ) {
					echo '<div class="content mb11">';
					the_excerpt();
					echo '</div>';
				}

				remove_filter( 'excerpt_length', array( $this, 'excerpt_length' ), 999 );

				if( !empty( $instance['show_link'] ) AND $instance['show_link'] == 'yes' ) {
					echo '<a class="primary" href="' . get_permalink() . '">' . get_theme_mod('read_more_text') . '</a>';
				}

				echo '</li>';
			}
			echo '</ul>';
		}

		echo $args['after_widget'];
    }

    // 1.5 Excerpt Length
	function excerpt_length( $length ) {
		return $this->excerpt_length;
	}




}


/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget('bshLatestPostsWidget');

?>
