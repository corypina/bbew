jQuery( "#send-draft-notice" ).click(function() {
	jQuery( "#draft-notice-form" ).toggle( 400 );
	jQuery( '#draft-notice' ).toggle( 400 );
});

jQuery( "#draft-notice-cancel" ).click(function() {
	jQuery( "#draft-notice-form" ).toggle( 400 );
	jQuery( '#draft-notice' ).toggle( 400 );
});

jQuery( "#draft-show-summary" ).click(function() {
	var summary = jQuery("#draft-changes-summary");
	var isVisible = summary.is(':visible');
	
	if ( isVisible == true ) {
		summary.hide( 400 );
		jQuery("#draft-show-summary").html("Show Summary");
	} 
	else if ( isVisible == false ) {
		summary.show( 400 );
		jQuery("#draft-show-summary").html("Hide Summary");
	}
});

function validateDraftForm() {
	var x = document.forms["draft-form"]["summary"].value;
	if ( x == '' ) {
		alert('Please include a summary of changes.');
		return false;
	}
}