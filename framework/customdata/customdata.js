( function( $ ) {

var $addForm = $( '#add-customdata' );
var $addFormType = $( '#add-customdata-type' );
var $addFormOptionsContainer = $( '#add-customdata-options' );
var $addFormOptions = $( '#add-customdata-options .options' );
var $addFormAddOption = $( '#add-customdata-add-option' );

$( document ).on( 'change', '#add-customdata-type', function(){
	var value = $addFormType.val();
	if( value === 'dropdown' || value === 'checkbox' || value === 'radio' ) {
		$addFormOptionsContainer.show();
	}
	else {
		$addFormOptionsContainer.hide();
	}
})

$( document ).on( 'click', '#add-customdata-add-option', function() {
	var element = $addFormOptions.find( '.option:first' ).clone();
	element.find('input').val( '' );
	$addFormOptions.append( element );

	$.each( $addFormOptions.find('.option'), function(i) {
		$(this).find( 'input:first' ).attr( 'name', 'options['+i+'][name]' )
		$(this).find( 'input:last' ).attr( 'name', 'options['+i+'][value]' )
	})

	return false;
})

$( document ).on( 'click', '#open-advanced-options', function() {
	$( '#advanced-options' ).slideToggle();

	return false;
})




} )( jQuery );