<?php
$pageSelectedLayout = 'default';
if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
  $pageLayout = get_theme_mod('ewd_kcae_prem_setting_page_layout', 'default');
  global $post;
  if(is_home()){
    $custom = get_post_custom($wp_query->queried_object->ID);
  }
  else{        
    $custom = get_post_custom($post->ID);
  }
  $pageSelectedLayout = $custom["_kcaeHeaderLayoutSelect"][0];
  if($pageSelectedLayout == ''){$pageSelectedLayout = 'from_customizer';}
}
if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
  $Label_404_Page_Title = get_theme_mod( 'ewd_kcae_prem_setting_label_404_title', __( '404', 'keep-calm-and-e-comm' ) );
}
else{
  $Label_404_Page_Title = __( '404', 'keep-calm-and-e-comm' );
}
?>
        <?php if($pageSelectedLayout == 'default' or ( function_exists( 'ewd_kcae_prem_setting_sanitize_false') and $pageSelectedLayout == 'from_customizer' and $pageLayout == 'default')){ ?>
          <section class="titleArea">
            <div class="wrapper">
              <div class="container">
                <?php if(is_archive()){
                  the_archive_title( '<h1>', '</h1>' );
                }
                elseif(is_404()){ ?>
                  <h1><?php echo esc_html($Label_404_Page_Title); ?></h1>
                <?php }
                elseif(is_search()){ ?>
                  <h1><?php _e('Search Results', 'keep-calm-and-e-comm'); ?></h1>
                <?php }
                elseif(is_home()){ ?>
                  <h1>
                    <?php 
                    if (is_object($wp_query->queried_object)) {$homePostTitle = $wp_query->queried_object->post_title;}
                    else {$homePostTitle = the_title();}
                    echo $homePostTitle;
                    ?>
                  </h1>
                <?php }
                else{ ?>
                  <h1><?php the_title(); ?></h1>
                <?php } ?>
                <div class="clear"></div>
                <?php 
                if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
                  get_template_part('inc/option', 'breadcrumbs');
                }
                ?>
              </div> <!-- container -->
            </div> <!-- wrapper -->
          </section>
        <?php }
        if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
          get_template_part('inc/part', 'prem_title_area');
        }
        