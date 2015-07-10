<?php

/**
 * List Categories Widget Class
 */
class ig_portfolio_categories_widget extends WP_Widget {

/**
* Register widget with WordPress.
**/
function __construct() {
    parent::__construct(
        'ig_portfolio_categories_widget', // Base ID
        esc_html__('IG Portfolio Categories', 'ig-portfolio'), // Name
        array('description' => esc_html__('Show portfolio categories.', 'ig-portfolio' ),) // Args
    );
}
/**
* Front-end display of widget.
*/
    function widget($args, $instance) {

        $tax_name = 'portfolio';
        $args = array();
        // retrieves an array of categories or taxonomy terms
        $taxonomies = get_terms($tax_name, $args);
        ?>
        <?php echo $args['before_widget']; ?>
        <?php if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }  ?>
                <?php
                    echo '<ul class="ig-portfolio-category">';
                        foreach( $taxonomies as $taxonomy ){
                            $link = get_term_link( $taxonomy, $tax_name );
                        echo '<li>';
                        echo '<a href="'.esc_url($link).'" class="cat-name">';
                        echo esc_html($taxonomy->name);
                        echo '</a>';
                        $sub_args = array(
                            'hide_empty' => false,
                            'hierarchical' => false,
                            'parent' => 0
                        );
                        echo '</li>';
                        }
                    echo '</ul>';
                ?>
    <?php echo $args['after_widget']; ?>
<?php }
// Back-end widget form.
public function form( $instance ) {
    $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','ig-portfolio'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
<?php
}
//Sanitize widget form values as they are saved.
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
}

} // Class ends here

//Load the widget
function ig_portfolio_categories_load_widget() {
    register_widget( 'ig_portfolio_categories_widget' );
}
add_action( 'widgets_init','ig_portfolio_categories_load_widget');
