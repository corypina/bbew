<?php

/**
 * Clear draft-related meta fields
 */

add_action( 'fl_builder_after_save_layout', 
    function( $post_id, $publish, $data, $settings ){
        // If page is fully published,
        // remove lingering draft-related meta fields
        BBEWorkflow::delete_draft_meta( $post_id );
}, 10, 4);

/**
 * Process the admin notice form
 */

add_action( 'admin_post_draft_submitted', function(){
    global $current_user; 
	get_currentuserinfo(); // @todo: do I need this?
	date_default_timezone_set('America/Los_Angeles'); // @todo: Set in Globals
	$date = date("F j, Y, g:i a");
	
	$name = $current_user->display_name;
	$email = $current_user->user_email;
	
	$sum = $_POST['summary'];
	$id = $_POST['post-id'];
	$url = $_POST['current-page'];
	$title = get_the_title( $id );
	$ts = $_POST['time-sensitive-change'];

	// calls fedu_sendDraftNotes() to send 
	// notifications to Admin and back to user
	if ( BBEWorkflow::send_notice( $sum, $url, $title, $ts, $name, $email, $date ) ) {

		// Update post meta with notification data
		update_post_meta( $id, 'admin_notified_of_draft', $date );
		update_post_meta( $id, 'draft_changes_summary', $sum );
		update_post_meta( $id, 'draft_changes_user', $current_user->display_name );

		// redirect with ?done for affirmative notification in browser
		wp_redirect( $url . '?done' );
	} else {
		// redirect with ?nomail for negative notification in browser
		wp_redirect( $url . '?nomail' );
	}
});

/**
 * Remove the Publish button if user cannot publish
 */

add_action( 'wp_enqueue_scripts', function(){
    if ( ! BBEWorkflow::user_can_publish() ) :
    wp_enqueue_style( 'hide_bb_publish', BBEWASSETS . 'hide-bb-publish-button.css' );
    endif;
}, 2000 );

 /**
  * Enqueue draft notice form script/style if necessary
  */

add_action( 'wp_enqueue_scripts', function(){
    // If user is logged in
    if ( is_user_logged_in() ) {
        // load draft notification CSS and JS
        wp_enqueue_style( 'draft-notice', BBEWASSETS . 'draft-notice.css', '', '0.1' );
        wp_enqueue_script( 'draft_action', BBEWASSETS . 'draft-notice.js', '', '0.1', true );
    }
});