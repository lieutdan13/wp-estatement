<?php
/*
Template Name: Booking Page
*/

if( !empty( $_GET['overview'] ) ) {
	$modify_url = get_permalink() . '/?' . str_replace( '&overview=true', '', $_SERVER['QUERY_STRING'] );
	$booking = new BonsaiBooking( $_GET['_est_property_id'], $_GET['_est_guests'], $_GET['_est_start'], $_GET['_est_end'] );
	$booking->checkBooking();
	if( empty( $_GET['_est_name'] ) ) {
		$booking->errors->addError( 'Please tell us your name', 'To complete your booking we need to know your name, please full the field out', 'Name', __LINE__ );
	}
	if( empty( $_GET['_est_email'] ) ) {
		$booking->errors->addError( 'Please tell us your email', 'To complete your booking we need to know your email, please full the field out', 'Email', __LINE__ );
	}
	if( $booking->errors->hasError() ) {
		$_SESSION['booking'] = $booking;
		header( 'Location: ' . $modify_url );
	}
}


get_header();
?>
<div class='row mt44'>
	<div class='large-9 small-12 columns centered small-centered'>
		<h1 class='floating-title mb44'><?php the_title() ?></h1>

<?php

if( !empty( $_GET['_est_property_id'] ) AND empty( $_GET['est_success'] ) ) {

	global $post;
	$post = get_post( $_REQUEST['_est_property_id'] );
	setup_postdata( $property );
	$thumbnail_id = get_post_thumbnail_id();
	$image = wp_get_attachment_image_src( $thumbnail_id, 'est_flyer_small' );
	$currency = get_post_meta( $post->ID, '_est_rent_currency', true );
	$currency_position = get_post_meta( $post->ID, '_est_rent_currency_position', true );
	$interval = get_post_meta( $post->ID, '_est_booking_interval', true );

?>
	<div <?php post_class( 'layout-booknow-property' ) ?> style="background-image: url( <?php echo $image[0] ?>); display: block;">
		<div class="post-content">
			<div class="post-image-overlay"></div>
			<h1><a class="heading-text-color" href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
			<div class="content">
				<?php the_excerpt() ?>
			</div>
		</div>
	</div>
<?php
	wp_reset_postdata();
}


if( empty( $_GET['_est_property_id'] ) ) {
	get_template_part( 'booking', 'select_property' );
}
elseif( !empty( $_GET['overview'] ) ) {
	get_template_part( 'booking', 'overview' );
}
elseif( !empty( $_GET['est_success'] ) ) {
	get_template_part( 'booking', 'success' );
}
else {
	get_template_part( 'booking', 'form' );
}

?>


</div>
</div>

<?php get_footer() ?>