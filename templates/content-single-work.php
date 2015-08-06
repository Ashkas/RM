<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
		<?php 
			
			// Put the post ID into a variable, it will change if it is an alternative work
			$post_id = $post->ID;
			
			
	      	// Check whether the work is an alternative title. If so pull the original matrix
			$alt_work_args = array(
				'numberposts' => -1,
				//'orderby' => 'post_date',
				//'order' => 'DESC',
				'post_type' => "work",
				'meta_query' => array(
						array(
							'key' => "c_alternative_title_select", // name of custom field
							'value' => '"' . $post->ID . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
							'compare' => "LIKE"
						)
					)
				);
				
			$alt_works = get_posts( $alt_work_args );
								
			if( $alt_works ) {
				
				foreach( $alt_works as $alt_work ) {
					
					// If this is an alt work with a parent, turn the post_ID into that of the original
					$post_id = $alt_work->ID;
					$alt_id = $post->ID;
				}
			}
	      	
			workEntry($post_id, $alt_id); 
		?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </article>
<?php endwhile; ?>
