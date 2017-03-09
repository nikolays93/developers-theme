<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$columns = wp_woo_shop_columns(null, true);
$non_responsive = get_theme_mod( 'site-format' );
$non_responsive = ($non_responsive == 'adaptive') ? false : true;

$post_classes = get_default_bs_columns($columns, $non_responsive);

$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true ); 
$thumbnail_url = ($thumbnail_id != 0) ?
	wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/img/placeholder.png';
?>
<li <?php wc_product_cat_class( $post_classes, $category ); ?>>
	<div class="card">
		<?php woocommerce_template_loop_category_link_open($category); ?>
			<div class="cat-thumbnail" style="background-image: url(<?=$thumbnail_url?>);"></div>
			<div class="card-block">
				<?php
				do_action( 'woocommerce_shop_loop_subcategory_title', $category );
				// empty hook
				do_action( 'woocommerce_after_subcategory_title', $category );
				?>
			</div><!-- .card-block -->
		<?php woocommerce_template_loop_category_link_close($category); ?>
	</div><!-- .card -->
</li>
