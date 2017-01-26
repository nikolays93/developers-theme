<?php
get_header();

$primary_class = "col-12";
$type = $affix = get_post_type();
?>
<div class="container">
	<?php if ( !is_front_page() ) do_action('breadcrumbs_from_yoast'); ?>
	<div class="row">
		<?php
		if ( $type=='post' && is_active_sidebar( 'archive' ) ){
			$primary_class = "col-9";
			echo '<div id="secondary" class="col-3">';
			get_sidebar();
			echo '</div>';
		}
		?>
		<div id="primary" class="<?php echo $primary_class; ?>">
			<main id="main" role="main">
			<?php
				if ( have_posts() ){
					while ( have_posts() ) :
						the_post();

					if($type == 'post')
						$affix = get_post_format();
					
					get_template_part( 'template-parts/content', $affix );
					endwhile;
					the_template_pagination();
				}
				else {
					get_template_part( 'template-parts/content', 'none' );
				}
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->
<?php
get_footer();