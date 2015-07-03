<?php
//IG PORTOFOLIO CUSTOM FIELDS
function project_details_get_meta( $value ) {
    global $post;

    $field = get_post_meta( $post->ID, $value, true );
    if ( ! empty( $field ) ) {
        return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
    } else {
        return false;
    }
}

function project_details_add_meta_box() {
    add_meta_box(
        'project_details',
        esc_html__( 'Project details', 'ig-portfolio' ),
        'project_details_html',
        'project',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'project_details_add_meta_box' );

function project_details_html( $post) {
    wp_nonce_field( '_project_details_nonce', 'project_details_nonce' ); ?>

    <p><?php esc_html_e( 'Add your project details', 'ig-portfolio' ); ?></p>

    <p>
        <label for="project_details_customer"><?php esc_html_e( 'Customer', 'ig-portfolio' ); ?></label><br>
        <input type="text" name="project_details_customer" id="project_details_customer" value="<?php echo project_details_get_meta( 'project_details_customer' ); ?>">
    </p>
    <p>
        <label for="project_details_project"><?php  esc_html_e( 'Project', 'ig-portfolio' ); ?></label><br>
        <input type="text" name="project_details_project" id="project_details_project" value="<?php echo project_details_get_meta( 'project_details_project' ); ?>">
    </p>
    <p>
        <label for="project_details_website"><?php  esc_html_e( 'Website', 'ig-portfolio' ); ?></label><br>
        <input type="url" name="project_details_website" id="project_details_website" value="<?php echo project_details_get_meta( 'project_details_website' ); ?>">
    </p><?php
}

function project_details_save( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! isset( $_POST['project_details_nonce'] ) || ! wp_verify_nonce( $_POST['project_details_nonce'], '_project_details_nonce' ) ) return;
    if ( ! current_user_can( 'edit_post' ) ) return;

    if ( isset( $_POST['project_details_customer'] ) )
        update_post_meta( $post_id, 'project_details_customer', esc_attr( $_POST['project_details_customer'] ) );
    if ( isset( $_POST['project_details_project'] ) )
        update_post_meta( $post_id, 'project_details_project', esc_attr( $_POST['project_details_project'] ) );
    if ( isset( $_POST['project_details_website'] ) )
        update_post_meta( $post_id, 'project_details_website', esc_attr( $_POST['project_details_website'] ) );
}
add_action( 'save_post', 'project_details_save' );

/*
    Usage: project_details_get_meta( 'project_details_customer' )
    Usage: project_details_get_meta( 'project_details_project' )
    Usage: project_details_get_meta( 'project_details_website' )
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
