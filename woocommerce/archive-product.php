<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$primary_class = "col-12";
get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @unhooked woocommerce_breadcrumb - 20 in /include/functions-woocommerce.php
		 * @hooked breadcrumbs_from_yoast - 25 in /include/functions-woocommerce.php
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
	<div class="row">
		<?php
		if ( is_active_sidebar( 'woocommerce' ) ){
			$primary_class = "col-9";
			echo '<div id="secondary" class="col-3">';
			do_action( 'woocommerce_sidebar' );
			echo '</div>';
		}
		?>
		<div id="archive-primary" class="<?=$primary_class; ?>">
			<main id="main" class="woocommerce main content" role="main">
				<?php if ( apply_filters( 'woocommerce_show_page_title', false ) ) : ?>
					<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
				<?php elseif ( apply_filters( 'woocommerce_show_archive_title', true ) ) :?>
					<?php the_advanced_archive_title(); ?>
				<?php endif; ?>
				
				<?php if ( have_posts() ) : ?>
					<?php
						/**
						 * woocommerce_before_shop_loop hook.
						 *
						 * @unhooked woocommerce_result_count - 20 in include/functions-woocommerce.php
						 * @unhooked woocommerce_catalog_ordering - 30 in include/functions-woocommerce.php
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>
					<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								/**
								 * woocommerce_shop_loop hook.
								 *
								 * @hooked WC_Structured_Data::generate_product_data() - 10
								 */
								do_action( 'woocommerce_shop_loop' );
							?>

							<?php wc_get_template_part( 'content', 'product' ); ?>

						<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
						/**
						 * woocommerce_after_shop_loop hook.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php
						/**
						 * woocommerce_no_products_found hook.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					?>

				<?php endif; ?>
			</main>
			<section class="woocommerce_archive_description">
				<?php do_action( 'woocommerce_archive_description' ); ?>
			</section>
		</div>
	</div>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>
