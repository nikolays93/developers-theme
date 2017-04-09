<?php
if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

global $post, $product;

if ( $product->is_on_sale() )
	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );