( function( $ ) {

	$advanced = $( '#advanced-search' );
	$advancedSwitch = $( '#advanced-search-switch' );

	var advanced_height = $advanced.outerHeight();

	var show_advanced = $advanced.data('show_advanced');
	if( show_advanced != 'yes'  ) {
		$advanced.hide();
	}

	function search_position( advanced_height, offset ) {

		if( $( '#search-page' ).hasClass('no-full') ) {
			var total_height = $('.cb-slideshow').height();
			var search_height = $('#search-page').height();
			var push = ( total_height - search_height ) / 2

			if( offset != '' && typeof offset != 'undefined' && offset != null ) {
				if(offset == 'top') {
					push = 58;
				}
				else {
					push = push + offset
				}
			}
			if( push < 36 ) {
				push = 36
			}

			$('#search-page').animate( { top : push + 'px' } );
		}
		else {
			if( advanced_height === '' || advanced_height === null || typeof advanced_height === 'undefined'  ) {
				advanced_height = 0;
			}

			var total_height = $(window).height();

			var header_height = $( '#siteHeader' ).height();
			var available_height = total_height - header_height;
			var $search_page = $( '#search-page' );

			var search_height = $( '#search-page' ).height() + advanced_height;

			var push = ( available_height - search_height ) / 3;
			$search_page.animate( { marginTop : push + 'px' } );
		}

	}

	$( document ).ready( function() {
		search_position();
	})

	$(window).on( 'debouncedresize', function( event ) {
		search_position();
	})

	$( document ).on( 'click', '#advanced-search-switch', function(){
		if( $advanced.is(':visible') ) {
			$advanced.slideUp();
			$advancedSwitch.removeClass('open');
			$advancedSwitch.html( $advancedSwitch.attr( 'data-closed_text' ) );
			if( $( '#search-page' ).hasClass('full') ) {
				search_position( -advanced_height );
			}
		}
		else {
			$advanced.slideDown( function() {
				$(this).css('overflow', 'visible')
			});
			$advancedSwitch.addClass('open');
			$advancedSwitch.html( $advancedSwitch.attr( 'data-open_text' ) );
			search_position( advanced_height, 'top' );
		}
	})

} )( jQuery );