<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package LitheStore
 */

get_header(); ?>

	<div id="page" class="hfeed site ls-grid-1000">
	  <div id="content" class="site-content">
		<main id="main" class="ls-grid ls-col8 site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="section-title"><?php printf( esc_html__( 'Search Results for: %s', 'lithestore' ), '<span>' . get_search_query() . '</span>' ); ?><div class="divider"><span></span></div></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
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