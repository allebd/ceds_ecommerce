<?php
/* Main page template */
get_header();
get_template_part('inc/part', 'single_page_clear');
global $ewdKCAEsinglePageClear;
?>
	
		
		<div class="singlePage<?php echo $ewdKCAEsinglePageClear; ?>">
			<?php get_template_part('inc/part', 'title_area'); ?>
			<div class="clear"></div>
			<section class="panel">
				<div class="wrapper">
					<div class="container">
						<?php woocommerce_content(); ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->	
		
		<div class="clear"></div>
		
<?php
get_footer();
?>		