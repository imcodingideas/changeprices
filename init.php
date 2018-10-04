<?php
/*
Plugin Name: Change prices
Description: Massively change prices
Version: 1
Author:
Author URI:
 */
define('ROOTDIR', plugin_dir_path(__FILE__));
require ROOTDIR . 'vendor/autoload.php';
require ROOTDIR . 'functions.php';
require ROOTDIR . 'changeprices-list.php';
require ROOTDIR . 'enqueue-style.php';

/**
 * Creates the admin menu item
 * @return boolean
 */
function custom_changeprices_modifymenu()
{
    add_menu_page(
        'Change Prices', //page title
        'Change Prices', //menu title
        'manage_options', //capabilities
        'custom_changeprices_list', //menu slug
        'custom_changeprices_list' //function
    );
    return true;
}
add_action('admin_menu', 'custom_changeprices_modifymenu');
