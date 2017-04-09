<?php
if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly
?>
<form role="search" method="get" class="woocommerce-product-search" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<div class="input-group">
		<input type="search" value="<?php echo get_search_query() ?>" name="s" id="s" class="search-field form-control" autocomplete="off" placeholder="Найти" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
		
		<span class="input-group-btn">
			<button class="btn btn-default" id="searchsubmit" type="submit">
				<span class="dashicons dashicons-search"></span>
			</button>
		</span>
	</div>
	<input type="hidden" name="post_type" value="product" />
</form>