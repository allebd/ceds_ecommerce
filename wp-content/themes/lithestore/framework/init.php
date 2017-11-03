<?php
/**
 * LitheStore Initialize
 *
 * @package LitheStore
 */


$lithestore_theme 	= wp_get_theme( 'lithestore' );
$lithestore_version 	= $lithestore_theme['Version'];

if ( ! function_exists( 'lithestore_support' ) ) :
function lithestore_support() {
    /*
 	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on LitheStore, use a find and replace
	 * to change 'lithestore' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'lithestore', get_template_directory() . '/languages' );
	$lithestore_locale = get_locale(); 
	$lithestore_locale_file = get_template_directory_uri()."/languages/$lithestore_locale.php"; 
	if ( is_readable($lithestore_locale_file) ) require_once($lithestore_locale_file);

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	/* Declare WooCommerce support*/
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*Change excerpt more string*/
	function lithestore_excerpt_more( $more ) {
		return '...';
	}
	add_filter( 'excerpt_more', 'lithestore_excerpt_more' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'lithestore' ),
		'mobile' => esc_html__( 'Mobile Menu', 'lithestore' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );
	
	// Set up the WordPress core custom header feature.
	add_theme_support( 'custom-header', apply_filters( 'lithestore_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'width'                  => 1200,
		'height'                 => 800,
		'flex-height'            => true,
		'header-text'			 => false
	) ) );
}

endif; // lithestore_setup

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lithestore_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lithestore_content_width', 1000 );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lithestore_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'lithestore' ),
		'id'            => 'sidebar',
		'description'   => __('This sidebar will included in the category and single post page.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Sidebar', 'lithestore' ),
		'id'            => 'sidebar-home',
		'description'   => __('This sidebar will included in the homepage template.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'lithestore' ),
		'id'            => 'sidebar-page',
		'description'   => __('This sidebar will included in the default page template.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	if ( class_exists( 'woocommerce' ) ){
	 register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'lithestore' ),
		'id'            => 'sidebar-shop',
		'description'   => __('This sidebar will included in the shop pages.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	 ) );
	}
	
	register_sidebar( array(
		'name'          => esc_html__( 'Bottom Widget 1', 'lithestore' ),
		'id'            => 'bottom-widget-1',
		'description'   => __('This widget area is placed at the left of bottom area.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Bottom Widget 2', 'lithestore' ),
		'id'            => 'bottom-widget-2',
		'description'   => __('This widget area is placed at the second left of bottom area.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Bottom Widget 3', 'lithestore' ),
		'id'            => 'bottom-widget-3',
		'description'   => __('This widget area is placed at the middle of bottom area.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
    ) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Bottom Widget 4', 'lithestore' ),
		'id'            => 'bottom-widget-4',
		'description'   => __('This widget area is placed at the right of bottom area.','lithestore'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
    ) );
}


/**
 * Load Google Fonts
 * Hook: lithestore_scripts
 */
function lithestore_font_styles() {
    wp_enqueue_style( 'lithestore-default-fonts', lithestore_fonts_url(), array(), null );
}
function lithestore_fonts_url() {
    $lithestore_fonts_url = '';
    $lithestore_karla = _x( 'on', 'Karla font: on or off', 'lithestore' );
    $lithestore_montserrat = _x( 'on', 'Montserrat: on or off', 'lithestore' );
    $lithestore_lato = _x( 'on', 'Lato: on or off', 'lithestore' );
    
    if ('off' !== $lithestore_karla || 'off' !== $lithestore_montserrat || 'off' !== $lithestore_lato) {
	    $lithestore_font_families = array();
	 
	    
	    if ( 'off' !== $lithestore_karla ) {
	        $lithestore_font_families[] = 'Karla:400,700,400italic';
	    }
	    
	    if ( 'off' !== $lithestore_montserrat ) {
	        $lithestore_font_families[] = 'Montserrat:400,700';
	    }
	    
	    if ( 'off' !== $lithestore_lato ) {
	        $lithestore_font_families[] = 'Lato:100,300,400,700 900';
	    }
	    
	    $lithestore_query_args = array(
            'family' => urlencode( implode( '|', $lithestore_font_families ) ),
            'subset' => urlencode( 'latin,latin-ext,vietnamese,cyrillic-ext,cyrillic,greek,greek-ext' ),
        );
 
        $lithestore_fonts_url = add_query_arg( $lithestore_query_args, 'https://fonts.googleapis.com/css' );
	}
    
    return esc_url_raw( $lithestore_fonts_url );
}

/**
 * Enqueue scripts and styles.
 * Hook: lithestore_scripts
 */
if ( ! function_exists( 'lithestore_scripts' ) ) :
function lithestore_scripts() {
    global $lithestore_version;

		wp_enqueue_style( 'lithestore-style', get_stylesheet_uri(), '', $lithestore_version );
		wp_enqueue_style( 'lithestore-grid', get_template_directory_uri() .'/framework/assets/css/grid.css', '', $lithestore_version );
		
		wp_enqueue_style( 'lithestore-main', get_template_directory_uri() .'/framework/assets/css/main.css', '', $lithestore_version );
		
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() .'/framework/assets/font-awesome/css/font-awesome.min.css', '', $lithestore_version );
		
		if ( class_exists( 'woocommerce' ) ){
		wp_enqueue_style( 'lithestore-woocommerce', get_template_directory_uri() .'/framework/assets/css/woocommerce.css', '', $lithestore_version);
		}
		wp_enqueue_script( 'pushy', get_template_directory_uri() . '/framework/assets/js/pushy.js', array('jquery'), '', true );
        wp_enqueue_script( 'lithestore-skip-link-fix', get_template_directory_uri() . '/framework/assets/js/skip-link-lithestore-fix.js', array(), '20130115', true );
		wp_enqueue_script( 'lithestore-script', get_template_directory_uri() . '/framework/assets/js/theme.js', array('jquery'), '', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
}
endif;


/* Load LitheStore Framework
 * Include the framework function files.
 * Hook: lithestore_init
 */
if ( ! function_exists( 'lithestore_load_framework' ) ) :
function lithestore_load_framework(){
	
	/**
	 * Custom template tags for this theme.
	 */
	require get_template_directory() . '/framework/templates/template-tags.php';
	
	/**
	 * Customizer additions.
	 */
	require get_template_directory() . '/framework/customizer/customizer.php';
	
	/**
	 * Custom functions that act independently of the theme templates.
	 */
	require get_template_directory() . '/framework/functions/extras.php';

	/**
	 * Plugins
	 */
	require get_template_directory() . '/framework/functions/plugins.php';
	
	
	/**
	 * Include Welcome screen
	 */
	require get_template_directory() . '/framework/functions/welcome/welcome.php';

	/**
	 * Include Demo Importer
	 */
	require get_template_directory() . '/framework/demo/demo-importer.php';

	
	/**
	 * If WooCommerce is actived, load custom woocommerce template tags for this theme.
	 */
	if ( class_exists( 'woocommerce' ) ){
		require get_template_directory() . '/framework/woocommerce/template-tags.php';
		require get_template_directory() . '/framework/woocommerce/extras.php';
		require get_template_directory() . '/framework/woocommerce/hooks.php';
	}
}
endif;

/**
 * Hooks
 */
require get_template_directory() . '/framework/hooks.php';

do_action('lithestore_init');