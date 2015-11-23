<header class="banner" role="banner" id="top">
				
	<div class="container">
		<div class="header_main">
			<div class="header_border">
				<div class="row">
					
					<div class="col-xs-9 col-sm-10 col-md-7 brand_col">
						<a class="brand" href="<?= esc_url(home_url('/')); ?>">
							<h1><?php bloginfo('name'); ?> <span><?php bloginfo( 'description' ); ?></span></h1>
						</a>
					</div>
					<div class="col-xs-3 col-sm-2 col-md-1 header_mobile_icons pull-right">
						<div class="header_hamburger_menu">
							<a href="javascript:void(0)" class="icon">
								<div class="hamburger">
								<div class="menui top-menu"></div>
								<div class="menui mid-menu"></div>
								<div class="menui bottom-menu"></div>
								</div>
							</a>
						</div> <!-- header_hamburger_menu -->
						<div class="header_search">
							<span class="icon-search" id="search_toggle"></span>
						</div> <!-- header_search -->
					</div>
					
					<?php include(locate_template( 'templates/menu-primary.php' )); ?>
					<div class="clearfix"></div>
				
				</div> <!-- row -->	
			
				<div class="sb-search" id="sb-search">
					<form method="get" class="search_form" action="<?php echo trailingslashit( home_url() ); ?>">
						<input class="sb-search-input" id="search" type="search" name="s" value="<?php echo sanitize_text_field($_GET['q']); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
						<input class="sb-search-submit" name="submit" type="submit" value="<?php esc_attr_e( 'Search', 'jch' ); ?>" />
						<div class="clearfix"></div>
					</form><!-- .search_form -->
				</div> 
				<div class="clearfix"></div>
				
			</div> <!-- header_border -->
		</div> <!-- header_main -->
	</div> <!-- container -->
		
</header>
