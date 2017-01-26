<?php
$affix = !empty($post->post_type) ? $post->post_type : '';
get_template_part( 'template-parts/content', $affix );