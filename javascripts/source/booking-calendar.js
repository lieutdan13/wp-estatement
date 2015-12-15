;(function($){
	$.fn.extend({
		bookingCalendar : function(options) {
			var defaults = {
				bookedDays: [],
			};
			options = $.extend(defaults, options);

				var start      = $(this).find( '.start' );
				var startField = $(this).find( '.start-field' );
				var end        = $(this).find( '.end' );
				var endField   = $(this).find( '.end-field' );
				var interval   = $(this).attr( 'data-interval' );


				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1;
				var yyyy = today.getFullYear();
				if(dd<10){dd='0'+dd}
				if(mm<10){mm='0'+mm}
				today = yyyy + '-' + mm + '-' + dd;

				var invalidEndDate = false;

				function get_start( format ) {
					var start_date = start.datepicker( 'getDate' );
					if( start_date != null ) {
						if( format == 'date' ) {
							return start_date;
						}
						else {
							return jQuery.datepicker.formatDate( 'yy-mm-dd', start_date );
						}
					}
					else {
						return null;
					}
				}

				function get_start_plus_one( format ) {
					var selectableFirstDate = start.datepicker( 'getDate', '+1d' );
					if( selectableFirstDate != null ) {
						selectableFirstDate.setDate(selectableFirstDate.getDate() + 1 );
						if( format == 'date' ) {
							return selectableFirstDate;
						}
						else {
							return jQuery.datepicker.formatDate( 'yy-mm-dd', selectableFirstDate );
						}
					}
				}

				function get_end( format ) {
					var end_date = end.datepicker( 'getDate' );
					if( end_date != null ) {
						if( format == 'date' ) {
							return end_date;
						}
						else {
							return jQuery.datepicker.formatDate( 'yy-mm-dd', end_date );
						}
					}
					else {
						return null;
					}
				}


				function dayStatusStart( raw_date ) {
					var date = jQuery.datepicker.formatDate( 'yy-mm-dd', raw_date );
					var start_date = get_start();
				 	var end_date = get_end();

					if( date < today ) {
						return [false, 'past'];
					}
					else if( options.bookedDays.indexOf( date ) !== -1 ) {
						return [false, 'booked'];
					}
					else if( start_date != null && end_date != null && date <= end_date && date >= start_date ) {
						return [ true, 'selected' ]
					}
					else if( ( start_date == null && date == end_date ) || ( end_date == null && date == start_date ) ) {
						return [ true, 'selected' ]
					}

					else {
						if( interval == 'week' ) {
							var i = -6;
							var dates = new Array;
							var current_date = new Date( raw_date );
					 		current_date.setDate(current_date.getDate() - 7 );
							var continuous = new Array;
							var counter = 0;
							var max_continuous = 0;

							while( i < 7 ) {
					 			current_date.setDate(current_date.getDate() + 1);
								dates.push( jQuery.datepicker.formatDate( 'yy-mm-dd', current_date ));
								i++;
							}


							$.each( dates, function( i, future_date ) {
								if( options.bookedDays.indexOf( future_date ) !== -1 ) {
									continuous.push( false );
								}
								else {
									continuous.push( true );
								}
							})


							$.each( continuous, function( i, value ) {
								if( value === true ) {
									counter++;
									if( counter > max_continuous ) {
										max_continuous = counter;
									}

								}
								else {
									counter = 0;
								}
							});

							if( max_continuous >= 7 ) {
								return [true, 'bookable'];
							}
							else {
								return [false, 'invalid'];
							}
						}
						else {
							return [true, 'bookable'];
						}
					}


				}

				function dayStatusEnd( raw_date ) {
					var date = jQuery.datepicker.formatDate( 'yy-mm-dd', raw_date );
					var start_date = get_start();
					var end_date = get_end();

					if( date < today ) {
						return [false, 'past'];
					}
					else if ( start_date != null && today <= date && date < start_date ) {
						return [false, 'invalid'];
					}
					else if( options.bookedDays.indexOf( date ) !== -1 ) {
						invalidEndDate = true;
						return [false, 'booked'];
					}
					else if( invalidEndDate == true ) {
						return [false, 'invalid'];
					}
					else if( start_date != null && date == start_date ) {
						return [ true, 'selected' ]
					}
					else if( start_date != null && end_date != null && date <= end_date && date >= start_date ) {
						return [ true, 'selected' ]
					}
					else if( ( start_date == null && date == end_date ) || ( end_date == null && date == start_date ) ) {
						return [ true, 'selected' ]
					}
					else {
						return [true, 'bookable'];
					}

				}


				start.datepicker({
					changeMonth: true,
					altField: startField,
					altFormat: 'yy-mm-dd',
					dateFormat: "DD, MM d, yy",
					beforeShowDay: dayStatusStart,
					onSelect: function() {
						end.val('');
						endField.val('');
						refreshPrice();
					}
				});


				end.datepicker({
					changeMonth: true,
					altField: endField,
					altFormat: 'yy-mm-dd',
					minDate: 0,
					dateFormat: "DD, MM d, yy",
					beforeShowDay: dayStatusEnd,
					beforeShow : function() { invalidEndDate = false },
					onSelect: function() {
						refreshPrice()
					}
				});



		}
	});
})(jQuery);

