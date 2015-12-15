( function( $ ) {

	$advanced = $( '#advanced-search' );
	$advancedSwitch = $( '#advanced-search-switch' );

	var advanced_height = $advanced.outerHeight();

	var show_advanced = $advanced.data('show_advanced');
	if( show_advanced != 'yes'  ) {
		$advanced.hide();
	}

	$( document ).on( 'click', '#advanced-search-switch', function(){
		if( $advanced.is(':visible') ) {
			$advanced.slideUp();
			$advancedSwitch.removeClass('open');
			$advancedSwitch.html( $advancedSwitch.attr( 'data-closed_text' ) );
		}
		else {
			$advanced.slideDown( function() {
				$(this).css('overflow', 'visible')
			});
			$advancedSwitch.addClass('open');
			$advancedSwitch.html( $advancedSwitch.attr( 'data-open_text' ) );
		}
	})

} )( jQuery );