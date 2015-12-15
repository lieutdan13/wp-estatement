function frequency(arr) {
    var a = [], b = [], prev;

    arr.sort();
    for ( var i = 0; i < arr.length; i++ ) {
        if ( arr[i] !== prev ) {
            a.push(arr[i]);
            b.push(1);
        } else {
            b[b.length-1]++;
        }
        prev = arr[i];
    }

    return [a, b];
}

	function filter_properties_ajax( page ) {
		var form = jQuery( '#filterPageSearch' );
		serialized = form.serializeArray();
		serializedString = JSON.stringify(serialized)

		if(  typeof(page) == 'undefined' || page == '') {
			page = 1;
		}
		jQuery.ajax({
			url: estAjax.ajaxurl,
			type: 'post',
			beforeSend: function() {
				jQuery( '#filter' ).prepend( '<div id="filterLoad"></div>' );
			},
			data: {
				page_id: jQuery( '#filter' ).attr('data-page-id'),
				args: jQuery('#fiterArgs').html(),
				details: jQuery('#fiterDetails').html(),
				search: jQuery('#fiterSearch').html(),
				options: jQuery('#fiterOptions').html(),
				form: serializedString,
				page: page,
				action: 'est_get_filter_content'
			},
			success: function( result ) {

				jQuery( '#filter' ).html( result)
			}
		})

		return false;
	}


jQuery(document).ready( function( $ ){
	var detectSliderFilter = '';

	function determine_if_ajax_sort() {
		clearTimeout( detectSliderFilter );
		detectSliderFilter = setTimeout( "filter_properties_ajax()", 500 );
	}

	var form = $( '#filterPageSearch' );

	$( '#propertyFilter' ).isotope({
		itemSelector : '.property',
		layoutMode : 'straightDown'
	});

	$.each( form.find('.range'), function() {
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
		   ,step: ( max - min < 100 ) ? 1 : 20
		   ,slide: function(){
		      var values = $(this).val();
		      $values.find('.min .value').html( number_format( parseFloat( values[0] ), 0, estAjax.decimal_separator, estAjax.thousand_separator ) );
		      $values.find('.max .value').html( number_format( parseFloat( values[1] ), 0, estAjax.decimal_separator, estAjax.thousand_separator ) );

		      if( $('#filterPageSearch').attr('data-type') == 'paginate' ) {
				  determine_if_ajax_sort();
		      }
		      else {
				  filter_properties()
		      }
		   }
		   ,serialization : {
		   	to: [ name + '[min]', name + '[max]' ],
		   	resolution: 1
		   }
		});

		if( current_min != '' && current_max != '' ) {
			$(this).val([current_min, current_max])
			$values.find('.min .value').html( number_format( parseFloat( current_min ), 0, estAjax.decimal_separator, estAjax.thousand_separator ) );
		    $values.find('.max .value').html( number_format( parseFloat( current_max ), 0, estAjax.decimal_separator, estAjax.thousand_separator ) );
		}

	})



	form.find( 'select' ).not( '#filterPageSearch[data-type="paginate"] select' ).on( 'change', function() {
		filter_properties();
	})

	form.find( 'input[type="text"]' ).not( '#filterPageSearch[data-type="paginate"] input[type="text"]' ).on( 'keyup', function() {
		filter_properties();
	})

	$(document).on( 'change', 'input[type="checkbox"]', function() {
		parent = $(this).parents( '#filterPageSearch[data-type="paginate"]' );
		if( parent.length == 0 ) {
			filter_properties();
		}
	})



	$(document).on( 'change', '#filterPageSearch[data-type="paginate"] select', function() {
			filter_properties_ajax();
	})

	form.find( '#filterPageSearch[data-type="paginate"] input[type="text"]' ).on( 'keyup', function() {
			filter_properties_ajax();
	})

	$(document).on( 'change', 'input[type="checkbox"]', function() {
		parent = $(this).parents( '#filterPageSearch[data-type="paginate"]' );
		if( parent.length == 1 ) {
			filter_properties_ajax();
		}
	})





	function filter_properties() {

		serialized = form.serializeArray();

		options = [];
		$.each( serialized, function( i, item ) {
			item = $(this);

			item = item[0];
			value = item.value;

			filter_type = $( '*[name="'+item.name+'"]:first' ).parents( '.checkboxes' ).data('type');

			if( typeof item.name == 'undefined' || item.name == null ) {
				item.name = '';
			}

			if( value != '' && value != null && typeof value != 'undefined' ) {
				value = value.replace(" ","-");
			}

			if( item.name.substr( -2 ) == '[]' ) {
				name = item.name.substr( 0, item.name.length - 2 );
				if( !( name in options ) ) {
					options[name] = [];
					options[name]['type'] = 'array',
					options[name]['values'] = [];
					options[name]['values'].push( value )
				}
				else {
					options[name]['values'].push(value)
				}
				options[name]['filter_type'] = filter_type;
			}
			else if( item.name.substr( -5 ) == '[min]' ) {
				name = item.name.substr( 0, item.name.length - 5 );
				if( !( name in options ) ) {
					options[name] = [];
					options[name]['type'] = 'range';
				}
				options[name]['filter_type'] = filter_type;
				options[name]['min'] = value
			}
			else if( item.name.substr( -5 ) == '[max]' ) {
				name = item.name.substr( 0, item.name.length - 5 );
				if( !( name in options ) ) {
					options[name] = [];
					options[name]['type'] = 'range';
				}
				options[name]['filter_type'] = filter_type;
				options[name]['max'] = value
			}
			else {
				name = item.name;
				if( !( name in options ) ) {
					options[name] = [];
					options[name]['type'] = 'value';
					options[name]['value'] = value
					options[name]['filter_type'] = filter_type;
				}

			}


		})


		property_ids = [];
		i = 0;
		for (var name in options ) {
			var option = options[name];
			if( option.type === 'value' ) {
				if( option.value == '' ) {
					properties = $( '.property' );
				}
				else {
					classname = '.property.filter_' + name + '-' + option.value;
					properties = $( classname );
				}
				property_ids[i] = [];
				$.each( properties, function() {
					property_ids[i].push( $(this).attr( 'data-id' ) )
				})
			}
			else if( option.type === 'array' ) {
				property_array = []

				if( option.filter_type == 'or' ) {
					$.each( option.values, function( i, value ) {
						classname = '.property.filter_' + name + '-' + value
						properties = $( classname );
						$.each( properties, function() {
							property_array.push( $(this).attr( 'data-id' ) )
						})
					})
				}
				else {
					classname = '';
					$.each( option.values, function( i, value ) {
						classname = classname + '.property.filter_' + name + '-' + value
					})

					properties = $( classname );
					$.each( properties, function() {
						property_array.push( $(this).attr( 'data-id' ) )
					})

				}

				var property_array = property_array.filter(function(itm,i,property_array){
				    return i==property_array.indexOf(itm);
				});


				property_ids[i] = property_array;
			}
			else if( option.type === 'range' ) {
				property_array = []
				min = parseFloat( option.min );
				max = parseFloat( option.max );
				$.each( $( '#propertyFilter .property' ), function() {
					value = parseFloat( $(this).attr( 'data-' + name ) );
					if( value >= min && value <= max ) {
						property_array.push( $(this).attr( 'data-id' ) )
					}
				})
				property_ids[i] = property_array;
			}
			i++;
		}

		var has_zero = 0;

		$.each( property_ids, function() {
			if( this.length == 0 ) {
				has_zero = 1;
			}
		})


		properties = [];
		freq = 0;
		$.each( property_ids, function( i, ids ) {
			if( ids != '' && ids != null && typeof ids != 'undefined' ) {
				freq++;
			}
			properties = properties.concat( ids );
		})

		properties = frequency(properties);

		properties_to_show = [];

		for ( var i in properties[1] ) {
			if( properties[1][i] == freq ) {
				properties_to_show.push( '.post-' + properties[0][i] );
			}
		}

		properties_to_show = properties_to_show.join( ',' )
		if( properties_to_show == '' || properties_to_show == null || typeof properties_to_show == 'undefined' || has_zero == 1 ) {
			properties_to_show = '.noneatall';
			$('#filterNoResults').fadeIn()
		}
		else {
			$('#filterNoResults').fadeOut()
		}

		$( '#propertyFilter' ).isotope({ filter : properties_to_show })

	}

	$( document ).on( 'click', '#filter .pagination a', function() {
		current = parseInt( $( '#filter .pagination .current' ).html() )
		if( $(this).hasClass( 'next' ) ) {
			next = current + 1;
		}
		else if( $(this).hasClass( 'next' ) ) {
			next = current - 1;
		}
		else {
			next = parseInt( $( this ).html() );
		}

		filter_properties_ajax( next );

		return false;
	})



})

