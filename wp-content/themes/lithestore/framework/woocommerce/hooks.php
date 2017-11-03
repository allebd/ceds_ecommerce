<?php
/**
 * LitheStore WooCommerce Hooks
 *
 * @package LitheStore
 */

/**
 * Wrapper
 * @hooked  lithestore_before_content()
 * @hooked  lithestore_after_content()
 * @hooked  lithestore_before_main_content()
 * @hooked  lithestore_after_main_content()
 * @hooked  lithestore_shop_sidebar()
 * @hooked  lithestore_before_shop
 * @hooked  lithestore_after_shop
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',10 );
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_after_main_content','woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_before_main_content', 'lithestore_before_content',10);
add_action( 'woocommerce_before_main_content', 'lithestore_before_main_content',20);
add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',30);
add_action( 'woocommerce_after_main_content', 'lithestore_after_main_content' ,10);
add_action( 'woocommerce_after_main_content', 'lithestore_shop_sidebar',20);
add_action( 'woocommerce_after_main_content', 'lithestore_after_content',30);
add_action( 'woocommerce_before_shop_loop','lithestore_before_shop',10 );
add_action( 'woocommerce_before_shop_loop','lithestore_after_shop',40 );
