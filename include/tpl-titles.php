<?php
/**
 * Get HTML Title (Second Title if exists)
 */
function get_advanced_title( $post_id = null, $args = array() ){
  $singular = ( isset($args['force_single']) || is_singular() ) ? true : false;
  $defaults = array(
    'title_tag' => $singular ? 'h1' : 'h2',
    'title_class' => 'post-title',
    'clear' => false,
    );
  $tag = (isset($args['title_tag'])) ? $args['title_tag'] : $defaults['title_tag'];
  $args = array_merge($defaults, $args);

  if(is_404())
    return "<{$tag} class='{$args['title_class']} error_not_found'> Ошибка #404: страница не найдена. </{$tag}>";

  /**
   * Get Title
   */
  if(function_exists('get_second_title'))
    $title = get_second_title($post_id);

  if( empty($title) )
    $title = get_the_title($post_id);
  
  /**
   * Get Edit Post Icon
   */
  $edit_link = get_edit_post_link($post_id);
  $edit_attrs = ' class=\'dashicons dashicons-welcome-write-blog no-underline\'';
  $edit_tpl = " <object><a style='position: absolute;' href='{$edit_link}'{$edit_attrs}></a></object>";

  /**
   * Get Title Template
   */
  if( $title ){
    if($args['clear'])
      return $title . $edit_tpl;

    $link = ( $singular ) ? array('', '') : array('<a href="'.get_permalink( $post_id ).'">', '</a>');
    $result = $link[0]."<{$tag} class='{$args['title_class']}'>".$title.$edit_tpl."</{$tag}>".$link[1];

    return $result;
  }
  // Title Not Found
  return false;
}

function the_advanced_title( $before = '', $after = '', $post_id = null, $args = array() ){
  if( $title = get_advanced_title($post_id, $args) )
    echo $before . $title . $after;
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