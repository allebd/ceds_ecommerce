<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package LitheStore
 */

if ( ! function_exists( 'lithestore_before_content' ) ) :
/**
 * Before Content
 */
function lithestore_before_content(){
	echo '<div id="page" class="hfeed site ls-grid-1000">
	  <div id="content" class="site-content">';
}
endif;

if ( ! function_exists( 'lithestore_after_content' ) ) :
/**
 * After Content
 * Closes the wrapping divs
 */
function lithestore_after_content(){
	echo '</div>
	   </div>';
}
endif;

if ( ! function_exists( 'lithestore_before_main_content' ) ) :
/**
 * Before Main Content
 */
function lithestore_before_main_content(){
	echo '<main id="primary" class="ls-grid ls-col9 site-main" role="main">';
}
endif;

if ( ! function_exists( 'lithestore_after_main_content' ) ) :
/**
 * After Main Content
 */
function lithestore_after_main_content(){
	echo '</main>';
}
endif;

if ( ! function_exists( 'lithestore_after_conent' ) ) :
/**
 * After Content
 * Closes the wrapping divs
 */
function lithestore_after_conent(){
	echo '</div>
	   </div>';
}
endif;


if ( ! function_exists( 'lithestore_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function lithestore_posted_on() {
	$lithestore_time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$lithestore_time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$lithestore_time_string = sprintf( $lithestore_time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$lithestore_posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'lithestore' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $lithestore_time_string . '</a>'
	);

	$lithestore_byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'lithestore' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on"><i class="fa fa-clock-o"></i> ' . $lithestore_posted_on . '</span><span class="byline"><i class="fa fa-user"></i> ' . $lithestore_byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'lithestore_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function lithestore_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$lithestore_categories_list = get_the_category_list( esc_html__( ', ', 'lithestore' ) );
		if ( $lithestore_categories_list && lithestore_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'lithestore' ) . '</span>', $lithestore_categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$lithestore_tags_list = get_the_tag_list( '', esc_html__( ', ', 'lithestore' ) );
		if ( $lithestore_tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'lithestore' ) . '</span>', $lithestore_tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'lithestore' ), esc_html__( '1 Comment', 'lithestore' ), esc_html__( '% Comments', 'lithestore' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'lithestore' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function lithestore_categorized_blog() {
	if ( false === ( $lithestore_all_the_cool_cats = get_transient( 'lithestore_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$lithestore_all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$lithestore_all_the_cool_cats = count( $lithestore_all_the_cool_cats );

		set_transient( 'lithestore_categories', $lithestore_all_the_cool_cats );
	}

	if ( $lithestore_all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so lithestore_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so lithestore_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in lithestore_categorized_blog.
 */
function lithestore_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'lithestore_categories' );
}
add_action( 'edit_category', 'lithestore_category_transient_flusher' );
add_action( 'save_post',     'lithestore_category_transient_flusher' );

/**
 * Custom LOGO and Text
 */
function lithestore_custom_logo(){
		$customize_logo=get_theme_mod( 'logo_upload');
	    if (!empty($customize_logo) && $customize_logo<>'' ) {
			$lithestore_logo='<img src="'.esc_url(get_theme_mod( 'logo_upload')).'" alt="'.get_bloginfo('name').'" />';
	    } else { 
		   $lithestore_logo=get_bloginfo('name');
		}
		
		echo '<div class="site-branding ls-grid ls-col3">';
			if ( is_front_page() && is_home() ){
				echo'<h1 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.$lithestore_logo.'</a></h1>';
			}else{
				echo'<span class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">'.$lithestore_logo.'</a></span>';
			}
		echo '</div><!-- .site-branding -->';
}

/**
 * Primary Navigation
 */
function lithestore_primary_navigation(){
	   echo'<nav id="site-navigation" class="main-navigation ls-grid ls-col7" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i></button>'.wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu','echo' => false ) ).'</nav><!-- #site-navigation -->';
}

/**
 * Top Buttons in Navigation
 */
function lithestore_top_buttons(){
  if ( class_exists( 'woocommerce' ) ){
	   echo'<div id="site-icons" class="ls-grid ls-col3">
	      <a href="javascript:void(0);" id="product_search"><i class="fa fa-search"></i></a>
		  <a href="'.home_url('/').'?page_id='.get_option('woocommerce_myaccount_page_id').'"><i class="fa fa-user"></i></a>
		  <a href="'.home_url('/').'?page_id='.get_option('woocommerce_cart_page_id').'"><i class="fa fa-shopping-cart"></i></a>
		</div>';
  }
}

function lithestore_cover(){
	if(is_home() || is_front_page()){
	  if(has_header_image()){
	 echo'<div id="ls-header-cover">
			  <h2>'.get_bloginfo('description').'</h2>
			  <a href="#page" title="'.esc_html__('Explore','lithestore').'" class="view-content"><i class="fa fa-angle-down"></i></a>
   	 </div>
   	 <div id="ls-header-overlay"></div>';
   	 }
    }
}

/**
 * The Wrapper Before Navigation
 */
function lithestore_before_navigation(){
	   echo'<div id="ls-topbar">
	 <div id="ls-primary-bar" class="ls-grid-1000">';
}

/**
 * The Wrapper After Navigation
 */
function lithestore_after_navigation(){
	   echo'</div>
	  </div>';
}

/**
 * Copyright Text in Footer	
 */
function lithestore_copyright(){
	$copyright = get_theme_mod( 'copyright');
	if(!empty($copyright) && $copyright<>''){
	    echo $copyright;
	}else{
        echo esc_html__( 'Proudly powered by', 'lithestore' ).'<a href="https://wordpress.org/" target="_blank"> WordPress</a><span class="sep"> | </span>'.esc_html__( 'Designed by','lithestore').' <a href="http://lithestore.com" target="_blank" alt="Free WooCommerce WordPress Theme">LitheStore</a>';
	}
}

/**
 * Output the lithestore Breadcrumb.
 * Thanks https://www.thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin
 */
if ( ! function_exists( 'lithestore_breadcrumbs' ) ) {
function lithestore_breadcrumbs() {
       
    // Settings
    $lithestore_separator          = '&gt;';
    $lithestore_breadcrums_id      = 'ls-breadcrumbs';
    $lithestore_breadcrums_class   = 'ls-breadcrumbs ls-grid-1000';
    $lithestore_home_title         = 'Homepage';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $lithestore_custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<div id="' . $lithestore_breadcrums_id . '" class="' . $lithestore_breadcrums_class . '"><ul>';
           
        // Home page
        echo '<li class="item-home"><i class="fa fa-home"></i><a class="bread-link bread-home" href="' . esc_url(get_home_url()) . '" title="' . $lithestore_home_title . '">' . $lithestore_home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $lithestore_separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $lithestore_post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($lithestore_post_type != 'post') {
                  
                $lithestore_post_type_object = get_post_type_object($lithestore_post_type);
                $lithestore_post_type_archive = get_post_type_archive_link($lithestore_post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $lithestore_post_type . '"><a class="bread-cat bread-custom-post-type-' . $lithestore_post_type . '" href="' . $lithestore_post_type_archive . '" title="' . $lithestore_post_type_object->labels->name . '">' . $lithestore_post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $lithestore_separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $lithestore_post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($lithestore_post_type != 'post') {
                  
                $lithestore_post_type_object = get_post_type_object($lithestore_post_type);
                $lithestore_post_type_archive = get_post_type_archive_link($lithestore_post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $lithestore_post_type . '"><a class="bread-cat bread-custom-post-type-' . $lithestore_post_type . '" href="' . $lithestore_post_type_archive . '" title="' . $lithestore_post_type_object->labels->name . '">' . $lithestore_post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $lithestore_separator . ' </li>';
              
            }
              
            // Get post category info
            $lithestore_category = get_the_category();
             
            if(!empty($lithestore_category)) {
              
                // Get last category post is in
                $lithestore_last_category = end(array_values($lithestore_category));
                  
                // Get parent any categories and create array
                $lithestore_get_cat_parents = rtrim(get_category_parents($lithestore_last_category->term_id, true, ','),',');
                $lithestore_cat_parents = explode(',',$lithestore_get_cat_parents);
                  
                // Loop through parent categories and store in variable $lithestore_cat_display
                $lithestore_cat_display = '';
                foreach($lithestore_cat_parents as $parents) {
                    $lithestore_cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $lithestore_cat_display .= '<li class="separator"> ' . $lithestore_separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $lithestore_taxonomy_exists = taxonomy_exists($lithestore_custom_taxonomy);
            if(empty($lithestore_last_category) && !empty($lithestore_custom_taxonomy) && $lithestore_taxonomy_exists) {
                   
                $lithestore_taxonomy_terms = get_the_terms( $post->ID, $lithestore_custom_taxonomy );
                $lithestore_cat_id         = $lithestore_taxonomy_terms[0]->term_id;
                $lithestore_cat_nicename   = $lithestore_taxonomy_terms[0]->slug;
                $lithestore_cat_link       = get_term_link($lithestore_taxonomy_terms[0]->term_id, $lithestore_custom_taxonomy);
                $lithestore_cat_name       = $lithestore_taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($lithestore_last_category)) {
                echo $lithestore_cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($lithestore_cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $lithestore_cat_id . ' item-cat-' . $lithestore_cat_nicename . '"><a class="bread-cat bread-cat-' . $lithestore_cat_id . ' bread-cat-' . $lithestore_cat_nicename . '" href="' . $lithestore_cat_link . '" title="' . $lithestore_cat_name . '">' . $lithestore_cat_name . '</a></li>';
                echo '<li class="separator"> ' . $lithestore_separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $lithestore_separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $lithestore_term_id        = get_query_var('tag_id');
            $lithestore_taxonomy       = 'post_tag';
            $lithestore_args           = 'include=' . $lithestore_term_id;
            $lithestore_terms          = get_terms( $lithestore_taxonomy, $lithestore_args );
            $lithestore_get_term_id    = $lithestore_terms[0]->term_id;
            $lithestore_get_term_slug  = $lithestore_terms[0]->slug;
            $lithestore_get_term_name  = $lithestore_terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $lithestore_get_term_id . ' item-tag-' . $lithestore_get_term_slug . '"><strong class="bread-current bread-tag-' . $lithestore_get_term_id . ' bread-tag-' . $lithestore_get_term_slug . '">' . $lithestore_get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $lithestore_separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $lithestore_separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $lithestore_separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $lithestore_userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $lithestore_userdata->user_nicename . '"><strong class="bread-current bread-current-' . $lithestore_userdata->user_nicename . '" title="' . $lithestore_userdata->display_name . '">' . 'Author: ' . $lithestore_userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page','lithestore') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul></div>';
           
    }
       
  }
}
			

