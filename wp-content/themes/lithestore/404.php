<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package LitheStore
 */

get_header(); ?>

	<?php
	  /* Hook: lithestore_before_content
	   * @Hooked: lithestore_before_content()
	   */
	  do_action('lithestore_before_content');
	?>

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'lithestore' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'lithestore' ); ?></p>
                    <br />
					<?php get_search_form(); ?>


				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		<?php
		  /* Hook: lithestore_after_content
	       * @Hooked: lithestore_after_main_content();
		   */
		  do_action('lithestore_after_content');
		?>

<?php get_footer(); ?>
