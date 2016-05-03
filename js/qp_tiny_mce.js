
	  //add classes on to the editor so they can see an example of layout. This class doesnt get really get added on actual pages.
	  var val = '';
	  jQuery(document).ready( function($){ 
		  
		   val  = '' +  $('.qp_layout:checked').val();
		 
		  
		 setTimeout(function() { 
    
			 	$("#content_ifr").contents().find("#tinymce").addClass(val); 
			 }, 500); 
		  
       $('.qp_layout').on('click', function(ev) { 
	     
	       
	     $("#content_ifr").contents().find("#tinymce").removeClass(val); 
	       
       val = $(this).val();
     
     $("#content_ifr").contents().find("#tinymce").addClass(val);
     
		});
       
      
 		});
	