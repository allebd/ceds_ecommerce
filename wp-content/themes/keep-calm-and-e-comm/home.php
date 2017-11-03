<?php
/* Blog home template file */
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
						<?php
						if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
							get_template_part('inc/part', 'blog_layouts_home');
						}
						else{
						?>
							<section class="pageWithSidebarContent">
								<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
									<div class="archivePost">
										<h2 class="archiveH2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<p style="margin-bottom: 16px;">
											<?php
											echo '<a href="' . get_permalink() . '">' . __('Posted by', 'keep-calm-and-e-comm') . '</a> ' . __('by', 'keep-calm-and-e-comm') . ' <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a> ' . __('on', 'keep-calm-and-e-comm') . ' ';
											the_date();
											echo ' ' . __('in', 'keep-calm-and-e-comm') . ' ' . get_the_category_list( ', ' );
											?>
										</p>
										<div class="clear"></div>
										<?php if ( has_post_thumbnail() ){ ?>
											<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
										<?php } ?>
										<?php the_excerpt(); ?>
									</div> <!-- archivePost -->
								<?php endwhile; else: ?>
									<p><?php _e('Sorry, no content matched your criteria.', 'keep-calm-and-e-comm'); ?></p>
								<?php endif; ?>
							</section> <!-- pageWithSidebarContent -->
							<?php get_sidebar('blog'); ?>
						<?php } //else blog_layouts ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->

		<div class="clear"></div>

<?php
get_footer();
?>
