<footer class="content-info" role="contentinfo">
	<div class="container">
		<div class="row">
			<?php if(is_dynamic_sidebar('sidebar-footer')): ?>
				<div class="col-sm-6">
					<?php dynamic_sidebar('sidebar-footer'); ?>
				</div> <!-- col-sm-6 -->
			<?php endif; ?>
			
			<div class="col-sm-6 pull-right-sm right_text">
				<small>Copyright Rick Amor <?php echo do_shortcode('[year]'); ?>.</small>
			</div> <!-- col-sm-6 -->
			<div class="clearfix"></div>
		</di> <!-- row -->
	</div> <!-- container -->
</footer>
