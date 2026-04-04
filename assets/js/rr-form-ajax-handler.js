jQuery( document ).ready( function( $ ) {

        "use strict";
	/**
         * The file is enqueued from inc/admin/class-admin.php.
	 */        
        $( '#new_rr_sp_form_id' ).submit( function( event ) {
            
            event.preventDefault(); // Prevent the default form submit.            
            
            // serialize the form data
            var ajax_form_data = $("#new_rr_sp_form_id").serialize();
            
            //add our own ajax check as X-Requested-With is not always reliable
            ajax_form_data = ajax_form_data+'&ajaxrequest=true&submit=Submit+Form';
            
            $.ajax({
                url:    params.ajaxurl, // domain/wp-admin/admin-ajax.php
                type:   'post',                
                data:   ajax_form_data
            })
            
            .done( function( response ) { // response from the PHP action
                $(" #rr_sp_response ").html( "<h2>The request was successful </h2><br>" + response );
            })
            
            // something went wrong  
            .fail( function() {
                $(" #rr_sp_response ").html( "<h2>Something went wrong.</h2><br>" );                  
            })
        
            // after all this time?
            .always( function() {
                event.target.reset();
            });
        
       });
        
});