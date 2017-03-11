<?php
if ( ! defined( 'ABSPATH' ) )    exit; // Exit if accessed directly

// Добавляем поддержку WooCommerce
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
	}
add_action( 'after_setup_theme', 'woocommerce_support' );

// Меняем символ рубля (так как он работает не корректно на некоторых системах)
function change_currency_symbol( $currency_symbol, $currency ) {
	if( $currency == 'RUB' ){
		if( defined(DT_PLUGIN_NAME) && $opt = get_option( DT_PLUGIN_NAME ) ){
			if(! empty( $opt['FontAwesome'] ) )
				$currency_symbol = '<i class="fa fa-rub"></i>';
		}
		$currency_symbol = 'Р.';
	}
	return $currency_symbol;
	}
add_filter('woocommerce_currency_symbol', 'change_currency_symbol', 10, 2);

// Вносим изменения в табы
function woo_change_tabs( $tabs ) {
	if(isset($tabs['description']))
		$tabs['description']['title'] = 'Описание товара';

	if(isset($tabs['reviews']))
		unset( $tabs['reviews'] );

	if(isset($tabs['additional_information']))
		unset( $tabs['additional_information'] );

	return $tabs;
	}
add_filter( 'woocommerce_product_tabs', 'woo_change_tabs', 98 );

// Отключить WooCommerce стили
function dp_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Отключение общих стилей
	unset( $enqueue_styles['woocommerce-layout'] );		// Отключение стилей шаблонов
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Отключение оптимизации для маленьких экранов
	return $enqueue_styles;
	}
add_filter( 'woocommerce_enqueue_styles', 'dp_dequeue_styles' );

// Регистрируем боковую зону для витрин магазина
function init_woocommerce_sidebar(){
	register_sidebar( array(
		'name'          => 'Витрины магазина',
		'id'            => 'woocommerce',
		'description'   => 'Показываются на витринах магазина WooCommerce',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );
	}
add_action( 'widgets_init', 'init_woocommerce_sidebar' );

// Используем формат цены вариативного товара WC 2.0
function wc_wc20_variation_price_format( $price, $product ) {
    $prices = array(
    	$product->get_variation_price( 'min', true ),
    	$product->get_variation_price( 'max', true )
    	);
    
    $price = wc_price( $prices[0] );
    if($prices[0] !== $prices[1])
    	$price = 'от ' . $price;

    $prices = array(
    	$product->get_variation_regular_price( 'min', true ),
    	$product->get_variation_regular_price( 'max', true )
    	);
    $saleprice = wc_price( $prices[0] );
    if( $prices[0] !== $prices[1] )
    	$saleprice = 'от ' . $saleprice;

    if ( $price !== $saleprice ) {
        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }

    return $price;
	}
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );

/**
 * Вернет объект таксономии если на странице есть категории товара
 * @param  string $taxonomy название таксаномии (Не уверен что логично изменять)
 * @return array | false 			ids дочерних категорий | не удалось получить
 */
function get_children_product_cat_ids($taxonomy = 'product_cat'){
	if( is_shop() && !is_search() ){
		$results = get_terms( $taxonomy );
		if(!empty($results)){
			$result = array();
			foreach ($results as $term) {
				$result[] = $term->term_id;
			}
		}
	}
	else {
		$o = get_queried_object();
		$term_id = !empty($o->term_id) ? $o->term_id : 0;
		$result = get_term_children( $term_id, $taxonomy );
	}

	if(empty($result))
		return false; // Не удалось получить

	return $result;
}
function has_product_cat(){
	if(get_children_product_cat_ids())
		return true;

	return false;
}

/**
 * Add Customize
 */
// Определяем сетку вывода товара
function wp_woo_shop_columns( $columns, $is_tax=false ) {
	if( $is_tax && has_product_cat() ){
		$columns = (int)get_theme_mod( 'woo_product_cat_columns', 4 );
		return ( $columns < 1) ? 4 : $columns;
	}

	$columns = (int)get_theme_mod( 'woo_product_columns', 4 );
	return ( $columns < 1) ? 4 : $columns;
	}
add_filter( 'loop_shop_columns', 'wp_woo_shop_columns' );

// Количество товаров на странице
function customize_per_page($cols){
	if(wp_is_mobile())
		return get_theme_mod( 'woo_item_count_mobile', 8 );

	return get_theme_mod( 'woo_item_count', 16 );
	}
add_filter( 'loop_shop_per_page', 'customize_per_page', 20 );

// Не показывать количество товаров в категории
function woo_remove_category_products_count( $count_html ) {
	if( get_theme_mod( 'woo_show_tax_count', false ) )
		return $count_html;
	
    return false;
	}
add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );

// Заменить "Товары" на..
function change_product_labels() {
	global $wp_post_types;

	$label = $wp_post_types['product']->label = get_theme_mod( 'woo_product_label', 'Каталог' );
	$wp_post_types['product']->labels->name = $label;
	$wp_post_types['product']->labels->all_items = $label;
	$wp_post_types['product']->labels->archives = $label;
	$wp_post_types['product']->labels->menu_name = $label;
	}
add_action( 'init', 'change_product_labels' );

function change_wc_menu_labels() {
    global $menu;

    foreach ($menu as $key => $value) {
    	if($value[0] == 'WooCommerce')
    		$menu[$key][0] = 'Магазин';

    	if($value[0] == 'Товары')
    		$menu[$key][0] = get_theme_mod( 'woo_product_label', 'Каталог' );
    }
	}
add_action( 'admin_menu', 'change_wc_menu_labels' );

function print_wc_settings( $wp_customize ){
	$section = 'display_wc_options';
	$wp_customize->add_section(
		$section,
		array(
			'title'     => 'Настройки WooCommerce',
			'priority'  => 60,
			'description' => 'Настройки шаблона WooCommerce'
			)
		);

	$wp_customize->add_setting( 'woo_product_columns', array('default' => '4') );
	$wp_customize->add_control(
		'woo_product_columns',
		array(
			'section'     => $section,
			'label'       => '',
			'description' => 'Колличество товара в строке',
			'type'        => 'number',
			)
		);

    $wp_customize->add_setting( 'woo_product_cat_columns', array('default' => '4') );
    $wp_customize->add_control(
    	'woo_product_cat_columns',
    	array(
    		'section'     => $section,
    		'label'       => '',
    		'description' => 'Колличество категорий в строке',
    		'type'        => 'number',
    		)
    	);

    $wp_customize->add_setting( 'woo_item_count', array('default' => '16') );
    $wp_customize->add_control(
    	'woo_item_count',
    	array(
    		'section'     => $section,
    		'label'       => '',
    		'description' => 'Товаров на странице',
    		'type'        => 'number',
    		)
    	);

    $wp_customize->add_setting( 'woo_item_count_mobile', array('default' => '8') );
    $wp_customize->add_control(
    	'woo_item_count_mobile',
    	array(
    		'section'     => $section,
    		'label'       => '',
    		'description' => 'Товаров на странице (Для мал. экранов)',
    		'type'        => 'number',
    		)
    	);

    $wp_customize->add_setting( 'woo_product_label', array('default' => '') );
    $wp_customize->add_control(
    	'woo_product_label',
    	array(
    		'section'     => $section,
    		'label'       => '',
    		'description' => 'Заменить "Товары" на..',
    		'type'        => 'text',
    		)
    	);

    $wp_customize->add_setting( 'woo_show_tax_count', array('default' => '') );
    $wp_customize->add_control(
    	'woo_show_tax_count',
    	array(
    		'section'     => $section,
    		'label'       => 'Показывать колличество товара таксономии в скобках',
    		'description' => '',
    		'type'        => 'checkbox',
    		)
    	);
}
add_action( 'customize_register', 'print_wc_settings' );