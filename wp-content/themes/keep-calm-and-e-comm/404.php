<?php
/* 404 template file */
get_header();
if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
	$Label_404_Page_Content = get_theme_mod('ewd_kcae_prem_setting_label_404_text', __( 'The requested URL was not found.', 'keep-calm-and-e-comm' ) );
}
else{
	$Label_404_Page_Content = __( 'The requested URL was not found.', 'keep-calm-and-e-comm' );
}
get_template_part('inc/part', 'single_page_clear');
global $ewdKCAEsinglePageClear;
?>

		<div class="singlePage<?php echo $ewdKCAEsinglePageClear; ?>">
			<?php get_template_part('inc/part', 'title_area'); ?>
			<div class="clear"></div>
			<section class="panel">
				<div class="wrapper">
					<div class="container">
						<section class="pageWithSidebarContent">
							<p><?php echo esc_html($Label_404_Page_Content); ?></p>
							<p>
								<?php _e('Use the form below to search the site.', 'keep-calm-and-e-comm'); ?>
								<br />
								<?php get_search_form(); ?>
							</p>
						</section> <!-- pageWithSidebarContent -->
						<?php get_sidebar(); ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>
		</div> <!-- singlePage -->

		<div class="clear"></div>

<?php
get_footer();
?>
