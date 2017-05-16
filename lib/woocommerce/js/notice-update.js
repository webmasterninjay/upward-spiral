jQuery(document).on( 'click', '.upward-spiral-woocommerce-notice .notice-dismiss', function() {

	jQuery.ajax({
	    url: ajaxurl,
	    data: {
	        action: 'upward_spiral_dismiss_woocommerce_notice'
	    }
	});

});
