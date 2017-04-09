<?php
if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() )
	return;

$columns = wp_woo_shop_columns(null);
$non_responsive = get_theme_mod( 'site-format' );
$non_responsive = ($non_responsive == 'adaptive') ? false : true;
$post_classes = get_default_bs_columns($columns, $non_responsive);

$content_link = apply_filters( 'add_content_link', false );
?>
<li <?php post_class($post_classes); ?>>
	<div class="card">
		<?php
		// <A>
		do_action( 'woocommerce_before_shop_loop_item' );
		?>
		<div class="product-thumbnail">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		</div>
		<?php woocommerce_template_loop_product_link_close(); ?>
		<div class="card-block card-content">
			<?php
			if( $content_link )
				woocommerce_template_loop_product_link_open();
			/**
			 * woocommerce_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item hook.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			if( ! $content_link )
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div><!-- .card-block -->
	</div><!-- .card -->
</li>