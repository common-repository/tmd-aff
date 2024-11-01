
jQuery.noConflict();

jQuery( document ).ready( function($) {

   $(document).on ( 'click', '#check_asin', function( event ) {
      event.preventDefault();
      // kiểm tra event click
      $("#tmd_views_sd").empty();
      var my_asin = $("#TMD-asin").val();
      var data = {
             'action': 'sb_test_ajax',
             'my_asin': my_asin,
         };
		jQuery.ajax({  
	        type: "POST",  
	        url: ajaxurl,  
	        data : {
	        	action: 'sb_test_ajax', 
	        	asin : my_asin,
	        	// locale: jQuery('#ttu_locale').val()
	        },
	        beforeSend: function(msg){
				jQuery('.tmd-loading').show();
			},
	        success:function(response) {
				jQuery('.tmd-loading').hide();
	        	if( response.error == false) {
					jQuery('#TMD-price').val(response.price);
					jQuery('#TMD-rating').val(response.ratting);
					jQuery('#TMD-reviews').val(response.totalreviews);
					jQuery('#TMD-images').val(response.largeimage);
					jQuery('#TMD-time').val(response.time);
					jQuery(':radio[name=Aff_active][value="enable"]').prop('checked', true);
	        	} else {
	        		alert('123');
	        	}
	        },  
	        error: function(errorThrown){
	        }
	    });
   } ) // end event

} );
