<?php
defined( 'ABSPATH' ) or die ('No direct access to files');

/**
 * Plugin Name: Minimize WP Admin Bar
 * Plugin URI: http://mikeeverhart.net
 * Description: Minimizes the WP Admin Bar, making it less obnoxious
 * Version: 0.1a
 * Author: Mike Everhart
 * Author URI: http://mikeeverhart.net
 * License: GPL2
 */

//------------------------------------------------------------------------------
// Do not inject CSS/JS on the front-end if the user is not logged in and the bar isn't present on the page
// Init done after plugin_loaded because is_admin_bar_showing() uses is_user_logged_in() which is a pluggable function.
//------------------------------------------------------------------------------
add_action("plugins_loaded", "mab_init_plugin");

function mab_init_plugin(){
  if( is_admin_bar_showing() ){
    add_action('wp_enqueue_scripts', 'mab_toggle_admin_bar_assets');
    add_action('wp_head', 'mab_remove_padding', 1);
   }

   add_action('wp_after_admin_bar_render', 'mab_add_admin_bar_toggle');

}

//------------------------------------------------------------------------------
// Enqueue the CSS and JS
//------------------------------------------------------------------------------
function mab_toggle_admin_bar_assets() {
    wp_enqueue_style( 'mab-minimize-admin-bar-css', plugin_dir_url( __FILE__ ) . 'css/style.css');
    wp_enqueue_script( 'mab-minimize-admin-bar-js', plugin_dir_url( __FILE__ ) . 'js/app.js', array( 'jquery' ), '1.0', true );
}

//------------------------------------------------------------------------------
// Remove the 32px of padding the WP Admin Bar adds
//------------------------------------------------------------------------------
function mab_remove_padding() {
  remove_action('wp_head', '_admin_bar_bump_cb');
}

//------------------------------------------------------------------------------
// Add the WP Admin Bar toggle
//------------------------------------------------------------------------------
function mab_add_admin_bar_toggle() {
    echo '<a href="javascript:void();" id="mab-btn-show-admin-bar" title="Show WP Admin Bar"></a>';
}
