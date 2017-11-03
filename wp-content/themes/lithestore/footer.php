<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LitheStore
 */

?>

      <?php if ( is_active_sidebar( 'bottom-widget-1' ) ):?>
      <div id="site-bottom" class="site-bottom">
       <div class="ls-grid-1000">
	      <div class="bottom-widget ls-grid ls-col2">
		      <?php dynamic_sidebar( 'bottom-widget-1' ); ?>
	      </div>
	      <div class="bottom-widget ls-grid ls-col2">
		      <?php dynamic_sidebar( 'bottom-widget-2' ); ?>
	      </div>
	      <div class="bottom-widget ls-grid ls-col3">
		      <?php dynamic_sidebar( 'bottom-widget-3' ); ?>
	      </div>
	      <div class="bottom-widget ls-grid ls-col5 last">
		      <?php dynamic_sidebar( 'bottom-widget-4' ); ?>
	      </div>
       </div>
       <?php endif;?>
	    
    </div>
    
    <footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info ls-grid-1000">
		  <?php
		    /**
		     * Hook: lithestore_footer
			 * @Hooked  lithestore_copyright()
		     */
			do_action('lithestore_footer');
		  ?>
		</div><!-- .site-info -->
	  </footer><!-- #colophon -->
	
   </div><!-- #page -->
   
</div>

<?php 
 /* Mobile Menu
  * It will only display at the right side when view the website on mobile.
  */
 get_template_part( 'template-parts/mobile-menu');
 
  /* Popup
   */
 get_template_part( 'template-parts/popup');
?>

<?php wp_footer(); ?>
</body>
</html>
