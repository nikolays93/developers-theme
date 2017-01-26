<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$primary_class = "col-12";
get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		do_action( 'woocommerce_before_main_content' );
		do_action('breadcrumbs_from_yoast');
	?>
	<div class="row">
		<?php
		if ( is_active_sidebar( 'woocommerce' ) ){
			$primary_class = "col-9";
			echo '<div id="secondary" class="col-3">';
			/**
			 * woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
			echo '</div>';
		}
		?>
		<div id="primary" class="<?=$primary_class; ?>">

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

			<?php if ( have_posts() ) : ?>
				<?php /*
				<div id="wc-before-loop-info" class="row">
					<div class="col-6 text-left"><?php woocommerce_result_count(); ?></div>
					<div class="col-6 text-right"><?php woocommerce_catalog_ordering(); ?></div>
				</div>
				// */ ?>
					<ul class="row products product-cats">
						<?php woocommerce_product_subcategories(); ?>
					</ul>
					<?php woocommerce_product_loop_start(); // has row ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; // end of the loop. ?>
					<?php woocommerce_product_loop_end(); ?>
					<?php the_template_pagination(); ?>
					
			<?php elseif ( ! woocommerce_product_subcategories(array(
				'before' => woocommerce_product_loop_start( false ),
				'after' => woocommerce_product_loop_end( false ) )
				) ) : ?>
				<?php wc_get_template( 'loop/no-products-found.php' ); ?>
			<?php endif; ?>
		</div><!-- #primary -->
	</div><!-- .row -->
	<section id="wc-description">
	<?php
		/**
		 * woocommerce_archive_description hook.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	?>
	</section>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>
