<?php
/**
 * Custom functions that act independently of the WooCommerce default templates.
 * Eventually, some of the functionality here could be replaced by core features.
 * @package LitheStore
 */


/* Remove each style one by one
 * ----------------------------
 * All WooCommerce CSS file are combined in /framework/assets/css/woocommerce.css
 */
//add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * Change 2 columns layout for WooCommerce Related Product
 * --------------------------------------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 
add_filter( 'woocommerce_output_related_products_args', 'lithestore_related_products_args' );
function lithestore_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 2; // arranged in 2 columns
	return $args;
}

/**
 * Customize the WooCommerce breadcrumb.
 * --------------------------------------------------------
 */ 
add_filter( 'woocommerce_breadcrumb_defaults', 'lithestore_woocommerce_breadcrumbs' );
function lithestore_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => ' &#47; ',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb"><i class="fa fa-home"></i>',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => _x( 'Home', 'breadcrumb', 'lithestore' ),
        );
}

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

/**
 * Products per page
 * ---------------------------------------------------
 */
add_filter( 'loop_shop_per_page','lithestore_products_per_page' );
function lithestore_products_per_page() {
	return intval( apply_filters( 'lithestore_products_per_page', 12 ) );
}
