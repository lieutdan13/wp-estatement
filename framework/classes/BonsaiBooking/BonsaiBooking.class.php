<?php

class BonsaiBooking {

	/***********************************************/
	/*                  Variables                  */
	/***********************************************/

	/* Passed to the constructor */

    protected $property_id;       // The ID of the property we are booking
	protected $guests;            // The number of guests arriving
	protected $start;             // The date of arrival
	protected $end;               // The date of departure
	protected $details;           // Name, email, phone and message

	/* Primitive data */

	protected $property;          // The details of the property booked
	protected $min_nights;        // The minimum allowed nights for the property
	protected $max_nights;        // The maximum allowed nights for the property
	protected $min_guests;        // The minimum allowed guests for the property
	protected $max_guests;        // The maximum allowed guests for the property
	protected $price_type;        // The type of pricing (night/person)
	protected $booking_interval;  // The allowed booking interal (day/week)
	protected $bookable;          // The bookable status of the property
	protected $bookings;          // Dates the property is booked on
	protected $name;              // Name of the booker
	protected $email;             // Email of the booker
	protected $phone;             // Phone number of the booker
	protected $message;           // Message from the booker

	/* Derived data */

	protected $nights;            // Number of nights stayed
	public $errors;               // Error handling
	protected $date_range;        // Booking date range
	protected $booking_id;        // The ID of the booking
	public $seasonal_pricing;     // Pricing for the seasons
	public $pricing;              // Pricing for the whole year
	public $used_price;           // The type price used

	/***********************************************/
	/*                Constructor                  */
	/***********************************************/

    function __construct( $property_id, $guests, $start, $end, $details = array() ) {
    	$this->errors = new BonsaiError();
        $this->property_id = $property_id;
        $this->setGuests( $guests );
		$this->setDates( $start, $end );
        $this->setProperty( $property_id );
        $this->setPropertyDetails( $this->property );
        $this->setName( $details );
        $this->setEmail( $details );
        $this->setPhone( $details );
        $this->setMessage( $details );
        $this->setUsedPrice();
        $this->setSeasonalPricing();
        $this->setPricing();
	}

	/***********************************************/
	/*                  Setters                    */
	/***********************************************/

	function setDates( $start, $end ) {
		$this->setStartDate( $start );
		$this->setEndDate( $end );
		$this->setNights();
        $this->setDateRange();
	}

    function setStartDate( $date ) {
    	try {
			$this->start = Carbon::createFromFormat( 'Y-m-d', $date );
    	} catch( Exception $exception ) {
			$this->errors->addError( 'Incorrect Date Formatting', 'The start date is incorrectly formatted', 'Start Date', __LINE__, $exception  );
    	}
    }


    function setEndDate( $date ) {
    	try {
			$this->end = Carbon::createFromFormat( 'Y-m-d', $date );
    	} catch( Exception $exception ) {
			$this->errors->addError( 'Incorrect Date Formatting', 'The end date is incorrectly formatted', 'End Date', __LINE__, $exception );
    	}
    }

    function setGuests( $guests ) {
    	$this->guests = $guests;
    	return $guests;
    }

    function getGuests() {
    	return $this->guests;
    }

    function setNights() {
   		$this->nights = $this->calculateNights( $this->start, $this->end );
   		return $this->nights;
    }

    function getNights() {
    	return $this->nights;
    }

    function setPriceType( $type ) {
    	$this->price_type = $type;
    }

	function setProperty( $property_id ) {
		$property = get_post( $property_id );

		if( empty( $property ) ) {
			$this->errors->addError( 'Property Doesn\'t exist', 'The property you\'re trying to book does not exist', 'Property', __LINE__ );
			$this->property = null;
			return null;
		}

		$meta = get_post_meta( $property_id );
		if( !empty( $meta ) ) {
			foreach( $meta as $key => $value ) {
				$value = $value[0];
				$array = @unserialize( $value );
				if( is_array( $array ) ) {
					$property->$key = $array;
				}
				else {
					$property->$key = $value;
				}
			}
		}

		$this->property = $property;
		return $property;
	}

	function setPropertyDetails( $property ) {

		if( empty( $property ) ) {
			$this->errors->addError( 'Property Details Can\'t be set', 'The property you\'re trying to get at doesn\'t exist so we can\'t set it\'s details' , 'Property', __LINE__ );
			return null;
		}

		$min_nights_key = '_' . THEMEPREFIX . '_min_nights';
		$min_nights = ( empty( $property->$min_nights_key ) ) ? 1 : $property->$min_nights_key;
		$this->setMinNights( $min_nights );

		$max_nights_key = '_' . THEMEPREFIX . '_max_nights';
		$max_nights = ( empty( $property->$max_nights_key ) ) ? 1 : $property->$max_nights_key;
		$this->setMaxNights( $max_nights );

		$min_guests_key = '_' . THEMEPREFIX . '_min_guests';
		$min_guests = ( empty( $property->$min_guests_key ) ) ? 1 : $property->$min_guests_key;
		$this->setMinGuests( $min_guests );

		$max_guests_key = '_' . THEMEPREFIX . '_max_guests';
		$max_guests = ( empty( $property->$max_guests_key ) ) ? 1 : $property->$max_guests_key;
		$this->setMaxGuests( $max_guests );

		$price_type_key = '_' . THEMEPREFIX . '_price_type';
		$price_type = ( empty( $property->$price_type_key ) ) ? 'night' : $property->$price_type_key;
		$this->setPriceType( $price_type );

		$bookable_key = '_' . THEMEPREFIX . '_bookable';
		$bookable = ( !empty( $property->$bookable_key ) AND $property->$bookable_key == 'yes' ) ? true : false;
		$this->setBookable( $bookable );

		$booking_interval_key = '_' . THEMEPREFIX . '_booking_interval';
		$booking_interval = ( !empty( $property->$booking_interval_key ) AND $property->$booking_interval_key == 'week' ) ? 7 : 1;
		$this->setBookingInterval( $booking_interval );

		$bookings_key = '_' . THEMEPREFIX . '_bookings';
		$booking_dates = ( empty( $property->$bookings_key ) ) ? array() : $property->$bookings_key;
		$this->setBookings( $booking_dates );

	}

	function setBookings( $booking_dates ) {
		$bookings = array();

		if( !empty( $booking_dates ) ) {
			foreach( $booking_dates as $dates ) {
				$bookings = array_merge( $bookings, $dates );
			}
		}

		$this->bookings = $bookings;
	}

	function setMinNights( $min_nights ) {
		$min_nights = ( $min_nights < 1 ) ? 1 : $min_nights;
		$this->min_nights = $min_nights;
		return $min_nights;
	}

	function setMaxNights( $max_nights ) {
		$max_nights = ( $max_nights < 1 ) ? 1 : $max_nights;
		$this->max_nights = $max_nights;
		return $max_nights;
	}

	function setMinGuests( $min_guests ) {
		$min_guests = ( $min_guests < 1 ) ? 1 : $min_guests;
		$this->min_guests = $min_guests;
		return $min_guests;
	}

	function setMaxGuests( $max_guests ) {
		$max_guests = ( $max_guests < 1 ) ? 1 : $max_guests;
		$this->max_guests = $max_guests;
		return $max_guests;
	}

	function setBookable( $bookable ) {
		$this->bookable = $bookable;
		return $bookable;
	}

	function setBookingInterval( $booking_interval ) {
		$this->booking_interval = $booking_interval;
		return $booking_interval;
	}

	function setDateRange() {
		if( $this->start instanceof Carbon === false OR $this->end instanceof Carbon === false ) {
			$this->errors->addError( 'Date Range Can Not Be Set', 'Due to incorrect date formatting of the start or end date, the date range of the stay can not be calculated', 'Date Range', __LINE__ );
			return null;
		}

		$this->date_range = $this->calculateDateRange( clone $this->start, clone $this->end );

	}

	function setBookingId( $booking_id ) {
		$this->booking_id = $booking_id;
	}

	function setName( $details ) {
		$this->name = !empty( $details['_est_name'] ) ? $details['_est_name'] : '';
	}
	function setEmail( $details ) {
		$this->email = !empty( $details['_est_email'] ) ? $details['_est_email'] : '';
	}
	function setPhone( $details ) {
		$this->phone = !empty( $details['_est_phone'] ) ? $details['_est_phone'] : '';
	}
	function setMessage( $details ) {
		$this->message = !empty( $details['_est_message'] ) ? $details['_est_message'] : '';
	}

	function setSeasonalPricing() {
		$seasonal_pricing = array();
		if( !empty( $this->property->_est_rent_seasonal_price ) ) {
			foreach( $this->property->_est_rent_seasonal_price as $season ) {
				if( !empty( $season['start'] ) AND !empty( $season['end'] ) ) {
					$current =  Carbon::createFromFormat('Y-m-d', '2012-' . $season['start'] );
					$end =  Carbon::createFromFormat('Y-m-d', '2012-' . $season['end'] );

					$pricing = array();
					$pricing['daily'] = $season['price']['daily'];
					$pricing['weekly'] = ( !empty( $season['price']['weekly'] ) ) ? $season['price']['weekly'] / 7 : $season['price']['daily'];
					$pricing['monthly'] = ( !empty( $season['price']['monthly'] ) ) ? $season['price']['monthly'] / 30 : $season['price']['daily'];

					if( $current->lte( $end ) ) {
						while( $current->lte( $end ) ) {
							$date = $current->format( 'm-d' );
							$seasonal_pricing[$date] = $pricing;
							$current->addDay();
						}
					}
					else {
						$end =  Carbon::createFromFormat('Y-m-d', '2012-12-31' );
						while( $current->lte( $end ) ) {
							$date = $current->format( 'm-d' );
							$seasonal_pricing[$date] = $pricing;
							$current->addDay();
						}

						$current =  Carbon::createFromFormat('Y-m-d', '2012-01-01' );
						$end =  Carbon::createFromFormat('Y-m-d', '2012-' . $season['end'] );
						while( $current->lte( $end ) ) {
							$date = $current->format( 'm-d' );
							$seasonal_pricing[$date] = $pricing;
							$current->addDay();
						}

					}
				}
			}
		}

		$this->seasonal_pricing = $seasonal_pricing;

	}

	function setPricing() {
		$pricing = array();
		$pricing['daily'] = $this->property->_est_rent_daily_price;
		$daily = $this->property->_est_rent_daily_price;
		$weekly = $this->property->_est_rent_weekly_price;
		$pricing['weekly'] = ( empty( $weekly ) ) ? $daily : $weekly / 7;
		$monthly = $this->property->_est_rent_monthly_price;
		$pricing['monthly'] = ( empty( $monthly ) ) ? $daily : $monthly / 30;

		$current =  Carbon::createFromDate( 2012, 1, 1 );
		$end =  Carbon::createFromDate( 2013, 1, 1 );

		$price_table = array();


		$seasonal_dates = ( !empty( $this->seasonal_pricing ) ) ? array_keys( $this->seasonal_pricing ) : array() ;

		while( $current->lt( $end ) ) {
			$date = $current->format( 'm-d' );
			if( !in_array( $date, $seasonal_dates ) ) {
				$price_table[$date] = $pricing;
			}
			else {
				$price_table[$date] = $this->seasonal_pricing[$date];
			}

			$current->addDay();
		}

		$this->pricing = $price_table;

	}

	function setUsedPrice() {
		if( $this->nights < 7 ) {
			$this->used_price = 'daily';
		}
		elseif( $this->nights < 30 ) {
			$this->used_price = 'weekly';
		}
		else {
			$this->used_price = 'monthly';
		}
	}

	/***********************************************/
	/*                 Main Logic                  */
	/***********************************************/

	function isNightsInRange() {
		if( $this->nights >= $this->min_nights AND $this->nights <= $this->max_nights ) {
			return true;
		}
		return false;
	}

	function isGuestsInRange() {
		if( $this->guests >= $this->min_guests AND $this->guests <= $this->max_guests ) {
			return true;
		}
		return false;
	}

	function isNightsInInterval() {
		if( $this->nights % $this->booking_interval == 0 ) {
			return true;
		}
		return false;
	}

	function isPropertyBookable() {
		if( $this->bookable == true ) {
			return true;
		}
		return false;
	}

	function isPropertyFreeInBookingRange() {
		$free = true;
		foreach( $this->date_range as $date ) {
			if ( !$this->isPropertyFreeOnDate( $date ) ) {
				$free = false;
				break;
			}
		}

		if( $free == true ) {
			return true;
		}
		else {
			return false;
		}
	}

	function checkBooking() {

		if( !$this->isPropertyBookable() ) {
			$this->errors->addError( 'This property is not bookable', 'This selected property is not available for booking', 'Bookable', __LINE__ );
			return;
		}

		if( !$this->isNightsInRange() ) {
			$this->errors->addError( 'The selected dates are not allowed', 'This property may only be booked if you stay between ' . $this->min_nights . ' and ' . $this->max_nights . ' nights', 'Nights', __LINE__ );
		}

		if( !$this->isGuestsInRange() ) {
			$this->errors->addError( 'The selected guest number is not allowed', 'This property may only be booked for ' . $this->min_guests . ' to ' . $this->max_guests . ' guests', 'Guests', __LINE__ );
		}

		if( !$this->isNightsInInterval() ) {
			$interval_name = ( $this->booking_interval == 'day' ) ? 'daily' : 'weekly';
			$this->errors->addError( 'The selected interval is not allowed', 'This property may only be booked ' . $interval_name, 'Booking Interval', __LINE__ );
		}

		if( !$this->isPropertyFreeInBookingRange() ) {
			$this->errors->addError( 'The property is not free for your chosen stay interval', 'Try selecting a different set of dates', 'Free', __LINE__ );
		}

	}

	function insertBooking( $payment = false ) {
		$this->checkBooking();
		if( $this->errors->hasError() ) {
			return $this->errors;
		}
		else {
			$data = array(
				'post_type'   => 'booking',
				'post_status' => 'pending',
				'post_title'  => 'Booking',
				'post_content' => $this->message
			);

			if( !empty( $payment ) ) {
				$data['post_status'] = 'publish';
			}

			$booking_id = wp_insert_post( $data );

			$data = array(
				'ID' => $booking_id,
				'post_title' => 'Booking #' . $booking_id,
			);

			wp_update_post( $data );
			update_post_meta( $booking_id, '_est_start', $this->start->toDateString() );
			update_post_meta( $booking_id, '_est_end', $this->end->toDateString() );
			update_post_meta( $booking_id, '_est_property_id', $this->property_id );
			update_post_meta( $booking_id, '_est_guests', $this->guests );
			update_post_meta( $booking_id, '_est_name', $this->name );
			update_post_meta( $booking_id, '_est_email', $this->email );
			update_post_meta( $booking_id, '_est_phone', $this->phone );
			if( !empty( $payment ) ) {
				update_post_meta( $booking_id, '_est_paid', 'yes' );
				update_post_meta( $booking_id, '_payment_id', $payment['txn_id'] );
				update_post_meta( $booking_id, '_est_paid_amount', $payment['mc_gross'] );
			}
			else {
				update_post_meta( $booking_id, '_est_paid', 'no' );
			}
			do_action( 'update_booking_dates', $booking_id );
			$this->setBookingId( $booking_id );
			return $booking_id;
		}
	}


	function saveCustomFields( $meta ) {
		foreach( $meta as $key => $value ) {
			update_post_meta( $this->booking_id, $key, $value );
		}
	}


	/***********************************************/
	/*              Price Calculation              */
	/***********************************************/


	function calculatePricePerNight() {
		$prices = array();
		foreach( $this->date_range as $date ) {
			$monthday = substr( $date, 5 );
			$prices[] = $this->pricing[$monthday][$this->used_price];
		}

		if( $this->price_type == 'person' ) {
			return ( array_sum( $prices ) / count( $prices ) ) * $this->getGuests();
		}
		else {
			return ( array_sum( $prices ) / count( $prices ) );
		}


	}

	function calculateTotalPrice() {
		$prices = array();
		foreach( $this->date_range as $date ) {
			$monthday = substr( $date, 5 );
			$prices[] = $this->pricing[$monthday][$this->used_price];
		}

		if( $this->price_type == 'person' ) {
			return array_sum( $prices ) * $this->getGuests();
		}
		else {
			return array_sum( $prices );
		}
	}


	/***********************************************/
	/*              Utility Functions              */
	/***********************************************/

	function calculateNights( $start, $end ) {
		if( $start instanceof Carbon === false OR $end instanceof Carbon === false ) {
			$this->errors->addError( 'Nights Can\'t Be Calculated', 'Due to incorrect date formatting of the start or end date, the number of nights could not be calculated', 'Nights', __LINE__ );
			return null;
		}
		try {
        	$nights = $start->diffInDays( $end, false );
        	if( $nights < 0 ){
			$this->errors->addError( 'Night Count Can\'t Be Negative', 'The chosen end date is before the start date', 'Nights', __LINE__ );
        	}
        	$this->nights = $nights;
        	return $nights;
    	} catch( Exception $exception ) {
			$this->errors->addError( 'Night Can\'t Be Calculated', 'Due to an unknown reason we could not calculate the number of nights', 'Nights', __LINE__, $exception );
    	}
	}

	function calculateDateRange( $start, $end ) {

		if( $start instanceof Carbon === false OR $end instanceof Carbon === false ) {
			$this->errors->addError( 'Nights Can\'t Be Calculated', 'Due to incorrect date formatting of the start or end date, the date range could not be calculated', 'Date Range', __LINE__ );
			return null;
		}

		$current = $start;
		$end = $end;
		$dates = array();

		while( $current->lt( $end ) ) {
			$dates[] = $start->toDateString();
			$current->addDay();
		}

		return $dates;

	}

	function isPropertyFreeOnDate( $date ) {
		if( !in_array( $date, $this->bookings ) ) {
			return true;
		}
		return false;
	}



	/***********************************************/
	/*                Magic Methods                */
	/***********************************************/

	function __toString() {
		$bookable = ( $this->bookable === true ) ? 'Yes' : 'No';
		$output = '
		<div style="font-family:monospace; max-width:500px;">
		<h2 style="margin:0px; padding:0 0 8px 0; border-bottom:1px dashed #000">Booking Details</h2>
		<table cellpadding="5" style=" margin:8px 0 22px 0">
			<tr><td style="text-align:right"><strong>Property ID</strong>:</td><td> ' . $this->property_id . '</td></tr>
			<tr><td style="text-align:right"><strong>Min Nights</strong>:</td><td> ' . $this->min_nights . '</td></tr>
			<tr><td style="text-align:right"><strong>Max Nights</strong>:</td><td> ' . $this->max_nights . '</td></tr>
			<tr><td style="text-align:right"><strong>Min Guests</strong>:</td><td> ' . $this->min_guests . '</td></tr>
			<tr><td style="text-align:right"><strong>Max Guests</strong>:</td><td> ' . $this->max_guests . '</td></tr>
			<tr><td style="text-align:right"><strong>Booking Interval</strong>:</td><td> ' . $this->booking_interval . ' days</td></tr>
			<tr><td style="text-align:right"><strong>Bookable</strong>:</td><td> ' . $bookable . '</td></tr>
			<tr><td style="border-bottom: 1px solid #ddd" colspan="2"></td></tr>
			<tr><td style="text-align:right"><strong>Arrival</strong>:</td><td> ' . $this->start . '</td></tr>
			<tr><td style="text-align:right"><strong>Departure</strong>:</td><td> ' . $this->end . '</td></tr>
			<tr><td style="text-align:right"><strong>Nights</strong>:</td><td> ' . $this->nights . '</td></tr>
			<tr><td style="text-align:right"><strong>Guests</strong>:</td><td> ' . $this->guests . '</td></tr>
			<tr><td style="vertical-align:top; text-align:right"><strong>Date Range</strong>:</td><td> ';
			if( !empty( $this->date_range ) ) {
				foreach( $this->date_range as $date ) {
					$output .= $date . '<br>';
				}
			}
			$output .= '</td></tr>

			<tr><td style="vertical-align:top; text-align:right"><strong>Bookings</strong>:</td><td> ';
			if( !empty( $this->bookings ) ) {
				foreach( $this->bookings as $date ) {
					$output .= $date . '<br>';
				}
			}
			$output .= '</td></tr>


		</table>
		';

		if( $this->errors->hasError() ) {
		$output .='
			<h2 style="margin:0 0 11px 0; padding:0 0 8px 0; border-bottom:1px dashed #000">Errors <span style="font-size:12px; position:Relative;top:-2px; color: #ea241c">(' . $this->errors->countErrors() . ')</span></h2>
			'. $this->errors->debugInformation() . '
		';
		}

		$output .= '
		</div>
		';

		return $output;
	}


	function get_property_id() {
		return $this->property_id;
	}

}
?>