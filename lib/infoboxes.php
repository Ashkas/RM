<?php
	
function workEntry($post_id, $alt_id = NULL) { 
	
	// ACF variables
	if(function_exists('get_field')) {
				
		$cat_number = get_field('c_catalog_number', $post_id);
		$work_types = get_field('c_work_type', $post_id);
		$artist_number = get_field('c_artist_number', $post_id);
		
		// date shown will change if this is the alternative entry. Same with title information
		if($alt_id):
			$title = get_the_title($alt_id);
			$date_start = get_field('c_start_date', $alt_id);
			$date_end = get_field('c_end_date', $alt_id);
			$date_desc_req = get_field('c_date_desc_req', $alt_id);
			if($date_desc_req):
				$date_desc = get_field('c_date_desc', $alt_id);
			endif;
		else: 
			$title = get_the_title($post_id);
			$date_start = get_field('c_start_date', $post_id);
			$date_end = get_field('c_end_date', $post_id);
			$date_desc_req = get_field('c_date_desc_req', $post_id);
			if($date_desc_req):
				$date_desc = get_field('c_date_desc', $post_id);
			endif;
		endif;
		
		// 1st step is to check whether this is an alternative title, if it is, then we want to pull values form the original
		if($alt_id):
			$get_alt_title = get_field('c_alternative_title', $alt_id);
		endif;
		
		// If the work does have an alternative title, get the values, otherwise ignore
		if($get_alt_title == 'has_alternative'): 
			$alt_title_select_id = get_field('c_alternative_title_select', $post_id);
		elseif($get_alt_title == 'is_alternative'):
			$alt_title = get_the_title($post_id);
			$alt_title_link = get_permalink($post_id);
		endif;
				
		$medium = get_field('c_medium_category', $post_id);
		
		$series_title = get_field('c_series_title', $post_id);
		$series_illustration_number = get_field('c_series_illustration_number', $post_id);
		$where_made = get_field('c_where_made', $post_id);
		
		// Get radio label for Medium (this isn't medium category)
		$medium_object = get_field_object('c_medium');
		$medium_value = get_field('c_medium');
		$medium = $medium_object['choices'][ $medium_value ];
		
		// Get technique info
		$intaglio = get_field('c_technique_intaglio', $post_id);
		$relief = get_field('c_technique_relief', $post_id);
		$planographic = get_field('c_technique_planographic', $post_id);
		$monotype = get_field('c_technique_monotype', $post_id);
		$stencil = get_field('c_technique_stencil', $post_id);	
		
		// Collect techniques together to check for them
		$technique = ($intaglio || $relief || $planographic || $monotype || $stencil);
		$technique_req = get_field('c_technique_description_req', $post_id);
		$technique_desc = get_field('c_technique_description', $post_id, false, false);
		
		// Get raido label for support
		$support = get_field('c_support');
		$support_desc = get_field('c_support_description', $post_id, false, false);
		
		// Printers
		$printers_workshops = get_field('c_printers_workshops', $post_id);
		$printer_req = get_field('c_printer_notes_req', $post_id);
		$printer_notes = get_field('c_printer_notes', $post_id, false, false);
		
		// Dimensions
		$image_size_h = get_field('c_dimensions_image_size_height', $post_id);
		$image_size_w = get_field('c_dimensions_image_size_width', $post_id);
		$matrix_size_h = get_field('c_dimensions_matrix_size_height', $post_id);
		$matrix_size_w = get_field('c_dimensions_matrix_size_width', $post_id);
		$sheet_size_h = get_field('c_dimensions_sheet_height', $post_id);
		$sheet_size_w = get_field('c_dimensions_sheet_width', $post_id);
		
		$summary_edition = get_field('c_sum_edition_information', $post_id, false, false);
		
		$description_feature_image = get_field('c_description_featured_image', $post_id, false, false);
		$comment = get_field('c_comment', $post_id, false, false);
		$special_notes = get_field('c_special_notes', $post_id, false, false);		
		$comment = get_field('c_comment', $post_id, false, false);	
		$keywords = get_field('c_keywords', $post_id);
	}
	?>
	<dl class="info_box">
		
		<?php // Catalogue number
			
		if($cat_number):  ?>
			
			<dt>Catalogue number</dt>
			<dd><?php echo $cat_number; ?></dd>
		<?php endif;
		
		// Title
		if($title  && !($date_start || $date_end)): ?>
			<dt>Title</dt>
			<dd><?php echo $title ?></dd>
			
		<?php // Title and date
			
		elseif($title && ($date_start || $date_end)): ?>
			<dt>Title and Date</dt>
			<?php if(!$date_desc_req): ?>
				<dd>
					<?php echo $title.' ';
						
					if($date_start != $date_end):
						echo $date_start.' - '.$date_end;
					else:
						echo $date_start;
					endif; ?>
				</dd>
			<?php else: ?>
				<dd><?php echo $title.' '; echo $date_desc; ?></dd>
			<?php endif; ?>
		<?php endif;
			
		// Alternative Title
		if($get_alt_title):
			
			// Change the title here depending if it is alt
			if($alt_id): echo '<dt>Original Title</dt>'; else: echo '<dt>Alternate Title(s)</dt>'; endif;			
			
			if($get_alt_title == 'has_alternative'): 
				$alt_title_select_ids = get_field('c_alternative_title_select', $post_id);
				foreach($alt_title_select_ids as $alt_title_select_id):
					// Get the alt values
					$alt_title = get_the_title($alt_title_select_id);
					$alt_title_link = get_permalink($alt_title_select_id);
					
					echo '<dd><a href="'.$alt_title_link.'" title="'.$alt_title.'">'.$alt_title.'</a></dd>';
				endforeach;
				
			elseif($get_alt_title == 'is_alternative'):
				
				echo '<dd><a href="'.$alt_title_link.'" title="'.$alt_title.'">'.$alt_title.'</a></dd>';
			endif; ?>
		<?php endif;
		
		// Series Title
		if($series_title): 
			
			$series_link = get_term_link($series_title->term_id, $series_title->taxonomy);
		?>
			<dt>Series/Book Title</dt>
				
			<dd><a href="<?php echo $series_link; ?>" title="<?php echo $series_title->name;?>"><?php echo $series_title->name;?></a></dd>
				
		<?php endif;
		
		// Series/Illustration Number
		if($series_illustration_number): ?>
			<dt>Series/Illustration Number</dt>
			<dd><?php echo $series_illustration_number; ?></dd>
		<?php endif;
		
		// Where made
		if($where_made):
			$where_made_link = get_term_link($where_made->term_id, $where_made->taxonomy);?>
			<dt>Where made</dt>
				
			<dd><a href="<?php echo $where_made_link; ?>" title="<?php echo $where_made->name;?>"><?php echo $where_made->name;?></a></dd>
				
		<?php endif;
		
		// Medium and Technique
		if($medium && $technique) :?>
			<dt>Medium and Technique</dt>
			<dd>
				<?php echo $medium.': ';
				
				// If Free text description is not set, then just show each of the techniaue items
				if(!$technique_req):
				
			        if($intaglio):
			        	if( count($intaglio) > 1 ):
				        	$last_element = array_pop($intaglio);
				        	array_push($intaglio, 'and '.$last_element);
					        echo implode(', ', $intaglio);
					    else :
					    	echo implode($intaglio);
					    endif;
					elseif($relief):
						if( count($relief) > 1 ):
				        	$last_element = array_pop($relief);
				        	array_push($relief, 'and '.$last_element);
					        echo implode(', ', $relief);
					    else :
					    	echo implode($relief);
					    endif;
					elseif($planographic):
						if( count($planographic) > 1 ):
				        	$last_element = array_pop($planographic);
				        	array_push($planographic, 'and '.$last_element);
					        echo implode(', ', $planographic);
					    else :
					    	echo implode($planographic);
					    endif;
					elseif($monotype):
						if( count($monotype) > 1 ):
				        	$last_element = array_pop($monotype);
				        	array_push($monotype, 'and '.$last_element);
					        echo implode(', ', $monotype);
					    else :
					    	echo implode($monotype);
					    endif;
					elseif($stencil):
						if( count($stencil) > 1 ):
				        	$last_element = array_pop($stencil);
				        	array_push($stencil, 'and '.$last_element);
					        echo implode(', ', $stencil);
					    else :
					    	echo implode($stencil);
					    endif;
				    endif;
									
				// else echo the technique free text description				    
				else: 
					
					echo $technique_desc;
				
				endif; //$technique_req	?>
			</dd>
		<?php endif;
		
		// Support
		if($support): ?>
			<dt>Support</dt>
			<dd><?php echo $support->name.': '; if($support_desc): echo $support_desc; endif; ?></dd>
		<?php endif;
		
		// Dimensions
		if(($image_size_h && $image_size_w) || ($matrix_size_h && $matrix_size_w) || ($sheet_size_h && $sheet_size_w)): ?>
			<dt>Dimensions</dt>
			<dd>
				<?php if($image_size_h && $image_size_w) echo 'Image size: '.$image_size_h.' x '.$image_size_w.' mm <br>';
				if($matrix_size_h && $matrix_size_w) echo 'Plate mark: '.$matrix_size_h.' x '.$matrix_size_w.' mm <br>';
				if($sheet_size_h && $sheet_size_w) echo 'Sheet size: '.$sheet_size_h.' x '.$sheet_size_w.' mm <br>';?>
			</dd>
		<?php endif;
		
		// Artist Record Number
		if($artist_number): ?>
			<dt>Artist Record number</dt>
			<dd><?php echo $artist_number ?></dd>
		<?php endif;
		
		// Printers
		if($printers_workshops): ?>
			<dt>Printer(s) and Workshop(s)</dt>
			<dd><?php // loop through printers
			    
			    // Create counter to see if we need to insert a comma
				$p_count = count($printers_workshops);
				$p_counter = 1;
			    
			    foreach($printers_workshops as $printer):
			    
			    	$printer_tax_link = get_term_link($printer->term_id, $printer->taxonomy);
			    	
			    	echo '<a href="'.$printer_tax_link.'" title="'.$printer->name.'">'.$printer->name.'</a>';
			    	
			    	// Insert comma is this isnt' the final entry
					if($p_count != $p_counter):
						echo '; ';
					endif;
					
					$p_counter++;	
			    	
			    endforeach; ?>
			</dd>
		<?php endif;
					
		// Printer Notes/Description
		if($printer_req): ?>
			<dt>Printer Notes</dt>
			<dd><?php echo $printer_notes; ?></dd>
		<?php endif;
		
		// Summary Edition Information
		if($summary_edition): ?>
			<dt>Summary Edition Information</dt>
			<dd><?php echo $summary_edition ?></dd>
		<?php endif;
		
		// Exhibitions
		if(have_rows('c_exhibitions', $post_id)) :?>
			<dt>Exhibitions</dt>
			
			<?php // loop through the rows of data
		    while ( have_rows('c_exhibitions', $post_id) ) : the_row(); ?>
		    	
		    	<dd>
			    	<?php $exhibition_tax = get_sub_field('c_exhibition_name');
			    	$exhibition_text = get_sub_field('c_exhibition_text');
			    	
			    	$exhibition_tax_link = get_term_link($exhibition_tax->slug, $exhibition_tax->taxonomy);
			    				    	
			    	// If there was an error, continue to the next term.
				    if ( is_wp_error( $exhibition_tax_link ) ) {
				        continue;
				    }
			    	
			    	if(function_exists('get_field')) {
						$exhibition_description = get_field('c_taxonomy_description', $exhibition_tax->taxonomy.'_'.$exhibition_tax->term_id);
					}
			    	
			    	echo '<a href="'.esc_url( $exhibition_tax_link ).'" title="'.$exhibition_tax->name.'">'.$exhibition_tax->name.'</a>';
			    	if($exhibition_text) echo ', '.$exhibition_text;
			    	if($exhibition_description) echo $exhibition_description; ?>
		    	</dd>
		    
		    <?php endwhile;
		endif;
		
		// Literature
		if(have_rows('c_literature', $post_id)) :?>
			<dt>Literature</dt>
			
			<?php // loop through the rows of data
		    while ( have_rows('c_literature', $post_id) ) : the_row(); ?>
		    	<dd>
			    	<?php $literature_tax = get_sub_field('c_literature_title');
			    	$literature_text = get_sub_field('c_literature_text');
			    	
			    	$literature_tax_link = get_term_link($literature_tax->term_id, $literature_tax->taxonomy);
			    	
			    	// If there was an error, continue to the next term.
				    if ( is_wp_error( $literature_tax_link ) ) {
				        continue;
				    }
			    	
			    	if(function_exists('get_field')) {
						$literature_description = get_field('c_taxonomy_description', $literature_tax->taxonomy.'_'.$literature_tax->term_id, false, false);
					}
			    	
			    	echo '<a href="'.esc_url( $literature_tax_link ).'" title="'.$literature_tax->name.'">'.$literature_tax->name.'</a>';
			    	if($literature_text) echo ', '.$literature_text;
			    	if($literature_description) echo '<br>'.$literature_description; ?>
				</dd>
		    <?php endwhile;
		endif;
		
		// Collections
		if(have_rows('c_collection', $post_id)) :?>
			<dt>Collections</dt>
			
			<?php // loop through the rows of data
		    while ( have_rows('c_collection', $post_id) ) : the_row(); ?>
		    	
		    	<dd>
			    	<?php $collection_tax = get_sub_field('c_collection_location');
			    	$collection_desc = get_sub_field('c_collection_description', false, false);
			    				    	
			    	$collection_tax_link = get_term_link($collection_tax->slug, $collection_tax->taxonomy);
			    	
			    	// If there was an error, continue to the next term.
				    if ( is_wp_error( $collection_tax_link ) ) {
				        continue;
				    }
			    	
/*
			    	if(function_exists('get_field')) {
						$collection_location_description = get_field('c_taxonomy_description', $collection_tax->taxonomy.'_'.$collection_tax->term_id);
					}
*/
								    	
			    	echo '<a href="'.esc_url( $collection_tax_link ).'" title="'.$collection_tax->name.'">'.$collection_tax->name.'</a>';
			    	if($collection_desc) echo ', '.$collection_desc;
			    	//if($collection_location_description) echo $collection_location_description; ?>
		    	</dd>
		    
		    <?php endwhile;
		endif;
		
		// Description
		if($description_feature_image): ?>
			<dt>Description of Featured Image</dt>
			<dd><?php echo $description_feature_image; ?></dd>
		<?php endif;
		
		// Comment
		if($comment): ?>
			<dt>Comment</dt>
			<dd><?php echo $comment; ?></dd>
		<?php endif;
		
		// Related Material
		if(have_rows('c_related_material', $post_id)): ?>
			<dt>Related Material</dt>
			<dd><?php
				echo '<ul>';
					while ( have_rows('c_related_material', $post_id) ) : the_row();
						
						$resource_caption = get_sub_field('caption');
						$resource_file = get_sub_field('file');					
						
						if($resource_file && $resource_caption):
							echo '<li><a href="'.$resource_file.'" title="'.$resource_caption.'" target="_blank">'.$resource_caption.'</a></li>';
						endif;
						
					endwhile;
				echo '</ul>';
			?></dd>
		<?php endif;
			
		// Keywords
		if($keywords): ?>
			<dt>Keywords</dt>
			<dd><?php 
				
				// Create counter to see if we need to insert a comma
				$k_count = count($keywords);
				$k_counter = 1;
				
				foreach ($keywords as $keyword):
					
					$keyword_link = get_term_link($keyword->term_id, $keyword->taxonomy);
					
					// If there was an error, continue to the next term.
				    if ( is_wp_error( $keyword_link ) ) {
				        continue;
				    }
					
					echo '<a href="'.esc_url( $keyword_link ). '" title="'.$keyword->name.'">'.$keyword->name.'</a>';
					
					// Insert comma is this isnt' the final entry
					if($k_count != $k_counter):
						echo ', ';
					endif;
					
					$k_counter++;	
				endforeach;
			?></dd>
		<?php endif;
			
		// Special Notes
		if($special_notes): ?>
			<dt>Special Notes</dt>
			<dd><?php echo $special_notes; ?></dd>
		<?php endif; ?>
		
	</dl>
<?php }