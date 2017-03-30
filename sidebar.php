<?php
if (!is_active_sidebar('archive') && !is_active_sidebar('woocommerce') )
	return;

add_action( 'before_sidebar', 'aside_start', 10 );
add_action( 'after_sidebar',  'aside_end', 10 );

function aside_start(){
	echo '<aside class="widget-area" role="complementary">';
	echo '<div id="secondary" class="col-3">';
}
function aside_end(){
	echo '</div>';
	echo '</aside>';
}

do_action('before_sidebar');

if ( function_exists('is_woocommerce') && is_woocommerce() ){
	dynamic_sidebar( 'woocommerce' );
}
else {
	dynamic_sidebar( 'archive' );
}

do_action('after_sidebar');