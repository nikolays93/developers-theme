<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<div class="input-group">
		<input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" class="search-field form-control" autocomplete="off" placeholder="Найти" />
		
		<span class="input-group-btn">
			<button class="btn btn-default" id="searchsubmit" type="submit">
				<span class="dashicons dashicons-search"></span>
			</button>
		</span>
	</div>
</form>