<?php
	
function workEntry($post_id) { 
	
	// ACF variables
	if(function_exists('get_field')) {
		
		// 1st step is to check whether this is an alternative title, if it is, then we want to pull values form the original
		$get_alt_title = get_field('c_alternative_title', $post_id);
		
		if($get_alt_title != 'is_alternative'): 
			$post_id = $post_id;
		endif;
		
		$cat_number = get_field('c_number', $post_id);
		$work_types = get_field('c_work_type', $post_id);
		$artist_number = get_field('c_artist_number', $post_id);
		$title = get_the_title($post_id);
		$year = get_field('c_year', $post_id);
		
		// If the work does have an alternative title, get the values, otherwise ignore
		if($get_alt_title == 'has_alternative'): 
			$alt_title_select_id = get_field('c_alternative_title_select', $post_id);
			$alt_title = get_the_title($alt_title_select_id[0]);
			$alt_title_link = get_permalink($alt_title_select_id[0]);
		endif;
		
		$series_title = get_field('c_series_title', $post_id);
		$where_made = get_field('c_where_made_title', $post_id);
		
		// Get radio label for Medium
		$medium_object = get_field_object('c_medium');
		$medium_value = get_field('c_medium');
		$medium = $medium_object['choices'][ $medium_value ];
		
		// Get technique info
		$technique = get_field('c_technique', $post_id);
		$technique_req = get_field('c_technique_description_req', $post_id);
		$technique_desc = get_field('c_technique_description', $post_id);
		
		// Get raido label for support
		$support_object = get_field_object('c_support');
		$support_value = get_field('c_support');
		$support = $support_object['choices'][ $support_value ];
		
		$support_desc = get_field('c_support_description', $post_id);
		
		// Dimensions
		$image_size_h = get_field('c_dimensions_image_size_height', $post_id);
		$image_size_w = get_field('c_dimensions_image_size_width', $post_id);
		$matrix_size_h = get_field('c_dimensions_matrix_size_height', $post_id);
		$matrix_size_w = get_field('c_dimensions_matrix_size_width', $post_id);
		$sheet_size_h = get_field('c_dimensions_sheet_height', $post_id);
		$sheet_size_w = get_field('c_dimensions_sheet_width', $post_id);
		
		$summary_edition = get_field('c_sum_edition_information', $post_id);
		$printers = get_field('c_printers', $post_id);
		$collection = get_field('c_collection', $post_id);
		$edition = get_field('c_edition_information', $post_id);
		$description = get_field('c_description', $post_id);
		$comment = get_field('c_comment', $post_id);
		$special_notes = get_field('c_special_notes', $post_id);		
		$comment = get_field('c_comment', $post_id);	
		$keywords = get_field('c_keywords', $post_id);
		$resource_material = get_field('c_resource_material', $post_id);		
		$exhibitions = get_field('c_exhibitions', $post_id);
		$literature = get_field('c_literature', $post_id);
		
		//States
		$states = get_field('c_states', $post_id);
	}
	?>
	
	<dl>
		<?php if($cat_number && $work_types): 
			
			// Get the prefix for the work type
			$type_prefix = get_field('c_work_type_prefix', 'type_'.$work_types); ?>
			
			<dt>Catalogue number</dt>
			<dd><?php echo $type_prefix.'_'.$cat_number ?></dd>
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
		
		<?php if($alt_title):?>
			<dt>Alternate Title</dt>
			<dd><a href="<?php echo $alt_title_link; ?>" title="<?php echo $alt_title ?>"><?php echo $alt_title ?></a></dd>
		<?php endif; ?>
		
		<?php if($alt_year): ?>
			<dt>Alternate Year</dt>
			<dd><?php echo $alt_year ?></dd>
		<?php endif; ?>
		
		<?php if($series_title): 
			
			$series_link = get_term_link($series_title->term_id, $series_title->taxonomy);
		?>
			<dt>Series Title</dt>
				
			<dd><a href="<?php echo $series_link; ?>" title="<?php echo $series_title->name;?>"><?php echo $series_title->name;?></a></dd>
				
			<?php if(function_exists('get_field')) {
				$plate_number = get_field('c_plate_number', $series_title->taxonomy.'_'.$series_title->term_id);
				if($plate_number): ?>
					<dt>Series Plate Number</dt>
					<dd><?php echo $plate_number; ?>
				<?php endif;
			} ?>
				
		<?php endif; ?>
		
		<?php if($where_made):
			
			$where_made_link = get_term_link($where_made->term_id, $where_made->taxonomy);
		?>
			<dt>Where made</dt>
				
			<dd><a href="<?php echo $where_made_link; ?>" title="<?php echo $where_made->name;?>"><?php echo $where_made->name;?></a></dd>
				
		<?php endif; ?>
		
		<?php if($medium && $technique) :?>
			<dt>Medium and Technique</dt>
			<dd>
				<?php echo $medium.': ';
				
				// If Free text description is not set, then just show each of the techniaue items
				if(!(in_array('technique_free',$technique_req))):
				
					// loop through the rows of data
				    while ( have_rows('c_technique') ) : the_row();
						
				        if(get_sub_field('intaglio')):
				        	$checkbox = get_sub_field('intaglio');
				        	$last_element = array_pop($checkbox);
				        	array_push($checkbox, 'and '.$last_element);
					        echo implode(', ', $checkbox);
						elseif(get_sub_field('relief')):
							$checkbox = get_sub_field('relief');
				        	$last_element = array_pop($checkbox);
				        	array_push($checkbox, 'and '.$last_element);
					        echo implode(', ', $checkbox);
						elseif(get_sub_field('planographic')):
							$checkbox = get_sub_field('planographic');
				        	$last_element = array_pop($checkbox);
				        	array_push($checkbox, 'and '.$last_element);
					        echo implode(', ', $checkbox);
						elseif(get_sub_field('monotype')):
							$checkbox = get_sub_field('monotype');
				        	$last_element = array_pop($checkbox);
				        	array_push($checkbox, 'and '.$last_element);
					        echo implode(', ', $checkbox);
						elseif(get_sub_field('stencil')):
							$checkbox = get_sub_field('stencil');
				        	$last_element = array_pop($checkbox);
				        	array_push($checkbox, 'and '.$last_element);
					        echo implode(', ', $checkbox);
					    endif;
				
				    endwhile;
				
				// else echo the technique free text description				    
				else: 
					
					echo $technique_desc;
				
				endif; //$technique_req	?>
			</dd>
		<?php endif; ?>
		
		<?php if($support):?>
			<dt>Support</dt>
			<dd><?php echo $support.'. '; ?><?php if($support_desc): echo $support_desc; endif; ?></dd>
		<?php endif; ?>
		
		<?php if($summary_edition): ?>
			<dt>Summary Edition Information</dt>
			<dd><?php echo $summary_edition ?></dd>
		<?php endif; ?>
		
		<?php if(($image_size_h && $image_size_w) || ($matrix_size_h && $matrix_size_w) || ($sheet_size_h && $sheet_size_w)): ?>
			<dt>Dimensions</dt>
			<dd>
				<?php if($image_size_h && $image_size_w) echo 'Image size: '.$image_size_h.' x '.$image_size_w.' mm <br>';
				if($matrix_size_h && $matrix_size_w) echo 'Matrix size: '.$matrix_size_h.' x '.$matrix_size_w.' mm <br>';
				if($sheet_size_h && $sheet_size_w) echo 'Sheet size: '.$sheet_size_h.' x '.$sheet_size_w.' mm <br>';?>
			</dd>
		<?php endif; ?>
		
		<?php if($printers): ?>
			<dt>Printer</dt>
			<dd><?php echo $printers ?></dd>
		<?php endif; ?>
		
		<?php if($collection) :?>
			<dt>Collections</dt>
			<dd>
				<?php // loop through the rows of data
			    while ( have_rows('c_collection') ) : the_row();
			    	$collection_tax = get_sub_field('c_collection_location');
			    	$collection_desc = get_sub_field('c_collection_description');
			    	
			    	$collection_tax_link = get_term_link($collection_tax->term_id, $collection_tax->taxonomy);
			    	
			    	if(function_exists('get_field')) {
						$collection_location_description = get_field('c_collection_location_description', $collection_tax->taxonomy.'_'.$collection_tax->term_id);
					}
			    	
			    	echo '<a href="'.$collection_tax_link.'" title="'.$collection_tax->name.'">'.$collection_tax->name.'</a>';
			    	if($collection_desc) echo ', '.$collection_desc;
			    	if($collection_location_description) echo $collection_location_description;
			    
			    endwhile; ?>
			</dd>
		<?php endif; ?>
		
		<?php if($exhibitions) :?>
			<dt>Exhibitions</dt>
			<dd>
				<?php // loop through the rows of data
			    while ( have_rows('c_exhibitions') ) : the_row();
			    	$exhibition_tax = get_sub_field('c_exhibition_name');
			    	$exhibition_text = get_sub_field('c_exhibition_text');
			    	
			    	$exhibition_tax_link = get_term_link($exhibition_tax->term_id, $exhibition_tax->taxonomy);
			    	
			    	if(function_exists('get_field')) {
						$exhibition_description = get_field('c_exhibition_description', $exhibition_tax->taxonomy.'_'.$exhibition_tax->term_id);
					}
			    	
			    	echo '<a href="'.$exhibition_tax_link.'" title="'.$exhibition_tax->name.'">'.$exhibition_tax->name.'</a>';
			    	if($exhibition_text) echo ', '.$exhibition_text;
			    	if($exhibition_description) echo $exhibition_description;
			    
			    endwhile; ?>
			</dd>
		<?php endif; ?>
		
		<?php if($literature) :?>
			<dt>Literature</dt>
			<dd>
				<?php // loop through the rows of data
			    while ( have_rows('c_literature') ) : the_row();
			    	$literature_tax = get_sub_field('c_literature_title');
			    	$literature_text = get_sub_field('c_literature_text');
			    	
			    	$literature_tax_link = get_term_link($literature_tax->term_id, $literature_tax->taxonomy);
			    	
			    	if(function_exists('get_field')) {
						$literature_description = get_field('c_literature_description', $literature_tax->taxonomy.'_'.$literature_tax->term_id);
					}
			    	
			    	echo '<a href="'.$literature_tax_link.'" title="'.$literature_tax->name.'">'.$literature_tax->name.'</a>';
			    	if($literature_text) echo ', '.$literature_text;
			    	if($literature_description) echo $literature_description;
			    
			    endwhile; ?>
			</dd>
		<?php endif; ?>
		
		<?php if($edition): ?>
			<dt>Edition</dt>
			<dd><?php echo $edition; ?></dd>
		<?php endif; ?>
		
		<?php if($description): ?>
			<dt>Description</dt>
			<dd><?php echo $description; ?></dd>
		<?php endif; ?>
		
		<?php if($comment): ?>
			<dt>Comment</dt>
			<dd><?php echo $comment; ?></dd>
		<?php endif; ?>
		
		<?php if($special_notes): ?>
			<dt>Special Notes</dt>
			<dd><?php echo $special_notes; ?></dd>
		<?php endif; ?>
		
		<?php if($keywords): ?>
			<dt>Keywords</dt>
			<dd><?php 
				
				// Create counter to see if we need to insert a comma
				$k_count = count($keywords);
				$k_counter = 1;
				
				foreach ($keywords as $keyword):
					
					$keyword_link = get_term_link($keyword->term_id, $keyword->taxonomy);
					
					echo '<a href="'.$keyword_link.'" title="'.$keyword->name.'">'.$keyword->name.'</a>';
					
					// Insert comma is this isnt' the final entry
					if($k_count != $k_counter):
						echo ', ';
					endif;
					
					$k_counter++;	
				endforeach;
			?></dd>
		<?php endif; ?>
		
		<?php if($resource_material): ?>
			<dt>Resource Material</dt>
			<dd><?php
				echo '<ul>';
					while ( have_rows('c_resource_material') ) : the_row();
						
						$resource_label = get_sub_field('label');
						$resource_file = get_sub_field('file');					
						
						if($resource_file && $resource_label):
							echo '<li><a href="'.$resource_file.'" title="'.$resource_label.'" target="_blank">'.$resource_label.'</a></li>';
						endif;
						
					endwhile;
				echo '</ul>';
			?></dd>
		<?php endif; ?>
		
	</dl>
	
	<h2>States</h2>
	
	<dl>
		<?php if($states):
			while ( have_rows('c_states') ) : the_row();
				
				$s_title = get_sub_field('s_title');
				$s_description = get_sub_field('s_description');
				$s_image_id = get_sub_field('s_image');		
				
				$state_image = wp_get_attachment_image( $s_image_id, 'large' );
								
				if($s_title) echo '<dt>'.$s_title.'</dt>';
				
				if($s_description) echo '<dd>'.$s_description.$state_image.'</dd>';
					
				
			endwhile;
		endif; ?>
	</dl>
<?php }