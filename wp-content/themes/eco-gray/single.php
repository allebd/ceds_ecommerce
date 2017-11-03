<?php get_header(); ?>   
		<div class="content">
			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
			<div <?php post_class(); ?>>
			<div class="post-main"> 
				<div class="post">
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span><?php the_date(); ?></span></h1>
					<?php the_content(); ?>
					<?php wp_link_pages(); ?> 
					

						<div class="categories"><div class="tagi"><?php the_tags(); ?></div>	<?php _e( 'Categories:', 'ecogray' ); ?> <?php the_category(' '); ?></div>
						<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'ecogray' ) . '</span> %title' ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'ecogray' ) . '</span>' ); ?></span>
					<?php comments_template(); ?>
				</div>
			</div>
			<?php endwhile; ?>
			<?php endif; ?>
		</div>

</div></div>
</div></div>
<?php get_footer(); ?>