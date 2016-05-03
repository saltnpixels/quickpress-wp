<?php
/**
 * Template Name: page sidebar left
 *
 * This is the template that display pages with sidebars. tip: dont use content column width!
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package quickpress
 */

get_header(); ?>


<div class="has-sidebar right-sidebar <?php echo get_post_meta(get_the_ID(), 'quickpress_layout_type', true); ?> ">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
	
						
						<?php
						while ( have_posts() ) : the_post();
			
							get_template_part( 'template-parts/content', 'page-sidebar' );
			
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
			
						endwhile; // End of the loop.
						?>
						

		</main><!-- #main -->
	</div><!-- #primary -->


<div class="col-1-4"> <?php get_sidebar(); ?></div>

</div> <!-- .wrap -->
<?php
get_footer();
