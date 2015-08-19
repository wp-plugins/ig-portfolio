<?php

/**
 * List Project Widget Class
 */
class ig_portfolio_project_widget extends WP_Widget {

//Register widget with WordPress.

function __construct() {
    parent::__construct(
        'ig_portfolio_project_widget', // Base ID
        esc_html__('IG Portfolio Projects', 'ig-portfolio'), // Name
        array('description' => esc_html__('Show portfolio most recent projects.', 'ig-portfolio' ),) // Args
    );
}
//Front-end display of widget.

function widget($args, $instance) {
        $number = isset( $instance['number']  ) ? esc_attr( $instance['number']) : '';
        $show_date = isset( $instance['show_date'] ) ? esc_attr( $instance['show_date']) : '';

        $query = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'post_type' => 'project', ) ) );
?>
    <?php echo $args['before_widget']; ?>
    <?php if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
    }  ?>
        <ul class="ig-portfolio-project">
        <?php if ($query->have_posts()) :
            while ( $query->have_posts() ) : $query->the_post(); ?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
                    <?php if ( get_the_title() ) the_title(); else the_ID(); ?>
                </a>
            <?php if ( $show_date ) : ?>
                <span class="project-date">
                    <?php echo $show_date . get_the_date(); ?>
                </span>
            <?php endif; ?>
            </li>
        <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata(); ?>
        <?php endif; ?>

    <?php echo $args['after_widget']; ?>

<?php }
// Back-end widget form.
public function form( $instance ) {
    $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $number = isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '';
    $show_date= isset( $instance['show_date'] ) ? esc_attr( $instance['show_date'] ) : '';
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of project to show:','ig-portfolio' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" value="1" <?php checked( '1', $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />

        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php esc_html_e( 'Display project date?', 'ig-portfolio' ); ?></label></p>
<?php
}
//Sanitize widget form values as they are saved.
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
    $instance['show_date'] = ( ! empty( $new_instance['show_date'] ) ) ? strip_tags( $new_instance['show_date'] ) : '';

    return $instance;
}

} // Class ends here

//Load the widget
function ig_portfolio_project_load_widget() {
    register_widget( 'ig_portfolio_project_widget' );
}
add_action( 'widgets_init','ig_portfolio_project_load_widget');
