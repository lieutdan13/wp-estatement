<div class="wrap nosubsub">
<div id='est_header'>
<div id="est_booking_page_icon" class="icon32 icon32-posts-property"><br></div><h2><?php _e( 'Booking Calendar', THEMENAME ) ?></h2>
</div>


<form id='bookingFilters' class="mt22 mb22">
	<select name="property_id">
		<?php
			$properties = get_property_dropdown_options();
			echo '<option value="">' . __( 'All Properties', THEMENAME ) . '</option>';
			foreach( $properties as $value => $name ) :
			$selected = ( !empty( $_GET['property_id'] ) AND $value == $_GET['property_id'] ) ? 'selected="selected"' : '';
		?>
			<option <?php echo $selected ?> value='<?php echo $value ?>'><?php echo $name ?></option>
		<?php endforeach ?>
	</select>
	<input type='hidden' name='post_type' value='booking'>
	<input type='hidden' name='page' value='booking_calendar_display'>
	<input type="submit" name=""  class="button action" value="<?php _e( 'Apply', THEMENAME ) ?>">
</form>

<script>

	jQuery(document).ready(function( $ ) {

		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=get_bookings_for_calendar&<?php echo $_SERVER['QUERY_STRING'] ?>'
		})
	});

</script>


<div id='calendar'></div>


</div>
