<?php
/*Import data*/
if ( ! function_exists( 'lithestore_import_files' ) ) :
function lithestore_import_files() {
    return array(
        array(
            'import_file_name'             => 'Default',
            'local_import_file'            => get_template_directory() . '/framework/demo/default/content.xml',
            'local_import_widget_file'     => get_template_directory() . '/framework/demo/default/widgets.wie',
            'local_import_customizer_file_url' => get_template_directory() . '/framework/demo/default/customizer.dat',
            'import_preview_image_url'     => get_template_directory_uri() . '/screenshot.png',
            'import_notice'                => __( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'lithestore' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'lithestore_import_files' );
endif;


if ( ! function_exists( 'lithestore_after_import' ) ) :
function lithestore_after_import( $selected_import ) {
    //Set Menu
    $primary_menu = get_term_by('name', 'Primary Menu', 'nav_menu');
    set_theme_mod( 'nav_menu_locations' , 
        array( 
              'primary' => $primary_menu->term_id, 
              'mobile' => $primary_menu->term_id 
             ) 
    );

    //Set Front page
    $page = get_page_by_title( 'Home');
    if ( isset( $page->ID ) ) {
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
    }
}
add_action( 'pt-ocdi/after_import', 'lithestore_after_import' );
endif;