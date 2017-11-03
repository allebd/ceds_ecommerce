<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package LitheStore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if(has_post_thumbnail()):?>
	<a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark"><?php if(has_post_thumbnail()){the_post_thumbnail('large');}?></a>
	<?php endif;?>
	
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php lithestore_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		
		if(!has_post_thumbnail()){
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'lithestore' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		}else{
			the_excerpt();
			echo '<p><a href="'.esc_url(get_permalink()).'" title="'.get_the_title().'">'.esc_html__('Continue reading','lithestore').' <span class="meta-nav">&rarr;</span></a></p>';
		}
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lithestore' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	
	<div class="divider"></div>

	<footer class="entry-footer">
		<?php lithestore_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<div class="divider"></div>

</article><!-- #post-## -->
