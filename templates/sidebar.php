<?php 
	
	// Show the sidebar	
	dynamic_sidebar('sidebar-primary');
	
	
	if( current_user_can('edit_others_pages') ) {  
	    
	    // stuff here for user roles that can edit pages: editors and administrators
		edit_post_link('Edit Page', '<p>', '</p>');
	}
?>
