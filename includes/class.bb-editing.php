<?php

class BBEWorkflow {

    /**
     * Check if current user can publish
     * 
     * @return bool
     */

     static public function user_can_publish() {
         $permission = BBPERMISSION;
         if ( is_user_logged_in() ) {
            $user = wp_get_current_user();
            $roles = $user->roles;
            $result = array_intersect($permission, $roles);
            if ( empty($result) ) {
                return false;
            } else { return true; }
        } else { return false; }
     }

    /**
     * Does the current page page have a draft in process?
     * 
     * @return bool
     */
    
    static public function has_draft() {
        global $post;
        if ( is_page() ) {
            $published = serialize( FLBuilderModel::get_layout_data('published', $post->ID) );
            $draft = serialize( FLBuilderModel::get_layout_data('draft', $post->ID) );
        
            if ( $published !== $draft) {
                return true;
            }  
            return false;
        }
        return null;
    }

    /**
     * Delete draft meta
     * 
     * @var string $post_id
     */

    static public function delete_draft_meta( $post_id ) {
        delete_post_meta( $post_id, 'admin_notified_of_draft' );
	    delete_post_meta( $post_id, 'draft_changes_summary' );
	    delete_post_meta( $post_id, 'draft_changes_user' );
    }

    /**
     * Send draft notices to the Admin
     * 
     * @var string  $sum    Summary of edits made, supplied by user
     * @var string  $url    URL of page edited by user
     * @var string  $title  Title of page edited by user
     * @var string  $ts     Are the edits marked as time-sensitive  
     * @var string  $name   Editing user's name
     * @var string  $email  Editing user's email
     * @var string  $date   Date the edit was submitted by the user
     * 
     * @return bool
     */

    public static function send_notice( $sum, $url, $title, $ts, $name, $email, $date ) {

        $sub = 'Draft for Review: ' . $title;
    
        // Headers
        $headers[] = 'From: ' . $name . '<' . $email . '>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        
        // Message body
        $msg = "A draft has been submitted for review.";
            if ( $ts == 'yes' ) {
                $msg .= " It has been mark as <strong>Time Sensitive</strong>.";
            }
            $msg .= "<br/><br/><strong>By:</strong> " . $name . " (" . $email . ")<br/>";
            $msg .= "<strong>Link:</strong> " . home_url() . $url . "<br/>";
            $msg .= "<strong>On:</strong> " . $date . "<br/><br/>";
            $msg .= "<strong>Summary of Changes:</strong><br/>" . stripslashes($sum);
        
        // Send Admin email
        if ( wp_mail( WEBADMIN, $sub, $msg, $headers ) ) {
            return true;
        } else {
            return false;
        }
    }
}