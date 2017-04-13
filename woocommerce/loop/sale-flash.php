<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

?>
<?php if ( $product->is_on_sale() )
	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */