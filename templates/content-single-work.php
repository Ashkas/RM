<?php while (have_posts()) : the_post(); 
	
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
	
	?>

<article id="print-work">
	  
    <header>
		<h1 class="work_title">
			<?php // if title and no date
			if($title  && !($date_start || $date_end)):
			
				echo $title;
				
			// if Title and date
			elseif($title && ($date_start || $date_end)):
				
				if(!$date_desc_req): 
						echo $title.' ';
							
						if($date_start != $date_end):
							echo '<span>'.$date_start.' - '.$date_end.'</span>';
						else:
							echo '<span>'.$date_start.'</span>';
						endif;
				else:
					echo $title.' '; echo '<span>'.$date_desc.'</span>';
				endif;
				
			endif;?>
		</h1>
    </header>
    <div class="entry-content work_entry">
		
		<div class="row">
			<div class="col-sm-5">
				
				<?php if(have_rows('c_states', $post_id)): ?>
					
					<!-- 				Slideshow -->
					<div class="owl-carousel amor-theme" id="work_slider">
						<?php $counter = 1; while ( have_rows('c_states', $post_id) ) : the_row();
							
							$s_title = get_sub_field('s_title');
							//$s_description = get_sub_field('s_description');
							$s_image_id = get_sub_field('s_image');		
							
							$state_image_large = wp_get_attachment_image_src( $s_image_id, 'medium' );
							$state_image_full = wp_get_attachment_image_src( $s_image_id, 'large' );
																		
							$s_final_state = get_sub_field('s_final_state');
							
							if($s_final_state) {
								$final_state = 'id="final_state"';
								$final_state_img_for_print = $state_image_large[0];
							}
							
							if($s_image_id): ?>
								<div class="item" <?php if($counter == 2) echo $final_state;?>>
									 <a href='<?php echo $state_image_full[0]; ?>' class='fresco' data-fresco-group='<?php echo "work".$post->D; ?>' data-fresco-caption="<?php echo $s_title; ?>">
										 <img src="<?php echo $state_image_large[0]; ?>" class="<?php if(!$s_final_state) echo 'dont-print-work'; ?>" data-src="<?php echo $state_image_large[0]; ?>">
										<?php //echo $state_image_large; ?>
									 </a>
									 
									 <?php if($s_title) echo '<h2 class="state_title dont-print-work">'.$s_title.'</h2>'; ?>
								</div>
							<?php endif;
							
						$counter++; endwhile; ?>
					</div> <!-- owl-carousel work_slider-->
					
					<?php if($final_state_img_for_print):
						
						echo '<img src="'.$final_state_img_for_print.'" class="print_work_img">';
						
					endif; ?>
					
					<!-- 				Carousel navigation -->
					<div class="owl-carousel amor-theme margin_bottom no-print" id="work_slider_navigation">
						<?php while ( have_rows('c_states', $post_id) ) : the_row();
							
							//$s_title = get_sub_field('s_title');
							//$s_description = get_sub_field('s_description');
							$s_image_id = get_sub_field('s_image');		
							
							$state_image = wp_get_attachment_image( $s_image_id, 'thumbnail' );
											
							//if($s_title) echo '<h2 class="state_title dont-print-work"'.$s_title.'</h2>';
							
							if($s_image_id):
								echo '<div class="item dont-print-work">'.$state_image.'</div>';
							endif;
							
						endwhile; ?>
					</div> <!-- owl-carousel work_carousel-->
					
					<div class="morph-button morph-button-overlay morph-button-fixed">
						<button type="button">View Description for all States</button>
						<div class="morph-content">
							<div>
								<div class="content-style-overlay work_states">
									
									<h2 class="centre_text">
										<?php // if title and no date
										if($title  && !($date_start || $date_end)):
										
											echo $title.' - '.'<span class="capitalise">'.$cat_number.'</span>';
											
										// if Title and date
										elseif($title && ($date_start || $date_end)):
											
											if(!$date_desc_req): 
													echo $title.' ';
														
													if($date_start != $date_end):
														echo '<span>'.$date_start.' - '.$date_end.'</span> - '.'<span class="capitalise">'.$cat_number.'</span>';
													else:
														echo '<span>'.$date_start.'</span> - '.$cat_number;
													endif;
											else:
												echo $title.' '; echo '<span>'.$date_desc.'</span> - '.'<span class="capitalise">'.$cat_number.'</span>';
											endif;
											
										endif;?>
									</h2>
									
									<span class="icon icon-close icon-cross dont-print-states">Close the overlay</span>
									
									<button class="print-states">Print <span class="icon-printer"></span></button>
									
									<div id="print-states">
										<ul class="zebra_list">
											
											<?php while ( have_rows('c_states', $post_id) ) : the_row();
								
												$s_title = get_sub_field('s_title');
												$s_description = get_sub_field('s_description');
												$s_image_id = get_sub_field('s_image');	
												$state_image = wp_get_attachment_image( $s_image_id, 'medium' );
												
												if($s_title): ?>
													<li class="overlay_grid">
														<h3><?php echo $s_title; ?></h3>
														
														<?php if($s_image_id): ?>
														
															<div class="row">
																
																<?php if($s_image_id): ?>
																	<figure class="col-xs-3">
																		<?php echo$state_image; ?>
																	</figure>
																<?php endif;
																	
																if($s_description):?>
																	<div class="col-xs-9">
																		<?php echo $s_description; ?>
																	</div>
																<?php endif; ?>
																<div class="clearfix"></div>
															</div>
															
														<?php elseif(!$s_image_id && $s_description): ?>
															<div class="row">
																<div class="col-xs-12">
																	<?php if($s_description):?>
																		<?php echo $s_description; ?>
																	<?php endif; ?>
																</div>
															</div>
														<?php endif; ?>
	
														<div class="clearfix"></div>
													</li>
												<?php endif;
												
											endwhile; ?>
											
											
										</ul>
									</div> <!-- print-states -->
								</div>
							</div>
						</div>
					</div><!-- morph-button -->
					
					<!-- 				Descriptions -->
					<div class="owl-carousel amor-theme margin_bottom" id="work_slider_description">
						<?php while ( have_rows('c_states', $post_id) ) : the_row();
							
							//$s_title = get_sub_field('s_title');
							$s_description = get_sub_field('s_description');
							$s_image_id = get_sub_field('s_image');	
							
							if($s_image_id /* && $s_title */): ?>
								<div class="item">
<!-- 									 <h2 class="state_title dont-print-work"><?php echo $s_title; ?></h2> -->
									 <?php if($s_description) echo $s_description; ?>
								</div>
							<?php endif;
							
						endwhile; ?>
					</div> <!-- owl-carousel work_slider_description-->
										
				<?php endif; // have_rows ?>
				
			</div> <!-- col-sm-5 -->
		    
		    <div class="col-sm-7">
			    <?php if( current_user_can('edit_others_pages') ) {  
				    
				    // stuff here for user roles that can edit pages: editors and administrators
					edit_post_link('Edit Work', '<p>', '</p>');
				}  ?>
				
				<nav class="work_pagination margin_bottom dont-print-work">
			    	<div class="row">
					    <div class="col-xs-6">
						    <?php if(function_exists('previous_post_link_plus')):
						    	previous_post_link_plus( array(
								    'post_type' => '"work"',
								    'in_same_cat' => true,
								    'link' => 'Previous',
								    'in_same_tax' => 'medium',
								    'order_by' => 'numeric',
								    'meta_key' => 'c_number'
							    ) );
						    endif;
						    //previous_post_link(); //previous_post_link( '%link', 'Previous post in taxonomy', TRUE, ' ', 'type' );  ?>
					    </div>
							
						<div class="col-xs-6 text-right">
							<?php  if(function_exists('next_post_link_plus')):
								next_post_link_plus( array(
									'post_type' => '"work"',
									'in_same_cat' => true,
									'link' => 'Next',
									'in_same_tax' => 'medium',
									'order_by' => 'numeric',
									'meta_key' => 'c_number'
								) );
							endif;
							//next_post_link( '%link', 'Next post in taxonomy', TRUE, ' ', 'type' ); ?>
						</div>
						<div class="clearfix"></div>
			    	</div> <!-- row -->
		    	</nav> <!--  work_pagination -->
				
				<button class="print-work">Print <span class="icon-printer"></span></button>
				
				<?php // The Work Data
				workEntry($post_id, $alt_id); ?>
		    </div>
		    <div class="clearfix"></div>
		</div> <!-- row -->
    </div> <!-- work_entry -->
    <footer>
    	<nav class="work_pagination margin_bottom dont-print-work">
	    	<div class="row">
			    <div class="col-xs-6">
				    <?php if(function_exists('previous_post_link_plus')):
				    	previous_post_link_plus( array(
						    'post_type' => '"work"',
						    'in_same_cat' => true,
						    'link' => 'Previous',
						    'in_same_tax' => 'medium',
						    'order_by' => 'numeric',
						    'meta_key' => 'c_number'
					    ) );
				    endif;
				    //previous_post_link(); //previous_post_link( '%link', 'Previous post in taxonomy', TRUE, ' ', 'type' );  ?>
			    </div>
					
				<div class="col-xs-6 text-right">
					<?php  if(function_exists('next_post_link_plus')):
						next_post_link_plus( array(
							'post_type' => '"work"',
							'in_same_cat' => true,
							'link' => 'Next',
							'in_same_tax' => 'medium',
							'order_by' => 'numeric',
							'meta_key' => 'c_number'
						) );
					endif;
					//next_post_link( '%link', 'Next post in taxonomy', TRUE, ' ', 'type' ); ?>
				</div>
				<div class="clearfix"></div>
	    	</div> <!-- row -->
    	</nav> <!--  work_pagination -->
    </footer>
  </article>
<?php endwhile; ?>
