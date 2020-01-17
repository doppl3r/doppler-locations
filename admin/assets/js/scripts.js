(function($) {
	'use strict';
	console.log('doppler-locator-admin.js');
	
	$(document).ready(function(){
		$('[href*="#add-location"]').on('click', function(e){
			e.preventDefault();
			$.post(ajaxurl, { 'action': 'add_post', 'post_type': 'location' }, function(response) { 
				console.log(response);
			});
		});
	});
})(jQuery);
