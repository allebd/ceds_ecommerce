<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

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
