<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 */

if ( has_nav_menu( 'primary_navigation' ) ) : 

	wp_nav_menu( array( 
		'theme_location' => 'primary_navigation',
		'container' => 'false', 
		'menu_class' => 'mobilenav',
		'depth' => 2, )
	);
	
endif; ?>