<?php

// Добавляем поддержку WooCommerce
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'woocommerce_support' );

// Меняем символ рубля (так как он работает не корректно на некоторых системах)
function change_currency_symbol( $currency_symbol, $currency ) {
	$options = get_option( 'dp_options' );
	if( $currency == 'RUB' ){
		return !empty( $options['FontAwesome'] ) ? '<i class="fa fa-rub"></i>' : 'р.';
	}
	}
	add_filter('woocommerce_currency_symbol', 'change_currency_symbol', 10, 2);

// Определяем сетку вывода товара
function wp_woo_shop_columns( $columns ) {
	// На главной витрине
		// if(is_shop() && !is_search())
		// 	return 4;

	// если на странице есть категории
		// if(has_product_cat())
		// 	return 4;

	// В остальных случаях
	return 4;
	}
	add_filter( 'loop_shop_columns', 'wp_woo_shop_columns' );

// Количество товаров на странице
function customize_per_page($cols){
	if(wp_is_mobile())
		return 8;
	else
		return 16;
	}
	add_filter( 'loop_shop_per_page', 'customize_per_page', 20 );

// Вносим изменения в табы
function woo_change_tabs( $tabs ) {
	$tabs['description']['title'] = 'Описание товара';
	unset( $tabs['reviews'] );
	unset( $tabs['additional_information'] );

	return $tabs;
	}
	add_filter( 'woocommerce_product_tabs', 'woo_change_tabs', 98 );

// количество товаров в категории
function woo_remove_category_products_count() {
    return;
	}
	add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );

// отключаить wooCommerce стили
function dp_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Отключение общих стилей
	unset( $enqueue_styles['woocommerce-layout'] );		// Отключение стилей шаблонов
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Отключение оптимизации для маленьких экранов
	return $enqueue_styles;
	}
	add_filter( 'woocommerce_enqueue_styles', 'dp_dequeue_styles' );

/**
 * вернет объект таксономии если на странице есть категории товара
 * @param  string $taxonomy название таксаномии (Не уверен что логично изменять)
 * @return array | false 			ids дочерних категорий | не удалось получить
 */
function get_children_product_cat_ids($taxonomy = 'product_cat'){
	if(is_shop() && !is_search()){
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
    // Основная цена
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price = $prices[0] !== $prices[1] ? sprintf( __( 'от %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
    // Цена со скидкой
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'от %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );

    

    if ( $price !== $saleprice ) {
        $price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
    }

    return $price;
	}
	add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
	add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );

function change_label_post_object() {
	global $wp_post_types;
	$wp_post_types['product']->label = 'Каталог';
	$labels = &$wp_post_types['product']->labels;
	// $labels->name = 'Продукция';
	// $labels->singular_name = 'Товар';
	}

	add_action( 'init', 'change_label_post_object' );