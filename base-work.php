<?php

use Roots\Sage\Config;
use Roots\Sage\Wrapper;

?>

<?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if lt IE 9]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="wrap container" role="document">
		<div class="content">
			<?php if(is_search()): ?>
	        	<aside class="sidebar" role="complementary">
		        	
<!--
		        	<?php if(is_dynamic_sidebar('sidebar-search')): ?>
							<?php dynamic_sidebar('sidebar-search'); ?>
					<?php endif; ?> 
-->
		        	<?php //echo do_shortcode('[facetwp facet="artist_number"]'); ?>
			        <?php echo facetwp_display( 'facet', 'artist_number' ); ?>
		        </aside><!-- /.sidebar -->
	        <?php endif; ?>
			<main class="main" role="main" id="page">
				<?php include Wrapper\template_path(); ?>
			</main><!-- /.main -->
			
			<div class="clearfix"></div>
		</div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  </body>
</html>
