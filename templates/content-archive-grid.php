<?php // ACF Variables
if(function_exists('get_field')):

	// Check to see if this is the alternative, only run if that is the case
	$get_alt_original = get_field('c_alternative_title', $post->ID);
	
	$orig_title_select_id = get_field('c_original_title_select', $post_id);
			    
    if($get_alt_original == 'is_alternative'):
    
		$post_id = $orig_title_select_id[0];
		$alt_id = $post->ID;
		
	endif; //is_alternative
	
	// Get date data for the title
	// This information is also in infoboxes.php
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
	
	$cat_number = get_field('c_catalog_number', $post_id);
	
	// Dimensions
	$image_size_h = get_field('c_dimensions_image_size_height', $post_id);
	$image_size_w = get_field('c_dimensions_image_size_width', $post_id);
	$matrix_size_h = get_field('c_dimensions_matrix_size_height', $post_id);
	$matrix_size_w = get_field('c_dimensions_matrix_size_width', $post_id);
	$sheet_size_h = get_field('c_dimensions_sheet_height', $post_id);
	$sheet_size_w = get_field('c_dimensions_sheet_width', $post_id);

endif;

// Featured image 
$featured_image = do_free_height_picturefill(get_post_thumbnail_id());

// Title
$get_title = get_the_title();

// show different layout if SEARCH and extra ACF fields
if(is_search()):
	
	if(function_exists('get_field')):
	
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
	
	endif; ?>

	<article class="col-sm-6 margin_bottom">
		
		<div <?php post_class(); ?>>
			<?php if(get_the_post_thumbnail($post->ID)): ?>
				<div class="col-sm-5">
					<a href="<?php the_permalink(); ?>" title="Information about <?php echo $get_title; ?>">
						<?php echo $featured_image; ?>
					</a>
				</div>
				
				<div class="col-sm-7">
			<?php endif; ?>
			
			<header>
				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="Information about <?php echo $get_title; ?>">
						<?php // Title
						if($title  && !($date_start || $date_end)):
							echo $title;
							
						// Title and date
						elseif($title && ($date_start || $date_end)):
							if(!$date_desc_req):
								echo $title.' ';
									
								if($date_start != $date_end):
									echo $date_start.' - '.$date_end;
								else:
									echo $date_start;
								endif;
							else:
								echo $title.' '; echo $date_desc;
							endif;
						endif; ?>
					</a>
				</h3>
			</header>
			
			<ul class="no_bullets">
				
				<?php if($cat_number) echo '<li><strong>Catalogue Number</strong>: <span class="capitalise">'.$cat_number.'</span></li>';
					
				// Dimensions
				if(($image_size_h && $image_size_w) || ($matrix_size_h && $matrix_size_w) || ($sheet_size_h && $sheet_size_w)):
					if($image_size_h && $image_size_w) echo '<li><strong>Image size</strong>: '.$image_size_h.' x '.$image_size_w.' mm </li>';
					if($matrix_size_h && $matrix_size_w) echo '<li><strong>Plate mark</strong>: '.$matrix_size_h.' x '.$matrix_size_w.' mm </li>';
					if($sheet_size_h && $sheet_size_w) echo '<li><strong>Sheet size</strong>: '.$sheet_size_h.' x '.$sheet_size_w.' mm </li>';
				endif;
				
				// Medium and Technique
				if($medium && $technique): ?>
					
					<li>
						<?php echo '<strong>'.$medium.'</strong>: ';
							
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
						endif; //$technique_req ?>
					</li>
					
				 <?php endif; //$medium && $technique ?>
				
			</ul>
			
			<?php if(get_the_post_thumbnail($post->ID)): ?>
				</div>
			<?php endif; ?>
			
		</div> <!-- post_class -->
		
	</article>
	
<?php else: ?>
	
	<article class="col-sm-4 col-md-3 small_margin_bottom grid_item">
		
		<div <?php post_class(); ?>>
			<?php if(get_the_post_thumbnail($post->ID)): ?>
				<div class="small_margin_bottom">
					<a href="<?php the_permalink(); ?>" title="Information about <?php echo $get_title; ?>">
						<?php echo $featured_image; ?>
					</a>
				</div>
			<?php endif; ?>
			<header>
				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="Information about <?php echo $get_title; ?>">
						<?php // Title
						if($title  && !($date_start || $date_end)):
							echo $title;
							
						// Title and date
						elseif($title && ($date_start || $date_end)):
							if(!$date_desc_req):
								echo $title.' ';
									
								if($date_start != $date_end):
									echo $date_start.' - '.$date_end;
								else:
									echo $date_start;
								endif;
							else:
								echo $title.' '; echo $date_desc;
							endif;
						endif; ?>
					</a>
				</h3>
			</header>
			
			<ul class="no_bullets">
				
				<?php if($cat_number) echo '<li>Catalogue Number: '.$cat_number.'</li>';
					
				// Dimensions
				if(($image_size_h && $image_size_w) || ($matrix_size_h && $matrix_size_w) || ($sheet_size_h && $sheet_size_w)):
					if($image_size_h && $image_size_w) echo '<li>Image size: '.$image_size_h.' x '.$image_size_w.' mm </li>';
					if($matrix_size_h && $matrix_size_w) echo '<li>Plate mark: '.$matrix_size_h.' x '.$matrix_size_w.' mm </li>';
					if($sheet_size_h && $sheet_size_w) echo '<li>Sheet size: '.$sheet_size_h.' x '.$sheet_size_w.' mm </li>';
				endif; ?>
				
			</ul>
		</div> <!-- post_class -->
		
	</article>
	
<?php endif; ?>