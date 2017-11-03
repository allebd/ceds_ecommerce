<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LitheStore
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
	return;
}
?>

<div id="shop-secondary" class="ls-grid ls-col3 widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-shop' ); ?>
</div><!-- #secondary -->
