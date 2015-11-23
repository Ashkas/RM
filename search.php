<?php use Roots\Sage\Config;

//get_template_part('templates/page', 'header');

// If no results
if (!have_posts()) : ?>
	<div class="big_margin_bottom">
		<div class="alert alert-warning">
			<?php _e('Sorry, no results were found.', 'sage'); ?>
		</div>
		<div class="margin_auto centre_text">
			<?php get_search_form(); ?>
		</div>
	</div> <!-- big_margin_bottom -->
<?php endif; ?>

<?php // If it has posts
if (have_posts()) :
	
	$counter = 0; ?>
	<div class="row grid">
		
		<div class="facetwp-template">
			<?php while (have_posts()) : the_post();
				
				get_template_part('templates/content-archive-grid', get_post_type() != 'post' ? get_post_type() : get_post_format());
				
				$counter++; 
				if ($counter%2 == 0) echo '<div class="clearfix"></div>';
				//if ($counter%4 == 0) echo '<div class="clearfix visible-md visible-lg"></div>';
				
			endwhile; ?>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<?php // Pagination
	$page_args = array(
		
		'prev_text' => '<span class="icon-arrow-left previous"></span>',
		'next_text' => '<span class="icon-arrow-right"></span>',
	);
	
	$paginate_links = paginate_links($page_args);
		
	if($paginate_links):
 		echo '<div class="pagination">';
			echo $paginate_links;
		echo '</div>';
	endif;
	
endif; // have_posts ?>
	