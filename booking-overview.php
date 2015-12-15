<?php
	global $booking, $modify_url;
	$booking_type = get_post_meta( get_the_ID(), '_est_booking_type', true );
	$counter = 1;
?>

<?php if( !empty( $booking_type ) AND $booking_type == 'payment' ) : ?>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" class='custom' id='booking-form'>
<?php else : ?>
	<form method='post' action='<?php echo admin_url( 'admin-ajax.php' ) ?>' class='custom' id='booking-form'>
<?php endif ?>

	<div class='box mt22'>
		<header>
			<div class='counter'><?php echo $counter ?></div>
			<h1><?php _e( 'Booking Details', THEMENAME ) ?>	<a class='body-font modify' href='<?php echo $modify_url ?>'><?php _e( 'modify booking', THEMENAME ) ?></a>
			</h1>
		</header>
		<article>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_start'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/calendar.png" alt="Calendar icon"><?php _e( 'Arrival', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo date( 'l, jS \of F, Y', strtotime( $_GET['_est_start'] ) ) ?></div>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_end'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/calendar.png" alt="Calendar icon"><?php _e( 'Departure', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo date( 'l, jS \of F, Y', strtotime( $_GET['_est_end'] ) ) ?></div>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_nights'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/moon.png" alt="Moon icon"><?php _e( 'Nights', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo $booking->getNights() ?></div>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_guests'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/user.png" alt="Calendar icon"><?php _e( 'Guests', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo $booking->getGuests() ?></div>
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

						<div class='price-per-night'>
						<?php

							$amount = round( $booking->calculatePricePerNight(), 2 );
							$currency = get_post_meta( $booking->get_property_id(), '_est_rent_currency', true);
							$currency_position = get_post_meta( $booking->get_property_id(), '_est_rent_currency_position', true);
							$price = bsh_get_price( $amount, $currency, $currency_position);
						?>
						<span class='unit'><span><span class='value'><?php echo $price ?></span></div>
					</div>
				</div>
				<div class='row mt22'>
					<div class='small-12 large-4 columns'>
						<?php

							$amount = $booking->calculateTotalPrice();
							$currency = get_post_meta( $booking->get_property_id(), '_est_rent_currency', true);
							$currency_position = get_post_meta( $booking->get_property_id(), '_est_rent_currency_position', true);
							$price = bsh_get_price( $amount, $currency, $currency_position);
						?>


						<div class='button total-price'><span class='unit'><span><span class='value'><?php echo $price ?></span></div>
					</div>
					<div class='small-12 large-8 columns total-price-label'>
						<h2><?php _e( 'Total Price', THEMENAME ) ?></h2>
					</div>
				</div>
			</div>

		</article>
	</div>

	<?php $counter++ ?>
	<div class='box mt22'>
		<header>
			<div class='counter'><?php echo $counter ?></div>
			<h1><?php _e( 'Contact Details', THEMENAME ) ?> <a class='body-font modify' href='<?php echo $modify_url ?>'><?php _e( 'modify booking', THEMENAME ) ?></a></h1>
		</header>
		<article>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_name'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/user.png" alt="User icon"><?php _e( 'Full Name', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo $_GET['_est_name'] ?></div>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_email' class='est_email'>
						<img class="retina" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/envelope.png" alt="Email icon"><?php _e( 'Email', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo $_GET['_est_email'] ?></div>
				</div>
			</div>
			<div class='row'>
				<div class='small-12 large-3 columns'>
					<label for='_est_phone'>
						<img class="retina est_phone" src="<?php echo get_template_directory_uri() ?>/images/icons/glyphicons/black/24x24/iphone.png" alt="Phone icon"><?php _e( 'Phone', THEMENAME ) ?>
					</label>
				</div>
				<div class='small-12 large-6 pull-3 columns'>
					<div class='booking-value'><?php echo $_GET['_est_phone'] ?></div>
				</div>
			</div>

		</article>
	</div>
	<?php $counter++ ?>


<?php
	$info = get_post_meta( get_the_ID(), '_est_additional_details', true );
	if( !empty( $info ) ) :
?>
	<div class='box mt22'>
		<header>
			<div class='counter'><?php echo $counter ?></div>
			<h1><?php _e( 'Additional Information', THEMENAME ) ?></h1>
		</header>
		<article>
			<div class='row'>
				<div class='small-12 large-12 columns'>
					<?php echo $info ?>
				</div>
			</div>

		</article>
	</div>
	<?php $counter++ ?>

<?php endif ?>

	<?php
		if( !empty( $booking_type ) AND $booking_type == 'payment' ) :
	?>

	<div class='box mt22 mb88'>
		<header>
			<div class='counter'><?php echo $counter ?></div>
			<h1><?php _e( 'Book &amp; Pay', THEMENAME ) ?></h1>
		</header>
		<article>
			<?php echo get_post_meta( get_the_ID(), '_est_complete_text', true ); ?>

			  <input type="hidden" name="cmd" value="_xclick">
			  <input type="hidden" name="_est_property_id" value='<?php echo $_GET['_est_property_id'] ?>'>
			  <?php
			  	$data['booking_page'] = get_the_ID();
			  	$data['_est_start'] = $_GET['_est_start'];
			  	$data['_est_end'] = $_GET['_est_end'];
			  	$data['_est_property_id'] = $_GET['_est_property_id'];
			  	$data['_est_guests'] = $_GET['_est_guests'];
			  	$data['e'] = $_GET['_est_email'];
			  	$data['n'] = $_GET['_est_name'];
			  	$data['p'] = $_GET['_est_phone'];
			  	$custom = http_build_query( $data );
			  	$currency_code = get_post_meta( get_the_ID(), '_est_currency_code', true );
			  	$currency_code = ( empty( $currency_code ) ) ? 'USD' : $currency_code;
			  	$merchant_id = get_post_meta( get_the_ID(), '_est_paypal_id', true );
			  	$property_merchant_id = get_post_meta( $_GET['_est_property_id'] , '_est_property_paypal', true );
			  	$merchant_id = ( !empty( $property_merchant_id ) ) ? $property_merchant_id : $merchant_id;
			  ?>
			  <input type='hidden' name='custom' value='<?php echo $custom ?>'>
			  <input type="hidden" name="first_name" value='<?php echo $_GET['_est_name'] ?>'>
			  <input type="hidden" name="payer_email" value='<?php echo $_GET['_est_email'] ?>'>
			  <input type="hidden" name="contact_phone" value='<?php echo $_GET['_est_phone'] ?>'>
			  <input type="hidden" name="return" value='<?php the_permalink() ?>/?est_success=true&paid=true&_est_property_id=<?php echo $_GET['_est_property_id'] ?>'>
			  <input type="hidden" name="notify_url" value='<?php echo admin_url('admin-ajax.php?action=intercept_ipn') ?>'>
			  <input type="hidden" name="amount" value='<?php echo $booking->calculateTotalPrice() ?>'>
			  <input type="hidden" name="currency_code" value="<?php echo $currency_code ?>">
			  <input type="hidden" name="item_name" value="<?php echo get_the_title( $_GET['_est_property_id'] ) ?> Booking">
			  <input type="image" name="submit" border="0"  src="https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
			<input type="hidden" name="business" value="<?php echo $property_merchant_id ?>">
			</form>



		</article>
	</div>

	<?php else : ?>

	<div class='box mt22 mb88'>
		<header>
			<div class='counter'><?php echo $counter ?></div>
			<h1><?php _e( 'Complete Your Booking', THEMENAME ) ?></h1>
		</header>
		<article>
			<?php echo get_post_meta( get_the_ID(), '_est_complete_text', true ); ?>

			<input type='hidden' name='_est_property_id' id='_est_property_id' value='<?php echo $_GET['_est_property_id'] ?>'>
			<input type='hidden' name='redirect' value='<?php the_permalink() ?>'>
			<input type='hidden' name='booking_page' value='<?php the_ID() ?>'>
			<input type='hidden' name='action' value='action_booking'>
			<?php foreach( $_GET as $key => $value ) : ?>
				<input type='hidden' name='<?php echo $key ?>' value='<?php echo $value ?>'>
			<?php endforeach ?>
			<input type='submit' class='submit button mb0' value='<?php echo esc_attr( get_post_meta( get_the_ID(), '_est_complete_button', true ) ) ?>'>
		</article>
	</div>


	<?php endif ?>


</form>

