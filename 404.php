<?php
get_header();

$primary_class = "col-12";
?>
<div class="container">
	<?php do_action('breadcrumbs_from_yoast'); ?>
	<div class="row">
		<?php
		if ( is_active_sidebar( 'archive' ) ){
			$primary_class = "col-9";
			get_sidebar();
		}
		?>
		<div id="primary" class="<?php echo $primary_class; ?>">
			<main id="main" role="main">
				<article class="error-404 not-found">
					<header class="error-header entry-header">
						<?php the_advanced_title( '', '', null, true) ?>
					</header>
					<div class="error-content entry-content">
						<p>К сожалению эта страница не найдена или не доступна. Попробуйте зайти позднее или воспользуйтесь главным меню для перехода по основным страницам.</p>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->
			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .row -->
</div><!-- .container -->
<?php
get_footer();