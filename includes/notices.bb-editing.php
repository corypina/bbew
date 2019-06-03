<?php

/**
 * Controls the notices shown to logged in users
 * regarding draft status
 */

add_action( 'fl_before_top_bar', function(){
    global $post;
	
	// A. Logged in? Front end? Has unpublished draft?
	// Tally-ho! 
	if ( is_user_logged_in() && !FLBuilderModel::is_builder_active() && BBEWorkflow::has_draft() ) {
		
		// A.1 User can publish
		if ( BBEWorkflow::user_can_publish() ) {
			
			// A.1.1 Admin has been notified of draft
			if ( get_post_meta( $post->ID, 'admin_notified_of_draft', true ) ) { ?>
				<div id="draft-notice"><i class="fa fa-exclamation-circle"></i> This page has an unpublished draft ready for review. <a href="?fl_builder">Open the Page Builder</a> to see the changes.</div>
            <?php }
            
			// A.1.2 Not yet submitted to admin
			else { ?>
				<div id="draft-notice"><i class="fa fa-exclamation-circle"></i> This page has an unpublished draft. It has <u><strong>not</strong></u> been submitted for review.</div>
			<?php }
 			
		} // end A.1
		
		// A.2 User cannot publish
		else {
			
			// A.2.1 Error in sending mail.
			if ( isset($_GET['nomail']) ) { ?>
				<div id="draft-notice"><i class="fa fa-exclamation-circle"></i> Something went wrong, and your message didn't go through. Please contact <?php echo WEBADMIN ?></div>
			<?php }
			
			else if ( isset($_GET['done']) ) { ?>
				<div id="draft-notice" class="done"><i class="fa fa-thumbs-up"></i> Your changes were submitted, and the page is locked for editing until reviewed.</div>
			<?php }
			
			// A.2.2 No Error. Now check if already notified.
			else {
				
				// A.2.2.1 Admin was already notified
				if ( get_post_meta( $post->ID, 'admin_notified_of_draft', true ) ) { ?>
					<div id="draft-notice" class="notified"><i class="fa fa-exclamation-circle"></i> This page is locked from editing until submitted changes are reviewed.</div>
				<?php } // end A.2.2.1
				
				// A.2.2.2 Admin not yet notified
				else { ?>
					<div id="draft-notice"><i class="fa fa-exclamation-circle"></i> There is an unpublished draft of this post. <a id="send-draft-notice" href="#">Click here</a> if it's ready for review.</div>
					<div id="draft-notice-form" style="display:none;">
						<form name="draft-form" action="/wp-admin/admin-post.php" method="POST" onsubmit="return validateDraftForm()">
							<input type="hidden" name="action" value="draft_submitted">
							<input type="hidden" name="post-id" value="<?php echo $post->ID; ?>">
							<input type="hidden" name="current-page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
							<div class="summary-label">Please describe the changes made to this page (Required).</div>
							<textarea name="summary"></textarea>
							<div class="summary-time-sensitive"> 
								Is this is a time-sensitive change?<br/>
								<input name="time-sensitive-change" type="radio" value="yes"> Yes<br/>
								<input name="time-sensitive-change" type="radio" value="no"> No
							</div>
							<a id="draft-notice-cancel" class="" href="#">Cancel</a>
							<button type="Submit" id="draft-notice-send" class="" href="#">Send</button>
						</form>
					</div>
				<?php } // end A.2.2.2
				
			} // end A.2.2
			
		} // end A.2
		
	} // end A
	
	// B — Show unpublished draft notice in Builder interface
	else if ( is_user_logged_in() && FLBuilderModel::is_builder_active() && BBEWorkflow::has_draft() ) {
		
		// B.1 If already subitted for review
		if ( get_post_meta( $post->ID, 'admin_notified_of_draft', true ) ) { ?>
		<div id="draft-notice"><i class="fa fa-exclamation-circle"></i> You are viewing an unpublished draft of this page. It has been submitted for review. <?php 
			
			// if Summary available show link
			if ( get_post_meta( $post->ID, 'draft_changes_summary', true ) ) { ?>
				<a id="draft-show-summary" href="#">Show Summary</a>
			<?php } ?>
		</div><?php 
			
			// B.1.1 If a summary is available
			if ( get_post_meta( $post->ID, 'draft_changes_summary', true ) ) { ?>
				<div id="draft-changes-summary" style="display:none;">
					<p class="draft-summary-title">Summary of Changes</p>
					<p><?php echo get_post_meta( $post->ID, 'draft_changes_summary', true ); ?></p>
                    <p>— <em><?php echo get_post_meta( $post->ID, 'draft_changes_user', true ); ?></em></p>
				</div>
			<?php } // end B.1.1
			
		} // end B.1
		
		// B.2 Not yet submitted for review
		else { ?>
			<div id="draft-notice"><i class="fa fa-exclamation-circle"></i> You are viewing an unpublished draft of this page.</div>
		<?php } // end B.2
		
	} // end B
	
	// C - Do nothing
	else {
		return;
	} // end C
});