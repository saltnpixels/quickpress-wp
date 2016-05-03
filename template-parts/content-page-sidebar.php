<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package quickpress
 * this works a bit interestingly. I keep entry header inside the article and still have it on top of sidebar and article using floating collapse
  * if the user sets wrap on the article and sidebar, the header can still have full widht background using the break-out! style entry-header as you want
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header break-out">
		
		<div>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
		
	</header><!-- .entry-header -->
	
<!-- 	collapsing to the rescue! keep header inside article but still float the sidebar! -->

<div class="col-3-4 post-content">

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'quickpress' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					esc_html__( 'Edit %s', 'quickpress' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer><!-- .entry-footer -->
</div> <!-- .post-content-->
</article><!-- #post-## -->

<!-- now the sidebar will float nicely -->
