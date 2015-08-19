<?php
if ( ! function_exists('ig_portfolio_post_type') ) {

// Register Custom Post Type
function ig_portfolio_post_type() {

    $labels = array(
        'name'                => _x( 'Projects', 'ig-portfolio' ),
        'singular_name'       => _x( 'Project', 'ig-portfolio' ),
        'menu_name'           => __( 'Portfolio', 'ig-portfolio' ),
        'parent_item_colon'   => __( 'Parent Item:', 'ig-portfolio' ),
        'all_items'           => __( 'All Projects', 'ig-portfolio' ),
        'view_item'           => __( 'View Project', 'ig-portfolio' ),
        'add_new_item'        => __( 'Add New Project', 'ig-portfolio' ),
        'add_new'             => __( 'Add New', 'ig-portfolio' ),
        'edit_item'           => __( 'Edit Project', 'ig-portfolio' ),
        'update_item'         => __( 'Update Project', 'ig-portfolio' ),
        'search_items'        => __( 'Search Project', 'ig-portfolio' ),
        'not_found'           => __( 'Not found', 'ig-portfolio' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ig-portfolio' ),
    );
    $args = array(
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( 'portfolio' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'				=> 'dashicons-portfolio',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'project', $args );

}

// Hook into the 'init' action
add_action( 'init', 'ig_portfolio_post_type', 0 );

}

if ( ! function_exists( 'ig_portfolio_taxonomy' ) ) {

// Register Custom Taxonomy
function ig_portfolio_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Category', 'ig-portfolio' ),
        'singular_name'              => _x( 'Category', 'ig-portfolio' ),
        'menu_name'                  => __( 'Category', 'ig-portfolio' ),
        'all_items'                  => __( 'All Items', 'ig-portfolio' ),
        'parent_item'                => __( 'Parent Item', 'ig-portfolio' ),
        'parent_item_colon'          => __( 'Parent Item:', 'ig-portfolio' ),
        'new_item_name'              => __( 'New Item Name', 'ig-portfolio' ),
        'add_new_item'               => __( 'Add New Item', 'ig-portfolio' ),
        'edit_item'                  => __( 'Edit Item', 'ig-portfolio' ),
        'update_item'                => __( 'Update Item', 'ig-portfolio' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'ig-portfolio' ),
        'search_items'               => __( 'Search Items', 'ig-portfolio' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'ig-portfolio' ),
        'choose_from_most_used'      => __( 'Choose from the most used items', 'ig-portfolio' ),
        'not_found'                  => __( 'Not Found', 'ig-portfolio' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'portfolio', array( 'project' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'ig_portfolio_taxonomy', 0 );

}

//flush 
function ig_portfolio_plugin_activation() {
    // Register types to register the rewrite rules
    ig_portfolio_post_type();
    ig_portfolio_taxonomy();
    // Then flush them
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ig_portfolio_plugin_activation');
 
function ig_portfolio_plugin_deactivation() {
 
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ig_portfolio_plugin_activation');

/* Stop Adding Functions Below this Line */
?>
