<?php
	
	/*
		this page is used to display all archive headers except front page which uses the customizer header page you choose
		
		it uses pods so users can create and edit headers without opening the theme!
		a new post type of archiveheaders exists and you can set the archive post type and it will display at the top of an archive page.
		A featured image will also be used as the cover photo if they want.
		
		if you add a new post type. make sure to edit the archiveheader post type pod and add the new post type into the custom list.
		then just add a new post to archiveheaders and set te post type to the new type you created.
		
		if not using pods, you will have to create a switch case and go trhough each type if post type and output a seperate
		header for each one. Chagnges to header would happen here rather than in the harchives header post type.
		
		This file takes place OUTSIDE the loop.
		*/

?>

<header class="site-header">



<?php
	
	switch(true){
		
		case (is_post_type_archive() || is_home() ):
		
		
			$post_type = get_query_var('post_type');

			if( $post_type == ''){
			 	$post_type = 'post';
			 	}
			
			
			if( function_exists( 'pods' ) ) {
				if(! is_front_page() ){
					$archiveheaders = pods( 'archiveheader' ); //get pod of post type
				
					$params = array(
						  'limit' => 1,
					    'where' => '
					        header_for_which_archive.meta_value = "' . $post_type . '"
					    '
					);
				
					$archiveheaders->find( $params );
				
					while ( $archiveheaders->fetch() ) {
					
						  //var_dump($archiveheaders);
				  	  echo $archiveheaders->display ('post_content');
				  	  set_featured_as_cover_photo($archiveheaders->ID() );
				  	  
				  	  
				  	  edit_post_link(
							sprintf(
									/* translators: %s: Name of current post */
									esc_html__( 'Edit %s', 'quickpress' ),
									the_title( '<span class="screen-reader-text">"', '"</span>', false )
								),
								'<span class="edit-link">',
								'</span>', $archiveheaders->ID()
							);
							
							
				  	  
				  }
				}
			}
		
		break;
		
		
		
		
		
		default:
		
		break;
		
	}

?>

</header>



