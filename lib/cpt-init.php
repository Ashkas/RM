<?php

	
////////////* Works CUSTOM POSTS *//////////////

add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_cpts() {
	$labels = array(
		"name" => "Works",
		"singular_name" => "Work",
		"menu_name" => "Works",
		"all_items" => "All Works",
		"add_new" => "Add New",
		"add_new_item" => "Add New Work",
		"edit" => "Edit",
		"edit_item" => "Edit Work",
		"new_item" => "New Work",
		"view" => "View",
		"view_item" => "View Work",
		"search_items" => "Search Work",
		"not_found" => "No Works Found",
		"not_found_in_trash" => "No Works found in Trash",
		"parent" => "Parent Work",
		);

	$args = array(
		"labels" => $labels,
		"description" => "A work of art",
		"public" => true,
		"show_ui" => true,
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "work", "with_front" => true ),
		"query_var" => true,
				
		"supports" => array( "title", "editor", "custom-fields", "revisions", "thumbnail", "author" ),		
	);
	register_post_type( "work", $args );

// End of cptui_register_my_cpts()
}

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


////////////* TAXONOMies *//////////////

add_action( 'init', 'cptui_register_my_taxes' );
function cptui_register_my_taxes() {

	$labels = array(
		"name" => "Series",
		"label" => "Series",
		"menu_name" => "Series",
		"all_items" => "All Series",
		"edit_item" => "Edit Series",
		"view_item" => "View Series",
		"update_item" => "Update Series Name",
		"add_new_item" => "Add New Series",
		"new_item_name" => "New Series Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Series",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove series",
		"choose_from_most_used" => NULL,
		"not_found" => "No series found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Series",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'series', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "series", array( "work" ), $args );


	$labels = array(
		"name" => "Keywords",
		"label" => "Keywords",
		"menu_name" => "Keywords",
		"all_items" => "All Keywords",
		"edit_item" => "Edit Keyword",
		"view_item" => "View Keyword",
		"update_item" => "Update Keyword Name",
		"add_new_item" => "Add New Keyword",
		"new_item_name" => "New Keyword Name",
		"parent_item" => "Parent Keyword",
		"parent_item_colon" => "Parent Keyword:",
		"search_items" => "Search Keywords",
		"popular_items" => "Popular Keywords",
		"separate_items_with_commas" => "Separate keywords with commas",
		"add_or_remove_items" => "Add or remove keywords",
		"choose_from_most_used" => "Choose from the most used keywords",
		"not_found" => "No keywords found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => false,
		"label" => "Keywords",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'keyword', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "keyword", array( "work" ), $args );


	$labels = array(
		"name" => "Exhibitions",
		"label" => "Exhibitions",
		"menu_name" => "Exhibitions",
		"all_items" => "All Exhibitions",
		"edit_item" => "Edit Exhibition",
		"view_item" => "View Exhibition",
		"update_item" => "Update Exhibition Name",
		"add_new_item" => "Add New Exhibition",
		"new_item_name" => "New Exhibition Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Exhibitions",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove exhibitions",
		"choose_from_most_used" => NULL,
		"not_found" => "No exhibitions found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Exhibitions",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'exhibition', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "exhibition", array( "work" ), $args );


	$labels = array(
		"name" => "Where Made",
		"label" => "Where Made",
		"menu_name" => "Where Made",
		"all_items" => "All Where Made",
		"edit_item" => "Edit Where Made",
		"view_item" => "View Where Made",
		"update_item" => "Update Where Made Name",
		"add_new_item" => "Add New Where Made",
		"new_item_name" => "New Where Made Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Where Made",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove where made",
		"choose_from_most_used" => NULL,
		"not_found" => "None found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Where Made",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'where-made', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "where-made", array( "work" ), $args );


	$labels = array(
		"name" => "Literature",
		"label" => "Literature",
		"menu_name" => "Literature",
		"all_items" => "All Literature",
		"edit_item" => "Edit Literature",
		"view_item" => "View Literature",
		"update_item" => "Update Literature Name",
		"add_new_item" => "Add New Literature",
		"new_item_name" => "New Literature Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Literature",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove items",
		"choose_from_most_used" => NULL,
		"not_found" => "No literature found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Literature",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'literature', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "literature", array( "work" ), $args );


	$labels = array(
		"name" => "Printer",
		"label" => "Printers",
		"menu_name" => "Printers",
		"all_items" => "All Printers",
		"edit_item" => "Edit Printer",
		"view_item" => "View Printer",
		"update_item" => "Update Printer Name",
		"add_new_item" => "Add New Printer",
		"new_item_name" => "New Printer Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Printers",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove printers",
		"choose_from_most_used" => NULL,
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Printers",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'printer', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "printer", array( "work" ), $args );


	$labels = array(
		"name" => "Medium",
		"label" => "Medium Categories",
		"menu_name" => "Medium Category",
		"all_items" => "All Mediums",
		"edit_item" => "Edit Medium Category",
		"view_item" => "View Medium Category",
		"update_item" => "Update Medium Name",
		"add_new_item" => "Add New Medium",
		"new_item_name" => "New Medium Category Name",
		"parent_item" => "Parent Medium Category",
		"parent_item_colon" => "Parent Medium Category:",
		"search_items" => "Search Medium Categories",
		"not_found" => "No work categories found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Medium Categories",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'medium', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "medium", array( "work" ), $args );
	
	$labels = array(
		"name" => "Collection",
		"label" => "Collections",
		"menu_name" => "Collection",
		"all_items" => "All Collections",
		"edit_item" => "Edit Collection",
		"view_item" => "View Collection",
		"update_item" => "Update Collection",
		"add_new_item" => "Add New Collection",
		"new_item_name" => "New Collection Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Collections",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove collections",
		"choose_from_most_used" => NULL,
		"not_found" => "No collections found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Collections",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'collection', 'with_front' => true ),
		"show_admin_column" => false,
	);
	register_taxonomy( "collection", array( "work" ), $args );
	
	
	$labels = array(
		"name" => "Support",
		"label" => "Support",
		"menu_name" => "Support",
		"all_items" => "All Support",
		"edit_item" => "Edit Support",
		"view_item" => "View Support",
		"update_item" => "Update Support",
		"add_new_item" => "Add New Support",
		"new_item_name" => "New Support Name",
		"parent_item" => NULL,
		"parent_item_colon" => NULL,
		"search_items" => "Search Support",
		"popular_items" => NULL,
		"separate_items_with_commas" => NULL,
		"add_or_remove_items" => "Add or remove support",
		"choose_from_most_used" => NULL,
		"not_found" => "No support items found",
		);

	$args = array(
		"labels" => $labels,
		"hierarchical" => true,
		"label" => "Support",
		"show_ui" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'support', 'with_front' => false ),
		"show_admin_column" => false,
	);
	register_taxonomy( "support", array( "work" ), $args );

// End cptui_register_my_taxes
}


// Hide the parent category dropdown 
// http://wordpress.stackexchange.com/questions/58799/remove-parent-selection-when-adding-editing-categories

// Series
add_action( 'admin_head-edit-tags.php', 'remove_parent_ui_series' );
function remove_parent_ui_series()
{
    if ( 'series' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}

// Exhibition
add_action( 'admin_head-edit-tags.php', 'remove_parent_ui_exhibition' );
function remove_parent_ui_exhibition()
{
    if ( 'exhibition' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}

// Where Made
add_action( 'admin_head-edit-tags.php', 'remove_parent_ui_where' );
function remove_parent_ui_where()
{
    if ( 'where-made' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}

// Literature
add_action( 'admin_head-edit-tags.php', 'remove_parent_ui_literature' );
function remove_parent_ui_literature()
{
    if ( 'literature' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}

// Printer
add_action( 'admin_head-edit-tags.php', 'remove_parent_ui_printer' );
function remove_parent_ui_printer()
{
    if ( 'printer' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}

// Collection
add_action( 'admin_head-edit-tags.php', 'remove_parent_ui_collection' );
function remove_parent_ui_collection()
{
    if ( 'collection' != $_GET['taxonomy'] )
        return;

    $parent = 'parent()';

    if ( isset( $_GET['action'] ) )
        $parent = 'parent().parent()';

    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {     
                $('label[for=parent]').<?php echo $parent; ?>.remove();       
            });
        </script>
    <?php
}