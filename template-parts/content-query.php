<?php
// $columns - colums count from custom-query.php ([query])
$column_class = get_default_bs_columns(empty($columns) ? 1 : $columns);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($column_class); ?>>
	<?php the_advanced_title();  ?>
	<div class="entry-content">
		<?php
				the_content('<span class="meta-nav">&rarr;</span>');
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->