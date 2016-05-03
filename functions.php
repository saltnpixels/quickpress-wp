<?php
/**
 * quickpress functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package quickpress
 */

if ( ! function_exists( 'quickpress_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function quickpress_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on quickpress, use a find and replace
	 * to change 'quickpress' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'quickpress', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
//set a size for it...
//set_post_thumbnail_size( 640, 360, true );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'quickpress' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'quickpress_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'quickpress_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function quickpress_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'quickpress_content_width', 640 );
}
add_action( 'after_setup_theme', 'quickpress_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function quickpress_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'quickpress' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'quickpress_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function quickpress_scripts() {
	wp_enqueue_style( 'quickpress-style', get_stylesheet_uri() );

	wp_enqueue_script( 'quickpress-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20120206', true );
	
		wp_enqueue_script( 'quickpress-animation', get_template_directory_uri() . '/js/animations.js', array('jquery'), '20120206', true );

//added localized script for my menu
	wp_localize_script( 'quickpress-navigation', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'quickpress' ),
		'collapse' => __( 'collapse child menu', 'quickpress' ),
	) );
  
	wp_enqueue_script( 'quickpress-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	//scrollmagic
	wp_enqueue_script('quickpress-gsap', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js');
  wp_enqueue_script('quickpress-scrollmagic', 'http://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js');
	wp_enqueue_script('quickpress-scrollmagic-debug', 'http://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js');
	wp_enqueue_script('quickpress-gsap-scroll', 'https://dl.dropboxusercontent.com/u/1090829/cdn/animation.gsap.js');
	
	
	//fontaweosme
	wp_enqueue_style('quickrpess-font-awesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');	
	
	//modernizr
	wp_enqueue_script('quickpress-modernizr', 'https://dl.dropboxusercontent.com/u/1090829/cdn/modernizr.custom.js');
	
		
		

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'quickpress_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';




/*--------------------------------------------------------------
#  get quickpress additions
--------------------------------------------------------------*/

require get_template_directory() . '/inc/quickpress_extras.php';



