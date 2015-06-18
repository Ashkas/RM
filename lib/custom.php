<?php
	
// LIMIT POST REVISION to just 5, to help lessen DB bloat
define( 'WP_POST_REVISIONS', 5);

// Add custom CSS to admin header
function custom_admin_css() {

	$template_directory = get_template_directory_uri();
		
	// CSS
	echo "<link rel='stylesheet' href='".$template_directory."/dist/styles/admin.css' type='text/css' media='all' />";

}

if (is_admin()) add_action('admin_head', 'custom_admin_css');