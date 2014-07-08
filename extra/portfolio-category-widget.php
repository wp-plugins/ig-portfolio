<?php

/**
 * List Categories Widget Class
 */
class ig_portfolio_categories_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function ig_portfolio_categories_widget() {
        parent::WP_Widget(false, $name = 'Portfolio Categories');
    }
 
	/** @see WP_Widget::widget -- do not rename this */
	function widget($args, $instance) {
		extract( $args );
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Portfolio Categories' );
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$tax_name = 'portfolio';
		$args = array(
		);
 
		// retrieves an array of categories or taxonomy terms
		$taxonomies = get_terms($tax_name, $args);
		?>
			  <?php echo $before_widget; ?>
				  <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
					<?php echo '<ul class="ig-portfolio-category-widget-content">';
		foreach( $taxonomies as $taxonomy ){
			$link = get_term_link( $taxonomy, $tax_name );
		echo '<li>';
			echo '<a href="'.$link.'">';
			echo $taxonomy->name;
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
		return $instance;
	}
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
        $title 		= esc_attr($instance['title']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<?php
    }
 
 
} // end class portfolio_categories_widget
add_action('widgets_init', create_function('', 'return register_widget("ig_portfolio_categories_widget");'));
?>