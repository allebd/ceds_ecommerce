<?php
/**
 * LitheStore Theme Customizer.
 *
 * @package LitheStore
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lithestore_customize_register( $wp_customize ) {
    /* Remove Default Options */
    $wp_customize->remove_control('background_color');
    $wp_customize->remove_section('background_image');
    $wp_customize->remove_control('background_image');
    
    /* Include Google Font Lists*/
    include_once 'fonts.php';
    
    /* LOGO Uploader */
	$wp_customize->add_setting( 
	   'logo_upload', 
	   array(	
	      'default' => '',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'esc_attr'
	   ) 
	);
	
	$wp_customize->add_control( 
	    new WP_Customize_Upload_Control( 
		$wp_customize, 
		'logo_upload', 
		array(
			'label'      => __( 'Custom LOGO', 'lithestore' ),
			'description' => __( 'Your theme recommends a LOGO max size of 280 x 60 pixels.','lithestore'),
			'section'    => 'title_tagline',
			'settings'   => 'logo_upload',
		) ) 
	);
	
	/* Copyright Text */
	$wp_customize->add_setting( 
	   'copyright', 
	   array(	
	      'default' => '',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'esc_attr'
	   ) 
	);
																		
	$wp_customize->add_control( 
	   'control_copyright', 
	    array(
	      'label' => __('Copyright Text','lithestore'),
		  'section' => 'title_tagline',
		  'settings' => 'copyright',
		  'type' => 'text'
		) 
	);
	
	/**
     * Color Section
     */
    $wp_customize->add_section(
	    'color_section',
	    array(
	        'title' => __('Colors','lithestore'),
	        'description' => __( 'You can change the color scheme below.','lithestore'),
	        'priority' => 20,
	    )
	);
	
	$wp_customize->add_setting( 
	    'global_color', 
	    array(	
	      'default' => '#289bc1',
		  'transport' => 'postMessage',
		  'sanitize_callback' => 'esc_attr'
		) 
	);
																		
	$wp_customize->add_control( 
	    new WP_Customize_Color_Control( 
	      $wp_customize,
		  'control_global_color', 
		  array(  
		    'label' => __( 'Global Color', 'lithestore' ),												 	
		    'section' => 'color_section',
		    'settings' => 'global_color' 
		 ) 
	   ) 
	);
    
    /**
     * Font Section
     */
    $wp_customize->add_section(
	    'font_section',
	    array(
	        'title' => __('Fonts','lithestore'),
	        'description' => __( 'You can change the other font from the following google fonts list.','lithestore'),
	        'priority' => 25,
	    )
	);
	
	/* Logo Text Font*/
	$wp_customize->add_setting( 
	    'logo_font', 
	    array(	
	      'default' => 'Montserrat',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'esc_attr'
		) 
	);
																		
	$wp_customize->add_control( 
	     'control_logo_font', 
	     array(	
	       'label' => __('LOGO Text Font','lithestore'),
		   'section' => 'font_section',
		   'settings' => 'logo_font',
		   'type' => 'select',
		   'choices' => $lithestore_all_fonts 
		 ) 
	);
	
	/* Heading Text Font*/
	$wp_customize->add_setting( 
	    'heading_font', 
	    array(	
	      'default' => 'Lato',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'esc_attr'
		) 
	);
																		
	$wp_customize->add_control( 
	     'control_heading_font', 
	     array(	
	       'label' => __('Heading Text Font','lithestore'),
		   'section' => 'font_section',
		   'settings' => 'heading_font',
		   'type' => 'select',
		   'choices' => $lithestore_all_fonts 
		 ) 
	);
	
	/* Navigation Text Font*/
	$wp_customize->add_setting( 
	    'navigation_font', 
	    array(	
	      'default' => 'Karla',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'esc_attr'
		) 
	);
																		
	$wp_customize->add_control( 
	     'control_navigation_font', 
	     array(	
	       'label' => __('Navigation Text Font','lithestore'),
		   'section' => 'font_section',
		   'settings' => 'navigation_font',
		   'type' => 'select',
		   'choices' => $lithestore_all_fonts 
		 ) 
	);
	
	/* Body Text Font*/
	$wp_customize->add_setting( 
	    'body_font', 
	    array(	
	      'default' => 'Lato',
		  'transport' => 'refresh',
		  'sanitize_callback' => 'esc_attr'
		) 
	);
																		
	$wp_customize->add_control( 
	     'control_body_font', 
	     array(	
	       'label' => __('Body Text Font','lithestore'),
		   'section' => 'font_section',
		   'settings' => 'body_font',
		   'type' => 'select',
		   'choices' => $lithestore_all_fonts 
		 ) 
	);

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'logo_font' )->transport = 'postMessage';
	$wp_customize->get_setting( 'heading_font' )->transport = 'postMessage';
	$wp_customize->get_setting( 'navigation_font' )->transport = 'postMessage';
	$wp_customize->get_setting( 'body_font' )->transport = 'postMessage';
	$wp_customize->get_setting( 'global_color' )->transport = 'postMessage';
}
add_action( 'customize_register', 'lithestore_customize_register' );

/**
 * Import Google Fonts	
 */
function lithestore_custom_fonts_url() {
        $lithestore_fonts_url = '';
	    $lithestore_font_families = array();
	 
	    if(get_theme_mod( 'navigation_font', 'Karla' )<>'Karla'){
	        $lithestore_font_families[] = esc_html(get_theme_mod( 'navigation_font', 'Karla' )).':400,600,700,900,400italic,600italic,700italic,900italic';
	    }
	 
	    if(get_theme_mod( 'body_font', 'Lato' )<>'Lato') {
	        $lithestore_font_families[] = esc_html(get_theme_mod( 'body_font', 'Lato' )).':400,700,400italic,700italic';
	    }
	    
	    if(get_theme_mod( 'heading_font', 'Lato' )<>'Lato'){
	        $lithestore_font_families[] = esc_html(get_theme_mod( 'heading_font', 'Lato' )).':400,700,800,300,100';
	    }
	    
	    if(get_theme_mod( 'logo_font', 'Montserrat' )<>'Montserrat'){
	        $lithestore_font_families[] = esc_html(get_theme_mod( 'logo_font', 'Montserrat' ));
	    }
	    
	    $lithestore_query_args = array(
            'family' => urlencode( implode( '|', $lithestore_font_families ) ),
            'subset' => urlencode( 'latin,latin-ext,vietnamese,cyrillic-ext,cyrillic,greek,greek-ext' ),
        );
 
        $lithestore_fonts_url = add_query_arg( $lithestore_query_args, 'https://fonts.googleapis.com/css' );
    
    return esc_url_raw( $lithestore_fonts_url );
}

function lithestore_custom_font_styles() {
	if ( esc_html(get_theme_mod( 'navigation_font', 'Karla' ))<>'Karla' || esc_html(get_theme_mod( 'body_font', 'Lato' ))<>'Lato' || esc_html(get_theme_mod( 'logo_font', 'Montserrat' ))<>'Montserrat' || esc_html(get_theme_mod( 'heading_font', 'Karla' ))<>'Karla' ) {
    wp_enqueue_style( 'lithestore-custom-fonts', lithestore_custom_fonts_url(), array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'lithestore_custom_font_styles' );


/**
 * Output Customize CSS	
 */
function lithestore_customize_css(){
	if ( esc_html(get_theme_mod('global_color', '#289bc1')) <>'#289bc1' || esc_html(get_theme_mod( 'navigation_font', 'Karla' ))<>'Karla' || esc_html(get_theme_mod( 'body_font', 'Lato' ))<>'Lato' || esc_html(get_theme_mod( 'logo_font', 'Montserrat' ))<>'Montserrat' || esc_html(get_theme_mod( 'heading_font', 'Karla' ))<>'Karla' ):
?>
     <style type="text/css">
     <?php if ( esc_html(get_theme_mod('body_font', 'Lato')) <>'Lato'):?>
         body { font-family:<?php echo esc_html(get_theme_mod('body_font', 'Lato')); ?>; }
     <?php endif;?>
     <?php if ( esc_html(get_theme_mod('heading_font', 'Karla')) <>'Karla'):?>
         h1,h2,h3,h4,h5,h6,blockquote{font-family: <?php echo esc_html(get_theme_mod('heading_font', 'Karla')); ?>, serif;}
     <?php endif;?>
     <?php if ( esc_html(get_theme_mod('navigation_font', 'Karla')) <>'Karla'):?>
         .main-navigation a {font-family: <?php echo esc_html(get_theme_mod('navigation_font', 'Karla')); ?>, serif;}
     <?php endif;?>
     <?php if ( esc_html(get_theme_mod('logo_font', 'Montserrat')) <>'Montserrat'):?>
         .site-branding .site-title{font-family: <?php echo esc_html(get_theme_mod('logo_font', 'Montserrat')); ?>, serif;}
     <?php endif;?>
     <?php if ( esc_html(get_theme_mod('global_color', '#289bc1')) <>'#289bc1'):?>    
         a,#ls-topbar.withbg .main-navigation a:hover,.main-navigation a:hover,.site-cover .main-navigation a:hover,.widget li a:hover,.widget_categories ul.children li a:hover,
.widget_nav_menu ul.sub-menu li a:hover,.entry-title a:hover,.woocommerce ul.products li.product .price {color:<?php echo esc_html(get_theme_mod('global_color', '#289bc1')); ?>;}
         input[type="button"]:hover,input[type="submit"]:hover,input[type="reset"]:hover,.button:hover,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.bullet_links a.active,.woocommerce a.button.checkout-button{border-color:<?php echo esc_html(get_theme_mod('global_color', '#289bc1')); ?>;background-color:<?php echo esc_html(get_theme_mod('global_color', '#289bc1')); ?>;}
         #site-icons a:hover{border-color:<?php echo esc_html(get_theme_mod('global_color', '#289bc1')); ?>;color:<?php echo esc_html(get_theme_mod('global_color', '#289bc1')); ?>;}
      <?php endif;?>
     </style>
<?php
  endif;
}
add_action( 'wp_head', 'lithestore_customize_css');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lithestore_customize_preview_js() {
	wp_enqueue_script( 'lithestore_customizer', get_template_directory_uri() . '/framework/assets/js/customizer.js', array( 'customize-preview' ), rand(), true );
}
add_action( 'customize_preview_init', 'lithestore_customize_preview_js' );
?>