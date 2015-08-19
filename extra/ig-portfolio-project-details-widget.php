<?php
/*------------------------------------
 * IG PORTFOLIO WIDGET
 ------------------------------------*/
class ig_portfolio_project_details_widget extends WP_Widget {

//Register widget with WordPress.

function __construct() {
    parent::__construct(
        'ig_portfolio_project_details_widget', // Base ID
        esc_html__('IG Portfolio Project Details', 'ig-portfolio'), // Name
        array('description' => esc_html__('The project details.', 'ig-portfolio' ))
    );
}

//Front-end display of widget.
function widget($args, $instance) {
    $show_cat = isset( $instance['show_cat'] ) ? esc_attr( $instance['show_cat'] ) : '';
?>

<?php if (is_singular('project')) { ?>

        <?php echo $args['before_widget']; ?>
        <?php if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }  ?>

        <div class="ig-project-details">
            <?php global $post; ?>

            <?php if( get_post_meta($post->ID, 'ig_portfolio_customer', true) ):?>
            <span class="customer">
                <?php esc_html_e('Customer: ', 'ig-portfolio'); ?>
                    <?php echo ig_portfolio_get_meta( 'ig_portfolio_customer' ); ?>
            </span>
            <?php endif; ?>

            <?php if( get_post_meta($post->ID, 'ig_portfolio_project', true) ):?>
            <span class="project">
                <?php esc_html_e('Project: ', 'ig-portfolio'); ?>
                <?php echo ig_portfolio_get_meta('ig_portfolio_project'); ?>
            </span>
            <?php endif; ?>

            <?php if( get_post_meta($post->ID, 'ig_portfolio_website', true) ):?>
            <span class="website">
                <a href="<?php echo esc_url(ig_portfolio_get_meta('ig_portfolio_website')); ?>" rel="nofollow">
                    <?php esc_html_e('view the project &#8594;', 'ig-portfolio'); ?>
                </a>
            </span>
          <?php endif; ?>

        <?php if ( $show_cat ) : ?>
            <span class="categories">
                 <span class="cat-title">
                     <?php esc_html_e('Categories:','ig-portfolio'); ?>
                 </span>
                 <?php ig_portfolio_get_terms();?>
            </span>
        <?php endif; ?>
    </div>
    <?php echo $args['after_widget']; ?>

<?php }; ?>

<?php }
// Back-end widget form.
public function form( $instance ) {
    $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
    $show_cat = isset( $instance['show_cat'] ) ? esc_attr( $instance['show_cat'] ) : '';
?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">
            <?php esc_html_e( 'Title:','ig-portfolio' ); ?>
        </label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $show_cat ); ?> id="<?php echo $this->get_field_id( 'show_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_cat' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_cat' ); ?>">
            <?php esc_html_e( 'Display project categories?', 'ig-portfolio' ); ?>
        </label>
    </p>

<?php
}

//Sanitize widget form values as they are saved.
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['show_cat'] = ( ! empty( $new_instance['show_cat'] ) ) ? strip_tags( $new_instance['show_cat'] ) : '';

    return $instance;
}

} // Class ends here

//Load the widget
function ig_portfolio_project_details_load_widget() {
    register_widget( 'ig_portfolio_project_details_widget' );
}
add_action( 'widgets_init', 'ig_portfolio_project_details_load_widget');
