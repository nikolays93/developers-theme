<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( apply_filters( 'woocommerce_show_no_products_found', false ) ){
	?>
	<article class="no-results woocommerce-not-found">
		<h1 class="post-title">Ничего не найдено</h1>
		<div class="no-results-content error-content content-body">
			<p class="woocommerce-info"><?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
		</div><!-- .entry-content -->
	</article>
<?php
}