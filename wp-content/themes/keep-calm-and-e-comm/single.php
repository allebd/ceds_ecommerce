<?php
/* Single Post Template */
get_header();
?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
			$thisPostClass = 'singlePage';
			if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
				$utilityNavEnable = get_theme_mod('ewd_kcae_prem_setting_utility_nav_enable', 'yes');
				$promoBar = get_theme_mod('ewd_kcae_prem_setting_promo_bar_enable', 'no');
				if($utilityNavEnable == 'yes' && $promoBar == 'no'){
					$thisPostClass = 'singlePage utilityNavClear';
				}
				elseif($utilityNavEnable == 'no' && $promoBar == 'yes'){
					$thisPostClass = 'singlePage promoBarClear';
				}
				elseif($utilityNavEnable == 'yes' && $promoBar == 'yes'){
					$thisPostClass = 'singlePage utilityNavAndPromoBarClear';
				}
				else{
					$thisPostClass = 'singlePage';
				}
			}
			?>
			<div id="post-<?php the_ID(); ?>" <?php post_class($thisPostClass); ?>>
				<?php get_template_part('inc/part', 'title_area'); ?>
				<div class="clear"></div>
				<section class="panel">
					<div class="wrapper">
						<div class="container">
							<?php
							if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
								get_template_part('inc/part', 'blog_layouts_single');
							}
							else{
							?>
								<section class="pageWithSidebarContent">
									<p style="margin-bottom: 16px;">
										<?php 
										echo '<a href="' . get_permalink() . '">' . __('Posted', 'keep-calm-and-e-comm') . '</a> ' . __('by', 'keep-calm-and-e-comm') . ' <a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '">' . get_the_author() . '</a> ' . __('on', 'keep-calm-and-e-comm') . ' ';
										the_date();
										echo ' ' . __('in', 'keep-calm-and-e-comm') . ' ' . get_the_category_list( ', ' );
										?>
									</p>
									<div class="clear"></div>
									<?php if ( has_post_thumbnail() ){ ?>
										<div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
									<?php } ?>
									<?php the_content(); ?>
									<div class="clear"></div>
									<p><?php echo get_the_tag_list( __('<p>Tags: ', 'keep-calm-and-e-comm'),', ',__('</p>', 'keep-calm-and-e-comm') ); ?></p>
									<?php edit_post_link(__('Edit', 'keep-calm-and-e-comm'), '<p>', '</p>'); ?>
									<div class="clear"></div>
									<?php
									wp_link_pages( array(
										'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'keep-calm-and-e-comm' ) . '</span>',
										'after'       => '</div>',
										'link_before' => '<span>',
										'link_after'  => '</span>',
										'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'keep-calm-and-e-comm' ) . ' </span>%',
										'separator'   => '<span class="screen-reader-text">, </span>',
									) );
									?>
									<div class="clear"></div>
									<div class="postsNavigation">
										<?php
										the_post_navigation( array(
											'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next:', 'keep-calm-and-e-comm' ) . '</span> ' .
												'<span class="screen-reader-text">' . __( 'Next post:', 'keep-calm-and-e-comm' ) . '</span> ' .
												'<span class="post-title">%title</span>&nbsp;&nbsp;&gt;&gt;',
											'prev_text' => '&lt;&lt;&nbsp;&nbsp;<span class="meta-nav" aria-hidden="true">' . __( 'Previous:', 'keep-calm-and-e-comm' ) . '</span> ' .
												'<span class="screen-reader-text">' . __( 'Previous post:', 'keep-calm-and-e-comm' ) . '</span> ' .
												'<span class="post-title">%title</span>',
										) );
										?>
									</div> <!-- postsNavigation -->	
									<div class="clear"></div>
									<div class="postComments">
										<?php
										if ( comments_open() || get_comments_number() ) {
											comments_template();
										}
										?>
									</div> <!-- postComments -->	
								</section> <!-- pageWithSidebarContent -->
								<?php get_sidebar('blog'); ?>
							<?php } //else blog_layouts ?>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			</div> <!-- singlePage -->
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no content matched your criteria.', 'keep-calm-and-e-comm'); ?></p>
		<?php endif; ?>

		<div class="clear"></div>

<?php
get_footer();
?>
