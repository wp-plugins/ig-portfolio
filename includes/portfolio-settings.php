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
<p><?php echo __('To display projects in two or more columns and to customize the post information please upgrade to premium version.', 'ig-portfolio') ?></p>
<h2><?php echo __('IG Portfolio Shortcodes', 'ig-portfolio') ?></h2>
<p><?php echo __('Shortcodes are available only in the premium version.', 'ig-portfolio') ?></p>
<a href="http://www.iograficathemes.com/downloads/ig-portfolio-premium/" target="_blank">
<?php submit_button( 'Upgrade to premium version', 'primary') ?>
</a>
</div>	
<?php } ?>
