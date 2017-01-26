<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<?php wp_head(); ?>
	<!--[if lt IE 9]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
	<div id="page" class="site">
		<header class="site-header">
		<?php // <!-- =8<== --> ?>
			<div class="container">
				<div class="row head-info">
					<div class="col-4 logotype"><?php the_logotype(true); ?></div>
					<div class="col-4"><?php echo get_company_info('address'); ?></div>
					<div class="col-4">
						<?php echo get_company_info('numbers'); ?>
						<?php echo get_company_info('email'); ?>
					</div>
				</div><!--.row head-info-->
			</div>
		<?php // <!-- =8<== --> ?>
			<nav class="navbar navbar-default navbar-toggleable-md navbar-light bg-faded">
				<div class="container">
					<?php do_action('main_menu_template'); ?>
				</div>
			</nav>
		<div id="content" class="site-content">