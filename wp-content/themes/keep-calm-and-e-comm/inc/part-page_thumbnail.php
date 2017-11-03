<?php
$pageLayout = 'default';
if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
  $pageLayout = get_theme_mod('ewd_kcae_prem_setting_page_layout', 'default');
}

              if($pageLayout != 'banner_image'){
                if ( has_post_thumbnail() ){ ?>
                  <div class="thumbnailImage"><?php the_post_thumbnail(); ?></div>
                <?php }
              }
