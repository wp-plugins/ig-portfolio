<?php
/****
IG PORTFOLIO CATEGORY SHORTCODES
****/
function ig_portfolio_query_shortcode($atts) {

   // EXAMPLE USAGE:
   // [ig-portfolio]

   extract( shortcode_atts( array(
		'columns' => '',
		'category' => '',
		'orderby' 				=> 'date',
		'order' 				=> 'desc',
	), $atts, 'ig-portfolio-grid' ) );
	
// run query
query_posts(array( 
	'post_type'				=> 'project',
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'	=> 1,
	'orderby' 				=> $orderby,
	'order' 				=> $order,
	'tax_query' 			=> array(
									   array(
											'taxonomy' 	=> 'portfolio',
											'field' 	=> 'slug',
											'terms' 	=> array ($category),											 
										))
	));

   // the loop
   if (have_posts()) : while (have_posts()) : the_post();
      $portfolio_id = $post->ID;
      $portfolio_title = get_the_title($post->ID);
      $portfolio_link = get_permalink($post->ID);
      $portfolio_content = get_the_content($post->ID);
      //$temp_ex = get_the_excerpt();
        if ( has_post_thumbnail() ) {
        $portfolio_thumb = get_the_post_thumbnail($post->ID);
        } else {
        $portfolio_thumb = "" ;
        }

      // output all findings -
     $output .= "<div class='ig-portfolio-grid $columns'>
                <h2 class='ig-portfolio-title'>
                    <a title='$portfolio_title' rel='bookmark' href='$portfolio_link'>$portfolio_title</a>
                </h2><!--BEGIN .entry-content-->
                <div class='ig-portfolio-grid-content'>
                     <a href='$portfolio_link'>$portfolio_thumb</a>
                </div><!--END .hentry-->
            </div><!--END .ig-portfolio-grid-->";
	
    endwhile; else:
      $output .= "No project found.";
	  
   endif;
   wp_reset_query();
   return $output . "<div style='clear:both'></div>";
}
add_shortcode("ig-portfolio", "ig_portfolio_query_shortcode");


/****
IG PORTFOLIO PAGE GRID SHORTCODES
****/

function ig_portfolio_grid_query_shortcode($atts) {

   // EXAMPLE USAGE:
   // [ig-portfolio-grid]

   extract( shortcode_atts( array(
		'columns' => '',
		'orderby' 				=> 'date',
		'order' 				=> 'desc',
	), $atts, 'ig-portfolio-grid' ) );
	
// run query
query_posts(array( 
	'post_type'				=> 'project',
	'post_status' 			=> 'publish',
	'ignore_sticky_posts'	=> 1,
	'orderby' 				=> $orderby,
	'order' 				=> $order,
	));

   // the loop
   if (have_posts()) : while (have_posts()) : the_post();
      $portfolio_id = $post->ID;
      $portfolio_title = get_the_title($post->ID);
      $portfolio_link = get_permalink($post->ID);
      $portfolio_content = get_the_content($post->ID);
      //$temp_ex = get_the_excerpt();
        if ( has_post_thumbnail() ) {
        $portfolio_thumb = get_the_post_thumbnail($post->ID);
        } else {
        $portfolio_thumb = "" ;
        }

      // output all findings -
     $output .= "<div class='ig-portfolio-grid $columns'>
                <h2 class='ig-portfolio-title'>
                    <a title='$portfolio_title' rel='bookmark' href='$portfolio_link'>$portfolio_title</a>
                </h2><!--BEGIN .entry-content-->
                <div class='ig-portfolio-grid-content'>
                     <a href='$portfolio_link'>$portfolio_thumb</a>
                </div><!--END .hentry-->
            </div><!--END .ig-portfolio-grid-->";
	
    endwhile; else:
      $output .= "No project found.";
	  
   endif;
   wp_reset_query();
   return $output . "<div style='clear:both'></div>";
}
add_shortcode("ig-portfolio-grid", "ig_portfolio_grid_query_shortcode");
