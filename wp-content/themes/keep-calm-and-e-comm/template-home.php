<?php
/* Template Name: Homepage */
get_header();

$installedSlider = function_exists('EWD_US_Admin_Options');
$installedThemeCompanion = function_exists('EWD_UPCP_Theme_Enable_Menu');
$installedUPCP = function_exists('UPCP_Plugin_Menu');
$installedOTP = function_exists('EWD_OTP_Default_Statuses');
$installedWC = function_exists('woocommerce_get_page_id');

$Featured_Products = get_option("EWD_UPCP_Theme_Featured_Products");
$Featured_Products_Type = get_option("EWD_UPCP_Theme_Featured_Products_Type");
if ($Featured_Products_Type == "") {$Featured_Products_Type = "UPCP";}

if( function_exists('ewd_kcae_prem_setting_sanitize_false') ){
	$Featured_Products_Label = get_theme_mod( 'ewd_kcae_prem_setting_label_featured_products', __( 'Featured Products', 'keep-calm-and-e-comm' ) );
	$Testimonials_Label = get_theme_mod( 'ewd_kcae_prem_setting_label_testimonials', __( 'Testimonials', 'keep-calm-and-e-comm' ) );
	$Full_Catalog_Label = get_theme_mod( 'ewd_kcae_prem_setting_label_fullcatalog', __( 'Full Catalog', 'keep-calm-and-e-comm' ) );
}
else {
	$Featured_Products_Label = __( 'Featured Products', 'keep-calm-and-e-comm' );
	$Testimonials_Label = __( 'Testimonials', 'keep-calm-and-e-comm' );
	$Full_Catalog_Label = __( 'Full Catalog', 'keep-calm-and-e-comm' );
}
?>

<style>
	<?php
	$pageHomeCSS = "";
	$pageHomeCSS .= ".textOnPic .innerText .innerTextTitle { color: " . get_theme_mod( 'ewd_kcae_setting_textonpic_text_color' ) . "; }";
	$pageHomeCSS .= ".textOnPic .innerText .innerTextExcerpt { color: " . get_theme_mod( 'ewd_kcae_setting_textonpic_text_color' ) . "; }";
	$pageHomeCSS .= ".textOnPic { background: url(" . get_theme_mod( 'ewd_kcae_setting_textonpic_background_image' ) . "); }";
	echo esc_html($pageHomeCSS);
	?>
</style>

<?php
if( ! function_exists('ewd_kcae_prem_setting_sanitize_false') ){
 
	$sliderEnable = get_theme_mod( 'ewd_kcae_setting_homepage_slider_enable', 'yes' );
	if ($sliderEnable == "yes" && $installedSlider){ ?>
		<script>
			jQuery(document).ready(function($){
				var scrollDistance;
				$(window).scroll(function(){
					scrollDistance = $(window).scrollTop();
					if( scrollDistance > 48 ){
						$('#header').removeClass('menuOnSlider');		
					}
					else{
						$('#header').addClass('menuOnSlider');		
					}
				});
			});
		</script>
	<?php } ?>

			<?php
			if ($sliderEnable == "yes" && $installedSlider) {
				$sliderMenuClearID = 'sliderMenuClear';
				if( function_exists('ewd_kcae_prem_setting_sanitize_false') ){
					$promoBar = get_theme_mod('ewd_kcae_prem_setting_promo_bar_enable', 'no');
					$utilityNavEnable = get_theme_mod('ewd_kcae_prem_setting_utility_nav_enable', 'yes');
					if($utilityNavEnable == 'yes' && $promoBar == 'no'){
						$sliderMenuClearID = 'sliderMenuClearWithUtilityNav';
					}
					elseif($utilityNavEnable == 'no' && $promoBar == 'yes'){
						$sliderMenuClearID = 'sliderMenuClearWithPromoBar';
					}
					elseif($utilityNavEnable == 'yes' && $promoBar == 'yes'){
						$sliderMenuClearID = 'sliderMenuClearWithUtilityNavAndPromoBar';
					}
					else{
						$sliderMenuClearID = 'sliderMenuClear';
					}
				}
				?>
				<div id="<?php echo $sliderMenuClearID; ?>"></div>
				<?php
				if(function_exists('EWD_US_Display_Slider')){
					echo EWD_US_Display_Slider(
						array(
							'posts' => -1,
							'static' => get_theme_mod( 'ewd_kcae_setting_homepage_slider_static_first' ),
						)
					);
				}
			}
			?>

			<?php $jumpBoxesEnable = get_theme_mod( 'ewd_kcae_setting_homepage_jumpboxes_enable', 'yes' );
			if ($jumpBoxesEnable == 'yes' && $installedThemeCompanion) { ?>
				<section class="panel">
					<div class="wrapper">
						<div class="container<?php echo ( ( get_theme_mod( 'ewd_kcae_setting_homepage_slider_enable' ) == 'no' || ! $installedSlider ) ? ' homeContentNoSlider' : ''); ?>">
							<?php
							if(function_exists('upcp_theme_jumpbox_shortcode')){
								echo upcp_theme_jumpbox_shortcode(
									array(
										'posts' => -1,
									)
								);
							}
							?>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			<?php } ?>

			<div class="clear"></div>

			<?php 
			$trackOrdersEnable = get_theme_mod( 'ewd_kcae_setting_homepage_track_orders_enable', 'yes' );
			if($installedOTP && $trackOrdersEnable == 'yes'){ ?>
				<section class="panel greenPanel">
					<div class="wrapper">
						<div class="container centerText">
							<h2><?php _e("Track an Order", "keep-calm-and-e-comm"); ?></h2>
							<p><?php _e("Enter your tracking code below and press Enter", "keep-calm-and-e-comm"); ?></p>
							<?php 
							$TrackingPageUrl = get_theme_mod( 'ewd_kcae_setting_tracking_page_url_text' );
							if( function_exists('ewd_kcae_prem_setting_sanitize_false') ){
								$Homepage_Track_Orders_Label = get_theme_mod( 'ewd_kcae_prem_setting_label_home_track', __( 'Enter Tracking #', 'keep-calm-and-e-comm' ) );
							}
							else{ 
								$Homepage_Track_Orders_Label = __( 'Enter Tracking #', 'keep-calm-and-e-comm' );
							}
							?>
							<form id="homePageTrackingForm" method="post" action="<?php echo esc_url($TrackingPageUrl); ?>">
								<input type="text" name="Tracking_Number" id="homePageTrackingFormInput" placeholder="<?php echo esc_attr($Homepage_Track_Orders_Label); ?>">
							</form>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
				<div class="clear"></div>
			<?php } ?>

			<section class="panel">
				<div class="wrapper">
					<div class="container centerText">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<h1><?php the_title(); ?></h1>
							<div class="tagline"><?php the_content(); ?></div>
							<?php wp_link_pages(); ?>
						<?php endwhile; else: ?>
							<p><?php _e('Sorry, but it seems that a homepage hasn\'t been created.', 'keep-calm-and-e-comm'); ?></p>
						<?php endif; ?>
					</div> <!-- container -->
				</div> <!-- wrapper -->
			</section>

			<div class="clear"></div>

			<?php $featuredProdsEnable = get_theme_mod( 'ewd_kcae_setting_homepage_featured_enable', 'yes' ); ?>
			<?php if ( $featuredProdsEnable == 'yes' && $installedThemeCompanion && ($installedUPCP || $installedWC) ) { ?>
				<section class="panel grayPanel">
					<div class="wrapper">
						<div class="container">
							<h2 class="centerText">
								<?php echo esc_html($Featured_Products_Label); ?>
							</h2>
							<section class="featuredProds" id="homeFeaturedProds">
								<ul class="fourCols">
									<?php
									if (!is_array($Featured_Products)) {$Featured_Products = array();}
									if ($Featured_Products_Type == "UPCP" and class_exists('UPCP_Product') and $installedUPCP) {
										foreach ($Featured_Products as $Featured_Product) {
											$Product = new UPCP_Product(array('ID' => $Featured_Product['ProductID']));
											$Product_Permalink = $Product->Get_Permalink(get_theme_mod( 'ewd_kcae_setting_catalog_url_text' ));
											echo "<li>";
												echo "<img src='" . esc_url( $Product->Get_Field_Value('Item_Photo_URL') ) . "' alt='" . esc_attr( $Product->Get_Product_Name() ) . "' />";
												echo "<a href='" . esc_url($Product_Permalink) . "' class='proLink'>";
													echo "<div class='prodInfo'>";
														echo "<div class='prodTitle'>" . esc_html( substr($Product->Get_Product_Name(), 0, 30) ) . "</div>";
														echo "<div class='prodExcerpt'>" . esc_html( substr(strip_tags($Product->Get_Field_Value('Item_Description')), 0, 60) ) . "</div>";
														echo "<div class='readMore'><i class='fa fa-external-link-square'></i></div>";
													echo "</div>";
												echo "</a>";
											echo "</li>";
										}
									}
									elseif ($Featured_Products_Type == "WooCommerce" and class_exists('WC_Product') and $installedWC) {
										foreach ($Featured_Products as $Featured_Product) {
											$Product = new WC_Product($Featured_Product['ProductID']);
											$Product_Permalink = get_permalink($Featured_Product['ProductID']);
											$Product_Image = wp_get_attachment_image_src( get_post_thumbnail_id($Featured_Product['ProductID']), 'medium_large' );
											echo "<li>";
												echo "<img src='" . esc_url( $Product_Image[0] ) . "' alt='" . esc_attr( get_the_title($Featured_Product['ProductID']) ) . "' />";
												echo "<a href='" . esc_url($Product_Permalink) . "' class='proLink'>";
													echo "<div class='prodInfo'>";
														echo "<div class='prodTitle'>" . esc_html( substr(get_the_title($Featured_Product['ProductID']), 0, 30) ) . "</div>";
														echo "<div class='prodExcerpt'>" . esc_html( substr(strip_tags(get_post_field('post_content', $post_id)), 0, 60) ) . "</div>";
														echo "<div class='readMore'><i class='fa fa-external-link-square'></i></div>";
													echo "</div>";
												echo "</a>";
											echo "</li>";
										}
									}
									?>
								</ul>
							</section> <!-- featuredProds -->
							<div class="clear"></div>
							<?php
							$CatalogUrl = get_theme_mod('ewd_kcae_setting_catalogue_url_text');
							?>
							<a href="<?php echo esc_url($CatalogUrl); ?>" class="newButton centerButton"><?php echo esc_html($Full_Catalog_Label); ?></a>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			<?php } ?>

			<div class="clear"></div>

			<?php $textPicEnable = get_theme_mod( 'ewd_kcae_setting_textonpic_enable', 'yes' ); ?>
			<?php if($textPicEnable == "yes" && $installedThemeCompanion){ ?>
				<section class="textOnPic">
					<div class="wrapper">
						<div class="container">
							<div class="textOnPicImage">
								<?php if( get_theme_mod( 'ewd_kcae_setting_textonpic_overlay_image' ) != '' ){ ?>
									<img src="<?php echo esc_url( get_theme_mod( 'ewd_kcae_setting_textonpic_overlay_image' ) ); ?>">
								<?php } ?>
							</div>
							<div class="innerText">
								<div class="innerTextTitle"><?php echo esc_html( get_theme_mod( 'ewd_kcae_setting_textonpic_heading_text' ) ); ?></div>
								<div class="clear"></div>
								<div class="innerTextExcerpt"><?php echo esc_html( get_theme_mod( 'ewd_kcae_setting_textonpic_subheading_text' ) ); ?></div>
								<div class="clear"></div>
								<?php if(get_theme_mod( 'ewd_kcae_setting_textonpic_button_text' ) != ''){echo '<a href="' . esc_url( get_theme_mod( 'ewd_kcae_setting_textonpic_button_link' ) ) . '" class="newButton whiteButton">' . esc_html( get_theme_mod( 'ewd_kcae_setting_textonpic_button_text' ) ) . '</a>'; } ?>
							</div> <!-- innerText -->
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			<?php } ?>

			<div class="clear"></div>

			<?php $testiEnable = get_theme_mod( 'ewd_kcae_setting_homepage_testimonials_enable', 'yes' ); ?>
			<?php if($testiEnable == 'yes' && $installedThemeCompanion){ ?>
				<section class="panel">
					<div class="wrapper">
						<div class="container">
							<?php
							if(function_exists('upcp_theme_testimonials_shortcode')){
								echo upcp_theme_testimonials_shortcode(
									array(
										'posts' => -1,
										'title' => esc_html($Testimonials_Label),
									)
								);
							}
							?>
						</div> <!-- container -->
					</div> <!-- wrapper -->
				</section>
			<?php } ?>

			<?php
			$calloutEnable = get_theme_mod( 'ewd_kcae_setting_callout_enable', 'yes' );
			if($calloutEnable == "yes" && $installedThemeCompanion){
				if(function_exists('upcp_theme_callout_shortcode')){
					echo upcp_theme_callout_shortcode(
						array(
							'color' => esc_attr( get_theme_mod( 'ewd_kcae_setting_callout_background_color' ) ),
							'text_color' => esc_attr( get_theme_mod( 'ewd_kcae_setting_callout_text_color' ) ),
							'button_text' => esc_html( get_theme_mod( 'ewd_kcae_setting_callout_button_text' ) ),
							'button_link' => esc_url( get_theme_mod( 'ewd_kcae_setting_callout_button_link' ) ),
							'subtext' => esc_html( get_theme_mod( 'ewd_kcae_setting_callout_subheading_text' ) ),
						),
						esc_html( get_theme_mod( 'ewd_kcae_setting_callout_heading_text' ) )
					);
				}
			}

} // if function does not exist sanitize false
else{
	get_template_part('inc/part', 'home_prem');
}			

get_footer();
