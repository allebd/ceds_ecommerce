<?php
/**
 * LitheStore Hooks
 *
 * @package LitheStore
 */

/**
 * General
 * @see  lithestore_support()
 * @see  lithestore_content_width()
 * @see  lithestore_widgets_init()
 * @see  lithestore_scripts()
 * @see  lithestore_font_styles()
 * @see  lithestore_load_framework()
 */
add_action( 'after_setup_theme', 'lithestore_support' );
add_action( 'after_setup_theme', 'lithestore_content_width', 0 );
add_action( 'widgets_init', 'lithestore_widgets_init' );
add_action( 'wp_enqueue_scripts', 'lithestore_scripts',10);
add_action( 'wp_enqueue_scripts', 'lithestore_font_styles' );
add_action( 'lithestore_init', 'lithestore_load_framework' );

/**
 * Wrapper
 * @see  lithestore_before_content()
 * @see  lithestore_after_content()
 * @see  lithestore_before_main_content()
 * @see  lithestore_after_main_content()
 */
add_action( 'lithestore_before_content', 'lithestore_before_content' );
add_action( 'lithestore_after_content', 'lithestore_after_content');
add_action( 'lithestore_before_main_content', 'lithestore_before_main_content' );
add_action( 'lithestore_after_main_content', 'lithestore_after_main_content' );

/**
 * Homepage
 * @see  lithestore_product_categories()
 * @see  lithestore_featured_products()
 * @see  lithestore_popular_products()
 * @see  lithestore_recent_products()
 * @see  lithestore_on_sale_products()
 */
add_action( 'lithestore_product_categories', 'lithestore_product_categories');
add_action( 'lithestore_featured_products', 'lithestore_featured_products');
add_action( 'lithestore_popular_products', 'lithestore_popular_products');
add_action( 'lithestore_recent_products', 'lithestore_recent_products');
add_action( 'lithestore_on_sale_products', 'lithestore_on_sale_products');


/**
 * Header
 * @see lithestore_before_navigation()
 * @see lithestore_custom_logo()
 * @see lithestore_primary_navigation()
 * @see lithestore_top_buttons()
 * @see lithestore_after_navigation()
 * @see lithestore_cover()	
 */
add_action( 'lithestore_header', 'lithestore_before_navigation',0);
add_action( 'lithestore_header', 'lithestore_custom_logo',10);
add_action( 'lithestore_header', 'lithestore_primary_navigation',20);
add_action( 'lithestore_header', 'lithestore_top_buttons',30);
add_action( 'lithestore_header', 'lithestore_after_navigation',40);
add_action( 'lithestore_header', 'lithestore_cover',50);

/**
 * Footer
 * @see lithestore_copyright()	
 */
add_action( 'lithestore_footer', 'lithestore_copyright');