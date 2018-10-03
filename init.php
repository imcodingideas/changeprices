<?php
/*
Plugin Name: Change prices
Description: Massively change prices
Version: 1
Author: 
Author URI: 
*/

//menu items
add_action('admin_menu','custom_changeprices_modifymenu');
function custom_changeprices_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Change Prices', //page title
	'Change Prices', //menu title
	'manage_options', //capabilities
	'custom_changeprices_list', //menu slug
	'custom_changeprices_list' //function
	);
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require(ROOTDIR."vendor/autoload.php");
require_once(ROOTDIR . 'functions.php');
require_once(ROOTDIR . 'changeprices-list.php');
