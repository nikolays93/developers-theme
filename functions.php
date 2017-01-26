<?php
/*
 * Добавление поддержки функций
 * Добавление областей 'primary', 'footer'
 * функция вывода главного меню
 * функция вывода меню подвала
 * Регистрация Сайдбаров: Главная страница, Архивы и записи, Страницы
 * Подключение стандартных скриптов / стилей
 * Загрузка фалов дополнительных функций
 */
function seo18_setup() {
	// load_theme_textdomain( 'seo18theme', get_template_directory() . '/assets/languages' );

	add_theme_support( 'automatic-feed-links' );
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

	function wp_bootstrap_main_nav() {
		$class = get_theme_mod( 'site-format' );
		$class = ($class == 'adaptive') ? ' class="collapse navbar-collapse navbar-responsive-collapse"' : false;

		wp_nav_menu( 
			array( 
				'menu' => 'main_nav', /* menu name */
				'menu_class' => 'nav navbar-nav',
				'allow_click' => get_theme_mod( 'allow_click', false ),
				'theme_location' => 'primary', /* where in the theme it's assigned */
				'container' => $class,
				'walker' => new Bootstrap_walker()
				)
			);
	}

	function wp_bootstrap_footer_links() {
	  wp_nav_menu(
	    array(
	      'menu' => 'footer_links', /* menu name */
	      'theme_location' => 'footer', /* where in the theme it's assigned */
	      'container_class' => 'footer clearfix', /* container class */
	    )
	  );
	}
}
add_action( 'after_setup_theme', 'seo18_setup' );

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
function seo18theme_addComponents() {
	$scss_cache = get_theme_mod( 'use_scss' );

	if(empty($scss_cache)){
		wp_enqueue_style( 'common-style', get_stylesheet_uri(), array(), '1.0', 'all' );
	}
	else {
		$out_file = '/assets/style.css';
		$role = isset(wp_get_current_user()->roles[0]) ? wp_get_current_user()->roles[0] : '';
		if($role == 'administrator'){
			$file = get_template_directory() . '/style.css';

			if (file_exists( $file ) && filemtime($file) !== $scss_cache){
				include_once get_template_directory() . "/include/scss.inc.php";

				$scss = new scssc();
				$scss->setImportPaths(function($path) {
					if (!file_exists(get_template_directory() . '/assets/scss/'.$path)) return null;
					return get_template_directory() . '/assets/scss/'.$path;
				});

				if(!WP_DEBUG)
					$scss->setFormatter('scss_formatter_compressed');
				
				$compiled = $scss->compile( file_get_contents($file) );
				if(!empty($compiled)){
					file_put_contents(get_template_directory().$out_file, $compiled );
					set_theme_mod( 'use_scss', filemtime($file) );
				}
			}
		} // is user admin
		wp_enqueue_style('scss-style', get_template_directory_uri() . $out_file, array(), '1.0', 'all');
	} // is use scss

	

    // get jQuery
    wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js');
    wp_enqueue_script('jquery');
    
    // get bootstrap
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/bootstrap.css',array(),'a6nikolays93');
    // wp_enqueue_script('Tether', 'https://www.atlasestateagents.co.uk/javascript/tether.min.js');
    // wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.min.js');

    // get scripts
    
	wp_enqueue_script('common-js', get_template_directory_uri() . '/assets/js/common.js');
}
add_action( 'wp_enqueue_scripts', 'seo18theme_addComponents' );

require_once get_template_directory() . '/include/functions-template.php';
require_once get_template_directory() . '/include/customizer.php';
require_once get_template_directory() . '/include/functions-custom.php';

if(function_exists('is_woocommerce')){
	require_once get_template_directory() . '/include/functions-woocommerce.php';
}