/***********************************************/
/*       3. Theme Option Modifications         */
/***********************************************/
( function( $ ) {

var contact_info = {
	header_contact_location : {
		icon  : 'icons/defaulticon/14x14/map-marker-pin.png',
		alt   : 'Map pin icon'
	},
	header_contact_phone : {
		icon  : 'icons/defaulticon/14x14/i-phone.png',
		alt   : 'Map pin icon'
	},
	header_contact_email : {
		icon  : 'icons/defaulticon/14x14/mail.png',
		alt   : 'Envelope icon'
	}
}

function manage_contact_info( name, newval ) {
	var contact = $( '#headerContact' );
	var element = $( '#' + name );

	if( element.length > 0 ) {
		if( newval === '' || typeof newval === 'undefined' || newval === null ) {
			element.remove();
		}
		else {
			element.find('span').html( newval );
		}
	}
	else {
		if( contact.length === 0 ) {
			$( '#headerContent' ).prepend( '<ul id="headerContact" />' );
		}
		var template =
			"<li id='" + name + "'>" +
			"<img src='" + bs.template_url + "/images/" + contact_info[name].icon  + "' alt='" + contact_info[name].alt + "'> " +
			"<span>" + newval + "</span></li>";
		contact.prepend( template );

	}
}

// 2.1. Load Sidebar
function load_sidebar( sidebar ) {
	if( sidebar === '' || typeof sidebar === 'undefined' || sidebar === null ) {
		sidebar = 'mus_default';
	}
	$.ajax({
		url: mus.ajaxurl,
		type: 'post',
		data: {
			action : 'customizer_get_sidebar',
			sidebar: sidebar
		},
		success: function( result ){
			$('#siteSidebar').html( result );
		}
	});

}


	wp.customize( 'logo_image', function( value ) {
		value.bind( function( newval ) {
			if( newval === '' || newval === null || typeof newval === 'undefined' ) {
				$('#headerLogo img').hide();
				$('#headerLogo hgroup').show();
			}
			else {
				$('#headerLogo img').show();
				$('#headerLogo hgroup').hide();
				$('#headerLogo img' ).attr( 'src',  newval  );
			}
		});
	});


	wp.customize( 'header_contact_location', function( value ) {
		value.bind( function( newval ) {
			var name = 'header_contact_location'
			manage_contact_info( name, newval );
		})
	})

	wp.customize( 'header_contact_phone', function( value ) {
		value.bind( function( newval ) {
			var name = 'header_contact_phone'
			manage_contact_info( name, newval );
		})
	})

	wp.customize( 'header_contact_email', function( value ) {
		value.bind( function( newval ) {
			var name = 'header_contact_email'
			manage_contact_info( name, newval );
		})
	})

	wp.customize( 'body_text_color', function( value ) {
		value.bind( function( newval ) {
			$( 'html, body, p, a, .body-text-color, table tbody tr td, .content a.body-text-color, label' ).not('.button, .primary-text-color, h1,h2,h3,h4,h5,h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .current-menu-item a').css( 'color', newval )
			$( '.light, code' ).css( 'color', $.xcolor.lighten( newval, 2, 12 ) )
		})
	})



	wp.customize( 'heading_text_color', function( value ) {
		value.bind( function( newval ) {
			$( 'h1,h2,h3,h4,h5,h6, .heading-text-color, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .widget_rss li > a, h1.widget-title a' ).css( 'color', newval )
		})
	})



	wp.customize( 'site_background_color', function( value ) {
		value.bind( function( newval ) {
			$( 'html' ).css( 'background-color', newval )
		})
	})

	wp.customize( 'background_image', function( value ) {
		value.bind( function( newval ) {
			if( newval === '' || newval === null || typeof newval === 'undefined' ) {
				$( 'html' ).css( 'background-image', 'none' );
			}
			else {
				$( 'html' ).css( 'background-image', 'url( ' + newval + ')' );
			}
		})
	})

	wp.customize( 'background_tiling', function( value ) {
		value.bind( function( newval ) {
			$( 'html' ).css( 'background-repeat', newval )
		})
	})


	wp.customize( 'content_background', function( value ) {
		value.bind( function( newval ) {
			$( '#siteContent, .layout-property-flyer, .layout-property-flyer .post-content' ).css( 'background-color', newval )
			$( '.layout-property-card, .layout-property-minicard, .carousel, .pagination .page-numbers' ).css( 'background-color', $.xcolor.darken( newval, 1, 12 ) )
			$( '#siteContent input[type="text"],#siteContent input[type="password"],#siteContent input[type="date"],#siteContent input[type="datetime"],#siteContent input[type="datetime-local"],#siteContent input[type="month"],#siteContent input[type="week"],#siteContent input[type="email"],#siteContent input[type="number"],#siteContent input[type="search"],#siteContent input[type="tel"],#siteContent input[type="time"],#siteContent input[type="url"],#siteContent textarea, #siteContent .customSelect, code' ).css( 'background-color', $.xcolor.darken( newval, 1, 12 ) )
			$( '.map-canvas' ).css( 'border-color', $.xcolor.darken( newval, 1, 6 ) )

			$( '#siteContent .widget ul li, #siteContent .widget_propertydetailswidget table tr td' ).css( 'border-color', $.xcolor.darken( newval, 1, 18 ) )

		})
	})





	wp.customize( 'primary_color', function( value ) {
		value.bind( function( newval ) {
			$( '.primary, .primary-links a, .content a, .widget_calendar a' ).not('.button, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a').css( 'color', newval )
			$( '#siteHeader, #headerMenu .menu > li > ul,  #headerDropdown .menu > li > ul, #siteFooter, #footerMenu .menu  > li > ul' ).css( 'border-color', newval )
			$( '.primary-background, .button, .button.primary,#siteHeader .menu .current-menu-item > a,#siteHeader .menu .current-menu-parent > a,#siteHeader .menu .current-menu-ancestor > a, #headerDropdown .menu > li, .pagination .page-numbers.current' ).css( 'background-color', newval )
			$( '.button, .button.primary' ).css( 'text-shadow', '-1px -1px 0 ' + newval )
		})
	})



	wp.customize( 'primary_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '.primary-background, .primary-background a, .primary-background h1, .primary-background h2, .primary-background h3, .primary-background h4, .primary-background h5, .primary-background h6,#siteHeader .menu .current-menu-item > a,#siteHeader .menu .current-menu-parent > a,#siteHeader .menu .current-menu-ancestor > a,#headerDropdown .menu > li, .button, .content .button, .pagination .page-numbers.current' ).css( 'color', newval )
		})
	})



	wp.customize( 'header_background_color', function( value ) {
		value.bind( function( newval ) {
			$( '#siteHeader, #headerMenu .menu > li > ul, #headerDropdown .menu > li > ul' ).css( 'background-color', newval )
		})
	})


	wp.customize( 'header_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '#siteHeader, #headerMenu .menu > li > a, #headerMenu .menu > li a, #headerDropdown .menu > li > ul li a' ).css( 'color', newval )
		})
	})



	wp.customize( 'footer_background_color', function( value ) {
		value.bind( function( newval ) {
			$( '#siteFooter' ).css( 'background-color', newval );
			$( '#siteFooter .widget ul li' ).css( 'border-color', $.xcolor.lighten( newval, 1, 12 ) )
		})
	})

	wp.customize( 'footer_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '#siteFooter h1, #siteFooter h2, #siteFooter h3, #siteFooter h4, #siteFooter h5, #siteFooter h6, #siteFooter.heading-text-color' ).css( 'color', newval )
			$( '#siteFooter, #siteFooter p' ).css( 'color', $.xcolor.lighten( newval, 4, 12 ) )
		})
	})


	wp.customize( 'footer_bar_background_color', function( value ) {
		value.bind( function( newval ) {
			$( '#footerBar, #footerMenu .menu  > li > ul' ).css( 'background-color', newval )
		})
	})


	wp.customize( 'footer_bar_text_color', function( value ) {
		value.bind( function( newval ) {
			$( '#footerBar, #footerBar a, #footerBar .menu > li > a, #footerBar .menu > li a' ).css( 'color', newval )
		})
	})


	wp.customize( 'footer_bar_text', function( value ) {
		value.bind( function( newval ) {
			$( '#footerText' ).html( newval );
		})
	})







} )( jQuery );