<?php
add_action( 'after_setup_theme', 'ecogray_setup' );
function ecogray_setup() {
	global $content_width;
	if ( ! isset( $content_width ) )
	$content_width = 960;
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(166, 124, TRUE);
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );						// background
	add_editor_style( 'editor-style.css' ); add_theme_support( 'title-tag' ); 
	add_theme_support( 'woocommerce' );
    load_theme_textdomain( 'ecogray', get_template_directory() . '/languages' );
}
add_action( 'init', 'ecogray_my_menu' );
function ecogray_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu', 'ecogray'  ) );
}
function my_after_setup_theme() {
    add_image_size( 'my-theme-logo-size', 320, 100, true );
    add_theme_support( 'site-logo', array( 'size' => 'my-theme-logo-size' ) );
}
add_action( 'after_setup_theme', 'my_after_setup_theme' );
function ecogray_widgets() {
		register_sidebar(
		array(
			'id' => 'footer',
			'name' => __( 'footer', 'ecogray' ),
		)
	);
}
add_action( 'widgets_init', 'ecogray_widgets' );
add_filter('loop_shop_per_page', create_function('$cols', 'return 12;'));
add_filter('loop_shop_columns', 'ecogray_loop_columns');
if (!function_exists('ecogray_loop_columns')) {
	function ecogray_loop_columns() {
		return 3;
	}
}
add_filter( 'loop_shop_columns', 'ecogray_wc_loop_shop_columns', 1, 10 );
function ecogray_wc_loop_shop_columns( $number_columns ) {
	return 3;
}
function ecogray_frontend() {
 	wp_enqueue_style( 'ecogray-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'ecogray_frontend' );
function ecogray_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	if ( $paged >= 3 || $page >= 3 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'ecogray' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'ecogray', 'ecogray_wp_title', 10, 3 );
function woo_related_products_limit() {
  global $product;
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns'] = 3;
	return $args;
}
wp_link_pages(
	array(
		'before'           => '<p>' . __('Pages:', 'ecogray'),
		'after'            => '</p>',
		'link_before'      => '',
		'link_after'       => '',
		'next_or_number'   => 'number',
		'nextpagelink'     => __('Next page', 'ecogray'),
		'previouspagelink' => __('Previous page', 'ecogray'),
		'pagelink'         => '%',
		'echo'             => 1
	)
);
add_filter( 'wp_tag_cloud', 'ecogray_tag_cloud' );
if ( ! function_exists( 'ecogray_is_woocommerce_activated' ) ) {
	function ecogray_is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}
function ecogray_scripts() {
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
}
add_action( 'wp_enqueue_scripts', 'ecogray_scripts' );
function ecogray_tag_cloud( $tags ){
    return preg_replace(
        "~ style='font-size: (\d+)pt;'~",
        ' class="tag-cloud-size-\10"',
        $tags
    );
}
function ecogray_fragment( $fragments ) 
{
    global $woocommerce;
    ob_start(); ?>
    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'ecogray'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'ecogray'), $woocommerce->cart->cart_contents_count);?> <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
add_filter('add_to_cart_fragments', 'ecogray_fragment');
function ecogray_menu() {
	add_theme_page( __( 'Eco Gray Setup', 'ecogray' ), __( 'Premium Upgrade', 'ecogray' ), 'edit_theme_options', 'ecogray', 'ecogray_menu_page');
}
add_action('admin_menu', 'ecogray_menu');
function ecogray_menu_page() {
echo '
<br>
<center><h1>' . __( 'Eco Gray fee  vs  Eco Gray PRO', 'ecogray' ) . '</h1></ceter><br><br>
<center><img src="' . get_template_directory_uri() . '/images/pro-vs-free.png"></center>
<br/><br/><br/><br/>
<h1><center>' . __( 'Site', 'ecogray' ) . ' <a href="http://justpx.com/product/eco-gray-pro">' . __( 'Eco Gray PRO', 'ecogray' ) . '</a> - ' . __( 'theme, demo, documentation', 'ecogray' ) . '.</center></h1><br/><br/>
<center><h1><font color="#dd3f56">15% Christmas Sale!</font>' . __( ' Coupon expiry date 2016-01-11 - Code: ', 'ecogray' ) . '<font color="#dd3f56">justpx15</font></h1></ceter><br/><br/>
<center><h1>' . __( 'Theme Eco Gray PRO - width: 1280px; 12 Sidebars; No Backlink', 'ecogray' ) . '</h1></ceter><br/>
<center><img src="' . get_template_directory_uri() . '/images/eco-gray-pro-sidebar-home-4.jpg"></center><br/><br/><br/><br/>
<center><h1>' . __( 'Theme Eco Gray Bonus - width: 980px; 3 Sidebars; No backlink', 'ecogray' ) . '</h1></ceter><br/>
<center><img src="' . get_template_directory_uri() . '/images/eco-gray-bonus.jpg"></center><br/><br/>
<h2><center>' . __( 'Localization Ready: Chinese, Dutch, English, French, German, Greek, Hungarian, Italian, Russian, Spanish... and other. Add', 'ecogray' ) . ' <a href="http://justpx.com/your-language">' . __( 'Your language', 'ecogray' ) . '</a>. </center></h2><br/><br/>
<center><h1>' . __( 'Eco Gray PRO - Theme Options', 'ecogray' ) . '</h1></ceter><br/>
<center><img src="' . get_template_directory_uri() . '/images/admin-1.jpg"></center><br/><br/>
<center><img src="' . get_template_directory_uri() . '/images/admin-2.jpg"></center><br/><br/>
<center><img src="' . get_template_directory_uri() . '/images/admin-3.jpg"></center><br/><br/>
';
}
function ecogray_menu2() {
	add_theme_page( __( 'Eco Gray Setup', 'ecogray' ), __( 'Theme help', 'ecogray' ), 'edit_theme_options', 'ecogray-free', 'ecogray_menu_page2');
}
add_action('admin_menu', 'ecogray_menu2');
function ecogray_menu_page2() {
echo '
<br>
<center><h1>' . __( 'Theme Eco Gray free', 'ecogray' ) . '</h1></ceter><br>
<center><img src="' . get_template_directory_uri() . '/images/pro-vs-free.png"></center>
<br/><br/><br/>
<h1><center>' . __( 'Site ', 'ecogray' ) . '<a href="http://justpx.com/product/eco-gray-pro/" target="_blank">Eco Gray PRO</a> - ' . __( ' theme, demo, documentation', 'ecogray' ) . '.</center></h1><br><br>
<center><h1><font color="#dd3f56">10%</font> ' . __( 'Discount - Code', 'ecogray' ) . ': <font color="#dd3f56">justpx10</font></h1></ceter>
<br/><br/><br/><br/>
<center><h1>' . __( 'Theme Eco Gray free 1 Sidebar', 'ecogray' ) . '</h1></ceter>
<br/><br/>
<center><img src="' . get_template_directory_uri() . '/images/eco-gray-sidebar.png"></center><br/><br/>
<h2><center>' . __( 'Localization Ready: Chinese, Dutch, English, French, German, Greek, Hungarian, Italian, Russian, Spanish... and other.', 'ecogray' ) . ' ' . __( 'Add ', 'ecogray' ) . '<a href="http://justpx.com/your-language">' . __( 'Your language ', 'ecogray' ) . '</a>. </center></h2><br/><br/>
';
}
?>