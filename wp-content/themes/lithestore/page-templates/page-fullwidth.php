<?php
/**
 * Template Name: Full Width Page
 *
 * This is the template that displays the pages with fullwidth template.
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package LitheStore
 */

get_header(); ?>

	<?php
	  /* Hook: lithestore_before_content, lithestore_before_main_content
	   * @Hooked: lithestore_before_content()
	   */
	  do_action('lithestore_before_content');
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
	  /* Hook: lithestore_after_content
	   * @Hooked: lithestore_after_content()
	   */
	  do_action('lithestore_after_content');
	?>
<?php get_footer(); ?>
