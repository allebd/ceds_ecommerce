<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package LitheStore
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark"><?php if(has_post_thumbnail()){the_post_thumbnail('large');}?></a>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php lithestore_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
   
    <div class="divider"></div>
   
	<footer class="entry-footer">
		<?php lithestore_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	
	<div class="divider"></div>
</article><!-- #post-## -->
