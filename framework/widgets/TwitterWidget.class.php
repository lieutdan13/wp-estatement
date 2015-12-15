<?php
/***********************************************/
/*               About This File               */
/***********************************************/
/*
	This file contains the Twitter widget. It
	enables you to show a list of a Twitter
	user's tweets.

	A Twtter app must be created and the API
	details must be added to the Theme
	Customizer for this to work properly
*/

/***********************************************/
/*              Table of Contents              */
/***********************************************/
/*
	1. Twittwr Widget Class
		1.1 Constructor
		1.2 Backend Form
		1.3 Save Widget Options
		1.4 Frontend Widget Display
        1.5 Get Tweets
        1.6 Save Tweets
        1.7 Retrieve Tweets

	2. Widget Registration

*/

/***********************************************/
/*          1. Twitter Widget Class            */
/***********************************************/

class bshTwitterWidget extends WP_Widget {

	// 1.1 Constructor
	function bshTwitterWidget() {
        parent::WP_Widget(
        	false,
        	__( 'Estatement: Twitter Widget', THEMENAME ),
        	array(
        		'description' => __( 'Displays any Twitter widget you have created on Twitter', THEMENAME )
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
			'limit'              => 5,
			'username'           => 'bonsaished',
			'show_profile'       => 'yes'
		);
		$values = wp_parse_args( $instance, $defaults );
		$tweets = $this->get_tweets( $this->id, $instance );
		?>

		<?php if( !empty( $tweets['tweets']->errors[0]->code ) AND $tweets['tweets']->errors[0]->code == 32 AND !empty( $this->id ) ) : ?>
			<div style='color:red'><p><?php echo sprintf( __( 'Your Twitter credentials are not correct. Make sure to copy the correct access tokens from your Twitter app in to the <a href="%s">Theme Customizer</a>. Once you\'ve changed these settings it could take 10 minutes until it actually shows up. To force the changes to take effect, save the contents of this widget', THEMENAME ), admin_url( 'customizer.php' ) ) ?></p></div>
		<?php endif ?>

        <p>
        	<label for='<?php echo $this->get_field_id( 'title' ); ?>'>
        		<?php _e( 'Title:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'title' ); ?>' name='<?php echo $this->get_field_name( 'title' ); ?>' type='text' value='<?php echo $values['title']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'limit' ); ?>'>
        		<?php _e( 'Tweets to show:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'limit' ); ?>' name='<?php echo $this->get_field_name( 'limit' ); ?>' type='text' value='<?php echo $values['limit']; ?>' />
        	</label>
        </p>

        <p>
        	<label for='<?php echo $this->get_field_id( 'username' ); ?>'>
        		<?php _e( 'Twitter username:', THEMENAME ); ?>
        		<input class='widefat' id='<?php echo $this->get_field_id( 'username' ); ?>' name='<?php echo $this->get_field_name( 'username' ); ?>' type='text' value='<?php echo $values['username']; ?>' />
        	</label>
        </p>


        <p>
        	<label for='<?php echo $this->get_field_id( 'show_profile' ); ?>'>
        		<?php _e( 'Show Profile:', THEMENAME ); ?><br>
        		<?php $checked = ( $values['show_profile'] == 'yes' OR empty( $values['show_profile'] ) ) ? 'checked="checked"' : '' ?>
        		<input <?php echo $checked ?> id='<?php echo $this->get_field_id( 'show_profile' ); ?>_yes' name='<?php echo $this->get_field_name( 'show_profile' ); ?>' type='radio' value='yes' /> <label for='<?php echo $this->get_field_id( 'show_profile' ); ?>_yes'><?php _e( 'Yes', THEMENAME ) ?></label> <br>
         		<?php $checked = ( $values['show_profile'] == 'no' ) ? 'checked="checked"' : '' ?>
       		<input <?php echo $checked ?> id='<?php echo $this->get_field_id( 'show_profile' ); ?>_no' name='<?php echo $this->get_field_name( 'show_profile' ); ?>' type='radio' value='no' /> <label for='<?php echo $this->get_field_id( 'show_profile' ); ?>_no'><?php _e( 'No', THEMENAME ) ?></label>
        	</label>
        </p>



        <h3><?php _e( 'Twitter API Key', THEMENAME ) ?></h3>
        <?php echo sprintf( __( '<p>Twitter only allows access to timelines through their API. Due to this you will need an API key to make this widget work. This is free and can easily be done. Follow the directions found on the <a href="https://dev.twitter.com/">Twitter Developers</a> site.</p> <p>Once you have your API key you will need to input it into the API Keys section of the <a href="%s">Theme Customizer</a></p><p>If you do not create an API key the default Bonsai Shed API key will be used. Once many people use the same key it may get rate limited, making your Twitter widget stop working</p>', THEMENAME ), admin_url( 'customize.php' ) ) ?>

        <?php
    }

    // 1.3 Save Widget Options
	function update( $new_instance, $old_instance ) {
        $this->save_tweets( $this->id, $new_instance );
        return $new_instance;
    }

    // 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		$tweets = $this->get_tweets( $args['widget_id'], $instance );

		if( !empty( $tweets['tweets'] ) AND empty( $tweets['tweets']->errors ) ) {

			echo $args['before_widget'];
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];

			$user = current( $tweets['tweets'] );
			$user = $user->user;

			if( !( !empty( $instance['show_profile'] ) AND $instance['show_profile'] == 'no' ) )
			echo '
				<div class="twitter-profile">
				<img alt="' . __( 'Twitter Avatar', THEMENAME ) . '" src="' . $user->profile_image_url . '">
				<h1 class="title"><a class="heading-text-color" href="http://twitter.com/' . $user->screen_name . '">' . $user->screen_name . '</a></h1>
				<div class="description content">' . $user->description . '</div>
				</div>
			';

			echo '<ul>';
			foreach( $tweets['tweets'] as $tweet ) {
				if( is_object( $tweet ) ) {
					$tweet_text = htmlentities($tweet->text, ENT_QUOTES);
					$tweet_text = preg_replace( '/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a class="primary" href="http://$1" target="_blank">http://$1</a>', $tweet_text );

					echo '
						<li>
							<span class="content">' . $tweet_text . '</span>
							<div class="date">' . human_time_diff( strtotime( $tweet->created_at ) ) . ' ago </div>
						</li>';
				}
			}
			echo '</ul>';

			echo $args['after_widget'];

		}
    }

    // 1.5 Get Tweets
    function get_tweets( $widget_id, $instance ) {
    	$tweets = get_option( 'bsh_tweets_' . $widget_id );
    	$tweets = urldecode( $tweets );
    	$tweets = unserialize($tweets);
    	if( empty( $tweets ) OR empty( $tweets['update_time'] ) OR time() > $tweets['update_time'] ) {
    		$tweets = $this->save_tweets( $widget_id, $instance );
			$tweets = urldecode( $tweets );
	    	$tweets = unserialize($tweets);
    	}
    	return $tweets;
    }

    // 1.6 Save Tweets
    function save_tweets( $widget_id, $instance ) {
    	$timeline = $this->retrieve_tweets( $widget_id, $instance );
    	$tweets = array( 'tweets' => $timeline, 'update_time' => time() + ( 60 * 10 ) );
    	$tweets = urlencode( serialize( $tweets ) );
    	update_option( 'bsh_tweets_' . $widget_id, $tweets );
    	return $tweets;
    }

    // 1.7 Retrieve Tweets
    function retrieve_tweets( $widget_id, $instance ) {
    	global $cb;
    	$timeline = '';
    	if( !empty( $instance['username'] ) AND !empty( $instance['limit'] ) ) {
     		$timeline = $cb->statuses_userTimeline( 'screen_name=' . $instance['username']. '&count=' . $instance['limit'] . '&exclude_replies=true' );
     	}

     	return $timeline;
    }

}

/***********************************************/
/*          2. Widget Registration             */
/***********************************************/
register_widget('bshTwitterWidget');

?>