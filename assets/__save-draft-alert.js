/* Alert user that an email will be sent to Admin */

(function( jQuery ) {
    'use strict';
     
    // jQuery's DOM-ready event-handler
    jQuery(function() {
     
        /**
         * Listen for the 'click' event on the button identified
         * with the '[data-action=draft]' attribute.
         * 
         * When the user clicks on it, display an alert dialog.
         */
        jQuery( '[data-action="draft"]' ).bind( 'click', function( evt ) {
			// alert( 'Your changes have been saved, and will be published after review.' +
			//'\n\nSend any questions to websupport@fuller.edu.' );
			var summary = prompt('Please summarize the changes you made.');
			var data = { 'action' : 'sendDraftNotice', 'summary' : summary };
			jQuery.post( '/wp-admin/admin-ajax.php', data, function(response) {
				console.log(response);
			});
        });
     
    });
 
})( jQuery );