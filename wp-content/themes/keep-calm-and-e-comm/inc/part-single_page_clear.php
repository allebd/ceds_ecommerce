		<?php
		global $ewdKCAEsinglePageClear;
		$ewdKCAEsinglePageClear = '';
		if( function_exists( 'ewd_kcae_prem_setting_sanitize_false') ){
			$utilityNavEnable = get_theme_mod('ewd_kcae_prem_setting_utility_nav_enable', 'yes');
			$promoBar = get_theme_mod('ewd_kcae_prem_setting_promo_bar_enable', 'no');
			if($utilityNavEnable == 'yes' && $promoBar == 'no'){
				$ewdKCAEsinglePageClear = ' utilityNavClear';
			}
			elseif($utilityNavEnable == 'no' && $promoBar == 'yes'){
				$ewdKCAEsinglePageClear = ' promoBarClear';
			}
			elseif($utilityNavEnable == 'yes' && $promoBar == 'yes'){
				$ewdKCAEsinglePageClear = ' utilityNavAndPromoBarClear';
			}
			else{
				$ewdKCAEsinglePageClear = '';
			}
		}
