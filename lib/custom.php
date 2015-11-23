<?php
	
// LIMIT POST REVISION to just 5, to help lessen DB bloat
define( 'WP_POST_REVISIONS', 5);

// Change it so the default layout view for works for none administrators is single
// from http://wordpress.stackexchange.com/questions/4552/how-do-i-force-a-single-column-layout-in-screen-layout
/*
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

add_action('admin_init', function() {
    $_GET['mode'] = 'list';
}, 100);
*/

//Hide description field from custom taxonomy screens
/**
 * Remove default description column from category
 *
 */
 
// Exhibition
function remove_exhibition_description($columns) {
 // only edit the columns on the current taxonomy, replace category with your custom taxonomy (don't forget to change in the filter as well)
 if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'exhibition' )
 return $columns;

 // unset the description columns
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
 return $columns;
}
add_filter('manage_edit-exhibition','remove_exhibition_description');

// Literature
function remove_literature_description($columns) {
 // only edit the columns on the current taxonomy, replace category with your custom taxonomy (don't forget to change in the filter as well)
 if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'literature' )
 return $columns;

 // unset the description columns
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
 return $columns;
}
add_filter('manage_edit-literature','remove_literature_description');

// Where Made
function remove_where_made_description($columns) {
 // only edit the columns on the current taxonomy, replace category with your custom taxonomy (don't forget to change in the filter as well)
 if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'where-made' )
 return $columns;

 // unset the description columns
 if ( $posts = $columns['description'] ){ unset($columns['description']); }
 return $columns;
}
add_filter('manage_edit-where-made','remove_where_made_description');

// Custom filter for getting next and previous works based of the c_number custom field
// ref http://wordpress.stackexchange.com/questions/139453/filter-next-post-link-and-previous-post-link-by-meta-key
// Currently replaced by the ambrosite-post-link-plus plugin

/*
function get_adjacent_past_works_join($join) {
  if(is_singular('work')) {
    global $wpdb;
    $new_join = $join."INNER JOIN $wpdb->postmeta AS m ON p.ID = m.post_id ";
    return $new_join;
  }
  return $join;
}
add_filter('get_previous_post_join', 'get_adjacent_past_works_join');
add_filter('get_next_post_join', 'get_adjacent_past_works_join');

function get_prev_past_works_where($where) {
  if(is_singular('work')) {
    global $wpdb, $post;
    $id = $post->ID;
    $current_work = get_field('c_number', $id);
    $previous_work = $current_work - 1;
    $new_where = "WHERE p.post_type = 'work' AND p.post_status = 'publish' AND (m.meta_key = 'c_number' AND (m.meta_key = 'c_number' AND CAST(m.meta_value AS CHAR) > '$previous_work'))";
    return $new_where;
  }
  return $where;
}
add_filter('get_previous_post_where', 'get_prev_past_works_where');

function get_next_past_works_where($where) {
  if(is_singular('work')) {
    global $wpdb, $post;
    $id = $post->ID;
    $current_work = get_field('c_number', $id);
    $next_work = $current_work + 1;
    $new_where = "WHERE p.post_type = 'work' AND p.post_status = 'publish' AND (m.meta_key = 'c_number' AND (m.meta_key = 'c_number' AND CAST(m.meta_value AS CHAR) < '$next_work'))";
    return $new_where;
  }
  return $where;
}
add_filter('get_next_post_where', 'get_next_past_works_where');

function get_prev_past_works_sort($sort) {
  if(is_singular('work')) {
    global $wpdb;
    $new_sort = " GROUP BY p.ID ORDER BY m.meta_value+0 DESC";
    return $new_sort;
  }
  return $sort;
}
add_filter('get_previous_post_sort', 'get_prev_past_works_sort');

function get_next_past_works_sort($sort) {
  if(is_singular('work')) {
    global $wpdb;
    $new_sort = " GROUP BY p.ID ORDER BY m.meta_value+0 ASC";
    return $new_sort;
  }
  return $sort;
}
add_filter('get_next_post_sort', 'get_next_past_works_sort');
*/




// Update the Catalog number based off the c_number and what medium is set
function update_cat_number($post_id){
	if ( wp_is_post_revision( $post_id ) )
		return;
	
	// Get the prefix for the work type
	if(function_exists('get_field')):
	
		// Check to see if alternative title has been set, if so we need original post ID
		$get_alt_title = get_field('c_alternative_title', $post_id);
		
		// If the work does have an alternative title, get the values, otherwise ignore
		if($get_alt_title == 'is_alternative'):
			
			// Find the original work catalog number and set it there
			$alt_title_select_id = get_field('c_original_title_select', $post_id);
			$orig_id = $alt_title_select_id[0];
			$cat_number = get_field('c_catalog_number', $orig_id);
			
			// Get MEDIUM terms from original Work
			$mediums = get_the_terms( $orig_id, 'medium' );
						
			if ( $mediums && ! is_wp_error( $mediums ) ) {
				$medium_ids = array();
				foreach ( $mediums as $medium ) {
					$medium_ids[] = $medium->term_id;
				}
			}
			wp_set_object_terms( $post_id, $medium_ids, 'medium' );
			
			// Get SERIES terms from original Work
			$series = get_the_terms( $orig_id, 'series' );
						
			if ( $series && ! is_wp_error( $series ) ) {
				$series_ids = array();
				foreach ( $series as $serie ) {
					$series_ids[] = $serie->term_id;
				}
			}
			wp_set_object_terms( $post_id, $series_ids, 'series' );
			
			// Get KEYWORDS terms from original Work
			$keywords = get_the_terms( $orig_id, 'keyword' );
						
			if ( $keywords && ! is_wp_error( $keywords ) ) {
				$keyword_ids = array();
				foreach ( $keywords as $keyword ) {
					$keyword_ids[] = $keyword->term_id;
				}
			}
			wp_set_object_terms( $post_id, $keyword_ids, 'keyword' );
			
			// Get EXHIBITIONS terms from original Work
			$exhibitions = get_the_terms( $orig_id, 'exhibition' );
						
			if ( $exhibitions && ! is_wp_error( $exhibitions ) ) {
				$exhibition_ids = array();
				foreach ( $exhibitions as $exhibition ) {
					$exhibition_ids[] = $exhibition->term_id;
				}
			}
			wp_set_object_terms( $post_id, $exhibition_ids, 'exhibition' );
			
			// Get WHERE MADE terms from original Work
			$where_mades = get_the_terms( $orig_id, 'where-made' );
						
			if ( $where_mades && ! is_wp_error( $where_mades ) ) {
				$where_made_ids = array();
				foreach ( $where_mades as $where_made ) {
					$where_made_ids[] = $where_made->term_id;
				}
			}
			wp_set_object_terms( $post_id, $where_made_ids, 'where-made' );
			
			// Get LITERATURE terms from original Work
			$literatures = get_the_terms( $orig_id, 'literature' );
						
			if ( $literatures && ! is_wp_error( $literatures ) ) {
				$literature_ids = array();
				foreach ( $literatures as $literature ) {
					$literature_ids[] = $literature->term_id;
				}
			}
			wp_set_object_terms( $post_id, $literature_ids, 'literature' );
			
			// Get PRINTER terms from original Work
			$printers = get_the_terms( $orig_id, 'printer' );
						
			if ( $printers && ! is_wp_error( $printers ) ) {
				$printer_ids = array();
				foreach ( $printers as $printer ) {
					$printer_ids[] = $printer->term_id;
				}
			}
			wp_set_object_terms( $post_id, $printer_ids, 'printer' );
			
			// Get COLLECTION terms from original Work
			$collections = get_the_terms( $orig_id, 'collection' );
						
			if ( $collections && ! is_wp_error( $collections ) ) {
				$collection_ids = array();
				foreach ( $collections as $collection ) {
					$collection_ids[] = $collection->term_id;
				}
			}
			wp_set_object_terms( $post_id, $collection_ids, 'collection' );
			
			// Get SUPPORT terms from original Work
			$supports = get_the_terms( $orig_id, 'support' );
						
			if ( $supports && ! is_wp_error( $supports ) ) {
				$support_ids = array();
				foreach ( $supports as $support ) {
					$support_ids[] = $support->term_id;
				}
			}
			wp_set_object_terms( $post_id, $support_ids, 'support' );
		
		else:
			
			$medium_type = get_field('c_medium_category', $post_id);
			$medium_type_id = $medium_type->term_id;
			$type_prefix = get_field('c_medium_type_prefix', 'medium_'.$medium_type_id);
			$number = get_field('c_number', $post_id);
			
			// Add leader zeros
			$c_number = sprintf('%03d', $number);
			
			// Connect the prefix and the numbers
			$cat_number = $type_prefix.'.'.$c_number;
			
		endif;		
	
		// Update the field based off the key
		update_field('field_55c841510e677', $cat_number, $post_id);
		
	endif;
}
add_action('save_post','update_cat_number');


//Update/add taxonomies of alt entries based off their original
function update_custom_terms($post_id) {

	// only update terms if it's a post-type-B post
	if ( 'work' != get_post_type($post_id)) {
		return;
	}
	
	// don't create or update terms for system generated posts
	if (get_post_status($post_id) == 'auto-draft') {
		return;
	}
	
	if(function_exists('get_field')):
		
		$get_alt_title = get_field('c_alternative_title', $post_id);
		
		// If the work does have an alternative title, get the values, otherwise ignore
		if($get_alt_title == 'is_alternative'):
			$alt_title_select_id = get_field('c_alternative_title_select', $post_id);
			$alt_id = $alt_title_select_id[0];
		
			//SERIES
			$series = get_field('c_series_title', $alt_id);
			if($series):
				wp_set_object_terms( $post_id, $series->term_id, 'series');
			endif;
			
			//Medium
			$medium = get_field('c_medium_category', $alt_id);
			if($medium):
				wp_set_object_terms( $post_id, $medium->term_id, 'medium');	
			endif;
			
			//Where Made
			$where_made = get_field('c_where_made', $alt_id);
			if($where_made):
				wp_set_object_terms( $post_id, $where_made->term_id, 'where-made');
			endif;
			
			//Printers
			$printers = get_field('c_printers', $alt_id);
			if($printers):
				$printer_terms = array();
				foreach($printers as $printer):
					$printer_terms[] = $printer->term_id;
				endforeach;
				wp_set_object_terms( $post_id, $printer_terms, 'printer');
			endif;
			
			//Collection
			$collections = get_the_terms($alt_id, 'collection');
			if($collections):
				$collection_terms = array();
				foreach($collections as $collection):
					$collection_terms[] = $collection->term_id;
				endforeach;
				wp_set_object_terms( $post_id, $collection_terms, 'collection');
			endif;
			
			//Keywords
			$keywords = get_the_terms($alt_id, 'keyword');
			if($keywords):
				$keyword_terms = array();
				foreach($keywords as $keyword):
					$keyword_terms[] = $keyword->term_id;
				endforeach;
				wp_set_object_terms( $post_id, $keyword_terms, 'keyword');
			endif;
			
			// Exhibition
			$exhibitions = get_the_terms($alt_id, 'exhibition');
			if($exhibitions):
				$exhibition_terms = array();
				foreach($exhibitions as $exhibition):
					$exhibition_terms[] = $exhibition->term_id;
				endforeach;
				wp_set_object_terms( $post_id, $exhibition_terms, 'exhibition');
			endif;
			
			// Literature
			$literatures = get_the_terms($alt_id, 'literature');
			if($literatures):
				$literature_terms = array();
				foreach($literatures as $literature):
					$literature_terms[] = $literature->term_id;
				endforeach;
				wp_set_object_terms( $post_id, $literature_terms, 'literature');
			endif;
			
		endif;
		
	endif;
    
}

//run the update function whenever a post is created or edited
add_action('save_post', 'update_custom_terms');

// Customise the WysiWyg toolbar
// http://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars ) {
	// Uncomment to view format of $toolbars
/*
	echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;
*/

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Custom Set' ] = array();
	$toolbars['Custom Set' ][1] = array('bold' , 'italic' , 'underline', 'bullist', 'numlist', 'outdent', 'indent','link', 'unlink', 'pastetext', 'removeformat', 'fullscreen' );

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
	{
	    unset( $toolbars['Full' ][2][$key] );
	}

	// remove the 'Basic' toolbar completely
	unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

// From - http://css-tricks.com/snippets/wordpress/year-shortcode/
function year_shortcode() {
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'year_shortcode');

// Template function for PictureFill

function do_feature_picturefill ($image_id, $link = NULL, $size1="0", $size2="600", $size3="1000", $size4="1280") {
	$small = wp_get_attachment_image_src($image_id,'featured-small');
	$medium = wp_get_attachment_image_src($image_id,'featured-medium');
	$large = wp_get_attachment_image_src($image_id,'featured-large');
	$xlarge = wp_get_attachment_image_src($image_id,'featured-xlarge');
	$get_meta = get_post_meta($image_id);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$alt = get_the_title($image_id);
	}
	$link = '';
	
	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;
	
	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$xlarge[0].'" media="(min-width: '.$size4.'px)" alt="'.$alt.'">
					<source srcset="'.$large[0].'" media="(min-width: '.$size3.'px)" alt="'.$alt.'">
					<source srcset="'.$medium[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$small[0].'" alt="'.$alt.'">
			'.$link_close.'
		</picture>';
}

function do_page_feature_picturefill ($image_id, $link = NULL, $size1="0", $size2="600", $size3="1000", $size4="1280") {
	$small = wp_get_attachment_image_src($image_id,'page-featured-small');
	$medium = wp_get_attachment_image_src($image_id,'page-featured-medium');
	$large = wp_get_attachment_image_src($image_id,'page-featured-large');
	$xlarge = wp_get_attachment_image_src($image_id,'page-featured-xlarge');
	$get_meta = get_post_meta($image_id);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$alt = get_the_title($image_id);
	}
	$link = '';
	
	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;
	
	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$xlarge[0].'" media="(min-width: '.$size4.'px)" alt="'.$alt.'">
					<source srcset="'.$large[0].'" media="(min-width: '.$size3.'px)" alt="'.$alt.'">
					<source srcset="'.$medium[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$small[0].'" alt="'.$alt.'">
			'.$link_close.'
		</picture>';
}

function do_free_height_picturefill ($image_id, $link = NULL, $class = NULL, $size1="0", $size2="760") {
	$medium = wp_get_attachment_image_src($image_id,'medium');
	$large = wp_get_attachment_image_src($image_id,'large');
	$get_meta = get_post_meta($image_id);
	$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$alt = get_the_title($image_id);
	}
	$link = '';
	
	if($link):
		$link_open = '<a href="'.$link.'">';
		$link_close = '</a>';
	endif;
	
	if($class):
		$class = 'class="'.$class.'"';
	endif;
	
	return '
		<picture>
			'.$link_open.'
				<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="'.$large[0].'" media="(min-width: '.$size2.'px)" alt="'.$alt.'">
				<!--[if IE 9]></video><![endif]-->
				<img srcset="'.$medium[0].'" alt="'.$alt.'" '.$class.'>
			'.$link_close.'
		</picture>';
}

// Change the title on archives via filters
add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

        $title = single_cat_title( '', false );

    } elseif ( is_tag() ) {

        $title = single_tag_title( '', false );

    } elseif (is_post_type_archive('work')){
        
        $title = 'Works';
        
    } elseif (is_post_type_archive()){
        
        $title = post_type_archive_title( '', false );
    }
    
/*
    elseif (is_tax()){
        
        $title = single_term_title( '', false );
    }
*/

    return $title;
    
});

// Make sure Search only looks at the Work CPT
function searchfilter($query) {

    if ($query->is_search && !is_admin() ) {
        $query->set('post_type',array('work'));
    }

return $query;
}

add_filter('pre_get_posts','searchfilter');
