<?php
	
function workEntry($post_id) { 
	
	// ACF variables
	if(function_exists('get_field')) {
		$cat_number = get_field('c_number', $post_id);
		$artist_number = get_field('c_artist_number', $post_id);
		$title = get_the_title($post_id);
		$year = get_field('c_year', $post_id);
		$alt_title = get_field('c_alternative_title', $post_id);
		$alt_year = get_field('c_alternative_title_year', $post_id);
		$series_title = get_field('c_series_title', $post_id);
		$location_made = get_field('c_location_made', $post_id);
		$medium = get_field('c_medium', $post_id);
		$support = get_field('c_support', $post_id);
		$technique = get_field('c_technique', $post_id);
		$image_size = get_field('c_dimensions_image', $post_id);
		$matrix_size = get_field('c_dimensions_matrix', $post_id);
		$sheet_size = get_field('c_dimensions_sheet', $post_id);
		$summary_edition = get_field('c_summary_edition', $post_id);
		$printers = get_field('c_printers', $post_id);
		$exhibitions = get_field('c_exhibitions', $post_id);
		$literature = get_field('c_literature', $post_id);		
		$collection = get_field('c_collection', $post_id);	
		$collection = get_field('c_edition_information', $post_id);		
		$edition_information = get_field('c_edition_information', $post_id);	
		$comment = get_field('c_comment', $post_id);	
		$keywords = get_field('c_keywords', $post_id);		
	}
	?>
	
	<dl>
		<?php if($cat_number): ?>
			<dt>Catalogue number</dt>
			<dd><?php echo $cat_number ?></dd>
		<?php endif; ?>
		
		<?php if($artist_number): ?>
			<dt>Artist Record number</dt>
			<dd><?php echo $artist_number ?></dd>
		<?php endif; ?>
		
		<?php if($title): ?>
			<dt>Title</dt>
			<dd><?php echo $title ?></dd>
		<?php endif; ?>
		
		<?php if($year): ?>
			<dt>Year</dt>
			<dd><?php echo $year ?></dd>
		<?php endif; ?>
		
		<?php if($alt_title): ?>
			<dt>Alternate Title</dt>
			<dd><?php echo $alt_title ?></dd>
		<?php endif; ?>
		
		<?php if($series_title):?>
			<dt>Series Title</dt>
			<?php foreach( $series_title as $term ):
				 $term = get_term($term, 'series',$output, $filter);?>
				
				<dd><?php echo $term->name;?></dd>
				
				<?php if(function_exists('get_field')) {
					if(get_field('plate_number', $term->taxonomy.'_'.$term->term_id)): ?>
						<dt>Plate Number</dt>
						<dd><?php echo get_field('plate_number',$term->taxonomy.'_'.$term->term_id); ?>
					<?php endif;
				} ?>
				
			<?php endforeach;
		endif; ?>
		
		<?php if($location_made):?>
			<dt>Location made</dt>
			<?php foreach( $location_made as $term ):
				 $term = get_term($term, 'location_made',$output, $filter);?>
				
				<dd><?php echo $term->name;?></dd>
				
			<?php endforeach;
		endif; ?>
	</dl>
<?php }