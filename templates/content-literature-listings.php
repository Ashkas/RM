<?php 
	
	// Display the content
	the_content();

	// Display the terms
	$terms = get_terms( 'literature' );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		echo '<ul class="listings">';
			foreach ( $terms as $term ) {
				
				if(function_exists('get_field')) {
					$tax_description = get_field('c_taxonomy_description', $term->taxonomy.'_'.$term->term_id);
				}
				
				$term_link = get_term_link($term->slug, $term->taxonomy);
			    	
		    	// If there was an error, continue to the next term.
			    if ( is_wp_error( $collection_tax_link ) ) {
			        continue;
			    }
				
				echo '<li><h2><a href="'.esc_url( $term_link ).'" title="'.$term->name.'">'.$term->name.'</a></h2>'.$tax_description.'</li>';
				
			}
		echo '</ul>';
	}

?>