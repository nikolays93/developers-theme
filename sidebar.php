<?php
if (!is_active_sidebar('archive') &&
	!is_active_sidebar('woocommerce') )
{
	return;
}

?>

<?php
echo '<aside class="widget-area" role="complementary">';
if ( function_exists('is_woocommerce') && is_woocommerce() ){
	dynamic_sidebar( 'woocommerce' );
}
else {
	dynamic_sidebar( 'archive' );
}
echo '</aside>';