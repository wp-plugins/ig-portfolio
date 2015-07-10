<?php
//IG PORTOFOLIO CUSTOM FIELDS
function ig_portfolio_get_meta( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function ig_portfolio_add_meta_box() {
    add_meta_box(
        'ig_portfolio',
        esc_html__( 'Project details', 'ig-portfolio' ),
        'ig_portfolio_html',
        'project',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'ig_portfolio_add_meta_box' );

function ig_portfolio_html( $post) {
    wp_nonce_field( '_ig_portfolio_nonce', 'ig_portfolio_nonce' ); ?>

    <p><?php esc_html_e( 'Add your project details', 'ig-portfolio' ); ?></p>

    <p>
        <label for="ig_portfolio_customer"><?php esc_html_e( 'Customer', 'ig-portfolio' ); ?></label><br>
        <input type="text" name="ig_portfolio_customer" id="ig_portfolio_customer" value="<?php echo ig_portfolio_get_meta( 'ig_portfolio_customer' ); ?>">
    </p>
    <p>
        <label for="ig_portfolio_project"><?php  esc_html_e( 'Project', 'ig-portfolio' ); ?></label><br>
        <input type="text" name="ig_portfolio_project" id="ig_portfolio_project" value="<?php echo ig_portfolio_get_meta( 'ig_portfolio_project' ); ?>">
    </p>
    <p>
        <label for="ig_portfolio_website"><?php  esc_html_e( 'Website', 'ig-portfolio' ); ?></label><br>
        <input type="url" name="ig_portfolio_website" id="ig_portfolio_website" value="<?php echo ig_portfolio_get_meta( 'ig_portfolio_website' ); ?>">
    </p><?php
}

function ig_portfolio_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['ig_portfolio_nonce'] ) || ! wp_verify_nonce( $_POST['ig_portfolio_nonce'], '_ig_portfolio_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post' ) ) return;

    if ( isset( $_POST['ig_portfolio_customer'] ) )
        update_post_meta( $post_id, 'ig_portfolio_customer', esc_attr( $_POST['ig_portfolio_customer'] ) );
    if ( isset( $_POST['ig_portfolio_project'] ) )
        update_post_meta( $post_id, 'ig_portfolio_project', esc_attr( $_POST['ig_portfolio_project'] ) );
    if ( isset( $_POST['ig_portfolio_website'] ) )
        update_post_meta( $post_id, 'ig_portfolio_website', esc_attr( $_POST['ig_portfolio_website'] ) );
}
add_action( 'save_post', 'ig_portfolio_save' );

/*
    Usage: ig_portfolio_get_meta( 'ig_portfolio_customer' )
    Usage: ig_portfolio_get_meta( 'ig_portfolio_project' )
    Usage: ig_portfolio_get_meta( 'ig_portfolio_website' )
*/

//IG PORTFOLIO GET TERMS FUNCTION
function ig_portfolio_get_terms() {
    global $post;
    $terms = get_the_terms( $post->ID , 'portfolio' );
    // Loop over each item since it's an array
    if ( $terms != null ){
    foreach( $terms as $term ) {
    // Print the name method from $term which is an OBJECT
    echo '<span class="cat-name">'.$term->name. '</span>' ;
    // Get rid of the other data stored in the object, since it's not needed
    unset($term);
    } }
}

//IG PORTFOLIO CUSTOM IMAGE SIZE
add_image_size( 'ig-portfolio-thumb', 210, 150, true );

// COLUMN
add_filter('manage_project_posts_columns', 'ig_portfolio_columns');
function ig_portfolio_columns($defaults){
    $defaults['project_thumbs'] = __('Image');
    return $defaults;
}
//render the column
add_action('manage_project_posts_custom_column', 'ig_portfolio_custom_columns', 5, 2);
function ig_portfolio_custom_columns($column_name, $post_id){
    if($column_name === 'project_thumbs'){
        if (has_post_thumbnail( $post_id ))
            echo the_post_thumbnail( array('60','60') );
        else
            echo "N/A";
    }
}
