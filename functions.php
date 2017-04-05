<?php
/*
 * Добавление поддержки функций
 * Добавление областей 'primary', 'footer'
 * Регистрация Сайдбара: Архивы и записи
 * Подключение стандартных скриптов / стилей
 * Загрузка фалов дополнительных функций
 */
if(!function_exists('is_wp_debug')){
  function is_wp_debug(){
    if( WP_DEBUG ){
      if( defined(WP_DEBUG_DISPLAY) && ! WP_DEBUG_DISPLAY){
        return false;
      }
      return true;
    }
    return false;
  }
}

function theme_setup() {
	// load_theme_textdomain( 'seo18theme', get_template_directory() . '/assets/languages' );

	add_theme_support( 'custom-logo' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	register_nav_menus( array(
		'primary' => 'Главное меню', 
		'footer' => 'Меню в подвале',
	) );
}
add_action( 'after_setup_theme', 'theme_setup' );

function archive_widgets_init(){
	register_sidebar( array(
		'name'          => 'Архивы и записи',
		'id'            => 'archive',
		'description'   => 'Эти виджеты показываются в архивах и остальных страницах', 
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );
}
add_action( 'widgets_init', 'archive_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function add_theme_assets() {
	$tpl_uri = get_template_directory_uri();
	$suffix = (!is_wp_debug()) ? '.min' : ''; 
	// wp_deregister_script( 'jquery' );
  	// wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js');
	wp_enqueue_script('jquery');

	if ( get_theme_mod( 'use_bootstrap' ) ){
		wp_enqueue_style('bootstrap4',  $tpl_uri . '/assets/bootstrap.css', array(), '4.0alpha6');
	}

	if ( get_theme_mod( 'use_bootstrap_js' ) ){
		wp_enqueue_script('Tether', 'https://www.atlasestateagents.co.uk/javascript/tether.min.js', array(), null, true);
		wp_enqueue_script('bootstrap4-script', $tpl_uri . '/assets/js/bootstrap'.$suffix.'.js', array('jquery'), '4.0alpha6', true);
	}

    // wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0', 'all' );
	wp_enqueue_script('common-js', $tpl_uri . '/assets/js/common.js', array('jquery'), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'add_theme_assets', 999 );

/**
 * Include required files
 */
$tpl_uri = get_template_directory();
require_once $tpl_uri . '/include/customizer.php';
require_once $tpl_uri . '/include/functions-custom.php';

require_once $tpl_uri . '/include/tpl.php';
require_once $tpl_uri . '/include/tpl-titles.php';
require_once $tpl_uri . '/include/tpl-bootstrap.php';
require_once $tpl_uri . '/include/tpl-gallery.php';
require_once $tpl_uri . '/include/tpl-navigation.php';

if(function_exists('is_woocommerce'))
	require_once $tpl_uri . '/include/functions-woocommerce.php';