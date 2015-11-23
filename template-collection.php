<?php
/**
 * Template Name: Collection Listings
 */
?>

<?php while (have_posts()) : the_post();
	
	//get_template_part('templates/page', 'header');

	// Display the terms
	get_template_part('templates/content-collection', 'listings');

endwhile; ?>
