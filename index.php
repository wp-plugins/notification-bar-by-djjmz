<?php
	/*
		Plugin Name: Notification bar by DJJMZ
		Plugin URI: 
		Description: Simple notification bar to show message for website visitors.
		Version: 1.0
		Author: djjmz
		Author URI: 
	*/
	require_once('functions.php');
	add_action('wp_head', 'nnd_custom_css');
	add_action('wp_enqueue_scripts', 'nnd_js_load');	
	add_action('wp_footer', 'nnd_custom_html');
	add_action('admin_menu', 'nnd_add_menu');
