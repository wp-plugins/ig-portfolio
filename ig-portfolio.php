<?php
/**
 * Plugin Name:IG Portfolio
 * Plugin URI: http://themes.iografica.it/downloads/ig-portfolio
 * Description: IG Portfolio is a clean and easy-to-use portfolio plugin for WordPress.
 * Version: 1.0
 * Author: iografica
 * Author URI: http://themes.iografica.it/
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
		include ('extra/portfolio-category-widget.php');
		include ('extra/portfolio-project-widget.php');
		
		require_once( plugin_dir_path( __FILE__ ) . 'class-page-portfolio.php' );
	add_action( 'plugins_loaded', array( 'Page_Template_Portfolio', 'get_instance' ) );		

/* Add shortcodes scripts file */
function ig_portfolio_add_scripts() {

/* Style */
		wp_enqueue_style('ig_portfolio', plugins_url( 'css/ig-portfolio.css', __FILE__ ) );
}
add_filter('init', 'ig_portfolio_add_scripts');

/****
Load plugin textdomain 
****/
function ig_portfolio_load_textdomain() {
  load_plugin_textdomain( 'ig-portfolio', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'ig_portfolio_load_textdomain' );

/****
Template fallback
****/

function ig_portfolio_redirect() {
    global $wp;
    $plugindir = dirname( __FILE__ );

    //A Specific Custom Post Type
    if ($wp->query_vars["post_type"] == 'project') {
        $templatefilename = 'single-project.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/templates/' . $templatefilename;
        }
        do_theme_redirect($return_template);

    //A Custom Taxonomy Page
    } elseif ( is_tax('portfolio') ) {
        $templatefilename = 'taxonomy-portfolio.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/templates/' . $templatefilename;
        }
        do_theme_redirect($return_template);
} elseif ($wp->query_vars["post_type"] == 'project') {
        $templatefilename = 'index.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/templates/' . $templatefilename;
        }
        do_theme_redirect($return_template);
     }
}
		
function do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}

add_action("template_redirect", 'ig_portfolio_redirect');