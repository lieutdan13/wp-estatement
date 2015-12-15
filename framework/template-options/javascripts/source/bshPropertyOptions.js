function reorder_agents() {
	jQuery.each( jQuery( '.est_agent' ), function( i ){
		jQuery(this).find('label .agent_count').html( (i+1) );
		jQuery(this).find('select').attr( 'id', '_est_agent_' + i );
		jQuery(this).find('select').attr( 'name', '_est_agent[' + i + ']');
	})
}

function reorder_seasonal_prices() {
	jQuery.each( jQuery( '.est-seasonal-price' ), function( i ){
		jQuery(this).find('input.name').attr( 'name', '_est_rent_seasonal_price[' + i + '][name]' );
		jQuery(this).find('input.from').attr( 'name', '_est_rent_seasonal_price[' + i + '][start]' );
		jQuery(this).find('input.until').attr( 'name', '_est_rent_seasonal_price[' + i + '][end]' );
		jQuery(this).find('input.applied').attr( 'name', '_est_rent_seasonal_price[' + i + '][applied]' );
		jQuery(this).find('input.daily').attr( 'name', '_est_rent_seasonal_price[' + i + '][price][daily]' );
		jQuery(this).find('input.weekly').attr( 'name', '_est_rent_seasonal_price[' + i + '][price][weekly]' );
		jQuery(this).find('input.monthly').attr( 'name', '_est_rent_seasonal_price[' + i + '][price][monthly]' );
	})
}


jQuery( document ).ready( function( $ ) {


	$( document ).on('focusin', '.monthdaypicker', function(e) {
		$( this ).datepicker({
	        changeMonth: true,
	        changeYear: true,
	        showButtonPanel: true,
	        dateFormat: 'mm-dd'
		});
	});


	$(document).on( 'click', '#add-agent', function() {
		element = $( '.est_agent:first' ).clone();
		element.find( 'select option' ).removeAttr('selected');
		element.find( 'select option:first' ).attr('selected', 'selected');
		$('#est_agents').after( element );
		reorder_agents();

		return false;
	})

	$(document).on( 'click', '#add-seasonal-price', function() {
		element = $( '.est-seasonal-price:first' ).clone();
		element.find( 'input' ).val('');
		element.find( '.monthdaypicker' ).removeClass( 'hasDatepicker' ).removeAttr( 'id' )
		$('.est-seasonal-price:last').after( element );
		reorder_seasonal_prices();

		return false;
	})


	$(document).on( 'click', '.remove-seasonal-price', function() {
		element = $(this).parents( 'tr:first' );
		if( $('.est-seasonal-price').length > 1 ) {
			element.remove();
		}
		else {
			$('.est-seasonal-price').find( 'input' ).val( '' )
		}
		reorder_seasonal_prices();
		return false;
	})


})