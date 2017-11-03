<?php
/**
 * Custom WooCommerce template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 * Inspired by Storefront theme.
 * @package LitheStore
 */

if ( ! function_exists( 'lithestore_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 * @since  1.0.0
	 * @return void
	 */
	function lithestore_product_categories( $args ) {

		if ( class_exists( 'woocommerce' ) ){

			$args = apply_filters( 'lithestore_product_categories_args', array(
				'limit' 			=> 3,
				'columns' 			=> 3,
				'child_categories' 	=> 0,
				'orderby' 			=> 'name',
				'title'				=> __( 'Product Categories', 'lithestore' ),
				) );

			echo '<section class="ls-product-section ls-product-categories">';

				do_action( 'lithestore_homepage_before_product_categories' );

				echo do_shortcode( '[product_categories number='.intval( $args['limit'] ).' columns='.intval( $args['columns'] ).' orderby='.esc_attr( $args['orderby'] ).' parent='.esc_attr( $args['child_categories'] ).']');

				do_action( 'lithestore_homepage_after_product_categories' );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'lithestore_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 * @since  1.0.0
	 * @return void
	 */
	function lithestore_recent_products( $args ) {

		if ( class_exists( 'woocommerce' ) ){

			$args = apply_filters( 'lithestore_recent_products_args', array(
				'limit' 			=> 8,
				'columns' 			=> 4,
				'title'				=> __( 'Recent Products', 'lithestore' ),
				) );

			echo '<section class="ls-product-section ls-recent-products">';

				do_action( 'lithestore_homepage_before_recent_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '<div class="divider"><span></span></div></h2>';

				echo do_shortcode( '[recent_products per_page='.intval( $args['limit'] ).' columns='.intval( $args['columns'] ).']');
				do_action( 'lithestore_homepage_after_recent_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'lithestore_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 * @since  1.0.0
	 * @return void
	 */
	function lithestore_featured_products( $args ) {

		if ( class_exists( 'woocommerce' ) ){

			$args = apply_filters( 'lithestore_featured_products_args', array(
				'limit' 			=> 4,
				'columns' 			=> 2,
				'orderby'			=> 'date',
				'order'				=> 'desc',
				'title'				=> __( 'Handpicked Stuffs', 'lithestore' ),
				) );

			echo '<section class="ls-product-section ls-featured-products">';

				do_action( 'lithestore_homepage_before_featured_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '<div class="divider"><span></span></div></h2>';

				echo do_shortcode( '[featured_products per_page='.intval( $args['limit'] ).' columns='.intval( $args['columns'] ).' orderby='.esc_attr( $args['orderby'] ).' order='.esc_attr( $args['order'] ).']');
				
				do_action( 'lithestore_homepage_after_featured_products' );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'lithestore_popular_products' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 * @since  1.0.0
	 * @return void
	 */
	function lithestore_popular_products( $args ) {

		if ( class_exists( 'woocommerce' ) ){

			$args = apply_filters( 'lithestore_popular_products_args', array(
				'limit' 			=> 3,
				'columns' 			=> 3,
				'title'				=> __( 'Top Rated Products', 'lithestore' ),
				) );

			echo '<section class="ls-product-section ls-popular-products">';

				do_action( 'lithestore_homepage_before_popular_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '<div class="divider"><span></span></div></h2>';

				echo do_shortcode( '[top_rated_products per_page='.intval( $args['limit'] ).' columns='.intval( $args['columns'] ).']');
				do_action( 'lithestore_homepage_after_popular_products' );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'lithestore_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 * @since  1.0.0
	 * @return void
	 */
	function lithestore_on_sale_products( $args ) {

		if ( class_exists( 'woocommerce' ) ){

			$args = apply_filters( 'lithestore_on_sale_products_args', array(
				'limit' 			=> 8,
				'columns' 			=> 4,
				'title'				=> __( 'On Sale', 'lithestore' ),
				) );

			echo '<section class="ls-product-section ls-on-sale-products">';

				do_action( 'lithestore_homepage_before_on_sale_products' );

				echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '<div class="divider"><span></span></div></h2>';

				echo do_shortcode( '[sale_products per_page='.intval( $args['limit'] ).' columns='.intval( $args['columns'] ).']');

				do_action( 'lithestore_homepage_after_on_sale_products' );

			echo '</section>';

		}
	}
}

if ( ! function_exists( 'lithestore_shop_sidebar' ) ) {
	function lithestore_shop_sidebar(){
	    get_sidebar('shop');
	}
}

if ( ! function_exists( 'lithestore_before_shop' ) ) {
	function lithestore_before_shop(){
		echo '<div class="category_result">';
	}
}

if ( ! function_exists( 'lithestore_after_shop' ) ) {
	function lithestore_after_shop(){
		echo '</div>';
	}
}