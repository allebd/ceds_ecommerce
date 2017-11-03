<?php
/**
 * Popup
 *
 * @package LitheStore
 * @since 1.0
 */
?>

<?php if ( class_exists( 'woocommerce') ):?>
<div id="ls_popup">
  <div class="popup_content">
    <h3><?php esc_attr_e('Search Products','lithestore');?></h3>
	<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url( '/' ));?>" >
    <span class="screen-reader-text"><?php esc_html_e('Search Product and Knock Enter Key','lithestore');?></span>
    <div>
    <input type="text" id="search_product" placeholder="<?php esc_attr_e('Search Products and knock Enter key.','lithestore');?>" value="<?php get_search_query();?>" name="s" id="s" />
    <input type="hidden" id="post_type" name="post_type" value="product" />
    </div>
    </form>
  </div>
</div>
<div class="ls_popup_overlay"></div>
<?php endif;?>