<?php get_header(); ?>   

		<div class="content">
			<?php if(have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
			<div <?php post_class(); ?>>
				<div class="post-main">
					
					<div class="post">
						<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span><a href="<?php the_permalink(); ?>"><?php the_date(); ?></a></span></h1>
						<?php the_content( '' ); ?><div class="more-link"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php _e( 'Read more...', 'ecogray' ); ?><span class="screen-reader-text"><?php the_title();?></span></a></div>
						<span class="entry-comments"><?php comments_popup_link( ); ?>  </span>
						<div class="categories"><div class="tagi"><?php the_tags(); ?></div>	<?php _e( 'Categories:', 'ecogray' ); ?> <?php the_category(' '); ?></div>
					</div>
				</div> 
			</div> 

					<?php endwhile; ?>
						<?php if(function_exists('wp_pagenavi')) : ?>
						<div class="navigation"><?php wp_pagenavi(); ?></div>
						<?php else : ?>
										<div class="navigation">
											<div class="alignleft"><?php previous_posts_link(__('&laquo; Newer', 'ecogray')) ?></div>
											<div class="alignright"><?php next_posts_link(__('Older &raquo;', 'ecogray')) ?></div>
										</div>
										<?php endif; ?>
					<?php endif; ?>
		</div>





</div>
</div>
</div>
<?php get_footer(); ?>