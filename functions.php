<?php
/*
 * Debug функции
 * Добавление поддержки функций
 * Добавление областей 'primary', 'footer'
 * Регистрация Сайдбара: Архивы и записи
 * Загрузка фалов дополнительных функций
 * Фильтры шаблона
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
if(!function_exists('_debug')){
  if( is_wp_debug() || current_user_can( 'activate_plugins' ) ){
    function _debug( &$var, $var_dump = false ){
      echo "<pre>";
      if($var_dump)
        print_r( $var );
      else
        var_dump( $var );
      echo "</pre>";
    }
  } else {
    function _debug( &$var, $var_dump = false ){
      return false;
    }
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
 * Include required files
 */
$tpl_uri = get_template_directory();

require_once $tpl_uri . '/include/customizer.php';
require_once $tpl_uri . '/include/functions-custom.php';

require_once $tpl_uri . '/include/tpl.php';
require_once $tpl_uri . '/include/tpl-load-assets.php'; // * Подключение стандартных скриптов / стилей
require_once $tpl_uri . '/include/tpl-titles.php';    // * Шаблоны заголовков
require_once $tpl_uri . '/include/tpl-bootstrap.php';   // * Вспомагателные bootstrap функции
require_once $tpl_uri . '/include/tpl-gallery.php';   // * Шаблон встроенной галереи wordpress
require_once $tpl_uri . '/include/tpl-navigation.php';  // * Шаблон навигации

if(function_exists('is_woocommerce'))
  require_once $tpl_uri . '/include/functions-woocommerce.php';

/**
 * template filters
 */
// example :
// add_filter( 'archive_reviews_title', function($t){ return 'Отзывы наших покупателей'; } );
