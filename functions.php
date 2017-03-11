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
	// wp_deregister_script( 'jquery' );
  	// wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js');
	wp_enqueue_script('jquery');

    // wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0', 'all' );
	wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js', array('jquery'), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'add_theme_assets', 999 );

require_once get_template_directory() . '/include/functions-template.php';
require_once get_template_directory() . '/include/functions-bootstrap.php';
require_once get_template_directory() . '/include/customizer.php';
require_once get_template_directory() . '/include/functions-custom.php';
if(function_exists('is_woocommerce'))
	require_once get_template_directory() . '/include/functions-woocommerce.php';