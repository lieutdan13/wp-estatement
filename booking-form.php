<?php
global $currency, $currency_position, $interval;
if( !empty( $_SESSION['booking'] ) ) {
	$booking = $_SESSION['booking'];
	$booking->checkBooking();
}

?>

<form method='get' action='<?php the_permalink() ?>' class='custom' id='booking-form'>
<!-- ! BOOKING ERRORS -->

<?php if( !empty( $booking ) AND $booking->errors->hasError() ) : ?>

	<div class='box mt22 error-box' id='booking-errors'>
		<header>
			<div class='counter'>X</div>
			<h1><?php _e( 'There are some errors with your booking', THEMENAME ) ?></h1>
		</header>
		<article>
			<?php echo $booking->errors->errorInformation() ?>
		</article>
	</div>


<?php endif ?>

<!-- ! BOOKING DETAILS -->

	<div class='box mt22'>
		<header>
			<div class='counter'>1</div>
			<h1><?php _e( 'Booking Details', THEMENAME ) ?></h1>
		</header>
		<article>

			<div class='bookingCalendar' id='bookingCalendar-<?php the_ID() ?>' data-interval='<?php echo $interval ?>'>

				<div class='row'>
					<div class='small-12 large-3 columns'>
						<label for='_est_start'>
							<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/calendar.png" alt="Calendar icon"><?php _e( 'Arrival', THEMENAME ) ?>
						</label>
					</div>

					<?php
						$shown = ( !empty( $_GET['_est_start'] ) ) ? date( 'l, F j, Y', strtotime( $_GET['_est_start'] ) ) : '';
						$value = ( !empty( $_GET['_est_start'] ) ) ? $_GET['_est_start'] : '';
					?>

					<div class='small-12 large-6 pull-3 columns'>
						<input type='text' id='_est_start_shown' class='start' value='<?php echo $shown ?>'>
						<input type='hidden' name='_est_start' class='start-field' id='_est_start' value='<?php echo $value ?>'>
					</div>
				</div>
				<div class='row'>
					<div class='small-12 large-3 columns'>
						<label for='_est_end'>
							<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/calendar.png" alt="Calendar icon"><?php _e( 'Departure', THEMENAME ) ?>
						</label>
					</div>

					<?php
						$shown = ( !empty( $_GET['_est_end'] ) ) ? date( 'l, F j, Y', strtotime( $_GET['_est_end'] ) ) : '';
						$value = ( !empty( $_GET['_est_end'] ) ) ? $_GET['_est_end'] : '';
					?>

					<div class='small-12 large-6 pull-3 columns'>
						<input type='text' id='_est_end_shown' class='end' value='<?php echo $shown ?>'>
						<input type='hidden' class='calculatePrice end-field' name='_est_end' id='_est_end' value='<?php echo $value ?>'>
					</div>
				</div>
			</div>

			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_guests'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/user.png" alt="Calendar icon"><?php _e( 'Guests', THEMENAME ) ?>
					</label>
				</div>
				<?php
					$value = ( !empty( $_GET['_est_guests'] ) ) ? $_GET['_est_guests'] : '';
				?>
				<div class='small-12 large-6 pull-3 columns'>
					<input type='text' onkeyup='refreshPrice()' class='calculatePrice' name='_est_guests' id='_est_guests' value='<?php echo $value ?>'>
				</div>
			</div>

			<div class='calculated'>
				<div class='row'>
					<div class='small-12 large-4 columns'>
						<label>
							<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/coins.png" alt="Coin icon"><?php _e( 'Price Per Night', THEMENAME ) ?>
						</label>
					</div>
					<div class='small-12 large-8 columns'>
						<div class='price-per-night'><?php echo est_get_amount( 0, $currency, $currency_position ) ?></div>
					</div>
				</div>
				<div class='row mt22'>
					<div class='small-12 large-4 columns'>
						<div class='button total-price'><?php echo est_get_amount( 0, $currency, $currency_position ) ?></div>
					</div>
					<div class='small-12 large-8 columns total-price-label'>
						<h2><?php _e( 'Total Price', THEMENAME ) ?></h2>
					</div>
				</div>
			</div>

		</article>
	</div>

<!-- ! CONTACT DETAILS -->


	<div class='box mt22'>
		<header>
			<div class='counter'>2</div>
			<h1><?php _e( 'Contact Details', THEMENAME ) ?></h1>
		</header>
		<article>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_name'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/user.png" alt="User icon"><?php _e( 'Full Name', THEMENAME ) ?>
					</label>
				</div>
				<?php
					$value = ( !empty( $_GET['_est_name'] ) ) ? $_GET['_est_name'] : '';
				?>
				<div class='small-12 large-6 pull-3 columns'>
					<input type='text' name='_est_name' id='_est_name' value='<?php echo $value ?>'>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_email' class='est_email'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/envelope.png" alt="Email icon"><?php _e( 'Email', THEMENAME ) ?>
					</label>
				</div>
				<?php
					$value = ( !empty( $_GET['_est_email'] ) ) ? $_GET['_est_email'] : '';
				?>
				<div class='small-12 large-6 pull-3 columns'>
					<input type='text' name='_est_email' id='_est_email' value='<?php echo $value ?>'>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_phone'>
						<img class="retina est_phone" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/iphone.png" alt="Phone icon"><?php _e( 'Phone', THEMENAME ) ?>
					</label>
				</div>
				<?php
					$value = ( !empty( $_GET['_est_phone'] ) ) ? $_GET['_est_phone'] : '';
				?>
				<div class='small-12 large-6 pull-3 columns'>
					<input type='text' name='_est_phone' id='_est_phone' value='<?php echo $value ?>'>
				</div>
			</div>

		</article>
	</div>


<!-- ! REVIEW BOOKING -->

	<div class='box mt22 mb88'>
		<header>
			<div class='counter'>3</div>
			<h1><?php _e( 'Review Booking', THEMENAME ) ?></h1>
		</header>
		<article>
			<?php echo get_post_meta( get_the_ID(), '_est_review_text', true ) ?>

			<input type='hidden' id='_est_property_id' name='_est_property_id' value='<?php echo $_GET['_est_property_id'] ?>'>
			<input type='hidden' name='overview' value='true'>
			<input type='submit' class='submit button mb0' value='<?php echo esc_attr( get_post_meta( get_the_ID(), '_est_review_button', true ) ) ?>'>
		</article>
	</div>


	<script type='text/javascript'>
		jQuery( document ).ready( function() {
			refreshPrice();
			jQuery( '#bookingCalendar-<?php the_ID() ?>' ).bookingCalendar({
				bookedDays : <?php echo get_property_bookings_for_calendar( $_GET['_est_property_id'] ) ?>
			});

		})
	</script>


</form>

<?php
	unset( $_SESSION['booking'] );
?>