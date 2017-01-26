<?php
$layoutClass = 'col-12';

$user_id = get_post_meta($post->ID, 'user_id', true);
if(!empty($user_id)){
	$user = get_user_by('ID', $user_id);
	$user_name = $user->display_name;
	$vk_id = explode('_', $user->user_login);
	$vk_src = get_user_meta( $user_id, 'vkapi_ava', true );
} else {
	$user_name = get_post_meta($post->ID, 'your-name', true);
}

if(!empty($vk_src)){
	$avatar = "<img src='$vk_src' alt='$user->user_nicename' class='alignleft img-round vk-thumbnail'>";
	$vk_url = 'http://vk.com/'. $vk_id['1'];
}else{
	$avatar = get_avatar($user->ID, 200, '', '', array('class'=>'img-round'));
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<?php
		if(!empty($avatar)){
			echo '<div class="col-2">'.$avatar.'</div>';
			$layoutClass = 'col-10';
		}
		?>
		<div class="<?php echo $layoutClass; ?>">
			<h3>
				<?php
				if(isset($vk_url))
					echo '<a href="'.$vk_url.'" target="_blank">';
				echo 'Отзыв от '. $user_name;
				if(isset($vk_url))
					echo '</a>';
				?>
			</h3>
			<div class="entry-review">
				<?php the_content(''); ?>
			</div>
		</div>
	</div>
</article><!-- #post-## -->