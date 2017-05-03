<?php
/**
 * Enqueue scripts and styles.
 */
function add_theme_assets() {
	$tpl_uri = get_template_directory_uri();
	$suffix = (!is_wp_debug()) ? '.min' : ''; 
	// wp_deregister_script( 'jquery' );
  	// wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js');
	wp_enqueue_script('jquery');

	wp_enqueue_script('script', $tpl_uri . '/assets/script.js', array('jquery'), '1.0', true);
	wp_enqueue_script('data-actions', $tpl_uri . '/assets/jquery.data-actions/jquery.data-actions'.$suffix.'.js', array('jquery'), '1.0', true);

	$style_cache = get_option('scss_cache');
	$style_ver = $style_cache ? $style_cache : '1.0';

	$styles = array('/style'.$suffix.'.css', '/style.css');
	foreach ($styles as $style) {
		if( is_readable(get_template_directory() . $style) ){
			wp_enqueue_style( 'style', get_template_directory_uri() . $style, array(), $style_ver, 'all' );
			break;
		}
	}
}
add_action( 'wp_enqueue_scripts', 'add_theme_assets', 999 );
