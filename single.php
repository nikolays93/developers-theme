<?php
get_header();

$primary_class = "col-12";
$type = $affix = get_post_type();

if($type == 'post')
	$affix = get_post_format();
?>
<div class="container">
	<?php if ( !is_front_page() ) do_action('breadcrumbs_from_yoast'); ?>
	<div class="row">
		<?php
		if ( $type=='post' && is_active_sidebar( 'archive' ) ){
			$primary_class = "col-9";
			get_sidebar();
		}
		?>
		<div id="primary" class="<?php echo $primary_class; ?>">
			<main id="main" role="main">
			<?php
				get_tpl_content( $affix );
				
				the_template_pagination();
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->
<?php
get_footer();