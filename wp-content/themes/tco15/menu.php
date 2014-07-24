<?php

$nav = array (
		'menu' => 'Main menu',
		'menu_class' => '',
		'container' => '',
		'menu_class' => 'root',
		'items_wrap' => '%3$s',
		'walker' => new nav_menu_walker () 
);
wp_nav_menu ( $nav );	?>