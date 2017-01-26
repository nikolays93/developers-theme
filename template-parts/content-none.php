<article class="no-results not-found">
	<header class="error-header entry-header">
		<h1>Ничего не найдено</h1>
	</header>
	<div class="no-results-content error-content entry-content">
		
		<?php
		if( is_search() ){
			echo '<p>К сожалению по вашему запросу ничего не найдено. Попробуйте снова исользуя другой запрос.</p>';
			get_search_form();
		}
		else {
			echo 'К сожалению на этой странице пока нет дынных, пожалуйста, посетите страницу позже.';
		}
		?>
		
		
	</div><!-- .entry-content -->
</article><!-- #post-## -->