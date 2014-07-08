<?php
/**
 * The Template for displaying the single project
 */
get_header(); ?>
	
   <div id="primary" class="content-area twelve columns">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title">
				<?php printf( __( 'Portfolio Category: %s', 'ig-portfolio' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
                </h1>

			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->

	<?php while ( have_posts() ) : the_post(); ?>
   
    <article id="post-<?php the_ID(); ?>" <?php post_class('ig-portfolio-grid-grid four'); ?>>
	
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