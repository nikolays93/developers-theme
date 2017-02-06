<?php
if(class_exists('WPAdvancedPostType')){
	$types = new WPAdvancedPostType();
	$types -> add_type( 'enty', 'Entity', 'Entities', array('public'=>false) );
	$types -> add_type( 'news', 'News');
	$types -> reg_types();
}