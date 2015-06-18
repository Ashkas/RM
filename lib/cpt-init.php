<?php

	
////////////* Works CUSTOM POSTS *//////////////

/* Add custom post type for Works */
function works_cpt_init() {
  $labels = array(
    'name' => _x('Works', 'post type general name'),
    'singular_name' => _x('Work', 'post type singular name'),
    'add_new' => _x('Add Work', 'staff'),
    'add_new_item' => __('Add new work'),
    'edit_item' => __('Edit Work'),
    'new_item' => __('New Work'),
    'all_items' => __('All Works'),
    'view_item' => __('View Work'),
    'search_items' => __('Search Works'),
    'not_found' =>  __('No Works found'),
    'not_found_in_trash' => __('No Works found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Works'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
	'has_archive'   => true,
	'rewrite' => array('slug' => 'works'),
    'capability_type' => 'post',
    'supports' => array( 'title', 'author', 'revisions'  ),
    // Set the available taxonomies here
    //'taxonomies' => array('post_tag') 
  );
  
  register_post_type('work',$args); /* staff is the legacy id that is now used for Our Team */
}
add_action( 'init', 'works_cpt_init' );

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

// Generate Title and Slug from ACF field
// https://teamtreehouse.com/forum/collocating-acf-fields-to-post-title

/*
function my_post_title_updater( $post_id ) {
	if ( get_post_type( $post_id ) == 'work' ) {

		$my_post = array();
		$my_post['ID'] = $post_id;
		$my_post['post_title'] = get_field( 'c_title', $post_id );
		
		wp_update_post( $my_post );

	}
}
*/
 
// run after ACF saves the $_POST['fields'] data
//add_action('acf/save_post', 'my_post_title_updater', 20);

//Auto update slug to be post title
function myplugin_update_slug( $data, $postarr ) {
    if ( !in_array( $data['post_status'], array( 'draft', 'pending', 'auto-draft' ) ) ) {
        $data['post_name'] = wp_unique_post_slug(sanitize_title( $data['post_title'] ), $postarr['ID'], $data['post_status'], $data['post_type'], $data['post_parent'] );
    }
    return $data;
}
add_filter( 'wp_insert_post_data', 'myplugin_update_slug', 99, 2 );


////////////* Series TAXONOMY *//////////////

add_action( 'init', 'create_series_taxonomy', 0 );

function create_series_taxonomy() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Series', 'taxonomy general name' ),
    'singular_name' => _x( 'Series', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Seriess' ),
    'all_items' => __( 'All Seriess' ),
    'parent_item' => __( 'Parent Series' ),
    'parent_item_colon' => __( 'Parent Series:' ),
    'edit_item' => __( 'Edit Series' ), 
    'update_item' => __( 'Update Series' ),
    'add_new_item' => __( 'Add new Series' ),
    'new_item_name' => __( 'New Series name' ),
    'menu_name' => __( 'Series' ),
  ); 	

  register_taxonomy('series',array('work'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'series'), 
  ));
  
}
