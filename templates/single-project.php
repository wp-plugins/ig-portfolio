<?php
/**
 * The Template for displaying the single project
 */

get_header(); ?>

	<div id="primary" class="content-area twelve columns">
		<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
	
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <header class="entry-header">
		<h1 class="entry-title ig-portfolio-title"><?php the_title(); ?></h1>

    <div class="ig-portfolio-meta"> 
		<?php  echo __('Posted on:', 'ig-portfolio'); ?> <?php the_date(); ?>
     	<?php  echo __('Category', 'ig-portfolio'); ?> 
		<?php $terms = get_the_terms( $post->ID , 'portfolio' ); 
    		 foreach ( $terms as $term ) {
    			$term_link = get_term_link( $term, 'portfolio' );
    				if( is_wp_error( $term_link ) )
           		continue;
             echo '- <a href="' . $term_link . '">' . $term->name . '</a>';
          } ?>
	</div><!-- .ig-portfolio-meta -->
	
    </header><!-- .entry-header -->

	<div class="ig-portfolio-content">
   
  	<div class="ig-portfolio-image">
    	<?php 
			if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  			the_post_thumbnail('');} 
		?>
    </div>  <!-- .ig-portfolio-image -->
    
    <div class="ig-portfolio-details">
          <span class="customer"><?php echo __('Customer: ', 'ig-portfolio'); ?><?php echo get_post_meta($post->ID, 'customer', true); ?></span>
          <span class="project"><?php echo __('Project: ', 'ig-portfolio'); ?><?php echo get_post_meta($post->ID,'project', true); ?></span>
          <?php if( get_post_meta($post->ID, 'website', true) ):?>
          <span class="website"><?php echo __('Website: ', 'ig-portfolio'); ?><a href="<?php echo get_post_meta($post->ID, 'website', true); ?>" rel="nofollow"><?php echo __('Wiew the project', 'ig-portfolio'); ?></a></span>
		  <?php endif; ?>
    </div>  <!-- .portfolio-details -->
    
	<?php the_content(); ?>
	</div><!-- .ig-portfolio-content-->
    
</article>

	<?php endwhile; // end of the loop. ?>
    
   	<div class="navigation">
	<div class="alignleft">
		<?php previous_post(' &laquo; %','previous: ', 'yes'); ?>
	</div>
	<div class="alignright">
		<?php next_post('% &raquo; ', 'next: ', 'yes'); ?>
	</div>
	</div> <!-- end navigation -->
    
		</main><!-- #main -->
	</div><!-- #primary -->
    
<?php get_sidebar(); ?>
<?php get_footer(); ?>