<?php

	
////////////* Works CUSTOM POSTS *//////////////

/* Add custom post type for Works */
/*
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
//}

// add_action( 'init', 'works_cpt_init' );

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
/*
function myplugin_update_slug( $data, $postarr ) {
    if ( !in_array( $data['post_status'], array( 'draft', 'pending', 'auto-draft' ) ) ) {
        $data['post_name'] = wp_unique_post_slug(sanitize_title( $data['post_title'] ), $postarr['ID'], $data['post_status'], $data['post_type'], $data['post_parent'] );
    }
    return $data;
}
add_filter( 'wp_insert_post_data', 'myplugin_update_slug', 99, 2 );
*/


////////////* Series TAXONOMY *//////////////

/*
add_action( 'init', 'create_series_taxonomy', 0 );

function create_series_taxonomy() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Series', 'taxonomy general name' ),
    'singular_name' => _x( 'Series', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Series' ),
    'all_items' => __( 'All Series' ),
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
*/

////////////* Location Made TAXONOMY *//////////////

/*
add_action( 'init', 'create_location_made_taxonomy', 0 );

function create_location_made_taxonomy() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Location Made', 'taxonomy general name' ),
    'singular_name' => _x( 'Location Made', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Locations' ),
    'all_items' => __( 'All Locations Made' ),
    'parent_item' => __( 'Parent Location Made' ),
    'parent_item_colon' => __( 'Parent Location Made:' ),
    'edit_item' => __( 'Edit Location Made' ), 
    'update_item' => __( 'Update Location Made' ),
    'add_new_item' => __( 'Add new Location Made' ),
    'new_item_name' => __( 'New Location Made name' ),
    'menu_name' => __( 'Location Made' ),
  ); 	

  register_taxonomy('location_made',array('work'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'location'), 
  ));
  
}
*/

////////////* Support TAXONOMY *//////////////

/*
add_action( 'init', 'create_support_taxonomy', 0 );

function create_support_taxonomy() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Support', 'taxonomy general name' ),
    'singular_name' => _x( 'Support', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Support' ),
    'all_items' => __( 'All Support entries' ),
    'parent_item' => __( 'Parent Support Entry' ),
    'parent_item_colon' => __( 'Parent Support:' ),
    'edit_item' => __( 'Edit Support entry' ), 
    'update_item' => __( 'Update Support' ),
    'add_new_item' => __( 'Add new Support' ),
    'new_item_name' => __( 'New Support' ),
    'menu_name' => __( 'Support' ),
  ); 	

  register_taxonomy('support',array('work'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'support'), 
  ));
  
}
*/


////////////* Collection Location TAXONOMY *//////////////

/*
add_action( 'init', 'create_collection_location_taxonomy', 0 );

function create_collection_location_taxonomy() 
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => _x( 'Collection Location', 'taxonomy general name' ),
    'singular_name' => _x( 'Collection Location', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Collection Locations' ),
    'all_items' => __( 'All Collection Locations' ),
    'parent_item' => __( 'Parent Collection Location' ),
    'parent_item_colon' => __( 'Parent Collection Location:' ),
    'edit_item' => __( 'Edit Collection Location' ), 
    'update_item' => __( 'Update Collection Location' ),
    'add_new_item' => __( 'Add new Collection Location' ),
    'new_item_name' => __( 'New Collection Location name' ),
    'menu_name' => __( 'Collection Location' ),
  ); 	

  register_taxonomy('collection_location',array('works'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'collection-location'), 
  ));
  
}
*/

////////////* Keywords TAXONOMY *//////////////

/*
add_action( 'init', 'create_keywords_taxonomy', 0 );

function create_keywords_taxonomy() 
{
  // Add new taxonomy, make it non-hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Keywords', 'taxonomy general name' ),
    'singular_name' => _x( 'Keyword', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Keywords' ),
    'all_items' => __( 'All Keywords' ),
    'parent_item' => __( 'Parent Keyword' ),
    'parent_item_colon' => __( 'Parent Keyword:' ),
    'edit_item' => __( 'Edit Keyword' ), 
    'update_item' => __( 'Update Keywords' ),
    'add_new_item' => __( 'Add new Keyword' ),
    'new_item_name' => __( 'New Keyword name' ),
    'menu_name' => __( 'Keywords' ),
  ); 	

  register_taxonomy('keywords',array('work'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'keywords'), 
  ));
  
}
*/