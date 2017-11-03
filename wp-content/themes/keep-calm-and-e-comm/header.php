<?php /* Header */
$installedOTP = function_exists('EWD_OTP_Default_Statuses');
$installedSlider = function_exists('EWD_US_Admin_Options');
$installedUPCP = function_exists('UPCP_Plugin_Menu');
$installedWC = function_exists('woocommerce_get_page_id');
$sliderEnable = get_theme_mod( 'ewd_kcae_setting_homepage_slider_enable', 'yes' );

if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
	$promoBar = get_theme_mod('ewd_kcae_prem_setting_promo_bar_enable', 'no');
	$promoBarText = get_theme_mod('ewd_kcae_prem_setting_promo_bar_text', '');
	$utilityNavEnable = get_theme_mod('ewd_kcae_prem_setting_utility_nav_enable', 'yes');
	$utilityNavPhone = get_theme_mod('ewd_kcae_prem_setting_utility_nav_phone', '');
	$utilityNavEmail = get_theme_mod('ewd_kcae_prem_setting_utility_nav_email', '');
	$utilityNavFacebook = get_theme_mod('ewd_kcae_prem_setting_utility_nav_facebook', '');
	$utilityNavTwitter = get_theme_mod('ewd_kcae_prem_setting_utility_nav_twitter', '');
	$utilityNavInstagram = get_theme_mod('ewd_kcae_prem_setting_utility_nav_instagram', '');
	$utilityNavYouTube = get_theme_mod('ewd_kcae_prem_setting_utility_nav_youtube', '');
	$utilityNavPinterest = get_theme_mod('ewd_kcae_prem_setting_utility_nav_pinterest', '');
}

if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
	$Track_Orders_Label = get_theme_mod( 'ewd_kcae_prem_setting_label_search', __( 'Track Order', 'keep-calm-and-e-comm' ) );
}
else{
	$Track_Orders_Label = __( 'Track Order', 'keep-calm-and-e-comm' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, user-scalable=false,">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="toTopButton"></div>

		<?php
		if( is_admin_bar_showing() ){
			$mobileMenuClass = ' class="headerAdminBarClear"';
		}
		else{
			$mobileMenuClass = '';
		}
		if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
			if( is_admin_bar_showing() && $utilityNavEnable == 'no' && $promoBar == 'no'){
				$mobileMenuClass = ' class="headerAdminBarClear"';
			}
			elseif( !is_admin_bar_showing() && $utilityNavEnable == 'yes' && $promoBar == 'no'){
				$mobileMenuClass = ' class="headerUtilityNavClear"';
			}
			elseif( is_admin_bar_showing() && $utilityNavEnable == 'yes' && $promoBar == 'no'){
				$mobileMenuClass = ' class="headerAdminBarAndUtilityNavClear"';
			}
			elseif( !is_admin_bar_showing() && $utilityNavEnable == 'no' && $promoBar == 'yes'){
				$mobileMenuClass = ' class="headerPromoBarClear"';
			}
			elseif( is_admin_bar_showing() && $utilityNavEnable == 'no' && $promoBar == 'yes'){
				$mobileMenuClass = ' class="headerAdminBarAndPromoBarClear"';
			}
			elseif( !is_admin_bar_showing() && $utilityNavEnable == 'yes' && $promoBar == 'yes'){
				$mobileMenuClass = ' class="headerUtilityNavAndPromoBarClear"';
			}
			elseif( is_admin_bar_showing() && $utilityNavEnable == 'yes' && $promoBar == 'yes'){
				$mobileMenuClass = ' class="headerAdminBarAndUtilityNavAndPromoBarClear"';
			}
			else{
				$mobileMenuClass = '';
			}
		}
		?>

		<nav id="mobileMenu"<?php echo $mobileMenuClass; ?>>
			<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
		</nav>

		<?php
		$utilityPromoClearClass = '';
		if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
			if($utilityNavEnable == 'yes' && $promoBar == 'no'){
				$utilityPromoClearClass = ' headerWithUtilityNav';
			}
			elseif($utilityNavEnable == 'no' && $promoBar == 'yes'){
				$utilityPromoClearClass = ' headerWithPromoBar';
			}
			elseif($utilityNavEnable == 'yes' && $promoBar == 'yes'){
				$utilityPromoClearClass = ' headerWithUtilityNavAndPromoBar';
			}
			else{
				$utilityPromoClearClass = '';
			}
		}
		?>

		<header id="header" class="<?php echo ( is_admin_bar_showing() ? 'headerAdminBarClear' : '' ); ?><?php echo ( ( $sliderEnable == "yes" && $installedSlider && is_page_template('template-home.php') ) ? ' menuOnSlider' : '' ); ?><?php echo $utilityPromoClearClass; ?>">
			<?php 
			if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
				get_template_part('inc/part', 'utility_promo');
			}
			?>
					<div class="wrapper">
						<div class="container">
							<?php
							if ( function_exists('the_custom_logo') ){
								$custom_logo_id = get_theme_mod( 'custom_logo' );
								$custom_logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
								$theLogoURL = $custom_logo_image[0];
							}
							else{
								$theLogoURL = get_header_image();
							}
							$alternateLogoURL = get_theme_mod( 'ewd_kcae_setting_alternate_logo' );
							if($theLogoURL != ''){
								if( $sliderEnable == "yes" && $installedSlider && is_page_template('template-home.php') && $alternateLogoURL != '' ){
									?>
									<a href="<?php echo esc_url( home_url('/') ); ?>"><img id="logo" src="<?php echo esc_url($alternateLogoURL); ?>"></a>
									<script>
										jQuery(document).ready(function($){
											if( $('#menuBars').css('display') != 'none' ){
												$('#logo').attr('src','<?php echo esc_url($theLogoURL); ?>');
											}
											var scrollDistanceTwo;
											$(window).scroll(function(){
												scrollDistanceTwo = $(window).scrollTop();
												if( scrollDistanceTwo > 48 ){
													$('#logo').attr('src','<?php echo esc_url($theLogoURL); ?>');
												}
												else{
													if( $('#menuBars').css('display') == 'none' ){
														$('#logo').attr('src','<?php echo esc_url($alternateLogoURL); ?>');
													}
												}
											});
										});
									</script>	
									<?php
								}
								else{
									?>
									<a href="<?php echo esc_url( home_url('/') ); ?>"><img id="logo" src="<?php echo esc_url($theLogoURL); ?>"></a>
									<?php
								}
							}
							else{
								$theSiteTitle = get_bloginfo('name');
								$theSiteTagline = get_bloginfo('description');
								?>
								<div id="logoTitleAndDescription">
									<div id="logoTitle">
										<a href="<?php echo esc_url( home_url('/') ); ?>"><?php echo esc_html($theSiteTitle); ?></a>
									</div>
									<div class="clear"></div>
									<div id="logoDescription">
										<?php echo esc_html($theSiteTagline); ?>
									</div>
								</div>
								<?php
							}


							//////////////////////
							//// START SEARCH ////
							//////////////////////

							$searchType = get_theme_mod( 'ewd_kcae_setting_header_search_type', 'otp' );
							if($searchType == 'otp' && $installedOTP){
								$Search_URL = get_theme_mod('ewd_kcae_setting_tracking_page_url_text');
							}
							elseif($searchType == 'woocommerce' && $installedWC){
								$Search_URL = get_permalink( woocommerce_get_page_id('shop') );
							}
							elseif($searchType == 'upcp' && $installedUPCP){
								$Search_URL = get_theme_mod('ewd_kcae_setting_catalogue_url_text');
							}
							else{
								$Search_URL = esc_url( home_url('/') );
							}

							if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
								get_template_part('inc/part', 'ajax_search');
								global $AJAX_Search_Class;
							}
							else {
								$AJAX_Search_Class = "";
							}
							
							if( ($searchType == 'woocommerce' && $installedWC) || ($searchType == 'upcp' && $installedUPCP) ){
								?>
								<form id="headerSearch" class="<?php echo $AJAX_Search_Class . ' ' . $searchType; ?>" method="post" action="<?php echo esc_url($Search_URL); ?>">
									<input type="text" name="prod_name" id="headerSearchCatalog" placeholder="<?php echo esc_attr($Track_Orders_Label); ?>">
								</form>
								<?php
							}
							elseif($searchType == 'otp' && $installedOTP){
								?>
								<form id="headerSearch" method="post" action="<?php echo esc_url($Search_URL); ?>">
									<input type="text" name="Tracking_Number" id="headerSearchCatalog" placeholder="<?php echo esc_attr($Track_Orders_Label); ?>">
								</form>
								<?php 
							}
							else{
								get_search_form();
							}

							//////////////////////
							///// END SEARCH /////
							//////////////////////
							?>
							<nav id="menu">
								<?php
								if( function_exists('ewd_kcae_prem_setting_sanitize_false') ){
									get_template_part('inc/part', 'logged_in_menu');
								}
								else{
									wp_nav_menu( array( 'theme_location' => 'main-menu' ) );									
								}
								?>
							</nav>
							<div id="menuBars"><i class="fa fa-bars"></i></div>
						</div> <!-- container -->
					</div> <!-- wrapper -->
			<?php if( function_exists('ewd_kcae_prem_setting_sanitize_false') ){ ?>
				</div> <!-- mainHeader -->
			<?php } ?>
		</header>

		<div class="clear"></div>
