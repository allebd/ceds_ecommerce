<?php
/* Archive template file */
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
							get_template_part('inc/part', 'blog_layouts_archive');
						}
						else{
						?>
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
								<div id="post-<?php the_ID(); ?>" <?php post_class('archivePost'); ?>>
									<h2 class="archiveH2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php if ( has_post_thumbnail() ){ ?>
										<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
									<?php } ?>
									<?php the_excerpt(); ?>
								</div> <!-- archivePost -->	
							<?php endwhile;
							the_posts_pagination( array(
								'prev_text'          => __( 'Previous page', 'keep-calm-and-e-comm' ),
								'next_text'          => __( 'Next page', 'keep-calm-and-e-comm' ),
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'keep-calm-and-e-comm' ) . ' </span>',
							) );
							else: ?>
								<p><?php _e('Sorry, no content matched your criteria.', 'keep-calm-and-e-comm'); ?></p>
							<?php endif; ?>
						<?php } //else blog_layouts ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->

		<div class="clear"></div>

<?php
get_footer();
?>
