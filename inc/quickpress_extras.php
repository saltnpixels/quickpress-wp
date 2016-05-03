<?php 




/*--------------------------------------------------------------
# use featured image as cover photo inside site-header
--------------------------------------------------------------*/
//used on a sinlge or page. just pop it in before the article and it will add the featured image as a header above.

function set_featured_as_cover_photo( $id = '', $class= '.site-header'){
	echo( "<style>
							$class{
						background: url('" . get_the_post_thumbnail_url( $id, 'full') . "');	
						background-size: cover;
						background-position: center center;
					}
				</style>
					
				");
		}


	
/*--------------------------------------------------------------
# allowing svg upload for logo in customizer
--------------------------------------------------------------*/

//quickpress add svg as logo allowed in uploader
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


//add year shortcode for something like copyright in footer inside editor
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');




/*--------------------------------------------------------------
# // adding editor buttons
--------------------------------------------------------------*/
function quickpress_mce_buttons($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'quickpress_mce_buttons');


/* 
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats( $init_array ) {  

// Define the style_formats array

	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'breakout',  
			'block' => 'div',  
			'classes' => 'break-out',
			'wrapper' => true,
			  
		),
		array(  
			'title' => 'full-area',  
			'block' => 'div',  
			'classes' => 'break-out-full',
			'wrapper' => true,
			  
		),
		array(  
			'title' => 'code',  
			'inline' => 'code',  
			'classes' => 'language-php',
			'wrapper' => true,
			  
		) 
		
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 



/*--------------------------------------------------------------
# adding meta box for layout width on pages
--------------------------------------------------------------*/

/* Fire our meta box setup function on the post editor screen only. */
add_action( 'load-post.php', 'quickpress_meta_boxes_setup' );
add_action( 'load-post-new.php', 'quickpress_meta_boxes_setup' );


/* Meta box setup function. */
function quickpress_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'quickpress_add_post_meta_boxes' );
  
  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'quickpress_layout_save_post_meta', 10, 2 );
}


//add more meta boxes here

function quickpress_add_post_meta_boxes() {

  add_meta_box(
    'quickpress_layout_type',      // Unique ID
    esc_html__( 'Layout Type', 'quickpress' ),    // Title
    'quickpress_layout_meta_box',   // Callback function
    'page',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
}


/* Display the post meta box for layout */
function quickpress_layout_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'quickpress_layout_nonce' ); ?>
  
   <?php $value = get_post_meta( $object->ID, 'quickpress_layout_type', true ); 
	 
	   if ($value == '')
	   		$value = esc_html__( 'none', 'quickpress' );  //default value of none
	   ?>

  <p>
    <label for="quickpress_layout"><?php _e( "Choose the quickpress width of your page.", 'quickpress' ); ?></label>
    <br />
    
    <input class="qp_layout" type="radio" name="quickpress_layout_type" id="quickpress_layout" value="<?php 
echo esc_html__( 'none', 'quickpress'); ?> "<?php checked( $value, esc_html__( 'none', 'quickpress' )); ?>  size="30" />  <?php echo esc_html__( 'none (full screen)', 'quickpress'); ?> <br />
   
   <input class="qp_layout" type="radio" name="quickpress_layout_type" id="quickpress_layout" value="<?php echo
esc_html__( 'wrap', 'quickpress'); ?>" <?php checked( $value, esc_html__( 'wrap', 'quickpress' )); ?> size="30"  />  <?php echo esc_html__( 'wrap (large)', 'quickpress'); ?> <br />

	<input class="qp_layout" type="radio" name="quickpress_layout_type" id="quickpress_layout" value="<?php echo
esc_html__( 'content-column', 'quickpress'); ?>" <?php checked( $value, esc_html__( 'content-column', 'quickpress' )); ?> size="30" />  <?php echo esc_html__( 'content-column (small)', 'quickpress'); ?>

  </p>
  
    
<?php }
	
	
	/* Save the meta box's post metadata. */
function quickpress_layout_save_post_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['quickpress_layout_nonce'] ) || !wp_verify_nonce( $_POST['quickpress_layout_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['quickpress_layout_type'] ) ? sanitize_html_class( $_POST['quickpress_layout_type'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'quickpress_layout_type';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}



/*--------------------------------------------------------------
# tiny mce javascript to make meta box have scripts to toggle chagnges on editor right away.
--------------------------------------------------------------*/


add_action( 'after_wp_tiny_mce', 'custom_after_wp_tiny_mce' );
function custom_after_wp_tiny_mce() {
	
    printf( '<script type="text/javascript" src="%s"></script>',  get_template_directory_uri() . '/js/qp_tiny_mce.js' );
}


/*--------------------------------------------------------------
# editor styles to add to mce editor
--------------------------------------------------------------*/

function quickpress_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'quickpress_add_editor_styles' );







/*--------------------------------------------------------------
# other users on the site
--------------------------------------------------------------*/
function check_user_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
	$user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
	return false;
 
    return in_array( $role, (array) $user->roles );
}


// !disable admin bar. most ppl dont want subscribers getting anywhere
function disable_admin_bar() { 
	if( check_user_role('subscriber') )
		add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'disable_admin_bar' );
 
 
 /**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
function redirect_admin(){
	if( check_user_role('subscriber') ){
		wp_redirect( site_url() );
		exit;		
	}
}
add_action( 'admin_init', 'redirect_admin' );



//add login to nav menu. wordpress example doesnt work! needed to play with it. login menu item added!
//set to not run. turn on by uncommenting below

//add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if ($args->theme_location == 'primary') {
         $loginout = '<li class="nav-menu menu-item loginout">' . wp_loginout($_SERVER['REQUEST_URI'], false ) . '</li>';
    $items .= $loginout;
    return $items;
    }
  else
   return $items; 
}
