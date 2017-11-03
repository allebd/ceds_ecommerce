<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

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