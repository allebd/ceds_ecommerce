<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

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
		
		<?php get_sidebar('page'); ?>
	
	    <?php
	    /* Hook: lithestore_after_main_content
	     * @Hooked: lithestore_after_main_content();
	     */
		 do_action('lithestore_after_content');	 
	    ?>
<?php get_footer(); ?>
