function sticky_footer() {
	var footer = jQuery( '#siteFooter' );

	if( footer.length > 0 ) {
		var footerTop = footer.offset();
		var footerHeight = footer.outerHeight();

		var footerBottom = footerTop + footerHeight;
		var htmlHeight = jQuery( 'html' ).height();
		var windowHeight = jQuery( window ).height();

		if( windowHeight > htmlHeight ) {
			position = windowHeight - footerHeight;
			footer.offset( { top: position } )
		}
	}
}

function refreshPrice() {
	var start = jQuery( '#_est_start' ).val();
	var end = jQuery( '#_est_end' ).val();
	var guests = jQuery( '#_est_guests' ).val();
	var property_id = jQuery( '#_est_property_id' ).val();

	jQuery.ajax({
		url: estAjax.ajaxurl,
		data: {
			_est_start: start,
			_est_end: end,
			_est_guests: guests,
			action: 'get_booking_prices',
			_est_property_id: property_id
		},
		dataType: 'json',
		type: 'post',
		success: function( response ) {
			jQuery( '.total-price' ).html( response.total_price )
			jQuery( '.price-per-night' ).html( response.price_per_night )
		}
	})
}

( function( $ ) {

	$('.tabs section .content').css({'display' : 'block', 'position' : 'static'});

	$(window).load( function() {
		$(document).foundation();
		if( $('html').attr('dir') == 'rtl' ){
			setTimeout( function(){
				$.each( $('.section-container'), function() {
					titles = $(this).find('section p.title');
					$.each( titles, function() {
						left = $(this).css('left');
						$(this).css({ 'left' : 'auto', 'right' : left })
					})
				})
			}, 2000)
		}
		sticky_footer();
	})

	var retina = window.devicePixelRatio > 1;

	var logoWidth = 0;
	var logoHeight = 0;

	$('input[type="submit"]').not('.vfb-submit, .woocommerce input[type="submit"], #buddypress input[type="submit"], #sabai-content input[type="submit"], .jetpack_subscription_widget input[type="submit"], .contact-user-btn input[type="submit"]').customSubmit();
	$( '.button.submit' ).on( 'click', function(){
		$(this).parents( 'form' ).submit();
	});

	function header_positioning() {
		// Only on small screens
		var totalWidth = $( window ).width();
		if( totalWidth > 768 ) {
			// Make sure logo doesn't cover menu
			if( $( '#siteHeader' ).hasClass('fullLogo') == false ) {
				var headerWidth = $( '#siteHeader' ).width();
				$( '#headerMenu' ).css( 'width', ( headerWidth - logoWidth - 44 ) + 'px' );
				var headerHeight = $( '#siteHeader' ).height();
				var push = ( headerHeight - logoHeight ) / 2;
				$( '#headerLogo' ).css( 'top', push + 'px' );

			}
			// Center position logo
		}
	}

	function retinize_images() {
		var images = $( 'img.retina' );
		var dotpos = '';
		var extension = '';
		var file = '';
		var filename = '';
		var retina = '';
		$.each( images, function() {
			var retina_image = $(this).attr( 'data-retina' );
			if( typeof retina_image === 'undefined' ) {
				file = $(this).attr( 'src' );
				dotpos = file.lastIndexOf('.');

				extension = file.substr( ( dotpos + 1 ) );
				filename = file.substr( 0, dotpos );

				newfile = filename + '@2x.' + extension;
				$(this).attr( 'src', newfile );
			}
			else if( retina_image !== '' && typeof retina_image !== 'undefined' && retina_image !== null ) {
				$(this).attr( 'src', retina_image );
			}
		});
	}

	function retina_image_width() {
		var images = $( 'img.retina' );
		$.each( images, function() {
			var imageWidth = $(this).attr('width');
			if( imageWidth === '' || typeof imageWidth === 'undefined' || imageWidth === null ) {
				var width = $(this).attr('data-width');
				if( width === '' || typeof width === 'undefined' || width === null ) {
					$(this).width( $(this).width() / 2)
				}
				else {
					$(this).width( width / 2)
				}
			}
		})
	}

	function menu_structure() {
		$.each( $('.menu li'), function() {
			if( $(this).find('.sub-menu').length > 0 ) {
				$(this).addClass( 'has-sub-menu' );
			}
		});

		$('#headerMenu .menu > li.has-sub-menu > a').bind( 'touchstart',
		    function( e ) {
		    	$this = $(this);
		    	if( $this.hasClass('touched') ) {
			    	$this.removeClass('touched');
		    	}
		    	else {
		    		$this.addClass('touched');
		    		e.preventDefault();
		    	}
		    }
		);

	}

	function collapse_menu() {
		if( $( '#headerDropdown' ).length > 0 ) {
			$( '#headerMenu' ).hide();
			$( '#headerDropdown' ).show();
		}
		else {
			var collapsed_menu = $( '#headerMenu' ).clone();
			$( '#headerMenu' ).hide();

			collapsed_menu.attr( 'id', 'headerDropdown' );
			collapsed_menu.css( 'width', 'auto' );

			var items = collapsed_menu.find( 'li' );
			collapsed_menu.find( '.menu' ).html('<li>Menu <ul class="has-sub-menu"></ul></li>');

			$.each( items, function(){
				element = $(this);
				element.removeClass('has-sub-menu');
				collapsed_menu.find( '.menu > li > ul' ).append( element );
			});

			$(collapsed_menu).insertAfter( '#headerMenu' );
		}
	}

	function determine_menu_type() {
		var document_width = jQuery(window).width();
		if( document_width <= 768 ) {
			collapse_menu();
		}
		else {
			expand_menu();
		}
	}

	function expand_menu() {
		$( '#headerMenu' ).show();
		$( '#headerDropdown' ).hide();
	}

	$( document ).ready( function() {
		menu_structure();
		determine_menu_type();
		if( retina === true ) {
			retinize_images();
		}
	})

	$( window ).load( function() {
		if( retina === true ) {
			retina_image_width();
		}
	})

	$( '#headerLogo' ).imageready( function() {
		logoWidth = $( '#headerLogo' ).width();
		logoHeight = $( '#headerLogo' ).height();
		header_positioning();
	})

	$(window).on( 'debouncedresize', function( event ) {
		determine_menu_type()
		header_positioning();
	})

	$('#headerMenu .menu > li').hover(
	    function () {
	    	var $this = $(this);
	    	var $submenu = $this.find('.sub-menu:first');
	        var submenuheight = $submenu.attr('submenuheight');

	        if (!submenuheight) {
	            var submenuheight = $submenu.outerHeight();
	            $submenu.attr( 'submenuheight', submenuheight )
	        }

	        $submenu.show(0).height('0px').stop().animate({
	            height: submenuheight
	        }, 200 );
	    },
	    function () {
	        jQuery(this).find('.sub-menu:first').css('display', 'block').stop().animate({
	            height: '0px'
	        }, 200).hide(0);
	    }
	);

	$.each( $('.range').not('.off'), function() {
		var min = $(this).attr('data-min');
		var max = $(this).attr('data-max');
		var id = $(this).attr( 'id' );
		var name = $(this).attr( 'data-name' );
		var $values = $('.range-values[data-id="' + id + '"]');

		var current_min = $(this).attr('data-value_min');
		var current_max = $(this).attr('data-value_max');

		$(this).noUiSlider({
		    range: [min, max]
		   ,start: [min, max]
		   ,step: 1
		   ,slide: function(){
		      var values = $(this).val();
		      $values.find('.min .value').html( number_format( parseFloat( values[0] ), 0, estAjax.decimal_separator, estAjax.thousand_separator ) );
		      $values.find('.max .value').html( number_format( parseFloat( values[1] ), 0, estAjax.decimal_separator, estAjax.thousand_separator ) );

		   }
		   ,serialization : {
		   	to: [ name + '[min]', name + '[max]' ],
		   	resolution: 1
		   }
		});

		if( current_min != '' && current_max != '' ) {
			$(this).val([current_min, current_max])
			$values.find('.min .value').html( number_format( parseFloat( current_min ) ) );
		    $values.find('.max .value').html( number_format( parseFloat( current_max ) ) );
		}

	})


$(window).load(function() {

	$( '.section-container section:first' ).addClass('active')
	// The slider being synced must be initialized first
	$('#property-carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 210,
		itemMargin: 5,
		asNavFor: '#property-slider'
	});

	$('#property-slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#property-carousel"
	});
});





	jQuery(".gallery-item a").fancybox();
	jQuery(".fancybox-image").fancybox();


	function get_gallery_width( element ) {
		var gallery_width = element.parents('.columns:first').width();
		var column_width = '';
		var width = '';
		if( jQuery(window).width() < 500 ) {
			width = 420;
			$('.gallery-item').css('width', '100%')
		}
		else {
			column_width = gallery_width / 3
			width = Math.floor(element);
			$('.gallery-item').css('width', '33%')
		}
		return width;
	}


	jQuery(window).load( function(){
		jQuery('.gallery').each( function() {
			var gallery = jQuery(this)
			gallery.isotope({
				itemSelector : '.gallery-item',
				resizeable: false,
				layoutMode : 'masonry',
				masonry: {
					columnWidth: get_gallery_width( gallery ),
				},

			});
		})
	})


	jQuery(window).smartresize(function(){
		jQuery('.gallery').each( function() {
			var gallery = jQuery(this)
			gallery.isotope({
				masonry: {
					columnWidth: get_gallery_width( gallery ),
				},

			});
		})

	});




function start_property_slide() {
	var next_property = current_property + 1;
	if( next_property >= property_slides.length ) {
		next_property = 0;
	}
	featured_properties.find('.property:eq(' + current_property + ')').fadeOut( 1000 );
	featured_properties.find('.property:eq(' + next_property + ')').fadeIn( 1000 );

	current_property = next_property;

}

var featured_properties = $( '#featured-properties' );
var property_slides = featured_properties.find('.property');
if( property_slides.length > 1 ) {
	var current_property = 0;
	var speed = parseInt( featured_properties.attr('data-speed') ) * 1000;
	setInterval(start_property_slide, speed)
}





} )( jQuery );