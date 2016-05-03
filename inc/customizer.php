<?php
/**
 * quickpress Theme Customizer.
 *
 * @package quickpress
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function quickpress_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	


//added new section for quickpress

$wp_customize->add_section( 'qp_layout', array(
  'title' => __( 'QuickPress Options' ),
  'description' => __( 'change logo layout and menu' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  
) );



  //adding logo image
	$wp_customize->add_setting('your_theme_logo');
	
  // Add a control to upload the logo
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'your_theme_logo',
	array(
	'label' => 'Upload Logo',
	'section' => 'qp_layout',
	'settings' => 'your_theme_logo',
	) ) );

	//add theme logo placement setting
	$wp_customize->add_setting('logo_location');
	
	// Add a control to upload the logo
	$wp_customize->add_control('logo_location',
	array(
	'label' => 'place of logo',
	'section' => 'qp_layout',
	'settings' => 'logo_location',
	'type' => 'select',
	'choices'  => array(
			'left-logo'  => 'left',
			'right-logo' => 'right',
			'center-logo' => 'center',
	) ) ) ;
	
	
  //add nav wrap ability
  $wp_customize->add_setting('site_top_wrap');
  $wp_customize->add_control('site_top_wrap',
	array(
	'label' => 'wrap the logo and nav?',
	'section' => 'qp_layout',
	'settings' => 'site_top_wrap',
	'type' => 'select',
	'choices'  => array(
			'yes'  => 'yes',
			'no' => 'no',
			
	) ) ) ;
	
	//add front header
  $wp_customize->add_setting('qp_front_header', 
  array( 
  'default'=> 'header', 
  'sanitize_callback' => 'sanitize_text_field'
  ));
  
  $wp_customize->add_control('qp_front_header',
	array(
	'label' => 'front header pagename',
	'section' => 'qp_layout',
	'settings' => 'qp_front_header',
	) ) ;
	
	
	
	
		//add front footer
  $wp_customize->add_setting('qp_footer', 
  array( 
  'default'=> 'footer', 
  'sanitize_callback' => 'sanitize_text_field'
  ));
  
  $wp_customize->add_control('qp_footer',
	array(
	'label' => 'footer pagename',
	'section' => 'qp_layout',
	'settings' => 'qp_footer',
	) ) ;
  

}
add_action( 'customize_register', 'quickpress_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function quickpress_customize_preview_js() {
	wp_enqueue_script( 'quickpress_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'quickpress_customize_preview_js' );






