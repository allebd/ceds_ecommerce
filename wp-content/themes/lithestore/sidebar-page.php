<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LitheStore
 */

if ( ! is_active_sidebar( 'sidebar-page' ) ) {
	return;
}
?>

<div id="secondary" class="ls-grid ls-col3 widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-page' ); ?>
</div><!-- #secondary -->
