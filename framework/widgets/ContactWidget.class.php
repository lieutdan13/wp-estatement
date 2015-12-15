<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file contains the contact widget
	This widget displays contact information,
	social links and customized text.
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Contact Widget Class
		1.1 Constructor
		1.2 Backend Form
		1.3 Save Widget Options
		1.4 Frontend Widget Display

	2. Widget Registration

*/

/***********************************************/
/*          1. Contact Widget Class            */
/***********************************************/

class bshContactWidget extends WP_Widget {

	// 1.1 Constructor
	function bshContactWidget() {
        parent::WP_Widget(
        	false,
        	__( 'Estatement: Contact Widget', THEMENAME ),
        	array(
        		'description' => __( 'This widget displays a nicely formatted contact sheet with social links and contact info', THEMENAME )
        	),
        	array(
        		'width' => '400px'
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'              => '',
			'text'               => '',
			'twitter_username'   => '',
			'facebook_link'      => '',
			'linkedin_link'      => '',
			'flickr_link'        => '',
			'pinterest_link'     => '',
			'rss_link'           => 'yes',
			'phone_number'       => '',
			'email'              => '',
			'fax'                => '',
			'location'           => '',
		);
		$values = wp_parse_args( $instance, $defaults );
		?>
        <p>
        	<label for='<?php echo $this->get_field_id('title'); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $values['title']; ?>" />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'text' ); ?>'>
        		<?php _e( 'Text:', THEMENAME ); ?>
        		<textarea rows='9' cols='20' class='widefat' id='<?php echo $this->get_field_id( 'text' ); ?>' name='<?php echo $this->get_field_name( 'text' ); ?>'><?php echo $values['text']; ?></textarea>
        	</label>
        </p>

        <h3><?php _e( 'Social Sites', THEMENAME ) ?></h3>
        <p>
        <?php _e( 'Filling the following social site details out will generate an icon for each. Leave the ones you don\'t want to use blank.', THEMENAME ) ?>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'twitter_username' ); ?>'>
        		<?php _e('Twitter Username:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'twitter_username' ); ?>' name='<?php echo $this->get_field_name( 'twitter_username' ); ?>' type='text' value='<?php echo $values['twitter_username']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'facebook_link' ); ?>'>
        		<?php _e( 'Facebook Link:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'facebook_link' ); ?>' name='<?php echo $this->get_field_name( 'facebook_link' ); ?>' type='text' value='<?php echo $values['facebook_link']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'linkedin_link' ); ?>'>
        		<?php _e( 'Linkedin Link:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'linkedin_link' ); ?>' name='<?php echo $this->get_field_name( 'linkedin_link' ); ?>' type='text' value='<?php echo $values['linkedin_link']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'flickr_link' ); ?>'>
        		<?php _e( 'Flickr Link:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'flickr_link' ); ?>' name='<?php echo $this->get_field_name( 'flickr_link' ); ?>' type='text' value='<?php echo $values['flickr_link']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'pinterest_link' ); ?>'>
        		<?php _e( 'Pinterest Link:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'pinterest_link' ); ?>' name='<?php echo $this->get_field_name( 'pinterest_link' ); ?>' type='text' value='<?php echo $values['pinterest_link']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'google_link' ); ?>'>
        		<?php _e( 'Google Plus Link:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'google_link' ); ?>' name='<?php echo $this->get_field_name( 'google_link' ); ?>' type='text' value='<?php echo $values['google_link']; ?>' />
        	</label>
        </p>


        <p>
        	<label>
        		<?php _e( 'RSS Link:', THEMENAME ); ?><br>
        		<?php $checked = ( $values['rss_link'] == 'yes' ) ? 'checked="checked"' : '' ?>
        		<input <?php echo $checked ?> type='checkbox' id='<?php echo $this->get_field_id( 'rss_link' ); ?>' name='<?php echo $this->get_field_name( 'rss_link' ); ?>' value='<?php echo $values['rss_link']; ?>' /><label for='<?php echo $this->get_field_id( 'rss_link' ); ?>'> <?php _e( 'Display Link To RSS Feed', THEMENAME ) ?></label>
        	</label>
        </p>


        <h3><?php _e( 'Contact Info', THEMENAME ) ?></h3>

        <p>
        	<label for='<?php echo $this->get_field_id( 'phone_number' ); ?>'>
        		<?php _e( 'Phone Number:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'phone_number' ); ?>' name='<?php echo $this->get_field_name( 'phone_number' ); ?>' type='text' value='<?php echo $values['phone_number']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'email' ); ?>'>
        		<?php _e( 'Email:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'email' ); ?>' name='<?php echo $this->get_field_name( 'email' ); ?>' type='text' value='<?php echo $values['email']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'fax' ); ?>'>
        		<?php _e( 'Fax:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'fax' ); ?>' name='<?php echo $this->get_field_name( 'fax' ); ?>' type='text' value='<?php echo $values['fax']; ?>' />
        	</label>
        </p>


        <p>
        	<label for='<?php echo $this->get_field_id( 'location' ); ?>'>
        		<?php _e( 'Location:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'location' ); ?>' name='<?php echo $this->get_field_name( 'location' ); ?>' type='text' value='<?php echo $values['location']; ?>' />
        	</label>
        </p>

        <h3><?php _e( 'Icons', THEMENAME ) ?></h3>
        <p>
        	<?php _e( 'To change the icons for the social sites or the contact info, add different images to the <code>images/customWidget</code> folder in your child theme.', THEMENAME ) ?>;
        </p>


        <?php
    }

	// 1.3 Save Widget Options
	function update( $new_instance, $old_instance ) {
		$new_instance['rss_link'] = ( empty( $new_instance['rss_link'] ) ) ? 'no' : 'yes';
        return $new_instance;
    }

	// 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		global $post, $wpdb;
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];

		if( !empty( $instance['twitter_username'] ) OR !empty( $instance['facebook_link'] ) OR !empty( $instance['linkedin_link'] ) OR !empty( $instance['flickr_link'] ) OR !empty( $instance['pinterest_link'] ) OR $instance['rss_link'] != 'no' ) {
			echo '<div class="social">';
			if( !empty( $instance['twitter_username'] ) ) {
				echo '<a target="_blank" class="twitter socialIcon" href="http://twitter.com/' . $instance['twitter_username'] .'"></a>';
			}
			if( !empty( $instance['facebook_link'] ) ) {
				echo '<a target="_blank" class="facebook socialIcon" href="' . $instance['facebook_link'] .'"></a>';
			}
			if( !empty( $instance['linkedin_link'] ) ) {
				echo '<a target="_blank" class="linkedin socialIcon" href="' . $instance['linkedin_link'] .'"></a>';
			}
			if( !empty( $instance['flickr_link'] ) ) {
				echo '<a target="_blank" class="flickr socialIcon" href="' . $instance['flickr_link'] .'"></a>';
			}
			if( !empty( $instance['pinterest_link'] ) ) {
				echo '<a target="_blank" class="pinterest socialIcon" href="' . $instance['pinterest_link'] .'"></a>';
			}
			if( !empty( $instance['google_link'] ) ) {
				echo '<a target="_blank" class="google socialIcon" href="' . $instance['google_link'] .'"></a>';
			}

			if( $instance['rss_link'] != 'no' ) {
				echo '<a target="_blank" class="rss socialIcon" href="' . get_bloginfo( 'rss2_url' ) .'"></a>';
			}
			echo '</div>';
		}


		if( !empty( $instance['phone_number'] ) OR !empty( $instance['email'] ) OR !empty( $instance['fax'] ) OR !empty( $instance['location'] ) ) {

			$color = ( $args['id']  === 'footerbar' ) ? 'white' : 'black';

			echo '<ul class="contact m22">';
				if( !empty( $instance['phone_number'] ) ) {
					echo '<li class="phoneNumber"><span class="icon"><img alt="' . __( 'Phone Icon', THEMENAME ) . '" src="' . get_template_directory_uri() . '/images/icons/glyphicons/' . $color . '/14x14/iphone.png"></span> <a href="tel:' . str_replace(array('+', '-'), '', filter_var( $instance['phone_number'] , FILTER_SANITIZE_NUMBER_FLOAT)) . '">' . $instance['phone_number'] . '</a></li>';
				}
				if( !empty( $instance['email'] ) ) {
					echo '<li class="email"><span class="icon"><img alt="' . __( 'Envelope Icon', THEMENAME ) . '" src="' . get_template_directory_uri() . '/images/icons/glyphicons/' . $color . '/14x14/envelope.png"></span> <a href="mailto:' . $instance['email'] . '">' . $instance['email'] . '</a></li>';
				}
				if( !empty( $instance['fax'] ) ) {
					echo '<li class="fax"><span class="icon"><img alt="' . __( 'Fax Icon', THEMENAME ) . '" src="' . get_template_directory_uri() . '/images/icons/glyphicons/' . $color . '/14x14/print.png"></span>' . $instance['fax'] . '</li>';
				}
				if( !empty( $instance['location'] ) ) {
					echo '<li class="location"><span class="icon"><img alt="' . __( 'Map Pin Icon', THEMENAME ) . '" src="' . get_template_directory_uri() . '/images/icons/glyphicons/' . $color . '/14x14/pin.png"></span> ' . $instance['location'] . '</li>';
				}

			echo '</ul>';
		}

		if( !empty( $instance['text'] ) ) {
			echo '<div class="text mt11">' . wpautop( $instance['text'] ) . '</div>';
		}

		echo $args['after_widget'];
    }
}


/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget( 'bshContactWidget' );

?>