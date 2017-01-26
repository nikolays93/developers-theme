<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() )	return;
$columns = wp_woo_shop_columns(null);
$non_responsive = get_theme_mod( 'site-format' );
$non_responsive = ($non_responsive == 'adaptive') ? false : true;

$post_classes = get_default_bs_columns($columns, $non_responsive);

$thumbnail_url = (get_the_post_thumbnail_url( $product->id, 'shop_catalog' )) ?
			get_the_post_thumbnail_url( $product->id, 'shop_catalog' ) :
			get_template_directory_uri() . '/img/placeholder.png';
?>
<li <?php post_class($post_classes); ?>>
	<div class="card">
		<?php
		// link_open
		do_action( 'woocommerce_before_shop_loop_item' );
		?>
		<div class="product-thumbnail" style="background-image: url(<?=$thumbnail_url?>);">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		</div>
		<?php woocommerce_template_loop_product_link_close(); ?>
		<div class="card-block">
			<?php
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
			the_excerpt();
			do_action( 'woocommerce_after_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item hook.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div><!-- .card-block -->
	</div><!-- .card -->
</li>
