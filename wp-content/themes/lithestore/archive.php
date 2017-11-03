<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package LitheStore
 */

get_header(); ?>
	
	<?php
	  /* Hook: lithestore_before_content, lithestore_before_main_content
	   * @Hooked: lithestore_before_content()
	   * @Hooked: lithestore_before_main_content();
	   */
	  do_action('lithestore_before_content');
	  do_action('lithestore_before_main_content');
	?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="section-title">', '<div class="divider"><span></span></div></h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php echo lithestore_pagenavi(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		<?php
		  /* Hook: lithestore_after_main_content
		   * @Hooked: lithestore_after_main_content();
		   */
		  do_action('lithestore_after_main_content');
		?>

        <?php get_sidebar(); ?>
	
	    <?php
	    /* Hook: lithestore_after_main_content
	     * @Hooked: lithestore_after_main_content();
	     */
		 do_action('lithestore_after_content');	 
	    ?>
  
<?php get_footer(); ?>
