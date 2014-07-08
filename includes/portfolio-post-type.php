<?php
if ( ! function_exists('ig_portfolio_post_type') ) {

// Register Custom Post Type
function ig_portfolio_post_type() {

	$labels = array(
		'name'                => _x( 'Projects', 'Post Type General Name', 'ig-portfolio' ),
		'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'ig-portfolio' ),
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
		'name'                       => _x( 'Category', 'Taxonomy General Name', 'ig-portfolio' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'ig-portfolio' ),
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

//Custom fields portfolio

add_action("admin_init", "ig_portfolio_meta_box");  
function ig_portfolio_meta_box(){    
    add_meta_box("portfolio-meta", "Project details", "portfolio_meta_options", "project", "side", "low");    
}    

function ig_portfolio_meta_options(){    
        global $post;    
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;  
        $custom = get_post_custom($post->ID);    
        $customer = $custom["customer"][0];
		$project = $custom["project"][0];
		$link = $custom["website"][0]; 
?>    
    <label><?php _e( 'Customer:', 'ig-portfolio' ); ?></label></br><input type="text" class="widefat" name="customer" value="<?php echo $customer; ?>" /></br>
    <label><?php _e( 'Project:', 'ig-portfolio' ); ?></label></br><input type="text" class="widefat" name="project" value="<?php echo $project; ?>" /></br>
    <label><?php _e( 'Website:', 'ig-portfolio' ); ?></label></br><input type="url" class="widefat" name="website" value="<?php echo $link; ?>" />   
<?php    
    }
add_action('save_post', 'ig_portfolio_save_meta');   
    
function ig_portfolio_save_meta(){    
    global $post;    
      
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){   
        return $post_id;  
    }else{  
        update_post_meta($post->ID, "customer", $_POST["customer"]);
		update_post_meta($post->ID, "project", $_POST["project"]);
		update_post_meta($post->ID, "website", $_POST["website"]);  
    }   
}

/* Stop Adding Functions Below this Line */
?>