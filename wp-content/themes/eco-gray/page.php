<?php get_header(); ?>  
		<div class="content">
			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>
			<div class="post-main">
				<div class="post-post">
					<?php the_content(); ?><?php wp_link_pages(); ?><?php comments_template(); ?>
				</div>
			</div>
			<?php endwhile; ?>			
			<?php endif; ?>
		</div>
</div>
</div>
</div>
<?php get_footer(); ?>