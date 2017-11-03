<?php /* Footer */

$copyrightText = '&copy; ';
$copyrightText .= date('Y');
if( ! function_exists( 'ewd_kcae_prem_setting_sanitize_false') || get_theme_mod('ewd_kcae_prem_setting_label_copyright') == '' ){
	$Copyright_Text_Label = $copyrightText;
}
else{
	$Copyright_Text_Label = get_theme_mod('ewd_kcae_prem_setting_label_copyright');
}
?>

		<div class="clear"></div>

		<section class="panel blackPanel" id="footer">
			<div class="wrapper">
				<div class="container">
					<?php if ( dynamic_sidebar('footer_widget') ) : else : endif; ?>
				</div> <!-- container -->
			</div> <!-- wrapper -->			
		</section> <!-- footer -->

		<div class="clear"></div>

		<section class="panel blackPanel" id="copyrightPanel">
			<div class="wrapper">
				<div class="container">
					<div class="copyright"><?php echo esc_html($Copyright_Text_Label); ?></div>
				</div> <!-- container -->
			</div> <!-- wrapper -->
		</section>
	<?php wp_footer(); ?>			
	</body>
</html>