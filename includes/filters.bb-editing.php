<?php

/**
 * Force refresh of the page after "Publish" is clicked
 * Required for immediately showing notices to user
 */

add_filter('fl_builder_should_refresh_on_publish','__return_true');

/**
 * Prevent non-publishers from taking over a post being edted
 */

add_filter( 'override_post_lock', function(){
    if ( ! BBEWorkflow::user_can_publish() ) {
		return false;
	} else {
		return true;
	}
} );