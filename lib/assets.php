<?php

namespace Roots\Sage\Assets;

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/dist/styles/main.css
 *
 * Enqueue scripts in the following order:
 * 1. /theme/dist/scripts/modernizr.js
 * 2. /theme/dist/scripts/main.js
 */

class JsonManifest {
  private $manifest;

  public function __construct($manifest_path) {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get() {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null) {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }
    return $collection;
  }
}

function asset_path($filename) {
  $dist_path = get_template_directory_uri() . DIST_DIR;
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_template_directory() . DIST_DIR . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}

function assets() {
	wp_enqueue_style('sage_css', asset_path('styles/main.css'), false, null);
    wp_enqueue_style('sage_print_css', asset_path('styles/print.css'), false, null, 'print');

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('modernizr', asset_path('scripts/modernizr.js'), [], null, true);
  wp_enqueue_script('sage_js', asset_path('scripts/main.js'), ['jquery'], null, true);
}
if(!is_admin()):
	add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
endif;

function cat_header_js_css() { ?>
	
	<style>
    	
		/* =============================================================================
		Page load for Typekit - fades in elements while javascript is read from Type Kit
		========================================================================== */
		
		h1, h2, h3, h4,  p, li, time, code, small, dl, figcaption, span, .site_header img, blockquote, img, a, select, label, button, tr, td {
		    opacity: 0;
		    visibility: hidden; /* Old IE */
		}
		
		.wf-loading .main_content {
			background: 
				url(data:image/gif;base64,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) center 50px no-repeat;
		}
		
		.wf-active h1, .wf-active h2, .wf-active h3, .wf-active h4, .wf-active p, .wf-active li, .wf-active time,
		.wf-active pre, .wf-active small, .wf-active dl, .wf-active figcaption, .wf-active span, .wf-active .site_header img, p.sass_error, .wf-active img, .wf-active blockquote, .wf-active a, .wf-active select, .wf-active label, .wf-active button, .wf-active tr, .wf-active td {
		    opacity: 1;
		    visibility: visible; /* Old IE */
		    -webkit-transition: opacity 0.24s ease-in-out;
		       -moz-transition: opacity 0.24s ease-in-out;
		            transition: opacity 0.24s ease-in-out;
		}
		
		.wf-active {
			background: none;
		}
		
	</style>
	
	<!-- 	Typekit -->
	<script src="https://use.typekit.net/ibs1zlz.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	
<?php
}
add_action('wp_head', __NAMESPACE__ . '\\cat_header_js_css', 20);

function ra_footer_js_css() { ?>
	
<!-- 	Fallback for typography in case JS is off -->
	<style>
		
/* 		FOUT fallback */
		.no-js h1, .no-js h2, .no-js h3, .no-js h4, .no-js p, .no-js li, .no-js time,
		.no-js pre, .no-js small, .no-js dl, .no-js figcaption, .no-js span, .no-js .site_header img, p.sass_error, .no-js img, .no-js blockquote, .no-js a, .no-js select, .no-js input, .no-js label, .no-js button, .no-js tr, .no-js td {
			opacity: 1;
		    visibility: visible; /* Old IE */
		    -webkit-transition: opacity 0.24s ease-in-out;
		       -moz-transition: opacity 0.24s ease-in-out;
		            transition: opacity 0.24s ease-in-out;
		}
		
		.no-js {
			background: none;
		}
		
/* 		Search fallback */
		.no-js .sb-search {
			height: 60px;
			max-height: 60px;
		}
			
		.no-js .sb-search-input, .no-js .sb-search-submit {
			opacity: 1 !important;
			visibility: visible !important;
		}
		
	</style>
	
	<!-- Footer search -->
	<script>
		var menuTop = document.getElementById( 'sb-search' ),
			showTop = document.getElementById( 'search_toggle' ),
			body = document.body;
	
		showTop.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( menuTop, 'sb-search-open' );
			disableOther( 'search_toggle' );
		};
	
		function disableOther( button ) {
			if( button !== 'search_toggle' ) {
				classie.toggle( showTop, 'disabled' );
			}
		}
	</script>
	
<?php
}
add_action('wp_footer', __NAMESPACE__ . '\\ra_footer_js_css', 20);

// Admin styles and scripts
function ra_admin_scripts() {
	
	// CSS
	wp_enqueue_style( 'adminstyles', get_stylesheet_directory_uri().'/assets/styles/admin.css', false, '1.0', 'all');
	
	// Scripts
	wp_enqueue_script( 'adminscripts', get_stylesheet_directory_uri() . '/assets/scripts/admin.js', array('jquery'), NULL, true );
}
if (is_admin()) add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\ra_admin_scripts', 100);?>
