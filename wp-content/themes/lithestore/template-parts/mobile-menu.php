<?php
/**
 * Mobile Menu
 *
 * @package LitheStore
 * @since 1.1
 */
?>

<!-- Pushy Menu -->
<nav id="mobile_menu" class="pushy pushy-right">
    <ul>
	  <li><a href="javascript:void(0);" id="close-menu"><i class="fa fa-close"></i></a></li>
	  <li class="menu-title"><?php echo esc_html__('Menu','lithestore');?></li>
	  <?php wp_nav_menu(array(
				  'theme_location' => 'mobile',
				  'container' => '',
				  'echo' => true,
				  'items_wrap'      => '%3$s',
                  'depth' => 5) );
	      ?>
    </ul>
</nav>

<!-- Site Overlay -->
<div class="site-overlay"></div>