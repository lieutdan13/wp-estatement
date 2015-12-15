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

class bshBookingWidget extends WP_Widget {

    var $image_field = 'image';

	// 1.1 Constructor
	function bshBookingWidget() {
        parent::WP_Widget(
        	false,
        	__( 'Estatement: Booking Widget', THEMENAME ),
        	array(
        		'description' => __( 'This widget displays a booking calendar for a property', THEMENAME )
        	)
        );
    }

	// 1.2 Backend Form
	function form( $instance ) {
		$defaults = array(
			'title'              => '',
			'booking_page_id'              => '',
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
        	<label for='<?php echo $this->get_field_id('booking_page_id'); ?>'>
        		<?php _e( 'Booking Page:', THEMENAME ); ?>
        		<?php
        			$current = $values['booking_page_id'];
        			$options = est_get_page_template_dropdown( 'template-bshBookingPage.php' );
        		?>
        		<select class='widefat' id='<?php echo $this->get_field_id( 'booking_page_id' ); ?>' name='<?php echo $this->get_field_name( 'booking_page_id' ); ?>'>
        			<option value=''><?php _e( '-- Select a Booking Page --', THEMENAME ) ?>
	        		<?php
	        			foreach( $options as $value => $option ) :
	        			$selected = ( $current == $value ) ? 'selected="selected"' : '';
	        		?>
	        			<option value='<?php echo $value ?>' <?php echo $selected ?>><?php echo $option ?></option>
	        		<?php endforeach ?>
        		</select>
        	</label>
        </p>


        <?php
    }

	// 1.3 Save Widget Options
	function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

	// 1.4 Frontend Widget Display
	function widget( $args, $instance ) {
		global $post, $wpdb;
		$bookable = get_post_meta( $post->ID, '_est_bookable', true );
		$currency = get_post_meta( $post->ID, '_est_rent_currency', true );
		$currency_position = get_post_meta( $post->ID, '_est_rent_currency_position', true );
		$interval = get_post_meta( $post->ID, '_est_booking_interval', true );

		if( $bookable == 'yes' ) {
			echo $args['before_widget'];
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) .  $args['after_title'];
			?>
				<form method='get' action='<?php echo get_permalink( $instance['booking_page_id'] ) ?>' class='custom' id='booking-form-widget'>

					<div class='bookingCalendar' id='bookingCalendar-<?php echo $args['widget_id'] ?>' data-interval='<?php echo $interval ?>'>
						<div class='row'>
							<div class='small-12 large-4 columns'>
								<label for='_est_start'>
									<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/calendar.png" alt="Calendar icon"><?php _e( 'Arrival', THEMENAME ) ?>
								</label>
							</div>
							<div class='small-12 large-8 columns'>
								<input type='text'  class='calculatePrice start' value=''>
								<input type='hidden' name='_est_start' class='start-field' id='_est_start' value=''>
							</div>
						</div>
						<div class='row'>
							<div class='small-12 large-4 columns'>
								<label for='_est_end'>
									<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/calendar.png" alt="Calendar icon"><?php _e( 'Departure', THEMENAME ) ?>
								</label>
							</div>
							<div class='small-12 large-8 columns'>
								<input type='text' class='calculatePrice end' value=''>
								<input type='hidden' class='calculatePrice end-field' name='_est_end' id='_est_end' value=''>
							</div>
						</div>
					</div>

					<div class='row'>
						<div class='small-12 large-4 columns'>
							<label for='_est_guests'>
								<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/user.png" alt="Calendar icon"><?php _e( 'Guests', THEMENAME ) ?>
							</label>
						</div>
						<div class='small-12 large-8 columns'>
							<input type='text' onkeyup='refreshPrice()' class='calculatePrice' name='_est_guests' id='_est_guests' value=''>
						</div>
					</div>

					<div class='calculated'>
						<div class='row'>
							<div class='small-12 large-6 columns'>
								<label>
									<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/coins.png" alt="Coin icon"><?php _e( 'Price Per Night', THEMENAME ) ?>
								</label>
							</div>
							<div class='small-12 large-6 columns'>
								<div class='price-per-night'><?php echo est_get_amount( 0, $currency, $currency_position ) ?></div>
							</div>
						</div>
						<div class='row mt22'>
							<div class='small-12 large-6 columns'>
								<label class='total-price-label'>
									<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/14x14/coins.png" alt="Coin icon"><?php _e( 'Total Price', THEMENAME ) ?>
								</label>
							</div>
							<div class='small-12 large-6 columns total-price-label'>
								<div class='total-price'><?php echo est_get_amount( 0, $currency, $currency_position ) ?></div>
							</div>
						</div>
					</div>



					<div class='mt11 text-right'>

						<input type='hidden' name='_est_property_id' id='_est_property_id' value='<?php echo $post->ID ?>'>
						<input type='submit' class='submit button mb0' value='<?php _e( 'Submit Booking', THEMENAME ) ?>'>
					</div>

					<?php
						$bookings = get_property_bookings( $post->ID );
						$booking_dates = array();
						foreach( $bookings as $date ){
							$booking_dates[] = '"' . $date . '"';
						}
						$booking_dates = '[' . implode( ',', $booking_dates ) . ']';
					?>

					<script type='text/javascript'>

					jQuery(document).ready( function() {
						jQuery( '#bookingCalendar-<?php echo $args['widget_id'] ?>' ).bookingCalendar({
							bookedDays : <?php echo $booking_dates ?>
						});
					})


					</script>



				</form>

			<?php
			echo $args['after_widget'];
		}
    }
}




/***********************************************/
/*          2. Widget Registration             */
/***********************************************/

register_widget('bshBookingWidget');

?>