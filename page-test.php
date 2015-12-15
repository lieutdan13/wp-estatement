<?php

/*
        $this->start = Carbon::createFromFormat( 'Y-m-d', $start );
        $this->end = Carbon::createFromFormat( 'Y-m-d', $end );
        $this->nights = $this->start->diffInDays( $this->end, false );
        $this->property = $this->getProperty();
        $this->min_nights = $this->getMinNights();
        $this->max_nights = $this->getMaxNights();
        $this->min_guests = $this->getMinGuests();
        $this->max_guests = $this->getMaxGuests();
        $this->booking_interval = $this->getBookingInterval();
        $this->bookable = $this->getBookable();
*/


	$booking = new BonsaiBooking( 75, 2, '2013-06-28', '2013-06-29' );
	echo $booking->calculateTotalPrice();
?>