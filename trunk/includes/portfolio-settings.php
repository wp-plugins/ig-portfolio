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

<div class="wrap ig-portfolio">
<h2><?php echo __('IG Portfolio Settings', 'ig-portfolio') ?></h2>
    <p><?php echo __('Learn more about IG Portfolio plugin, visit our website to read the plugin documentation.', 'ig-portfolio') ?></p>
<a href="http://www.iograficathemes.com/document/make-a-translation/" class="button">
    <?php esc_html_e( 'Read the documentation', 'ig-portfolio' ); ?>
</a>
<h3>
    <?php esc_html_e( 'Can i contribute?', 'ig-portfolio' ); ?>
</h3>
    <p><?php esc_html_e( 'Would you like to translate the plugin into your language? Send us your language file and it will be included in the next plugin release.', 'igname' ); ?></p>
<a href="http://www.iograficathemes.com/document/make-a-translation/" class="button">
    <?php esc_html_e( 'Read how to make a translation', 'ig-portfolio' ); ?>
</a>
<h3>
    <?php esc_html_e( 'Can\'t find a feature?', 'ig-portfolio' ); ?>
</h3>
    <p><?php esc_html_e( 'Please suggest and vote on ideas / feature requests at the feedback forum.', 'ig-portfolio' ); ?></p>
    <a href="https://iograficathemes.uservoice.com" class="button">
        <?php esc_html_e( 'Submit your feedback', 'ig-portfolio' ); ?>
    </a>
<h3>
    <?php esc_html_e( 'Do you like the plugin?', 'ig-portfolio' ); ?>
</h3>
<p><?php esc_html_e( 'Why not leave a review on WordPress.org? We\'d really appreciate it!', 'ig-portfolio' ); ?></p>
    <a href="https://wordpress.org/support/view/plugin-reviews/ig-portfolio" class="button">
        <?php esc_html_e( 'Submit your review', 'ig-portfolio' ); ?>
    </a>
</div>
<?php } ?>
