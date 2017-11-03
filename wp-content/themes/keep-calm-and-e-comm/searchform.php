<?php
$Search_URL = esc_url( home_url('/') );
$Track_Orders_Label = __('Search', 'keep-calm-and-e-comm');
?>
<form id="headerSearch" role="search" method="get" action="<?php echo esc_url($Search_URL); ?>">
	<input type="text" name="s" id="headerSearchCatalog" placeholder="<?php echo esc_attr($Track_Orders_Label); ?>">
</form>
