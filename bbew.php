<?php
/*
Plugin Name: BB Editing Workflow
Description: An add on for Beaver Builder that requires some roles to submit a desription of changes, preventing them from publishing directly.
Version: 1.2
Author: Cory Piña
Author URI: http://thisiscory.com
*/

// Required for checking current user's login status
include_once(ABSPATH . 'wp-includes/pluggable.php');

/* Check if Beaver Builder is activated */
if ( class_exists('FLBuilderModel') ) {

    // Define email for notifications
    define( 'WEBADMIN', 'ADMIN_EMAIL@DOMAIN.COM');

    // Define the roles that have publishing permission
    define( 'BBPERMISSION', array( 'administrator') );

    define( 'BBEWASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );
    define( 'BBEWDIR', plugin_dir_path(__FILE__) );
    
    
    // Includes
    foreach(glob( BBEWDIR . "includes/[!_]*.php") as $file){
        include $file;
    }

} // if (class_exists)

