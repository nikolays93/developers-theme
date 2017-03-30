<?php
/**
 * Информация о компании (из customizer'а)
 * Yoast крошки
 * Получить заголовок записи
 * Получить заголовок архива
 * Принятые настройки постраничной навигации
 * Получить ID самой родительской страницы
 * Отчистить мета теги
 * Добавить ссылку о разработчике в топбар
 * Сменить строку "Спасибо за творчество с Wordpress"
 */
if ( ! defined( 'ABSPATH' ) )    exit; // Exit if accessed directly

if(is_wp_debug() || current_user_can( 'edit_theme_options' ) ){
  function _dump(&$var){

  if( empty($var) )
    print_r('var is empty');
    
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }
} else {
  function _dump(){
    return false;
  }
}
function _d(&$var){ _dump($var); }

add_filter( 'set_custom_brand', 'add_custom_brand', 10, 3 );
function add_custom_brand($brand, $brand_class, $brand_title){
  $brand = '<a class="'.$brand_class.'" title="'.$brand_title.'" href="'.get_home_url().'">'.$brand.'</a>';
  return $brand;
}

function default_theme_nav(
  $args = array( 'container_class' => 'container' ),
  $container = array( '<nav class="navbar navbar-default non-responsive">', '</nav>' ),
  $toggler = '' ){
  
  if( get_theme_mod( 'responsive' ) ){
    $container = array( '<nav class="navbar navbar-default navbar-toggleable-md navbar-light">', '</nav>' );
    $args['container_class'] .= ' collapse navbar-collapse navbar-responsive-collapse';
    $args['container_id'] = 'default-collapse';
    $toggler = '
    <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#default-collapse" aria-controls="default-collapse" aria-expanded="false">
      <span class="navbar-toggler-icon"></span>
    </button>';
  }

  $brand = apply_filters( 'set_custom_brand', get_bloginfo("name"), 'navbar-brand hidden-lg-up text-center text-primary', get_bloginfo("description") );

  echo $container[0];
  echo $toggler;
  echo $brand;
  echo wp_bootstrap_nav( $args );
  echo $container[1];
}

function wp_bootstrap_nav( $args = array() ) {
  $defaults = array(
    'menu' => 'main_nav',
    'menu_class' => 'nav navbar-nav',
    'theme_location' => 'primary',
    'walker' => new Bootstrap_walker(),
    'allow_click' => get_theme_mod( 'allow_click', false )
    );

  $args = array_merge($defaults, $args);
  wp_nav_menu( $args );
}

function wp_footer_links() {
  wp_nav_menu(
    array(
      'menu' => 'footer_links', /* menu name */
      'theme_location' => 'footer', /* where in the theme it's assigned */
      'container_class' => 'footer clearfix', /* container class */
    )
  );
}

/**
 * yoast крошки ( Для активации установить/активировать плагин, дополнительно => breadcrumbs => enable )
 */
add_action('breadcrumbs_from_yoast', function(){
  if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
  }
});

/**
 * Получить заголовок записи (Если установлен плагин developer_page получить дополнительное имя)
 */
function get_advanced_title(
  $post_id = null, // ID поста заголовок которого нужно вывести
  $clear = false, // Возвращает заголовок без <h> тега
  $force_single = false // возвращает как single заголовок принудительно
  ){
  if(is_404())
    return '<h1 class="error_not_found">Ошибка #404: страница не найдена.</h1>';

  if(function_exists('get_second_title'))
    $title = get_second_title($post_id);

  if(empty($title))
    $title = get_the_title($post_id);

  $edit_link = get_edit_post_link($post_id);
  $edit_class = 'dashicons dashicons-welcome-write-blog no-underline';
  $edit_tpl = ' <object><a style="position: absolute;" class="'.$edit_class.'" href="' . $edit_link . '"></a></object>';

  if(!empty($title)){
    if($clear)
      return $title . $edit_tpl;

    if( $force_single || is_singular() ){
      return  '<h1 class="post-title">'. $title . $edit_tpl .'</h1>';
    }
    else {
      return '<a href="'. get_permalink() .'"><h2 class="post-title">'.$title.$edit_tpl.'</h2></a>';
    }
  }
  // Если все же не удалось получить title
  return false;
}
function the_advanced_title(
  $before = '',
  $after = '',
  $post_id = null,
  $clear = false,
  $force_single = false
  ){
  echo $before . get_advanced_title($post_id, $clear, $force_single) . $after;
  return;
}

/**
 * Получить заголовок архива (отличие от стандартной функции:
 * не выводит "Категория:" или "Архивы:" )
 */
function get_template_archive_title() {
  if ( is_category() ) {
    $title = single_cat_title( '', false );
  } elseif ( is_tag() ) {
    $title = single_tag_title( '', false );
  } elseif ( is_author() ) {
    $title = sprintf( __( 'Автор: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
  } elseif ( is_year() ) {
    $title = sprintf( __( 'Записи за %s год' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
  } elseif ( is_month() ) {
    $title = sprintf( __( 'Записи за %s месяц' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
  } elseif ( is_day() ) {
    $title = sprintf( __( 'Записи за %s день' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
  } elseif ( is_tax( 'post_format' ) ) {
    if ( is_tax( 'post_format', 'post-format-aside' ) ) {
      $title = _x( 'Asides', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
      $title = _x( 'Galleries', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
      $title = _x( 'Images', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
      $title = _x( 'Videos', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
      $title = _x( 'Quotes', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
      $title = _x( 'Links', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
      $title = _x( 'Statuses', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
      $title = _x( 'Audio', 'post format archive title' );
    } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
      $title = _x( 'Chats', 'post format archive title' );
    }
  } elseif ( is_post_type_archive() ) {
    $title = post_type_archive_title( '', false );
  } elseif ( is_tax() ) {
    // $tax = get_taxonomy( get_queried_object()->taxonomy );
    /* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
    // $title = sprintf( __( '%1$s: %2$s' ), $tax->labels->singular_name, single_term_title( '', false ) );
    $title = single_term_title( '', false );
  } else {
    $title = __( 'Archives' );
  }

  return $title;
}
function the_template_archive_title(
  $before='',
  $after='') {

  $title = get_template_archive_title();
  if(!empty($title)){
    echo $before .'<h1 class="archive-title">'. $title .'</h1>'. $after;
    return true;
  }
  return false;
}
function has_children_terms($hide_empty=true){
  $o = get_queried_object();
  if(!empty($o->has_archive) && $o->has_archive==true){
    $tax = $o->taxonomies[0];
    $parent = 0;
  }

  if( !empty($o->term_id) ){
    $tax = $o->taxonomy;
    $parent = $o->term_id;
  }

  $children = get_terms( array(
    'taxanomy'  => $tax,
    'parent'    => $parent,
    'hide_empty' => $hide_empty
    ) );

  if($children) {
    return true;
  }
  return false;
}

/**
 * Принятые настройки постраничной навигации
 */
function the_template_pagination($echo=true){
  $args = array(
    'show_all'     => false,
    'end_size'     => 1,    
    'mid_size'     => 1,     
    'prev_next'    => true,  
    'prev_text'    => '« Пред.',
    'next_text'    => 'След. »',
    'add_args'     => false,
    );

  if($echo){
    the_posts_pagination($args);
    return true;
  }
  else {
    return get_the_posts_pagination($args);
  }    
}

/**
 * Получить ID самой родительской страницы (после "главной")
 */
function get_parent_page_id($post) {
  if ($post->post_parent)  {
    $ancestors=get_post_ancestors($post->ID);
    $root=count($ancestors)-1;
    $parent = $ancestors[$root];
  } else {
    $parent = $post->ID;
  }
  return $parent;
}

/**
 * Отчистить мета теги
 */
function seo18_head_cleanup() {
  remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
  remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
  remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
  remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
  remove_action( 'wp_head', 'index_rel_link' );                         // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
  remove_action( 'wp_head', 'wp_generator' );                           // WP version
  }
  add_action( 'init', 'seo18_head_cleanup' );

/**
 * Добавить ссылку о разработчике в топбар
 */
function customize_toolbar_link($wp_admin_bar) {
  $wp_admin_bar->add_node(array(
    'id' => 'seo',
    'title' => 'Seo18.ru',
    'href' => 'http://seo18.ru',
    'meta' => array(
      'title' => 'Перейти на сайт разработчика'
      )
    ));
  }
  add_action('admin_bar_menu', 'customize_toolbar_link', 999);

/**
 * Сменить строку "Спасибо за творчество с Wordpress"
 */
function custom_admin_footer() {
  echo '<span id="footer-thankyou">Разработано компанией <a href="http://seo18.ru" target="_blank">seo18.ru - создание и продвижение сайтов</a></span>.
  <small> Использована система <a href="wordpress.com">WordPress</a>. </small>';
  }
  add_filter('admin_footer_text', 'custom_admin_footer');
