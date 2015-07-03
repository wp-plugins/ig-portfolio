<?php

/**
 * List Categories Widget Class
 */
class ig_portfolio_categories_widget extends WP_Widget {


    /** constructor -- name this the same as the class above */
function __construct() {
        $widget_ops = array('classname' => 'widget_portfolio_categories', 'description' => esc_html__( 'Show the portfolio categories.','ig-portfolio') );
        parent::__construct('portfolio-categories', esc_html__('IG Portfolio Categories','ig-portfolio'), $widget_ops);
        $this->alt_option_name = 'widget_portfolio_categories';

        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        $cache = wp_cache_get('widget_portfolio_categories', 'widget');

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

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Portfolio Categories','ig-portfolio' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
        $tax_name = 'portfolio';
        $args = array(
        );

        // retrieves an array of categories or taxonomy terms
        $taxonomies = get_terms($tax_name, $args);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
                    <?php echo '<ul class="ig-portfolio-category">';
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
        echo '</ul>'; ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_portfolio_categories']) )
            delete_option('widget_portfolio_categories');

        return $instance;
    }
    function flush_widget_cache() {
        wp_cache_delete('widget_portfolio_categories', 'widget');
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','ig-portfolio'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php
    }


} // end class portfolio_categories_widget
add_action('widgets_init', create_function('', 'return register_widget("ig_portfolio_categories_widget");'));
?>
