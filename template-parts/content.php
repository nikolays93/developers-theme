<?php
	$class= is_singular() ? "content" : "media";
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
  <a class="<?=$class?>-left" href="<?php the_permalink();?>">
    <?php the_post_thumbnail(); ?>
  </a>
  <div class="<?=$class?>-body">
    <?php the_advanced_title(); ?>
    <?php the_content('<span class="meta-nav">Подробнее</span>'); ?>
  </div>
</article>