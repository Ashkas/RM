<?php //get ACF variables

if(function_exists('get_field')):
		
	$term = get_queried_object();
	
endif;

// Get Page Header
get_template_part('templates/page', 'header');

// Query the posts
query_posts($query_string . '&orderby=title&order=ASC');

// If no posts
if (!have_posts()) : ?>
	<div class="alert alert-warning">
		<h2 class="centre_text"><?php echo $term->name; ?></h2>
		<div class="big_margin_bottom">
			<div class="col-sm-4 no_padding margin_auto">
				<a class="cta_button big_button" href="http://counsellingathome.com/counsellors/">Find A Counsellor</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<?php endif;
	
// If it has posts
if (have_posts()) :
	
	$counter = 0;
	echo '<div class="row grid masonry_container">';
	
		while (have_posts()) : the_post();
			
			get_template_part('templates/content-archive-grid', get_post_type() != 'post' ? get_post_type() : get_post_format());
			
			$counter++; 
			if ($counter%3 == 0) echo '<div class="clearfix visible-sm"></div>';
			if ($counter%4 == 0) echo '<div class="clearfix visible-md visible-lg"></div>';
			
		endwhile;
		echo '<div class="clearfix"></div>';
		
	echo '</div>';
	
	// Pagination
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