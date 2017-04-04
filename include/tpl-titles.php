<?php
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