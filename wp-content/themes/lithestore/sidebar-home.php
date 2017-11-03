<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LitheStore
 */
?>

<div id="home-secondary" class="ls-grid ls-col3 widget-area" role="complementary">
	<?php 
	if ( is_active_sidebar( 'sidebar-home' ) ):
	  dynamic_sidebar( 'sidebar-home' ); 
	else:
	?>
	<aside class="widget">
		<h2 class="widget-title"><?php esc_html_e('No Widget!','lithestore');?></h2>
		<div class="textwidget">
		  <?php esc_html_e('You could add some widgets here in Appearance > Widgets, drop the widget to the Homepage sidebar area.','lithestore');?>
		</div>
	</aside>
	<?php endif;?>
</div><!-- #secondary -->
