<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package quickpress
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
		
			$footer = get_theme_mod('qp_footer') ? get_theme_mod('qp_footer') : 'footer';
				
				$footer_query = new WP_Query(array(
        	'post_status' => 'publish',
					'post_type' => 'page',
					'pagename' => $footer
        ));
        
//loop

			if ( $footer_query->have_posts() ) : ?>
	
		
		<?php while ( $footer_query->have_posts() ) : $footer_query->the_post(); ?>

		<?php the_content(); ?>
	<?php endwhile; ?>
<? endif; ?>
<?php wp_reset_postdata(); ?>

		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
