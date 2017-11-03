<?php 
/*
Plugin Name: Etoile Theme Companion
Description: A plugin that adds functionality to the themes by Etoile Web Design.
Author: Etoile Web Design
Author URI: http://www.EtoileWebDesign.com/plugins/
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: etoile-theme-companion
Version: 1.5
*/

if ( is_admin() ){
    add_action('widgets_init', 'Update_EWD_UPCP_Theme_Content');
    add_action('admin_head', 'EWD_UPCP_Theme_Admin_Styles');
    add_action('admin_init', 'Add_EWD_UPCP_Theme_Admin_Scripts');
    add_action('admin_menu' , 'EWD_UPCP_Theme_Enable_Menu');
}

function EWD_UPCP_Theme_Enable_Menu() {
    global $submenu;

    add_menu_page('Etoile Themes', 'Theme Options', 'edit_theme_options', 'EWD-UPCP-Theme-options', 'EWD_UPCP_Theme_Options_Page', null , '60.1');
    add_submenu_page('EWD-UPCP-Theme-options', 'Featured Products', 'Featured Products', 'edit_theme_options', 'EWD-UPCP-Theme-options&DisplayPage=Homepage', 'EWD_UPCP_Theme_Options_Page');
}

function EWD_UPCP_Theme_Admin_Styles() {
    wp_enqueue_style( 'ewd-upcp-theme-admin', plugins_url('etoile-theme-companion/css/Admin.css') );
}

function Add_EWD_UPCP_Theme_Admin_Scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'EWD-UPCP-Theme-options') {
        wp_enqueue_script( 'PageSwitch', plugins_url('etoile-theme-companion/js/Admin.js'), array('jquery'));
        $admin_js_localize = array(
            'delete' => __( 'Delete', 'etoile-theme-companion' ),
        );
        wp_localize_script( 'PageSwitch', 'admin_js_local', $admin_js_localize );
        wp_enqueue_media();
    }
}

function Add_EWD_UPCP_Theme_Scripts(){
        wp_enqueue_script( 'upcp_theme_load_featuredProds_js', plugins_url('etoile-theme-companion/js/featuredProds.js'), array( 'jquery' ) );
        wp_enqueue_script( 'upcp_theme_load_textOnPic_js', plugins_url('etoile-theme-companion/js/textOnPic.js'), array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'Add_EWD_UPCP_Theme_Scripts' );


//TEXT DOMAIN
function EWD_Theme_Companion_Text_Domain() {
    load_plugin_textdomain('etoile-theme-companion', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}
add_action('after_setup_theme', 'EWD_Theme_Companion_Text_Domain');



/*
=====================================================================
FEATURED PRODUCTS
=====================================================================
*/

function Update_EWD_UPCP_Theme_Content() {
    //Saving the featured products
    if( $_GET['Action'] == 'EWD_UPCP_Theme_UpdateOptions' && ( ! isset( $_POST['ewd_upcp_theme_featured_products_nonce_field'] ) || ! wp_verify_nonce( $_POST['ewd_upcp_theme_featured_products_nonce_field'], 'ewd_upcp_theme_featured_products_nonce_action' ) || !current_user_can('edit_theme_options') ) ){
        print 'You do not have permission to modify this.';
        exit;
    } 
    else{
        $Counter = 0;
        $Products = array();
        while ($Counter < 32) {
            if (isset($_POST['Featured_Product_' . $Counter . '_ID'])) {
                $Prefix = 'Featured_Product_' . $Counter;

                $Product['ProductID'] = intval($_POST[$Prefix . '_ID']);

                $Products[] = $Product;
                unset($Product);
            }
            $Counter++;
        }
        if (isset($_POST['Options_Submit']) and get_option("EWD_UPCP_Theme_Featured_Products_Type") == $_POST['featured_products_type']) {update_option("EWD_UPCP_Theme_Featured_Products", $Products);}
        elseif (isset($_POST['Options_Submit'])) {update_option("EWD_UPCP_Theme_Featured_Products", array());}
        if (isset($_POST['featured_products_type'])) {update_option("EWD_UPCP_Theme_Featured_Products_Type", sanitize_text_field($_POST['featured_products_type']));}
    }
}

function EWD_UPCP_Theme_Options_Page() {
    $Featured_Products_Type = get_option("EWD_UPCP_Theme_Featured_Products_Type");
    if ($Featured_Products_Type == "") {$Featured_Products_Type = "UPCP";}
    $Featured_Products = get_option("EWD_UPCP_Theme_Featured_Products");

if( ! function_exists( 'ewd_kcae_prem_setting_sanitize_false') && ! function_exists( 'ewd_uopt_prem_setting_sanitize_false') ){
    ?>
    <div id="ewd-ust-dashboard-top-upgrade">
        <div id="ewd-ust-dashboard-top-upgrade-left">
            <div id="ewd-ust-dashboard-pro" class="postbox upcp-pro upcp-postbox-collapsible" >
                <div class="handlediv" title="Click to toggle"></div><h3 class='hndle ewd-dashboard-h3'><span><?php _e("UPGRADE TO FULL VERSION", 'etoile-theme-companion') ?></span></h3>
                <div class="inside">
                    <h3><?php _e("What you get by upgrading:", 'etoile-theme-companion') ?></h3>
                    <div class="ewd-us-clear"></div>
                    <ul>
                        <li><span>Customizable homepage: Add, remove and arrange homepage elements, all in the WordPress customizer!</span></li>
                        <li><span>Additional page and blog layouts, to get that perfect look for your site.</span></li>
                        <li><span>Advanced options including a secondary navigation bar, promo bar, breadcrumbs, contact page form and map, and more!</span></li>
                        <li><span>A free license for the premium version of Ultimate Slider included!</span></li>
                        <li><span>Access to email support.</span></li>
                        <li><span>Free 7-day trial of the premium version available!</span></li>
                    </ul>
                    <div class="ewd-us-clear"></div>
                    <a class="purchaseButton" href="http://www.etoilewebdesign.com/themes/ultimate-showcase/" target="_blank">
                        Click here to purchase the full version
                    </a>
                </div>
            </div>
        </div> <!-- ewd-ust-dashboard-top-upgrade-left -->
    </div> <!-- ewd-ust-dashboard-top-upgrade -->
    <?php
} ?>
<div class="ewd-us-clear"></div>

<h2>Featured Products</h2>
<div class="wrap upcp-theme-options-page-tabbed">
    <div class="upcp-theme-options-submenu-div">
        <ul class="upcp-theme-options-submenu upcp-theme-options-page-tabbed-nav">
            <li><a id="Products_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == '' or $Display_Tab == 'Products') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Products');">Products</a></li>
        </ul>
    </div>


    <div class="upcp-theme-options-page-tabbed-content">

        <form method="post" action="admin.php?page=EWD-UPCP-Theme-options&DisplayPage=Homepage&Action=EWD_UPCP_Theme_UpdateOptions">
            <input type='hidden' class='upcp-theme-selected-products-type' name='Current_Featured_Products_Type' value='<?php echo $Featured_Products_Type; ?>' />
            <div id='Products' class='upcp-theme-option-set'>
                <h2 id='label-premium-options' class='upcp-theme-options-page-tab-title'>Products Options</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">Featured Products Type</th>
                        <td>
                            <fieldset><legend class="screen-reader-text"><span>Featured Products Type</span></legend>
                                <label title='UPCP'><input type='radio' name='featured_products_type' value='UPCP' <?php if($Featured_Products_Type == "UPCP") {echo "checked='checked'";} ?> /> <span>Ultimate Product Catalog</span></label><br />
                                <label title='WooCommerce'><input type='radio' name='featured_products_type' value='WooCommerce' <?php if($Featured_Products_Type  == "WooCommerce") {echo "checked='checked'";} ?> /> <span>WooCommerce</span></label><br />
                                <p>What type of products would you like to display on your homepage?<br/>
                                <strong>Changing this option will delete the featured products you currently have selected</strong></p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Featured Products</th>
                        <td>
                            <fieldset><legend class="screen-reader-text"><span>Featured Products</span></legend>
                                <table id='ewd-upcp-theme-product-list-table'>
                                    <tr>
                                        <th></th>
                                        <th>Product Name</th>
                                    </tr>
                                    <?php
                                    $Counter = 0;
                                    if (!is_array($Featured_Products)) {$Featured_Products = array();}
                                    if (function_exists('UPCP_Get_All_Products') and $Featured_Products_Type == "UPCP") {$Products = UPCP_Get_All_Products();}
                                    elseif ($Featured_Products_Type == "WooCommerce") {$Products = EWD_UPCP_Theme_Get_WooCommerce_Product_List();}
                                    else {$Products = array();}
                                    foreach ($Featured_Products as $Featured_Products_Item) {
                                        echo "<tr id='ewd-upcp-theme-product-list-item-" . $Counter . "'>";
                                        echo "<td><a class='ewd-upcp-theme-delete-product-list-item' data-productid='" . $Counter . "'>" . __('Delete', 'etoile-theme-companion') . "</a></td>";
                                        echo "<td><select name='Featured_Product_" . $Counter . "_ID'>";
                                        if ($Featured_Products_Type == "UPCP") {
                                            foreach ($Products as $Product) {
                                                echo "<option value='" . esc_attr( $Product->Get_Item_ID() ) . "' ";
                                                if ($Featured_Products_Item['ProductID'] == $Product->Get_Item_ID()) {echo "selected=selected";}
                                                echo "/>" . esc_html( $Product->Get_Product_Name() ) . "</option>";
                                            }
                                        }
                                        else {
                                            foreach ($Products as $Product) {
                                                echo "<option value='" . esc_attr( $Product['ID'] ) . "' ";
                                                if ($Featured_Products_Item['ProductID'] == $Product['ID']) {echo "selected=selected";}
                                                echo "/>" . esc_html( $Product['Name'] ) . "</option>";
                                            }
                                        }
                                        echo "</td>";
                                        echo "</tr>";
                                        $Counter++;
                                    }
                                    echo "<tr><td colspan='2'><a class='ewd-upcp-theme-add-product-list-item' data-nextid='" . $Counter . "'>Add</a></td></tr>";
                                    ?>
                                </table>
                                <div><pre><?php print_r($Products, true); ?></pre></div>
                                <p>Select the product names that you'd like to have in the featured boxes.</p>
                            </fieldset>
                        </td>
                    </tr>
                </table>
            </div>

            <p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p>
            <?php wp_nonce_field( 'ewd_upcp_theme_featured_products_nonce_action', 'ewd_upcp_theme_featured_products_nonce_field' ); ?>
        </form>
    </div>
</div>

<?php
}

function EWD_UPCP_Theme_Get_Products() {
    $Featured_Products_Type = $_POST['product_type'];
    
    $Products = array();

    if ($Featured_Products_Type == "WooCommerce") {
        $Products_Array = EWD_UPCP_Theme_Get_WooCommerce_Product_List();

        foreach ($Products_Array as $Products_Array_Item) {
            $Product['ID'] = $Products_Array_Item['ID'];
            $Product['Name'] = $Products_Array_Item['Name'];

            $Products[] = $Product;
        }
    }
    else {
        if (function_exists('UPCP_Get_All_Products')) {$Products_Array = UPCP_Get_All_Products();}
        else {$Products_Array = array();}

        foreach ($Products_Array as $Products_Array_Item) {
            $Product['ID'] = $Products_Array_Item->Get_Item_ID();
            $Product['Name'] = $Products_Array_Item->Get_Product_Name();

            $Products[] = $Product;
        }
    }

    echo json_encode($Products);
}
add_action('wp_ajax_upcp_theme_get_products', 'EWD_UPCP_Theme_Get_Products');


function EWD_UPCP_Theme_Get_WooCommerce_Product_List() {
    $full_product_list = array();
    $loop = new WP_Query( array( 'post_type' => array('product', 'product_variation'), 'posts_per_page' => -1 ) );
    
    while ( $loop->have_posts() ) : $loop->the_post();
        $theid = get_the_ID();
        if (class_exists('WC_Product')) {$product = new WC_Product($theid);}
        // its a variable product
        if( get_post_type() == 'product_variation' ){
            $parent_id = wp_get_post_parent_id($theid );
            $sku = get_post_meta($theid, '_sku', true );
            $thetitle = get_the_title( $parent_id);
 
    // ****** Some error checking for product database *******
            // check if variation sku is set
            if ($sku == '') {
                if ($parent_id == 0) {
                    // Remove unexpected orphaned variations.. set to auto-draft
                    $false_post = array();
                    $false_post['ID'] = $theid;
                    $false_post['post_status'] = 'auto-draft';
                    wp_update_post( $false_post );
                    if (function_exists(add_to_debug)) add_to_debug('false post_type set to auto-draft. id='.$theid);
                } else {
                    // there's no sku for this variation > copy parent sku to variation sku
                    // & remove the parent sku so the parent check below triggers
                    $sku = get_post_meta($parent_id, '_sku', true );
                    if (function_exists(add_to_debug)) add_to_debug('empty sku id='.$theid.'parent='.$parent_id.'setting sku to '.$sku);
                    update_post_meta($theid, '_sku', $sku );
                    update_post_meta($parent_id, '_sku', '' );
                }
            }
    // ****************** end error checking *****************
 
        // its a simple product
        } elseif (class_exists('WC_Product')) {
            $sku = get_post_meta($theid, '_sku', true );
            $thetitle = get_the_title();
        }
        // add product to array but don't add the parent of product variations
        $full_product_list[] = array('Name' => $thetitle, 'SKU' => $sku, 'ID' => $theid); 
    endwhile; wp_reset_query();
    // sort into alphabetical order, by title
    sort($full_product_list);
    return $full_product_list;
}


/*
=====================================================================
JUMP BOXES
=====================================================================
*/

//CREATE JUMP BOXES CUSTOM POST TYPE AND SET MENU ORDER
add_action( 'init', 'upcp_theme_jumpbox_posttype' );
function upcp_theme_jumpbox_posttype(){
    register_post_type(
        'upcp_theme_jumpboxes',
        array(
            'labels' => array(
            'name' => __( 'Jump Boxes', 'etoile-theme-companion' ),
            'singular_name' => __( 'Jump Box', 'etoile-theme-companion' ),
            'add_new_item' => __( 'Add New Jump Box', 'etoile-theme-companion' ),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'jumpbox'),
        'show_in_menu' => 'EWD-UPCP-Theme-options',
        'supports'=> array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' )
        )
    );
}

function upcp_theme_jumpboxes_menu_order($query){
    if($query->is_admin){
        if($query->get('post_type') == 'upcp_theme_jumpboxes'){
          $query->set('orderby', 'menu_order');
          $query->set('order', 'ASC');
        }
    }
    return $query;
}
add_filter('pre_get_posts', 'upcp_theme_jumpboxes_menu_order');

//SHORTCODE
function upcp_theme_jumpbox_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'posts' => '-1',
    ), $atts ) );

    $return_string = '<div class="clear"></div>';
    $return_string .= '<section class="jumpBoxes">';
        if( function_exists(ewd_uopt_load_styles) ){
            $jumpBoxUlClass = get_theme_mod( 'ewd_uopt_setting_homepage_jumpboxes_col', 'two' );
        }
        elseif( function_exists(ewd_kcae_load_styles) ){
            $jumpBoxUlClass = get_theme_mod( 'ewd_kcae_setting_homepage_jumpboxes_col', 'two' );
        }
        else{
            $jumpBoxUlClass = '';
        }
        $return_string .= '<ul class="' . $jumpBoxUlClass . 'Cols">';

            $my_query = new WP_Query('post_type=upcp_theme_jumpboxes&posts_per_page=' . $posts . '&orderby=menu_order&order=ASC');

            while ($my_query->have_posts()) : $my_query->the_post();

                $post_thumbnail_id = get_post_thumbnail_id();
                $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

                $return_string .= '<li>';
                    if($post_thumbnail_url != ''){
                        $return_string .= '<div class="jumpBoxIcon"><img src="' . $post_thumbnail_url . '" alt="' . esc_attr( get_the_title() ) . '"></div>';
                    }
                    $return_string .= '<div class="keepCalmJumpBox">';
                        $return_string .= '<h3>' . esc_html( get_the_title() ) . '</h3>';
                        $return_string .= '<p>' . esc_html( get_the_content() ) . '</p>';
                    $return_string .= '</div>';
                $return_string .= '</li>';

            endwhile;
            wp_reset_query();

        $return_string .= '</ul>';
    $return_string .= '</section>'; //jumpBoxes
    $return_string .= '<div class="clear"></div>';

    return $return_string;
}

function upcp_theme_register_jumpbox_shortcode(){
    add_shortcode('jumpboxes', 'upcp_theme_jumpbox_shortcode');
}
add_action( 'init', 'upcp_theme_register_jumpbox_shortcode');




/*
=====================================================================
TESTIMONIALS
=====================================================================
*/

//CREATE TESTIMONIALS CUSTOM POST TYPE AND SET MENU ORDER
add_action( 'init', 'upcp_theme_testimonial_posttype' );
function upcp_theme_testimonial_posttype(){
    register_post_type(
        'upcp_theme_testi',
        array(
            'labels' => array(
            'name' => __( 'Testimonials', 'etoile-theme-companion' ),
            'singular_name' => __( 'Testimonial', 'etoile-theme-companion' ),
            'add_new_item' => __( 'Add New Testimonial', 'etoile-theme-companion' ),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'testimonials'),
        'show_in_menu' => 'EWD-UPCP-Theme-options',
        'supports'=> array( 'title', 'editor', 'revisions', 'page-attributes' )
        )
    );
}

function upcp_theme_testimonials_menu_order($query){
    if($query->is_admin){
        if($query->get('post_type') == 'upcp_theme_testi'){
          $query->set('orderby', 'menu_order');
          $query->set('order', 'ASC');
        }
    }
    return $query;
}
add_filter('pre_get_posts', 'upcp_theme_testimonials_menu_order');



// ADD META BOXES TO THE EDIT/CREATE POST SCREENS
add_action( 'add_meta_boxes', 'upcp_theme_add_testimonials_metaboxes' );
function upcp_theme_add_testimonials_metaboxes() {
    add_meta_box('upcp_theme_testimonials_meta', __('Name and Company', 'etoile-theme-companion'), 'upcp_theme_testimonials_meta', 'upcp_theme_testi', 'normal', 'high');
}

//add inputs to the meta box
function upcp_theme_testimonials_meta() {
    global $post;
    //Noncename needed to verify where the data originated
    echo '<input type="hidden" name="upcp_theme_testimonials_meta_noncename" id="upcp_theme_testimonials_meta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    //Get the location data if its already been entered
    $testimonialName = get_post_meta($post->ID, '_testimonialName', true);
    $testimonialCompany = get_post_meta($post->ID, '_testimonialCompany', true);
    echo '<label for="_testimonialName">' . __('Name', 'etoile-theme-companion') . '</label>';
    echo '<input type="text" name="_testimonialName" id="_testimonialName" value="' . esc_attr($testimonialName)  . '" class="widefat" />';
    echo '<label for="_testimonialCompany">' . __('Position and Company', 'etoile-theme-companion') . '</label>';
    echo '<input type="text" name="_testimonialCompany" id="_testimonialCompany" value="' . esc_attr($testimonialCompany)  . '" class="widefat" />';
}

//save meta box input fields
function upcp_theme_testimonials_meta_save($post_id, $post) {
    if( !wp_verify_nonce( $_POST['upcp_theme_testimonials_meta_noncename'], plugin_basename(__FILE__) ) ){
        return $post->ID;
    }
    if( !current_user_can( 'edit_post', $post->ID ) )
        return $post->ID;
    $testimonialMeta['_testimonialName'] = sanitize_text_field( $_POST['_testimonialName'] );
    $testimonialMeta['_testimonialCompany'] = sanitize_text_field( $_POST['_testimonialCompany'] );
    // Add values of $testimonialMeta as custom fields
    foreach ($testimonialMeta as $key => $value) {
        if( $post->post_type == 'revision' ) return; //Don't store custom data twice
        $value = implode(',', (array)$value); //If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { //If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { //If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
}
add_action('save_post', 'upcp_theme_testimonials_meta_save', 1, 2); // save the custom fields



//SHORTCODE
function upcp_theme_testimonials_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'posts' => '-1',
        'title' => 'Testimonials',
        'display_title' => 'yes',
        'random' => 'no',
        'specify_post' => 'no',
        'specific_post' => '',
    ), $atts ) );

    if($random == 'yes'){
        $orderBy = 'rand';
    }
    else{
        $orderBy = 'menu_order';
    }

    $return_string = '<div class="clear"></div>';
    if($display_title == 'yes'){
        $return_string .= '<h2>' . esc_html( $title ) . '</h2>';
    }
    $return_string .= '<section class="testimonials">';
        if( function_exists(ewd_uopt_load_styles) ){
            $testimonialUlClass = get_theme_mod( 'ewd_uopt_setting_homepage_testimonials_col', 'three' );
        }
        elseif( function_exists(ewd_kcae_load_styles) ){
            $testimonialUlClass = get_theme_mod( 'ewd_kcae_setting_homepage_testimonials_col', 'three' );
        }
        else{
            $testimonialUlClass = '';
        }
        $return_string .= '<ul class="' . $testimonialUlClass . 'Cols">';

            if($specify_post == 'yes'){
                $specificPost = 'p=' . $specific_post . '&';
            }
            else{
                $specificPost = '';
            }

            $my_query = new WP_Query($specificPost . 'post_type=upcp_theme_testi&posts_per_page=' . $posts . '&orderby=' . $orderBy . '&order=ASC');

            while ($my_query->have_posts()) : $my_query->the_post();

                global $post;
                $custom = get_post_custom($post->ID);
                $testiName = $custom["_testimonialName"][0];
                $testiCompany = $custom["_testimonialCompany"][0];

                if($posts == '1'){
                    $fullWidthTestimonial = ' class="fullWidthTestimonial"';
                }
                else{
                    $fullWidthTestimonial = '';
                }

                $return_string .= '<li' . $fullWidthTestimonial . '>';
                    $return_string .= '<div class="testimonialQuote">&ldquo;</div>';
                    $return_string .= '<div class="testimonialText">';
                        $return_string .= '<p>' . esc_html( get_the_content() ) . '</p>';
                        $return_string .= '<div class="clear"></div>';
                        $return_string .= '<div class="testimonialAuthor">';
                            $return_string .= '<span>' . esc_html($testiName) . '</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;' . esc_html($testiCompany);
                        $return_string .= '</div>'; //testimonialAuthor
                    $return_string .= '</div>'; //testimonialText
                $return_string .= '</li>';

            endwhile;
            wp_reset_query();

        $return_string .= '</ul>';
    $return_string .= '</section>'; //testimonials
    $return_string .= '<div class="clear"></div>';

    return $return_string;
}

function upcp_theme_register_testimonials_shortcode(){
    add_shortcode('testimonials', 'upcp_theme_testimonials_shortcode');
}
add_action( 'init', 'upcp_theme_register_testimonials_shortcode');


//WIDGET

//Creating widget
class upcp_theme_testimonials_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'upcp_theme_testimonials_widget',
            __('Etoile Testimonials', 'etoile-theme-companion'),
            array( 'description' => __( 'Display a specific or a random testimonial', 'etoile-theme-companion' ), )
        );
    }

    //Widget front end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty($title) ){
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        //Output
        if($instance['which_testimonial'] == 'randomTestimonial'){
            echo do_shortcode('[testimonials posts="1" display_title="no" random="yes"]');
        }
        else{
            $theSpecificPost = $instance['which_testimonial'];
            echo do_shortcode('[testimonials posts="1" display_title="no" random="no" specify_post="yes" specific_post="' . $theSpecificPost . '"]');
        }
        echo $args['after_widget'];
    }

    //Widget back end
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Testimonial', 'etoile-theme-companion' );
        }
        //Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'etoile-theme-companion' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'which_testimonial' ); ?>"><?php _e( 'Choose Testimonial', 'etoile-theme-companion' )?>:</label>
            <select id="<?php echo $this->get_field_id( 'which_testimonial' ); ?>" name="<?php echo $this->get_field_name( 'which_testimonial' ); ?>" class="widefat">
                <?php
                $randomTestimonial = __('Random Testimonial','etoile-theme-companion');
                ?>
                <option <?php if ( $randomTestimonial == $instance['which_testimonial'] ) echo 'selected="selected"'; ?> value="<?php echo 'randomTestimonial'; ?>"><?php echo $randomTestimonial; ?></option>
                <?php
                $my_query = new WP_Query('post_type=upcp_theme_testi&posts_per_page=-1&orderby=menu_order&order=ASC');
                while ($my_query->have_posts()) : $my_query->the_post();
                    $postID = get_the_ID();
                ?>
                    <option <?php if ( $postID == $instance['which_testimonial'] ) echo 'selected="selected"'; ?> value="<?php echo $postID; ?>"><?php echo get_the_title(); ?></option>
                <?php
                endwhile;
                wp_reset_query();
                ?>
        </select>
        </p>
        <?php
    }

    //Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['which_testimonial'] = ( ! empty( $new_instance['which_testimonial'] ) ) ? strip_tags( $new_instance['which_testimonial'] ) : '';
        return $instance;
    }
} //Class upcp_theme_testimonials_widget ends here

//Register widget
function upcp_theme_load_testimonials_widget() {
    register_widget( 'upcp_theme_testimonials_widget' );
}
add_action( 'widgets_init', 'upcp_theme_load_testimonials_widget' );




/*
=====================================================================
OTHER SHORTCODES
=====================================================================
*/

//CALLOUT
function upcp_theme_callout_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'color' => '#34ADCF',
        'text_color' => '#ffffff',
        'button_text' => '',
        'button_link' => '#',
        'subtext' => '',
    ), $atts ) );

    $return_string = '<div class="clear"></div>';
    $return_string .= '<section class="calloutArea" style="background-color: ' . esc_attr($color) . '; color: ' . esc_attr($text_color) . ';">';
        $return_string .= '<div class="wrapper">';
            $return_string .= '<div class="container">';
                $return_string .= '<div class="calloutMessage">';
                    $return_string .= '<span class="mainText">' . esc_html($content) . '</span>';
                    if($subtext){
                        $return_string .= '<p>' . esc_html($subtext) . '</p>';
                    }
                $return_string .= '</div>';
                if ($button_text != ''){
                    $return_string .= '<div class="calloutConditionalClear"></div>';
                    $return_string .= '<a href="' . esc_url($button_link) . '" class="newButton rightButton whiteButton" style="margin-top: 0;">' . esc_html($button_text) . '</a>';
                }
            $return_string .= '</div> <!-- container -->';
        $return_string .= '</div> <!-- wrapper -->';
    $return_string .= '</section>';
    $return_string .= '<div class="clear"></div>';

    return $return_string;
}

function upcp_theme_register_callout_shortcode(){
    add_shortcode('callout', 'upcp_theme_callout_shortcode');
}
add_action( 'init', 'upcp_theme_register_callout_shortcode');
