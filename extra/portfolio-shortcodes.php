<?php
/****
IG PORTFOLIO CATEGORY SHORTCODES
****/
// Add Shortcode
function ig_portfolio_shortcode( $atts, $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'cat_id' => '',
            'image' => 'show',
            'meta' => 'show',
            ), $atts )
    );
ob_start();
    global $paged;
    $query = new WP_Query( array (
    'post_type' => 'project',
    'paged' => $paged
) ); ?>
<div class="ig-potfolio-page">
   <?php if ( $query->have_posts() ) {
             while ( $query->have_posts() ) : $query->the_post();?>
            <?php if ( has_post_thumbnail()) : ?>

            <div id="project-<?php the_ID(); ?>" class="ig-portfolio">
                <div class="image <?php echo $image; ?>">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                        <?php the_post_thumbnail('ig-portfolio-thumb'); ?>
                    </a>
                </div>
            <?php endif; ?>
                <div class="title">
                    <?php the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                </div>
                <div class="text">
                    <?php if ( ! has_excerpt() ) { echo '<p>' . wp_trim_words( get_the_content(), 80, '...' ) . '</p>'; } else { the_excerpt();}?>
                </div>
                <div class="meta <?php echo $meta; ?>">
                <?php esc_html_e('Author:','ig-portfolio'); ?> <?php the_author(); ?><?php echo esc_html__(' &middot; ','ig-portfolio'); ?><?php esc_html_e('Date:','ig-portfolio'); ?> <?php echo get_the_date(); ?> <?php ig_portfolio_get_terms() ?>
                </div><!-- .meta -->
            </div>

            <?php endwhile;
            //pagination
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'type'   => 'list',
                'current' => max( 1, get_query_var('paged') ),
                'total' =>  $query->max_num_pages
            ) );
            //end pagination
            wp_reset_postdata(); ?>
</div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}
add_shortcode( 'ig-portfolio', 'ig_portfolio_shortcode' );

function ig_portfolio_gallery_shortcode( $atts, $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'cat' => '',
            ), $atts )
    );
ob_start();
    $query = new WP_Query( array(
    'showposts' => -1,
    'post_type' => 'project',
    'tax_query' => array(
        array(
        'taxonomy' => 'portfolio',
        'field' => 'id',
        'terms' => array($cat))
    ))
);
    if ( $query->have_posts() ) { ?>
<div class="ig-portfolio-gallery">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <?php if ( has_post_thumbnail()) : ?>
                <div class="gallery-image">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                        <?php the_post_thumbnail('ig-portfolio-thumb'); ?>
                    </a>
                </div>
            <?php endif; ?>
            <?php endwhile;
            wp_reset_postdata(); ?>
 </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
        }
add_shortcode( 'ig-portfolio-gallery', 'ig_portfolio_gallery_shortcode' );
