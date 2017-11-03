<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LitheStore
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="body-container">
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'lithestore' ); ?></a>
    <?php
      do_action('lithestore_start_header');
	  $header=get_header_image();
	  $header_class='';
	  $header_picture='';
      if(is_home() || is_front_page()){
        if(has_header_image()){
	      $header_class=" site-cover";
	      $header_picture=' style="background-image:url('.esc_url($header).');"';
	    }
      }
    ?>
	<header id="masthead" class="site-header<?php echo esc_html($header_class);?>" role="banner"<?php echo $header_picture;?>>

		<?php
		/**
		 * Hook lithestore_header
		 * @hooked lithestore_before_navigation - 0
		 * @hooked lithestore_custom_logo - 10
		 * @hooked lithestore_primary_navigation - 20
		 * @hooked lithestore_top_buttons - 30
		 * @hooked lithestore_after_navigation - 40
		 * @hooked lithestore_cover - 50
		 */
		do_action('lithestore_header');
		?>
	</header><!-- #masthead -->
	
	<?php do_action('lithestore_after_header');?>
