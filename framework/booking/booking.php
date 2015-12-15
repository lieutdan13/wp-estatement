<?php

add_action('admin_menu', 'est_booking_submenus');
function est_booking_submenus() {
	add_submenu_page( 'edit.php?post_type=booking', 'View your bookings on a calendar', 'Booking Calendar', 'manage_options', 'booking_calendar_display', 'est_display_booking_calendar' );
}

function est_display_booking_calendar() {
	include( 'booking-calendar_display.php' );
}



add_action( 'admin_enqueue_scripts', 'est_booking_styles' );
function est_booking_styles($hook) {
	$pages = array( 'booking_page_booking_calendar_display' );
    if( !in_array( $hook, $pages ) )
        return;
	wp_register_style(
		'est_booking',
		get_template_directory_uri() . '/framework/booking/booking.css',
		array(),
		THEMEVERSION
	);
	wp_register_style(
		'fullcalendar',
		get_template_directory_uri() . '/framework/booking/fullcalendar.css',
		array(),
		THEMEVERSION
	);


	wp_enqueue_style( 'est_booking' );
	wp_enqueue_style( 'fullcalendar' );

	wp_register_script(
		'fullcalendar',
		get_template_directory_uri() . '/framework/booking/fullcalendar.min.js',
		array(),
		THEMEVERSION
	);
	wp_enqueue_script( 'fullcalendar' );

}






?>