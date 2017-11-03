<?php
/* Template Name: With Right Sidebar */
get_header();
get_template_part('inc/part', 'single_page_clear');
global $ewdKCAEsinglePageClear;
?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="singlePage<?php echo $ewdKCAEsinglePageClear; ?>">
				<?php get_template_part('inc/part', 'title_area'); ?>
				<div class="clear"></div>
				<section class="panel">
					<div class="wrapper">
						<div class="container">
							<section class="pageWithSidebarContent">
								<?php get_template_part('inc/part', 'page_thumbnail'); ?>
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
								<?php edit_post_link(__('Edit', 'keep-calm-and-e-comm'), '<p>', '</p>'); ?>
								<div class="clear"></div>
								<div class="postComments">
									<?php
									if ( comments_open() || get_comments_number() ) {
										comments_template();
									}
									?>
								</div> <!-- postComments -->	
							</section> <!-- pageWithSidebarContent -->
							<?php get_sidebar(); ?>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			</div> <!-- singlePage -->
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no content matched your criteria.', 'keep-calm-and-e-comm'); ?></p>
		<?php endif; ?>

		<div class="clear"></div>

<?php
get_footer();
?>
