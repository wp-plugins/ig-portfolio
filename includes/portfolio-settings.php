<?php

add_action('admin_menu', 'ig_portfolio_submenu_page');

function ig_portfolio_submenu_page() {
	add_submenu_page( 'edit.php?post_type=project', 'IG Portfolio Settings', 'Settings', 'manage_options', 'ig-portfolio-submenu-page', 'ig_portfolio_submenu_page_callback' ); 
	//call register settings function
	add_action( 'admin_init', 'ig_portfolio_settings' );
}

function ig_portfolio_settings() {
	//register our settings
	register_setting( 'ig-portfolio-settings-group', 'ig_portfolio_settings' );
}

function ig_portfolio_validate($input) {
  return array_map('wp_filter_nohtml_kses', (array)$input);
}


function ig_portfolio_submenu_page_callback() {
?>
                
<div>
<h2><?php echo __('IG Portfolio Settings', 'ig-portfolio') ?></h2>
<p><?php echo __('To view the project with a page template in two or more columns and to customize the metadata please update the plugin to the premium version.', 'ig-portfolio') ?></p>
<h2><?php echo __('IG Portfolio Shortcodes', 'ig-portfolio') ?></h2>
<p><?php echo __('Shortcodes available:</br>
[ig-portfolio] - show project by category.</br>
[ig-portfolio-grid] - show all project.</br>
Visit our site for more documentation.', 'ig-portfolio') ?></p>

<a href="http://themes.iografica.it/downloads/ig-portfolio-premium/" target="_blank">
<?php submit_button( 'Upgrade to premium version', 'primary') ?>
</a>
</div>	
<?php } ?>
