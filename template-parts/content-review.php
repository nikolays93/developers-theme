<?php
if(! class_exists( 'DTReview' ))
	return false;

$post_id = get_the_id();
$review_data = DTReview::get_review_options( $post_id );
extract($review_data);

/**
 * Данные пользователя
 */
$user_id = get_post_meta($post_id, 'user_id', true);
if($user_id){
	$user = get_user_by('ID', (int)$user_id);
	$name = $user->display_name;
	$vk_id = explode('_', $user->user_login);
	$vk_src = get_user_meta( $user_id, 'vkapi_ava', true );
	$avatar = "<img src='{$vk_src}' alt='{$user->user_nicename}' class='img-round vk-thumbnail'>";
	$user_link = 'http://vk.com/'. $vk_id['1'];
}
else {
	$avatar = ( has_post_thumbnail() ) ? 
		 get_the_post_thumbnail( $post_id, 'thumbnail', array('class' => 'img-round d-flex al') ) :
		 ''; //get_the_placeholder();
	
	$user_link = false;
	//get_avatar( $user->ID, 200, '', '', array('class'=>'img-round') );
}

/**
 * Заголовок отзыва
 */
$title = '';
if( $name ){
	$title = '<h4>';
	$title .= apply_filters( 'dt_review_title', $name, $user_link );
	if( $email )
		$title .= ' ' . apply_filters( 'dt_review_email', $email );
	$title .= '</h4>';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('media dt_review'); ?>>
	<?php echo $avatar; ?>
	<div class="media-body">
		<?php echo $title; ?>
		<div class="entry-review-body">
			<?php the_content(); ?>
		</div>
	</div>
</article>