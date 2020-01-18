(function($) {
	'use strict';
	
	$(document).ready(function(){
		// Add location button(s)
		$(document).on('click', '[href*="#add-location"]', function(e){
			e.preventDefault();
			$.post(ajaxurl, { 'action': 'add_post', 'post_type': 'location' }, function(response) { 
				// Append new row
				var row = response;
				$('.locations').append(row);
			});
		});

		// Delete location button(s)
		$(document).on('click', '[href*="#delete-location"]', function(e){
			e.preventDefault();
			var locationId = $(this).closest('.row').attr('data-post');
			$.post(ajaxurl, { 'action': 'delete_post', 'post_id': locationId }, function(response) { 
				// Remove row
				$('.locations [data-post=' + locationId + ']').remove();
			});
		});
	});
})(jQuery);
