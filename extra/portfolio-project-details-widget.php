<?php

/**
 * Project Details Widget
 */
class ig_portfolio_project_details_widget extends WP_Widget {

function __construct() {
        $widget_ops = array('classname' => 'widget_project_details', 'description' => esc_html__( 'The project details.' , 'ig-portfolio') );
        parent::__construct('project-details', esc_html__('IG Portfolio Projects Details'), $widget_ops);
        $this->alt_option_name = 'widget_project_details';

        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_project_details', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Project details','ig-portfolio' );
        $show_cat = isset( $instance['show_cat'] ) ? $instance['show_cat'] : false;
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
?>
<?php if (is_singular('project')) { ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <div class="ig-project-details">
            <?php global $post; ?>
            <?php if( get_post_meta($post->ID, 'project_details_customer', true) ):?>
            <span class="customer">
                <?php esc_html_e('Customer: ', 'ig-portfolio'); ?>
                    <?php echo project_details_get_meta( 'project_details_customer' ); ?>
            </span>
            <?php endif; ?>

            <?php if( get_post_meta($post->ID, 'project_details_project', true) ):?>
            <span class="project">
                <?php esc_html_e('Project: ', 'ig-portfolio'); ?>
                <?php echo project_details_get_meta('project_details_project'); ?>
            </span>
            <?php endif; ?>

            <?php if( get_post_meta($post->ID, 'project_details_website', true) ):?>
            <span class="website">
                <a href="<?php echo esc_url(project_details_get_meta('project_details_website')); ?>" rel="nofollow">
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
        <?php echo $after_widget; ?>
<?php } ?>
<?php
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_project_details', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['show_cat'] = (bool) $new_instance['show_cat'];

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_project_details']) )
            delete_option('widget_project_details');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_project_details', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $show_cat = isset( $instance['show_cat'] ) ? (bool) $instance['show_cat'] : false;

?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','ig-portfolio' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><input class="checkbox" type="checkbox" <?php checked( $show_cat ); ?> id="<?php echo $this->get_field_id( 'show_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_cat' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_cat' ); ?>"><?php esc_html_e( 'Display project categories?', 'ig-portfolio' ); ?></label></p>
<?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("ig_portfolio_project_details_widget");'));
?>
