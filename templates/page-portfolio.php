<?php
/**
 * Template Name: Portfolio
 */

 get_header(); ?>

	<?php
	$pte = Page_Template_Portfolio::get_instance();
	$locale = $pte->get_locale();
	?>
 
   	<div id="primary" class="content-area twelve columns">
		<main id="main" class="site-main" role="main">
        
	<header class="entry-header">
		<h1 class="entry-title ig-portfolio-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->
    
	<?php if ( have_posts() ) : ?>
		
		<?php 
    		query_posts(array( 
        	'post_type' => 'project' 
    		) );  
		?>

	<?php while ( have_posts() ) : the_post(); ?>
    	
    <article id="post-<?php the_ID(); ?>" <?php post_class('ig-portfolio-grid four'); ?>>
	
	<header class="entry-header">
			<h1 class="ig-portfolio-title">
            	<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h1>
             <div class="ig-portfolio-meta"> 
				<?php  echo __('Posted on:', 'ig-portfolio'); ?> <?php the_date(); ?>
     		</div><!-- .ig-portfolio-meta -->
   	</header><!-- .entry-header -->
	
    <div class="entry-content ig-portfolio-grid-content">
    	<?php if ( has_post_thumbnail()) : ?>
   			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail(); ?> </a>
		<?php endif; ?>
	</div><!-- .entry-content -->
		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'iografica' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post-## -->

		<?php endwhile;	?>
			
		<?php 
			global $wp_query;

			$big = 999999999; // need an unlikely integer
			$translated = __( 'Page', 'ig-portfolio' ); // Supply translatable string

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
        		'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
			) );
		    ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>