;(function ($, window, undefined) {
	var $page_template = $('#page_template');
	var post_id = $( '#post_ID' ).val();
	var $options_container = $( '#bshPostOptions' );

	$page_template.on( 'change', function(){
		addLoader();
		$.ajax({
			url: ajaxurl,
			type: 'post',
			dataType: 'json',
			data: {
				action: 'show_post_options',
				post_ID: post_id,
				template: $page_template.val(),
			},
			success: function( response ) {
				if( response.type === 'success' ) {
					$options_container.find( '.inside' ).html( response.options );
					$options_container.find( 'h3.hndle span' ).html( response.args.title );
					$('#bshPostOptions').show();
				}
				if( response.type === 'nooptions' ) {
					$('#bshPostOptions').hide();
				}
				removeLoader();
			}
		});
	})

	$('.redactor').redactor({
		buttons: ['html', '|', 'bold', 'italic', 'deleted', '|',
'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
 'link', '|',
'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule']

	});

	$( '#bshMenu li' ).live( 'click', function() {
		var index = $(this).index();

		switchToGroup( index );
	})

	$('.datetimepicker').each( function() {
		$(this).datetimepicker({
			dateFormat: 'd MM, yy',
			altField: $(this).next(),
			altFieldTimeOnly: false,
			altFormat: 'yy-mm-dd'
		});
	})

	$('.datetimepicker').on( 'change', function() {
		if( $(this).val() === '' ) {
			$(this).next().val( '' );
		}
	})

	$('.checkAll').live( 'click', function() {
		$(this).parents( '.option:first' ).find( 'tr' ).find( 'td:first input[type="checkbox"]' ).attr( 'checked', 'checked' )
	})

	$('.checkNone').live( 'click', function() {
		$(this).parents( '.option:first' ).find( 'tr' ).find( 'td:first input[type="checkbox"]' ).removeAttr( 'checked' )
	})


	function switchToGroup( index ) {
		$( '#bshMenu li' ).removeClass('active');
		$( '#bshOptions section' ).removeClass('active');

		$( '#bshMenu li' ).eq(index).addClass('active');
		$( '#bshOptions section' ).eq(index).addClass('active');
	}


	function addLoader() {
		$('#bshLoad').fadeIn( 400 );
	}

	function removeLoader() {
		$('#bshLoad').fadeOut( 400 );
	}


	function reorder_options() {
		jQuery( '.key-value-option' ).each( function( index ) {
			var i = index + 1;
			jQuery(this).find( 'input:first' ).attr( 'id', '_est_property_name_' + i );
			jQuery(this).find( 'input:last' ).attr( 'id', '_est_property_value_' + i );

			jQuery(this).find( 'input:first' ).attr( 'name', '_est_property_custom[' + i + '][name]' );
			jQuery(this).find( 'input:last' ).attr( 'name', '_est_property_custom[' + i + '][value]' );

			jQuery(this).find( 'label:first' ).attr( 'for', '_est_property_name_' + i );
			jQuery(this).find( 'label:last' ).attr( 'for', '_est_property_value_' + i );
		})
	}


// Uploading files
		var file_frame;

		jQuery('.bshUpload').live('click', function( event ){
			var id = $(this).attr('data-id');
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
			file_frame.open();
			return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery( this ).data( 'uploader_title' ),
				button: {
					text: jQuery( this ).data( 'uploader_button_text' ),
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});

			file_frame.on( 'select', function() {
				attachment = file_frame.state().get('selection').first().toJSON();
				$( '#' + id ).val( attachment.url )
				$( 'img[data-id="' + id + '"]').attr( 'src', attachment.url )
			});

			// Finally, open the modal
			file_frame.open();
		});



		$(document).on( 'click', '#add-key-value-option', function() {
			var template = $( '.key-value-option:first' ).clone();
			template.find( 'input' ).val( '' );
			template.appendTo( '.key-value-options' );
			reorder_options();
			return false;
		})

		$(document).on( 'click','.remove-key-value-option', function() {
			var count = $('.key-value-option').length;
			var element = $(this).parents( '.key-value-option:first' );

			if( count === 1 ) {
				element.fadeOut( function() {
					element.find( 'input' ).val( '' );
					element.fadeIn();
				});
			}
			else {
				element.fadeOut( function() {
					element.remove();
				});
			}
			reorder_options();
			return false;
		})



})(jQuery, this);