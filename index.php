<?php 
// ACF variables
if(function_exists('get_field')):
	
	$home_content_left = get_field('home_content_left','option');
	$home_content_right = get_field('home_content_right','option');
	$select_works = get_field('home_works','option');
		
endif; ?>

<div class="row margin_top margin_bottom">
	
	<div class="col-sm-6 margin_bottom">
		<h2 class="alt">Search the Collection</h2>
		<?php get_search_form(); ?>
		
	</div> <!-- col-sm-6 -->
	
	<div class="col-xs-6 col-sm-3">
		<h2 class="alt">Browse</h2>
		<?php if ( has_nav_menu( 'secondary_nav_2' ) ) : 

			wp_nav_menu( array( 
				'theme_location' => 'secondary_nav_2',
				'container' => 'false', 
				'menu_class' => 'no_bullets',
				'depth' => 1, )
			);
			
		endif ?>
	</div> <!-- col-sm-3 -->
	
	<div class="col-xs-6 col-sm-3">
		<h2 class="alt">About</h2>
		<?php if ( has_nav_menu( 'secondary_nav_1' ) ) : 

			wp_nav_menu( array( 
				'theme_location' => 'secondary_nav_1',
				'container' => 'false', 
				'menu_class' => 'no_bullets',
				'depth' => 1, )
			);
			
		endif ?>
	</div> <!-- col-sm-3 -->
	
</div> <!-- row -->

<?php if($select_works) : ?>
	<div class="row">
		<div class="masonry_container grid">
			<?php foreach($select_works as $work): setup_postdata($work); 
				// Featured image 
				$featured_image = do_free_height_picturefill(get_post_thumbnail_id($work->ID));
				
				// Title
				$get_title = get_the_title($work->ID);
				
				if(get_the_post_thumbnail($work->ID)): ?>
					<div class="grid_item col-xs-6 col-sm-4 col-md-3">
						<a href="<?php echo get_permalink($work->ID); ?>" title="Information about <?php echo $get_title; ?>">
							<?php echo $featured_image; ?>
						</a>
					</div>
				<?php endif;
			
			endforeach; wp_reset_postdata(); ?>
		</div> <!-- masonry_container -->
	</div> <!-- row -->
<?php endif; //$selected_works

// Home Content
if($home_content_left || $home_content_right): ?>

	<div class="row">
		
		<?php if($home_content_left): ?>
			<div class="col-sm-6">
				<?php echo $home_content_left; ?>
			</div>
		<?php endif;
			
		if($home_content_right): ?>
			<div class="col-sm-6">
				<?php echo $home_content_right; ?>
			</div>
		<?php endif; ?>
		
		<div class="clearfix"></div>
	</div>

<?php endif;?>