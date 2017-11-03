<?php
/*
=====================================================================
Enqueue styles and scripts
=====================================================================
*/

function ewd_kcae_load_styles(){
	wp_enqueue_style( 'ewd_kcae_load_normalize_css', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'ewd_kcae_load_style_css', get_stylesheet_uri() );
	wp_enqueue_style( 'ewd_kcae_load_googlefonts_css', 'https://fonts.googleapis.com/css?family=Montserrat|Oswald:500|Source+Sans+Pro:300,300i,400,400i,700,700i' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/inc/font-awesome/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'ewd_kcae_load_styles' );

function ewd_kcae_load_scripts(){
	wp_enqueue_script( 'ewd_kcae_load_ewd_kcae_js', get_template_directory_uri() . '/js/base.js', array( 'jquery' ) );
	$base_js_localize = array(
		'retrieving' => __( 'Retrieving Search Results...', 'keep-calm-and-e-comm' ),
		'viewall' => __( 'View All Search Results', 'keep-calm-and-e-comm' ),
	);
	wp_localize_script( 'ewd_kcae_load_ewd_kcae_js', 'base_js_local', $base_js_localize );
}
add_action( 'wp_enqueue_scripts', 'ewd_kcae_load_scripts' );

function ewd_kcae_load_customizer_scripts_styles() {
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script( 'ewd_kcae_load_customizer_js', get_template_directory_uri() . '/js/customizer.js', array( 'jquery' ) );
	$customizer_js_localize = array(
		'upgrade' => __( 'Upgrade to Keep Calm premium', 'keep-calm-and-e-comm' ),
		'savepublish' => __( 'Save & Publish', 'keep-calm-and-e-comm' ),		
	);
	wp_localize_script( 'ewd_kcae_load_customizer_js', 'customizer_js_local', $customizer_js_localize );
	wp_enqueue_style( 'ewd_kcae_load_customizer_css', get_template_directory_uri() . '/css/customizer.css');
}
add_action( 'customize_controls_enqueue_scripts', 'ewd_kcae_load_customizer_scripts_styles' );




/*
=====================================================================
TGM Plugin Stuff
=====================================================================
*/

require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'ewd_kcae_register_required_plugins' );

function ewd_kcae_register_required_plugins() {
	$plugins = array(
		array(
			'name'			=> 'Etoile Theme Companion',
			'slug'			=> 'etoile-theme-companion',
			'required'		=> false,
		),
		array(
			'name'			=> 'Ultimate Slider',
			'slug'			=> 'ultimate-slider',
			'required'		=> false,
		),
		array(
			'name'			=> 'Status Tracking',
			'slug'			=> 'order-tracking',
			'required'		=> false,
		),
	);

	// Only uncomment the strings in the config array if you want to customize the strings.
	$config = array(
		'id'           => 'keep-calm-and-e-comm',     // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}




/*
=====================================================================
Load text domain
=====================================================================
*/

add_action('after_setup_theme', 'ewd_kcae_text_domain');
function ewd_kcae_text_domain(){
    load_theme_textdomain('keep-calm-and-e-comm', get_template_directory() . '/lang');
}




/*
=====================================================================
Add customizable navigation
=====================================================================
*/

function ewd_kcae_register_my_menu() {
  register_nav_menu('main-menu', __('Main Menu', 'keep-calm-and-e-comm'));
}
add_action( 'init', 'ewd_kcae_register_my_menu' );




/*
=====================================================================
Widgetize sidebar and footer
=====================================================================
*/

function ewd_kcae_widgets_init() {
	register_sidebar( array(
		'name' => __('Page Sidebar', 'keep-calm-and-e-comm'),
		'id' => 'sidebar_widget',
		'before_widget' => '<div class="widgetBox">',
		'after_widget' => '</div> <!-- widgetBox -->',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="clear"></div>',
	) );
	register_sidebar( array(
		'name' => __('Blog Sidebar', 'keep-calm-and-e-comm'),
		'id' => 'sidebar_widget_blog',
		'before_widget' => '<div class="widgetBox">',
		'after_widget' => '</div> <!-- widgetBox -->',
		'before_title' => '<h3>',
		'after_title' => '</h3><div class="clear"></div>',
	) );
	register_sidebar( array(
		'name' => __('Footer', 'keep-calm-and-e-comm'),
		'id' => 'footer_widget',
		'before_widget' => '<div class="widgetBox">',
		'after_widget' => '</div><!-- widgetBox --></div><!-- column -->',
		'before_title' => '<div class="column"><h3>',
		'after_title' => '</h3><div class="clear"></div>',
	) );
}
add_action( 'widgets_init', 'ewd_kcae_widgets_init' );




/*
=====================================================================
Post thumbnails
=====================================================================
*/

add_action( 'after_setup_theme', 'ewd_kcae_post_thumbnails' );
function ewd_kcae_post_thumbnails(){
	add_theme_support('post-thumbnails');
}




/*
=====================================================================
Custom background
=====================================================================
*/

add_action( 'after_setup_theme', 'ewd_kcae_custom_background' );
function ewd_kcae_custom_background(){
	$args = array(
		'default-color' => 'ffffff',
	);
	add_theme_support( 'custom-background', $args );
}




/*
=====================================================================
Feeds
=====================================================================
*/

add_action( 'after_setup_theme', 'ewd_kcae_automatic_feed_links' );
function ewd_kcae_automatic_feed_links(){
	add_theme_support( 'automatic-feed-links' );
}




/*
=====================================================================
Content width
=====================================================================
*/

if ( ! isset( $content_width ) ) $content_width = 960;




/*
=====================================================================
Title tag
=====================================================================
*/

add_action( 'after_setup_theme', 'ewd_kcae_slug_setup' );
function ewd_kcae_slug_setup(){
	add_theme_support( 'title-tag' );
}



/*
=====================================================================
Custom logo
=====================================================================
*/

add_action( 'after_setup_theme', 'ewd_kcae_custom_header' );
function ewd_kcae_custom_header(){
	add_theme_support( "custom-header" );
	if ( ! defined('NO_HEADER_TEXT') ){
		define( 'NO_HEADER_TEXT', true );
	}
}
function ewd_kcae_custom_logo() {
	add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'ewd_kcae_custom_logo' );




/*
=====================================================================
Threaded comments
=====================================================================
*/

function ewd_kcae_threaded_comments(){
	if ( is_singular() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'ewd_kcae_threaded_comments' );




/*
=====================================================================
Customizer Stuff
=====================================================================
*/

//Upgrade to pro link in customizer
require_once( trailingslashit( get_template_directory() ) . 'trt-customize-pro/example-1/class-customize.php' );

/************************
START CALLBACK FUNCTIONS
************************/
function ewd_kcae_callback_homepage_template(){
	return is_page_template('template-home.php');
}
function ewd_kcae_callback_contact_page_template(){
	return is_page_template('template-contact.php');
}
/************************
END CALLBACK FUNCTIONS
************************/

function ewd_kcae_customize_register( $wp_customize ){

	/*==============
	START PANELS
	==============*/

	// HOMEPAGE
	$wp_customize->add_panel( 'ewd_kcae_setting_homepage_panel', array(
		'priority'       => 10,
		'title'          => __('Home Page', 'keep-calm-and-e-comm'),
		'active_callback' => 'ewd_kcae_callback_homepage_template'
	) );

	// STYLING
	$wp_customize->add_panel( 'ewd_kcae_setting_styling_panel', array(
		'priority'       => 10,
		'title'          => __('Styling', 'keep-calm-and-e-comm'),
	) );

	// HEADER
	$wp_customize->add_panel( 'ewd_kcae_setting_header_panel', array(
		'priority'       => 10,
		'title'          => __('Header', 'keep-calm-and-e-comm'),
	) );

	/*==============
	END PANELS
	==============*/

	$installedThemeCompanion = function_exists( 'EWD_UPCP_Theme_Enable_Menu');
	$installedUPCP = function_exists( 'UPCP_Plugin_Menu');
	$installedOTP = function_exists( 'EWD_OTP_Default_Statuses');
	$installedSlider = function_exists( 'EWD_US_Admin_Options');
	$installedWC = function_exists('woocommerce_get_page_id');

	$wp_customize->remove_section('background_image');
	$wp_customize->get_section('header_image')->title = __( 'Logo', 'keep-calm-and-e-comm');
	if ( function_exists('the_custom_logo') ){
		$wp_customize->remove_section('header_image');
	}

	$wp_customize->get_section('colors')->panel = 'ewd_kcae_setting_styling_panel';
	$wp_customize->get_section('custom_css')->panel = 'ewd_kcae_setting_styling_panel';

	/*==============
	START LOGO STUFF
	==============*/

	// LOGO HEIGHT
	$wp_customize->add_setting( 'ewd_kcae_setting_logo_height', array(
		'default'		=> '24px',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		'ewd_kcae_setting_logo_height',
		array(
			'section'	=> 'title_tagline',
			'label'		=> __( 'Logo Height', 'keep-calm-and-e-comm' ),
			'description'		=> __( 'Specify the logo height in pixels (e.g. 24px)', 'keep-calm-and-e-comm' ),
			'type'    => 'text',
		)
	);

	// LOGO TOP MARGIN
	$wp_customize->add_setting( 'ewd_kcae_setting_logo_top_margin', array(
		'default'		=> '28px',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		'ewd_kcae_setting_logo_top_margin',
		array(
			'section'	=> 'title_tagline',
			'label'		=> __( 'Logo Top Margin', 'keep-calm-and-e-comm' ),
			'description'		=> __( 'Specify the margin above the logo in pixels (e.g. 28px)', 'keep-calm-and-e-comm' ),
			'type'    => 'text',
		)
	);

	// ALTERNATE LOGO
	$wp_customize->add_setting( 'ewd_kcae_setting_alternate_logo', array(
		'default'		=> '',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ewd_kcae_setting_alternate_logo',
			array(
				'label'      => __( 'Alternate Logo', 'keep-calm-and-e-comm' ),
				'description'      => __( 'Use this if you\'d like a different logo to appear in the transparent menu on the slider in the homepage template', 'keep-calm-and-e-comm' ),
				'section'    => 'title_tagline',
				'settings'   => 'ewd_kcae_setting_alternate_logo',
			)
		)
	);


	/*==============
	END LOGO STUFF
	==============*/

	/*==============
	START COLOURS
	==============*/

	// TEXT COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_text_color', array(
		'default'		=> '#999',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_text_color',
			array(
				'label'		=> __( 'Text Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_text_color'
			)
		)
	);

	// LINK COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_link_color', array(
		'default'		=> '#037751',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_link_color',
			array(
				'label'		=> __( 'Link Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_link_color'
			)
		)
	);

	// HEADER BACKGROUND COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_header_background_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_header_background_color',
			array(
				'label'		=> __( 'Header Background Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_header_background_color'
			)
		)
	);

	// MENU TEXT COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_menu_text_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_menu_text_color',
			array(
				'label'		=> __( 'Menu Text Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_menu_text_color'
			)
		)
	);

	// MENU TEXT HOVER COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_menu_text_hover_color', array(
		'default'		=> '#037751',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_menu_text_hover_color',
			array(
				'label'		=> __( 'Menu Text Hover Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_menu_text_hover_color'
			)
		)
	);

	// MENU DROP DOWN BACKGROUND COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_menu_dropdown_background_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_menu_dropdown_background_color',
			array(
				'label'		=> __( 'Menu Drop Down Background Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_menu_dropdown_background_color'
			)
		)
	);

	// MENU DROP DOWN BACKGROUND HOVER COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_menu_dropdown_background_hover_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_menu_dropdown_background_hover_color',
			array(
				'label'		=> __( 'Menu Drop Down Background Hover Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_menu_dropdown_background_hover_color'
			)
		)
	);

	// MENU DROP DOWN TEXT COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_menu_dropdown_text_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_menu_dropdown_text_color',
			array(
				'label'		=> __( 'Menu Drop Down Text Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_menu_dropdown_text_color'
			)
		)
	);

	// MENU DROP DOWN TEXT HOVER COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_menu_dropdown_text_hover_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_menu_dropdown_text_hover_color',
			array(
				'label'		=> __( 'Menu Drop Down Text Hover Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_menu_dropdown_text_hover_color'
			)
		)
	);

	// PAGE TITLE BAR BACKGROUND COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_page_title_bar_background_color', array(
		'default'		=> '#037751',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_page_title_bar_background_color',
			array(
				'label'		=> __( 'Page Title Bar Background Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_page_title_bar_background_color'
			)
		)
	);

	// PAGE TITLE BAR TEXT COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_page_title_bar_text_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_page_title_bar_text_color',
			array(
				'label'		=> __( 'Page Title Bar Text Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_page_title_bar_text_color'
			)
		)
	);

	// TESTIMONIAL QUOTATION MARK COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_testimonial_quote_color', array(
		'default'		=> '#037751',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_testimonial_quote_color',
			array(
				'label'		=> __( 'Testimonial Quotation Mark Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_testimonial_quote_color'
			)
		)
	);

	// FOOTER BACKGROUND COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_footer_background_color', array(
		'default'		=> '#292929',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_footer_background_color',
			array(
				'label'		=> __( 'Footer Background Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_footer_background_color'
			)
		)
	);

	// FOOTER TEXT COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_footer_text_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_footer_text_color',
			array(
				'label'		=> __( 'Footer Text Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_footer_text_color'
			)
		)
	);

	// COPYRIGHT AREA BACKGROUND COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_copyright_background_color', array(
		'default'		=> '#111',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_copyright_background_color',
			array(
				'label'		=> __( 'Copyright Background Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_copyright_background_color'
			)
		)
	);

	// COPYRIGHT AREA TEXT COLOR
	$wp_customize->add_setting( 'ewd_kcae_setting_copyright_text_color', array(
		'default'		=> '#fff',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
		'transport'		=> 'refresh',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'ewd_kcae_setting_copyright_text_color',
			array(
				'label'		=> __( 'Copyright Text Color', 'keep-calm-and-e-comm' ),
				'section'	=> 'colors',
				'settings'	=> 'ewd_kcae_setting_copyright_text_color'
			)
		)
	);

	/*==============
	END COLOURS
	==============*/

	/*==============
	START FONTS
	==============*/

	// CREATE FONTS SECTION
	$wp_customize->add_section(
		'ewd_kcae_setting_fonts',
		array(
			'title'			=> __( 'Fonts', 'keep-calm-and-e-comm'),
			'description'	=> __( 'You only need to type in the name of the font (e.g. Helvetica). Please note that, if you use a Google font or other webfont, you must also properly include that font (i.e. in the header file, the functions file or via CSS).', 'keep-calm-and-e-comm'),
			'priority'		=> 50,
			'panel'			=> 'ewd_kcae_setting_styling_panel',
		)
	);

	// MAIN BODY FONT
	$wp_customize->add_setting( 'ewd_kcae_setting_font_main', array(
		'default'			=> '',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control(
		'ewd_kcae_setting_font_main',
		array(
			'section'	=> 'ewd_kcae_setting_fonts',
			'label'		=> __( 'Main Body Font', 'keep-calm-and-e-comm' ),
			'type'    	=> 'text',
		)
	);

	// HEADING FONT
	$wp_customize->add_setting( 'ewd_kcae_setting_font_heading', array(
		'default'			=> '',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control(
		'ewd_kcae_setting_font_heading',
		array(
			'section'	=> 'ewd_kcae_setting_fonts',
			'label'		=> __( 'Heading Font', 'keep-calm-and-e-comm' ),
			'type'    	=> 'text',
		)
	);

	// MENU FONT
	$wp_customize->add_setting( 'ewd_kcae_setting_font_menu', array(
		'default'			=> '',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
		'transport'			=> 'refresh',
	) );
	$wp_customize->add_control(
		'ewd_kcae_setting_font_menu',
		array(
			'section'	=> 'ewd_kcae_setting_fonts',
			'label'		=> __( 'Menu Font', 'keep-calm-and-e-comm' ),
			'type'    	=> 'text',
		)
	);

	/*==============
	END FONTS
	==============*/

	/*==============
	START CALLOUT
	==============*/

	if($installedThemeCompanion){

		// CREATE CALLOUT SECTION
		$wp_customize->add_section(
			'ewd_kcae_setting_callout_section',
			array(
				'title'     => __( 'Callout Area', 'keep-calm-and-e-comm'),
				'priority'  => 200,
				'panel'		=> 'ewd_kcae_setting_homepage_panel',
			)
		);

		// CALLOUT ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_callout_enable',
			array(
				'section'	=> 'ewd_kcae_setting_callout_section',
				'label'		=> __( 'Display Callout Area on Homepage', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'yes'    => __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'   => __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// CALLOUT HEADING TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_heading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_callout_heading_text',
			array(
				'section'	=> 'ewd_kcae_setting_callout_section',
				'label'		=> __( 'Heading Text', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// CALLOUT SUB-HEADING TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_subheading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_callout_subheading_text',
			array(
				'section'	=> 'ewd_kcae_setting_callout_section',
				'label'		=> __( 'Sub-Heading Text', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// CALLOUT BUTTON TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_button_text', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_callout_button_text',
			array(
				'section'	=> 'ewd_kcae_setting_callout_section',
				'label'		=> __( 'Button Text', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// CALLOUT BUTTON LINK
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_button_link', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_callout_button_link',
			array(
				'section'	=> 'ewd_kcae_setting_callout_section',
				'label'		=> __( 'Button Link', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// CALLOUT BACKGROUND COLOR
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_background_color', array(
			'default'		=> '#037751',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'ewd_kcae_setting_callout_background_color',
				array(
					'label'		=> __( 'Background Color', 'keep-calm-and-e-comm' ),
					'section'	=> 'ewd_kcae_setting_callout_section',
					'settings'	=> 'ewd_kcae_setting_callout_background_color'
				)
			)
		);

		// CALLOUT TEXT COLOR
		$wp_customize->add_setting( 'ewd_kcae_setting_callout_text_color', array(
			'default'		=> '#fff',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'ewd_kcae_setting_callout_text_color',
				array(
					'label'		=> __( 'Text Color', 'keep-calm-and-e-comm' ),
					'section'	=> 'ewd_kcae_setting_callout_section',
					'settings'	=> 'ewd_kcae_setting_callout_text_color'
				)
			)
		);

	} //if theme companion active

	/*==============
	END CALLOUT
	==============*/

	/*==============
	START TEXT ON PIC
	==============*/

	if($installedThemeCompanion){

		// CREATE TEXT ON PIC SECTION
		$wp_customize->add_section(
			'ewd_kcae_setting_textonpic_section',
			array(
				'title'     => __( 'Text on Picture', 'keep-calm-and-e-comm'),
				'priority'  => 200,
				'panel'		=> 'ewd_kcae_setting_homepage_panel',
			)
		);

		// TEXT ON PIC ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_textonpic_enable',
			array(
				'section'	=> 'ewd_kcae_setting_textonpic_section',
				'label'		=> __( 'Display Text-on-Picture Area on Homepage', 'keep-calm-and-e-comm' ),
				'description' => __('Should the text overlay on a background image area be displayed?', 'keep-calm-and-e-comm'),
				'type'    => 'radio',
				'choices'  => array(
					'yes'    => __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'   => __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// TEXT ON PIC HEADING TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_heading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_textonpic_heading_text',
			array(
				'section'	=> 'ewd_kcae_setting_textonpic_section',
				'label'		=> __( 'Heading Text', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC SUB-HEADING TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_subheading_text', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_textonpic_subheading_text',
			array(
				'section'	=> 'ewd_kcae_setting_textonpic_section',
				'label'		=> __( 'Sub-Heading Text', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC BUTTON TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_button_text', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_text_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_textonpic_button_text',
			array(
				'section'	=> 'ewd_kcae_setting_textonpic_section',
				'label'		=> __( 'Button Text', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC BUTTON LINK
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_button_link', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_textonpic_button_link',
			array(
				'section'	=> 'ewd_kcae_setting_textonpic_section',
				'label'		=> __( 'Button Link', 'keep-calm-and-e-comm' ),
				'type'    => 'text',
			)
		);

		// TEXT ON PIC TEXT COLOR
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_text_color', array(
			'default'		=> '#fff',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_color_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'ewd_kcae_setting_textonpic_text_color',
				array(
					'label'		=> __( 'Text Color', 'keep-calm-and-e-comm' ),
					'section'	=> 'ewd_kcae_setting_textonpic_section',
					'settings'	=> 'ewd_kcae_setting_textonpic_text_color'
				)
			)
		);

		// TEXT ON PIC TEXT BACKGROUND IMAGE
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_background_image', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'ewd_kcae_setting_textonpic_background_image',
				array(
					'label'      => __( 'Background Image', 'keep-calm-and-e-comm' ),
					'section'    => 'ewd_kcae_setting_textonpic_section',
					'settings'   => 'ewd_kcae_setting_textonpic_background_image',
				)
			)
		);

		// TEXT ON PIC TEXT OVERLAY IMAGE
		$wp_customize->add_setting( 'ewd_kcae_setting_textonpic_overlay_image', array(
			'default'		=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'ewd_kcae_setting_textonpic_overlay_image',
				array(
					'label'      => __( 'Overlay Image', 'keep-calm-and-e-comm' ),
					'section'    => 'ewd_kcae_setting_textonpic_section',
					'settings'   => 'ewd_kcae_setting_textonpic_overlay_image',
				)
			)
		);

	} //if theme companion active

	/*==============
	END TEXT ON PIC
	==============*/

	/*==============
	START HOMEPAGE GENERAL
	==============*/

	if($installedThemeCompanion){

		// CREATE HOMEPAGE GENERAL SECTION
		$wp_customize->add_section(
			'ewd_kcae_setting_homepage_section',
			array(
				'title'       => __( 'Home Page Options', 'keep-calm-and-e-comm'),
				'description' => __( 'The options to enable the Callout and Text-on-Picture areas can be found in the "Callout Area" and "Text on Picture" sections just below.', 'keep-calm-and-e-comm'),
				'priority'    => 199,
				'panel'		  => 'ewd_kcae_setting_homepage_panel',
			)
		);

		// SLIDER ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_slider_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_slider_enable',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Display Slider', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Should the slider be displayed on the homepage?', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'			=> __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// SLIDER STATIC FIRST SLIDE
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_slider_static_first', array(
			'default'		=> 'no',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_slider_static_first',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Display Static First Slide Only', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Select this option to display your first slide as a static image, with no sliding or animation.', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'			=> __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// JUMP BOXES ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_jumpboxes_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_jumpboxes_enable',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Display Jump Boxes', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Should the jump boxes be displayed on the homepage?', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'			=> __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// JUMP BOXES COLUMNS
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_jumpboxes_col', array(
			'default'		=> 'three',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_jumpboxes_col',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Jump Boxes Number of Columns', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Select the number of columns for your jump boxes.', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'two'			=> __( '2', 'keep-calm-and-e-comm' ),
					'three'			=> __( '3', 'keep-calm-and-e-comm' ),
					'four'			=> __( '4', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// TRACK ORDERS ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_track_orders_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_track_orders_enable',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Display Track Order Form', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Should the track order form be displayed on the homepage?', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'			=> __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// TESTIMONIALS ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_testimonials_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_testimonials_enable',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Display Testimonials', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Should the testimonials be displayed on the homepage?', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'			=> __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// TESTIMONIALS COLUMNS
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_testimonials_col', array(
			'default'		=> 'three',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_testimonials_col',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Testimonials Number of Columns', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Select the number of columns for your testimonials.', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'two'			=> __( '2', 'keep-calm-and-e-comm' ),
					'three'			=> __( '3', 'keep-calm-and-e-comm' ),
					'four'			=> __( '4', 'keep-calm-and-e-comm' ),
				)
			)
		);

		// FEATURED PRODUCTS ENABLE
		$wp_customize->add_setting( 'ewd_kcae_setting_homepage_featured_enable', array(
			'default'		=> 'yes',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
			'transport'		=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_homepage_featured_enable',
			array(
				'section'		=> 'ewd_kcae_setting_homepage_section',
				'label'			=> __( 'Display Featured Products', 'keep-calm-and-e-comm' ),
				'description'	=> __( 'Should featured products be displayed on the homepage?', 'keep-calm-and-e-comm' ),
				'type'			=> 'radio',
				'choices'		=> array(
					'yes'			=> __( 'Yes', 'keep-calm-and-e-comm' ),
					'no'			=> __( 'No', 'keep-calm-and-e-comm' ),
				)
			)
		);

	} //if theme companion active

	/*==============
	END HOMEPAGE GENERAL
	==============*/

	/*==============
	START TRACKING PAGE URL
	==============*/

	if($installedOTP){

		// CREATE TRACKING PAGE URL SECTION
		$wp_customize->add_section(
			'ewd_kcae_setting_tracking_page_url',
			array(
				'title'     => __( 'Tracking Page URL', 'keep-calm-and-e-comm'),
				'priority'  => 1
			)
		);

		// TRACKING PAGE URL TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_tracking_page_url_text', array(
			'default'			=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
			'transport'			=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_tracking_page_url_text',
			array(
				'section'	=> 'ewd_kcae_setting_tracking_page_url',
				'label'		=> __( 'Tracking Page URL', 'keep-calm-and-e-comm' ),
				'description'		=> __( 'Input here the URL of the page on which you\'ve placed the [tracking-form] shortcode. This will ensure correct functionality of the features related to the Status Tracking plugin.', 'keep-calm-and-e-comm' ),
				'type'    	=> 'text',
			)
		);

	} //if is active OTP

	/*==============
	END TRACKING PAGE URL
	==============*/

	/*==============
	START CATALOGUE URL
	==============*/

	if($installedUPCP){

		// CREATE CATALOGUE URL SECTION
		$wp_customize->add_section(
			'ewd_kcae_setting_catalogue_url',
			array(
				'title'     => __( 'Catalogue URL', 'keep-calm-and-e-comm'),
				'priority'  => 1
			)
		);

		// CATALOGUE URL TEXT
		$wp_customize->add_setting( 'ewd_kcae_setting_catalogue_url_text', array(
			'default'			=> '',
			'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_url_fields',
			'transport'			=> 'refresh',
		) );
		$wp_customize->add_control(
			'ewd_kcae_setting_catalogue_url_text',
			array(
				'section'	=> 'ewd_kcae_setting_catalogue_url',
				'label'		=> __( 'Catalogue URL', 'keep-calm-and-e-comm' ),
				'description'		=> __( 'Input here the URL of the page on which you\'ve placed your product-catalogue shortcode. This will ensure correct functionality of the features related to the Ultimate Product Catalog plugin.', 'keep-calm-and-e-comm' ),
				'type'    	=> 'text',
			)
		);

	} //if is active UPCP

	/*==============
	END CATALOGUE URL
	==============*/

	/*==============
	START SEARCH OPTIONS
	==============*/

	if( ! $installedOTP && ! $installedUPCP && ! $installedWC){
	}
	else{
		// CREATE SEARCH SECTION
		$wp_customize->add_section(
			'ewd_kcae_setting_search_section',
			array(
				'title'       => __( 'Search', 'keep-calm-and-e-comm'),
				'priority'    => 199,
				'panel'			=> 'ewd_kcae_setting_header_panel'
			)
		);
	}

	// SEARCH TYPE
	$wp_customize->add_setting( 'ewd_kcae_setting_header_search_type', array(
		'default'		=> 'otp',
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_all_radio_fields',
		'transport'		=> 'refresh',
	) );
	if($installedOTP && $installedUPCP && $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'otp'   => __( 'Orders', 'keep-calm-and-e-comm' ),
					'woocommerce'   => __( 'WooCommerce', 'keep-calm-and-e-comm' ),
					'upcp'   => __( 'Ultimate Product Catalog', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	if($installedOTP && $installedUPCP && ! $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'otp'   => __( 'Orders', 'keep-calm-and-e-comm' ),
					'upcp'   => __( 'Ultimate Product Catalog', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	if($installedOTP && ! $installedUPCP && $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'otp'   => __( 'Orders', 'keep-calm-and-e-comm' ),
					'woocommerce'   => __( 'WooCommerce', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	if(! $installedOTP && $installedUPCP && $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'woocommerce'   => __( 'WooCommerce', 'keep-calm-and-e-comm' ),
					'upcp'   => __( 'Ultimate Product Catalog', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	if(! $installedOTP && ! $installedUPCP && $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'woocommerce'   => __( 'WooCommerce', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	if(! $installedOTP && $installedUPCP && ! $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'upcp'   => __( 'Ultimate Product Catalog', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	if($installedOTP && ! $installedUPCP && ! $installedWC){
		$wp_customize->add_control(
			'ewd_kcae_setting_header_search_type',
			array(
				'section'	=> 'ewd_kcae_setting_search_section',
				'label'		=> __( 'Search Type', 'keep-calm-and-e-comm' ),
				'type'    => 'radio',
				'choices'  => array(
					'otp'   => __( 'Orders', 'keep-calm-and-e-comm' ),
					'wordpress'   => __( 'Regular WordPress Search', 'keep-calm-and-e-comm' ),
				)
			)
		);
	}
	else{
	}

	/*==============
	END SEARCH OPTIONS
	==============*/

	/*==============
	START IMPORTANT LINKS
	==============*/
	
	// DEFINE IMPORTANT LINKS
	class ewd_kcae_setting_important_links_class extends WP_Customize_Control {

		public $type = "ewd_kcae_setting_important_links_type";

		public function render_content() {
			$important_links = array(
				'view-pro' => array(
					'link' => esc_url('http://www.etoilewebdesign.com/themes/keep-calm-and-e-comm/'),
					'text' => esc_html__('View Premium Version', 'keep-calm-and-e-comm'),
				),
				'theme-info' => array(
					'link' => esc_url('https://wordpress.org/themes/keep-calm-and-e-comm/'),
					'text' => esc_html__('Theme Info', 'keep-calm-and-e-comm'),
				),
				'support' => array(
					'link' => esc_url('https://wordpress.org/support/theme/keep-calm-and-e-comm/'),
					'text' => esc_html__('Support Forum', 'keep-calm-and-e-comm'),
				),
				'demo' => array(
					'link' => esc_url('http://www.etoilewebdesign.com/keep-calm-and-e-comm/'),
					'text' => esc_html__('View Demo', 'keep-calm-and-e-comm'),
				),
				'rating' => array(
					'link' => esc_url('http://wordpress.org/support/view/theme-reviews/keep-calm-and-e-comm'),
					'text' => esc_html__('Leave a Review', 'keep-calm-and-e-comm'),
				),
				'feedback' => array(
					'link' => esc_url('mailto:contact@etoilewebdesign.com'),
					'text' => esc_html__('Send Us Feedback', 'keep-calm-and-e-comm'),
				),
			);

			foreach ( $important_links as $important_link ) {
				echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_html( $important_link['text'] ) . ' </a></p>';
			}
		}
	}

	// CREATE IMPORTANT SECTION
	$wp_customize->add_section(
		'ewd_kcae_setting_important_links_section',
		array(
			'title'     => __( 'Keep Calm Important Links', 'keep-calm-and-e-comm'),
			'priority'  => 1000
		)
	);

	// DISPLAY IMPORTANT LINKS
	$wp_customize->add_setting( 'ewd_kcae_setting_important_links', array(
		'sanitize_callback' => 'ewd_kcae_setting_sanitize_false',
	) );
	$wp_customize->add_control(
		new ewd_kcae_setting_important_links_class(
			$wp_customize, 'important_links', array(
				'section'	=> 'ewd_kcae_setting_important_links_section',
				'settings'	=> 'ewd_kcae_setting_important_links'
			)
		)
	);

	// IMPORTANT LINKS CSS
	add_action( 'customize_controls_print_footer_scripts', 'ewd_kcae_setting_important_links_css' );
	function ewd_kcae_setting_important_links_css() { ?>
		<style>
			li#accordion-section-ewd_kcae_setting_important_links_section h3 {
				background-color: #037751 !important;
				color: #fff !important;
			}
			li#accordion-section-ewd_kcae_setting_important_links_section h3:after {
				color: #fff !important;
			}
			li#accordion-section-ewd_kcae_setting_important_links_section:hover h3 {
				background-color: #12A374 !important;
			}
			.customize-control-ewd_kcae_setting_important_links_type p a {
				text-decoration: none;
				width: 75%;
				margin-left: 12.5%;
				background-color: #037751;
				color: #fff;
				text-align: center;
				float: left;
				clear: both;
				padding: 6px 0;
				margin-bottom: 10px;
			}
			.customize-control-ewd_kcae_setting_important_links_type p a:hover {
				background-color: #12A374;
			}
			#ewd-ust-lite-ugrade-button {
				text-decoration: none;
				text-align: center;
				margin-top: 4px;
				background: #037751;
				color: #fff;
				font-size: 12px;
				padding: 5px 8px;
				display: inline-block;
			}
			#ewd-ust-lite-ugrade-button:hover {
				background: #12A374;
			}
		</style>
	<?php }

	/*==============
	END IMPORTANT LINKS
	==============*/

} // END ewd_kcae_customize_register FUNCTION
add_action( 'customize_register', 'ewd_kcae_customize_register' );


function ewd_kcae_customizer_css(){
	$fontMain = get_theme_mod( 'ewd_kcae_setting_font_main', '' );
	$fontHeadings = get_theme_mod( 'ewd_kcae_setting_font_heading', '' );
	$fontMenu = get_theme_mod( 'ewd_kcae_setting_font_menu', '' );

	echo "<style type='text/css'>";
		$usCustomizerCSS = "";
		$usCustomizerCSS .= "body { color: " . get_theme_mod( 'ewd_kcae_setting_text_color' ) . "; }";
		$usCustomizerCSS .= "a { color: " . get_theme_mod( 'ewd_kcae_setting_link_color' ) . "; }";
		$usCustomizerCSS .= "#header { background: " . get_theme_mod( 'ewd_kcae_setting_header_background_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li a, #logoTitle a { color: " . get_theme_mod( 'ewd_kcae_setting_menu_text_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li a:hover { color: " . get_theme_mod( 'ewd_kcae_setting_menu_text_hover_color' ) . "; border-color: " . get_theme_mod( 'ewd_kcae_setting_menu_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#logoTitle a:hover { color: " . get_theme_mod( 'ewd_kcae_setting_menu_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#header input:hover { background: " . get_theme_mod( 'ewd_kcae_setting_menu_text_hover_color' ) . "; border-color: " . get_theme_mod( 'ewd_kcae_setting_menu_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li ul { background: " . get_theme_mod( 'ewd_kcae_setting_menu_dropdown_background_color' ) . "; }";
		$usCustomizerCSS .= "/*#menu ul li ul { border-color: " . get_theme_mod( 'ewd_kcae_setting_menu_dropdown_background_color' ) . "; }*/";
		$usCustomizerCSS .= "#menu ul li ul li a:hover { background: " . get_theme_mod( 'ewd_kcae_setting_menu_dropdown_background_hover_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li ul li a { color: " . get_theme_mod( 'ewd_kcae_setting_menu_dropdown_text_color' ) . "; }";
		$usCustomizerCSS .= "#menu ul li ul li a:hover, #header.menuOnSlider #menu ul li ul li a:hover { color: " . get_theme_mod( 'ewd_kcae_setting_menu_dropdown_text_hover_color' ) . "; }";
		$usCustomizerCSS .= "#logo { height: " . get_theme_mod( 'ewd_kcae_setting_logo_height', '24px' ) . "; margin-top: " . get_theme_mod( 'ewd_kcae_setting_logo_top_margin', '28px' ) . "; }";
		$usCustomizerCSS .= ".singlePage .titleArea { background-color: " . get_theme_mod( 'ewd_kcae_setting_page_title_bar_background_color' ) . "; }";
		$usCustomizerCSS .= ".singlePage .titleArea h1 { color: " . get_theme_mod( 'ewd_kcae_setting_page_title_bar_text_color' ) . "; }";
		$usCustomizerCSS .= ".testimonials ul li .testimonialQuote { color: " . get_theme_mod( 'ewd_kcae_setting_testimonial_quote_color' ) . "; }";
		$usCustomizerCSS .= ".panel#footer { background-color: " . get_theme_mod( 'ewd_kcae_setting_footer_background_color' ) . "; }";
		$usCustomizerCSS .= ".panel#footer, .panel#footer a, .panel#footer .widgetBox ul, .panel#footer .widgetBox ul li a, .panel#footer .widgetBox .testimonials ul li .testimonialText .testimonialAuthor span, .panel#footer h1, .panel#footer h2, .panel#footer h3, .panel#footer h4, .panel#footer h5, .panel#footer h6, .panel#footer h1 a, .panel#footer h2 a, .panel#footer h3 a, .panel#footer h4 a, .panel#footer h5 a, .panel#footer h6 a { color: " . get_theme_mod( 'ewd_kcae_setting_footer_text_color' ) . "; }";
		$usCustomizerCSS .= "#copyrightPanel { background-color: " . get_theme_mod( 'ewd_kcae_setting_copyright_background_color' ) . "; }";
		$usCustomizerCSS .= ".copyright { color: " . get_theme_mod( 'ewd_kcae_setting_copyright_text_color' ) . "; }";
		if($fontMain != ''){
			$usCustomizerCSS .= "body { font-family: " . $fontMain . "; }";
		}
		if($fontHeadings != ''){
			$usCustomizerCSS .= "h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { font-family: " . $fontHeadings . "; }";
		}
		if($fontMenu != ''){
			$usCustomizerCSS .= "#menu ul li a, #header input { font-family: " . $fontMenu . "; }";
		}
		echo esc_html($usCustomizerCSS);
	echo "</style>";
}
add_action( 'wp_head', 'ewd_kcae_customizer_css' );

function ewd_kcae_setting_sanitize_all_text_fields($input){
	return sanitize_text_field( wp_unslash($input) );
}
function ewd_kcae_setting_sanitize_all_textarea_fields($input){
	return sanitize_textarea_field( wp_unslash($input) );
}
function ewd_kcae_setting_sanitize_all_color_fields($input){
	return sanitize_hex_color( wp_unslash($input) );
}
function ewd_kcae_setting_sanitize_all_url_fields($input){
	return esc_url_raw( wp_unslash($input) );
}
function ewd_kcae_setting_sanitize_all_radio_fields($input, $setting){
	$input = sanitize_key( wp_unslash($input) );
	$choices = $setting->manager->get_control($setting->id)->choices;
	return ( array_key_exists($input, $choices) ? $input : $setting->default );
}
function ewd_kcae_setting_sanitize_false(){
	return false;
}




/*
=====================================================================
Excerpt Read More link
=====================================================================
*/

function ewd_kcae_excerpt_read_more($more) {
	global $post;
	return '<br><a class="excerptReadMore" href="'. get_permalink($post->ID) . '">' . __('Read More', 'keep-calm-and-e-comm') . '</a>';
}
add_filter('excerpt_more', 'ewd_kcae_excerpt_read_more');




/*
=====================================================================
WooCommerce
=====================================================================
*/

//Declare support
add_action( 'after_setup_theme', 'ewd_kcae_woocommerce_support' );
function ewd_kcae_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action('pre_get_posts','ewd_kcae_woocommerce_filter_product_search');
function ewd_kcae_woocommerce_filter_product_search($query) {
	if ( function_exists('is_shop') and is_shop() and isset($_REQUEST['prod_name'])) {
        $query->set( 's', sanitize_text_field($_REQUEST['prod_name']) );
    }
}

function EWD_KCAE_Get_WooCommerce_Matching_Products() {
	$Path = ABSPATH . 'wp-load.php';
	include_once($Path);

	$Search = $_POST['Search'];
	$Request_Count = $_POST['Request_Count'];

	$Message_Array = array('request_count' => $Request_Count);

	$params = array(
					's' => $Search, 
					'post_type' => 'product',
					'posts_per_page' => 4
				);
	
	$WC_Products_Query = new WP_Query($params);

	if ($WC_Products_Query->post_count > 0) {
		$ProductString = "<div class='upcp-minimal-catalogue upcp-minimal-width-4'>";
		while ( $WC_Products_Query->have_posts() ) : $WC_Products_Query->the_post();
			if (class_exists('WC_Product')) {
				$Product = new WC_Product(get_the_ID());
				$Product_Image = wp_get_attachment_image_src( get_post_thumbnail_id($Featured_Product['ProductID']), 'medium_large' );

				$ProductString .= "<div class='upcp-insert-product upcp-minimal-product-listing'>";
				$ProductString .= "<a class='upcp-minimal-link' href='" . get_permalink() . "'>";
				$ProductString .= "<div class='upcp-minimal-img-div'>";
				$ProductString .= "<div class='upcp-minimal-img-div-inside'>";
				$ProductString .= "<img class='upcp-minimal-img' src='" . $Product_Image[0] . "' alt='" . get_the_title() . "' />";
				$ProductString .= "</div>";
				$ProductString .= "</div>";
				$ProductString .= "<div class='upcp-minimal-title'>" . get_the_title() . "</div>";
				$ProductString .= "<div class='upcp-minimal-price'>" . $Product->get_price() . "</div>";
				$ProductString .= "</a>";
				$ProductString .= "</div>";
			}
		endwhile; wp_reset_query();
		$ProductString .= "</div>";
		$ProductString .= "<div class='clear'></div>";

		$Message_Array['message'] = $ProductString;
	}
	else {$Message_Array['message'] = __("No results found matching ", "keep-calm-and-e-comm") . $Search . ".";}

	echo json_encode($Message_Array);

	die();
}
add_action('wp_ajax_ewd_kcae_wc_ajax_search', 'EWD_KCAE_Get_WooCommerce_Matching_Products');
add_action('wp_ajax_nopriv_ewd_kcae_wc_ajax_search', 'EWD_KCAE_Get_WooCommerce_Matching_Products');
