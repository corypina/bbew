<?php

## Remove draft notices in backend

/*add_action( 'wp_before_admin_bar_render', function(){
    global $wp_admin_bar;
    global $post;
    
    if ( ! is_admin() ) :
		// If it's front end, check if there's a draft notification on file
		$drafted = get_post_meta( $post->ID, 'admin_notified_of_draft', true );
	else:
		// If it's the backend, forget about draft notifications
		$drafted = false;
	endif;
} );*/

## Remove page builder and edit links if necessary

add_action( 'wp_before_admin_bar_render', function(){
    global $wp_admin_bar;
    global $post;

    $drafted = !is_admin() && get_post_meta($post->ID, 'admin_notified_of_draft', true) ? true : false;
    /*if ( ! is_admin() ) :
		// If it's front end, check if there's a draft notification on file
		$drafted = get_post_meta( $post->ID, 'admin_notified_of_draft', true );
	else:
		// If it's the backend, forget about draft notifications
		$drafted = false;
	endif;*/

    // Remove Edit button
    if ( ! BBEWorkflow::user_can_publish() ) :
        $wp_admin_bar->remove_menu('edit');
    endif;
    
    if ( ! BBEWorkflow::user_can_publish() && $drafted ) :
		$wp_admin_bar->remove_menu('fl-builder-frontend-edit-link');
    endif;

} );