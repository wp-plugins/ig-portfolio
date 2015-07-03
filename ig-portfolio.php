<?php
/**
 * Plugin Name:IG Portfolio
 * Plugin URI: http://www.iograficathemes.com/downloads/ig-portfolio
 * Description: IG Portfolio is a clean and simply project showcase management system for WordPress.
 * Version: 1.3
 * Author: iografica
 * Author URI: http://www.iograficathemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
 // Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/* Variables */
$ig_portfolio_name = "IG Portfolio";

/* Includes */
        include ('includes/portfolio-post-type.php');
        include ('includes/portfolio-settings.php');
        include ('includes/portfolio-function.php');
        include ('extra/portfolio-category-widget.php');
        include ('extra/portfolio-project-widget.php');
        include ('extra/portfolio-project-details-widget.php');
        include ('extra/portfolio-shortcodes.php');

/****
Load plugin textdomain
****/
function ig_portfolio_load_textdomain() {
  load_plugin_textdomain( 'ig-portfolio', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ig_portfolio_load_textdomain' );

/* Add portfolio scripts file */
function ig_portfolio_scripts() {
        wp_enqueue_style('ig_sportfolio', plugins_url( 'css/ig-portfolio.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'ig_portfolio_scripts' );

// Hooks your functions into the correct filters
function ig_portfolio_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'ig_portfolio_tinymce_plugin' );
        add_filter( 'mce_buttons', 'ig_portfolio_register_mce_button' );
    }
}
add_action('admin_head', 'ig_portfolio_mce_button');

// Declare script for new button
function ig_portfolio_tinymce_plugin( $plugin_array ) {
    $plugin_array['ig_portfolio_mce_button'] = plugins_url('/includes/mce-button.js', __FILE__);
    return $plugin_array;
}

// Register new button in the editor
function ig_portfolio_register_mce_button( $buttons ) {
    array_push( $buttons, 'ig_portfolio_mce_button' );
    return $buttons;
}
