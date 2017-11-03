<?php
/**
 * Template Name: Homepage
 *
 * This is the template that displays WooCommerce content.
 * @package LitheStore
 */

get_header(); ?>
	
	<div id="page" class="hfeed site">
		    
	  <?php
	  if ( class_exists( 'woocommerce' ) ):
	  /* Product Categories
	   * Hook lithestore_product_categories
	   * Hooked lithestore_product_categories()  
	   */ 
	  do_action( 'lithestore_product_categories'); 
	  endif;
	  ?>
	  
	  <div id="content" class="site-content ls-grid-1000">
	  	<?php 
	  	if ( class_exists( 'woocommerce' ) ):
	  	/* Featured Products
	     * Hook lithestore_featured_products
	     * Hooked lithestore_featured_products()  
	     */ 
	  	 do_action( 'lithestore_featured_products');
	  	 
	  	/* Popular Products
	     * Hook lithestore_popular_products
	     * Hooked lithestore_popular_products()  
	     */
	     do_action( 'lithestore_popular_products');
	     
	    /* The wrapper before main content
	     * Hook lithestore_before_main_content
	     * Hooked lithestore_before_main_content()  
	     */

		 do_action( 'lithestore_before_main_content');
		 


		/* Recent Products
	     * Hook lithestore_recent_products
	     * Hooked lithestore_recent_products()  
	     */
         do_action( 'lithestore_recent_products'); 
         
        /* OnSale Products
	     * Hook lithestore_on_sale_products
	     * Hooked lithestore_on_sale_products()  
	     */
         do_action( 'lithestore_on_sale_products'); 
        
        
        /* The wrapper after main content
	     * Hook lithestore_after_main_content
	     * Hooked lithestore_after_main_content()  
	     */
		 do_action( 'lithestore_after_main_content');
		 
		 get_sidebar('home');

		else:
          echo '<div class="lithestore_notification">'.esc_html__('This is the shop front page, please activate WooCommerce plugin first.','lithestore').'</div>';
        endif;
		?>
	  </div>
	</div>
	
<?php get_footer(); ?>