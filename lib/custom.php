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

// Change it so the default layout view for works for none administrators is single
// from http://wordpress.stackexchange.com/questions/4552/how-do-i-force-a-single-column-layout-in-screen-layout
if(!current_user_can('manage_options')):
	function so_screen_layout_columns( $columns ) {
	    $columns['post'] = 1;
	    return $columns;
	}
	add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );
	
	function so_screen_layout_post() {
	    return 1;
	}
	//There is a filter called get_user_option_meta-box-order_{$page} where $page is the name of the post type.
	add_filter( 'get_user_option_screen_layout_work', 'so_screen_layout_post' );
endif;