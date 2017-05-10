<?php
	get_header();

	$primary_class = "col-12";
	$type = $affix = get_post_type();

	if($type == 'post')
		$affix = get_post_format();

?>
<div class="container">
	<?php if ( !is_front_page() ) breadcrumbs_from_yoast(); ?>
	<div class="row">
		<?php
		if ( $type == 'post' && is_active_sidebar( 'archive' ) ){
			$primary_class = "col-9";
			
			get_sidebar();
		}
		?>
		<div id="primary" class="<?php echo $primary_class; ?>">
			<main id="main" class="main content" role="main">
			<?php
				if ( have_posts() ){
					if( is_search() ){
						echo'
						<header class="archive-header">
							<h1>Результаты поиска: '. get_search_query().'</h1>
						</header>';

						get_tpl_search_content();
					}
					else {
						if( ! is_front_page() ){
							the_advanced_archive_title();
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						}

						get_tpl_content( $affix );

					}

					the_template_pagination();
				}
				else {
					if( ! is_front_page() )
						get_template_part( 'template-parts/content', 'none' );
				}
			?>	
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->

<a href="#" data-fade-IN="#myModal">Show modal!</a>

<span data-target="html, body" data-action="toggleClass" data-props="'modal-open'"> BODY!</span>

<!-- Modal -->
<div class="modal hidden" id="myModal" tabindex="-1" aria-hidden="true" data-wrapper="only" data-fade-Out="<< .modal">
  <div class="modal-dialog centered">
    <div class="modal-content">
    	<div class="modal-body">
    		<button type="button" class="close" data-fade-Out="<< .modal">&times;</button>
    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.    		
    	</div>
    </div>
  </div>
</div>

<?php
get_footer();