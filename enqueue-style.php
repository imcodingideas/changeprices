<?php
function load_custom_wp_admin_style($hook)
{
    // Load only on ?page=custom_changeprices_list
    if ($hook != 'toplevel_page_custom_changeprices_list') {
        return;
    }
    wp_enqueue_style('custom_wp_admin_css', plugins_url('style-admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');
