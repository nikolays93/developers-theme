<?php
/**
 * Информация о компании (из customizer'а)
 * Yoast крошки
 * Получить заголовок записи
 * Получить заголовок архива
 * Принятые настройки постраничной навигации
 * Получить стандартные классы ячейки bootstrap сетки
 * Получить ID самой родительской страницы
 * Добавить шорткод [CODE]
 * Отчистить мета теги
 * Исключить аттрибуты width и height из тега img
 * Шаблон вывода главного меню
 * Добавить ссылку о разработчике в топбар
 * Сменить строку "Спасибо за творчество с Wordpress"
 */

if(WP_DEBUG){
  if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
  }

  function _dump($var){
    echo '<style>
    #dump {
    background: #ccc;
    width: 100%;
    height: 200px;
    overflow: auto;
    padding: 10px;
  }
  #dump:hover {
    height: 500px;
  }
  </style>
  <pre id="dump">';

  if(empty($var))
    print_r('var is empty');
  
    $start = microtime(true);
    print_r($var);
    echo '<hr> Время выполнения: '.number_format((microtime(true) - $start), 6).' сек. - print_r';
    echo '</pre>';
  }
} else {
  function _dump(){
    return false;
  }
}

/**
 * Информация о компании (из customizer'а)
 */
function get_company_info($field){
  $info = get_theme_mod( 'company_'.$field );
  $filter_info = get_theme_mod( 'filter_company_'.$field );
  
  if(!$filter_info){
    $info = apply_filters( 'the_content', $info);
  }
  return $info;
}

function get_logotype($img_only = false){
  if(!$img_only)
    $logotype = '<h1>'.get_bloginfo('name').'</h1>';
  else
    $logotype = false;

  $urls = array(
    'png' => dirname(__FILE__) . '/../img/logotype.png',
    'jpg' => dirname(__FILE__) . '/../img/logotype.jpg'
    );
  foreach ($urls as $type => $url) {
    if(is_file($url) && is_readable($url)){
      $logotype= '<img src="'.get_template_directory_uri().'/img/logotype.'.$type.'" alt="'.get_bloginfo('name').'" />';
    }
  }
  return $logotype;
}

function the_logotype($link = false){
  $logotype = get_logotype();
  if($link)
    $out= '<a class="image-brand" title="'.get_bloginfo('description').'" href="'.get_home_url().'">'.
    $logotype.
    '</a>';
  else
    $out=$logotype;

  echo $out;
}

add_action('main_menu_template', function(){
  $sf = get_theme_mod( 'site-format' );
  if($sf == 'adaptive'){ ?>
    <a class="navbar-brand hidden-md-up text-primary" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php wp_bootstrap_main_nav(); ?>
    </div><!-- #navbarResponsive -->
  <?php
  }
  else { ?>
    <?php wp_bootstrap_main_nav(); ?>
    <?php
  }
});

/**
 * yoast крошки (Для активации установить/активировать плагин, 
 * дополнительно => breadcrumbs => enable)
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
      return  '<h1>'. $title . $edit_tpl .'</h1>';
    }
    else {
      return '<a href="'. get_permalink() .'"><h2>'.$title.$edit_tpl.'</h2></a>';
    }
  }
  // Если все же не удалось получить title
  return false;
}
function the_advanced_title(
  $before = '<header class="entry-header">',
  $after = '</header><!-- .entry-header -->',
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
  $before='<header class="archive-header">',
  $after='</header>') {

  $title = get_template_archive_title();
  if(!empty($title)){
    echo $before .'<h1>'. $title .'</h1>'. $after;
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
 * Получить стандартные классы ячейки bootstrap сетки
 */
function get_default_bs_columns($columns_count="4", $non_responsive=false){
  switch ($columns_count) {
    case '1': $col = 'col-12'; break;
    case '2': $col = (!$non_responsive) ? 'col-6 col-sm-6 col-md-6 col-lg-6' : 'col-6'; break;
    case '3': $col = (!$non_responsive) ? 'col-12 col-sm-6 col-md-4 col-lg-4' : 'col-4'; break;
    case '4': $col = (!$non_responsive) ? 'col-6 col-sm-4 col-md-3 col-lg-3' : 'col-3'; break;
    case '5': $col = (!$non_responsive) ? 'col-12 col-sm-6 col-md-2-4 col-lg-2-4' : 'col-2-4'; break; // be careful
    case '6': $col = (!$non_responsive) ? 'col-6 col-sm-4 col-md-2 col-lg-2' : 'col-2'; break;
    case '12': $col= (!$non_responsive) ? 'col-4 col-sm-3 col-md-1 col-lg-1' : 'col-1'; break;
    
    default: $col = false; break;
  }
  return $col;
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
 * Исключить аттрибуты width и height из тега img при выводе thumbnail'а
 */
function wp_bootstrap_remove_thumbnail_dimensions( $html ) {
  $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
  return $html;
  }
  add_filter( 'post_thumbnail_html', 'wp_bootstrap_remove_thumbnail_dimensions', 10 );
  add_filter( 'image_send_to_editor', 'wp_bootstrap_remove_thumbnail_dimensions', 10 );

/**
 * Добавить все главным меню элементам li.nav-item и li.nav-item.active активному элементу
 */
function wp_add_bootstrap_class($classes, $item) {
  if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) )
    $classes[] = "active";

  if($item->menu_item_parent == 0)
    $classes[] = "nav-item";

  return $classes;
  }
  add_filter('nav_menu_css_class', 'wp_add_bootstrap_class', 10, 2 );

/**
 * Шаблон вывода главного меню
 */
class Bootstrap_walker extends Walker_Nav_Menu{

  function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0){
  if( is_object($args) ):
   global $wp_query;
   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
  
   $class_names = $value = '';
  
    // If the item has children, add the dropdown class for bootstrap
    
    
    if ( $args->has_children ) {
      $class_names = "dropdown ";
    }
  
    $classes = empty( $object->classes ) ? array() : (array) $object->classes;
    
    $class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
    $class_names = ' class="'. esc_attr( $class_names ) . '"';
       
    $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';

    $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
    $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
    $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
    $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

    // if the item has children add these two attributes to the anchor tag
    if ( $args->has_children ) {
      if($depth == 0){
        if(empty($args->allow_click))
          $attributes .= ' class="nav-link dropdown-toggle" data-toggle="dropdown"';
        else
          $attributes .= ' class="nav-link dropdown-toggle"';
      } else {
        $attributes .= ' class="dropdown-item"';
      }
    // not has children
    } else {
      if($depth == 0)
        $attributes .= ' class="nav-link"';
      else
        $attributes .= ' class="dropdown-item"';
    }

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before .apply_filters( 'the_title', $object->title, $object->ID );
    $item_output .= $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
  endif; // is_object
  } // end start_el function
        
  function start_lvl(&$output, $depth = 0, $args = Array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }
      
  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
    $id_field = $this->db_fields['id'];
    if ( is_object( $args[0] ) ) {
        $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    }
    return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }        
}

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

if(is_admin()){
  /**
   * Сменить строку "Спасибо за творчество с Wordpress"
   */
  function custom_admin_footer() {
    echo '<span id="footer-thankyou">Разработано компанией <a href="http://seo18.ru" target="_blank">seo18.ru - создание и продвижение сайтов</a></span>.
    <small> Использована система <a href="wordpress.com">WordPress</a>. </small>';
    }
    add_filter('admin_footer_text', 'custom_admin_footer');
}


/*
 * in future
 * 
 ****************************************
 // ИзСменить […] на Подробнее &raquo;
function seo18_excerpt_more( $more ) {
  global $post;
  return '...  <a href="'. get_permalink($post->ID) . '" class="more-link" title="Читать '.get_the_title($post->ID).'">Подробнее &raquo;</a>';
}
add_filter('excerpt_more', 'seo18_excerpt_more');

// Prints HTML with meta information for the categories, tags and comments.
function entry_footer() {
  // Hide category and tag text for pages.
  if ( 'post' === get_post_type() ) {
    /* translators: used between list items, there is a space after the comma 
    $categories_list = get_the_category_list( esc_html__( ', ', 'seo18theme' ) );
    if ( $categories_list ) {
      printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'seo18theme' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }

    /* translators: used between list items, there is a space after the comma 
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'seo18theme' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'seo18theme' ) . '</span>', $tags_list ); // WPCS: XSS OK.
    }
  }
}
*/