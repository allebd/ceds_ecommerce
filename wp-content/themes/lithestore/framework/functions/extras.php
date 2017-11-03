<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package LitheStore
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function lithestore_body_classes( $lithestore_classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$lithestore_classes[] = 'group-blog';
	}

	return $lithestore_classes;
}
add_filter( 'body_class', 'lithestore_body_classes' );

/**
 * Modify the default WordPress search form
 */

function lithestore_default_search_form( $lithestore_form ) {
    $lithestore_form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Search for:','lithestore' ) . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search','lithestore' ) .'" />
    <input type="hidden" name="post_type" id="post_type" value="post" />
    </div>
    </form>';

    return $lithestore_form;
}
add_filter( 'get_search_form', 'lithestore_default_search_form', 100 );

/**
 * Custom Pagination Navigation
 */
function lithestore_pagenavi(){
   global $wp_query;

	$lithestore_big = 999999999; // need an unlikely integer
	$lithestore_return_html='';
	$lithestore_return_html.='<div class="lithstore_pagenavi">';
	$lithestore_return_html.= paginate_links( array(
		'base' => str_replace( $lithestore_big, '%#%', esc_url( get_pagenum_link( $lithestore_big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_text'    => '&lt;',
	    'next_text'    => '&gt;'
	) );
	$lithestore_return_html.='</div>';
	
	return $lithestore_return_html;
}
