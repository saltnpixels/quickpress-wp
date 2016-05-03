<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package quickpress
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'quickpress' ); ?></a>

<!-- quickpress additions: sea salt grid stickyfooter requires site-content hold header and anything else out side of footer -->
  <div id="content" class="site-content">
	

<?php
	/*
		using the cusomtizer we check on the placement of the logo and put a class onto site-top
		Then we get the logo. if its a svg we put it inline and dump file contents here. else we output image link.
		if no image is uploaded we fall back on blog name
	*/
?>

	<div class="site-top <?php //added qp
		if ( get_theme_mod('logo_location') ){ echo esc_html(get_theme_mod( 'logo_location') ); } else{ echo 'left-logo';  } ?>">
		
	<?php 
		if ( get_theme_mod('site_top_wrap') == 'yes' || get_theme_mod('site_top_wrap') == '')
		{
				echo '<div class="wrap">'; 
		} 
	?>
	
		<div class="site-logo">


		<?php
				if ( get_theme_mod( 'your_theme_logo' ) ) :
				
				$logo = get_theme_mod( 'your_theme_logo' );
			
			if( preg_match('/\.(svg)(?:[\?\#].*)?$/i', $logo, $matches) )
			{
				// if its an svg we can put it inline. added qp
				$logo = file_get_contents($logo);
			}
			else
			{
				$logo = '<img src="' . $logo .'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" >';
			}
			
			if ( is_front_page() ) : ?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo $logo; ?>
					</a>
				</h1>
				
			<?php else : ?>
			
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo $logo; ?>
					</a>
				</p>
				
			<?php endif; ?>
				
 
		<?php // if there is no theme mod use basic text from blog info name
			 else : 
			 
			 	 if ( is_front_page() ) : ?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name') ?>
					</a>
				</h1>
				
			<?php else : ?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name') ?>
					</a>
				</p>
		<?php endif; ?>
 
			<?php endif; //no theme mod ?>
			
			
		</div> <!-- .site-logo -->
		
		
		
		
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars"></i></button>
			
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'site-menu' ) ); ?>
			
	</nav><!-- #site-navigation -->
	
		
	<?php 
		if (get_theme_mod('site_top_wrap') == 'yes' || get_theme_mod('site_top_wrap') == '')
		{
				echo '</div>'; 
		} 
	?>
	
</div> <!-- end site-top -->




	
	<?php
		if(is_front_page()):
			  //get front page from customizer. default to page named header
				$front_header = get_theme_mod('qp_front_header') ? get_theme_mod('qp_front_header'): 'header';  

				
				$front_header_query = new WP_Query(array(
        	'post_status' => 'publish',
					'post_type' => 'page',
					'pagename' => $front_header
        ));
        
//loop

			if ( $front_header_query->have_posts() ) : ?>
	
		
		<?php while ( $front_header_query->have_posts() ) : $front_header_query->the_post(); ?>
		
		<header id="masthead" class="site-header" role="banner">

		<?php the_content(); ?>
		</header><!-- #masthead -->
		
	<?php endwhile; ?>

  <?php endif; ?>


<?php wp_reset_postdata(); ?>



<?php 
	//if its an archive page of any sort get the archive headers page which can use pods so users can create there own archive headers or remove pods 
	 // and just use switch statement to change the header for each archive type
  elseif( is_home() || is_post_type_archive() ):
 
	  get_header('archives');
 
?>

	
<?php endif; ?>
	
<?php 
//place a class here if you want to contain everything especially if you wrap the primary in a wrapper 
?>

