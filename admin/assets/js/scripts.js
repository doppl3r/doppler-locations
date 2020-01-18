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

		// Add click listener for delete buttons
		$(document).on('click', '[href*="#delete"]', function(e){
			e.preventDefault();
			$(this).closest('label').addClass('disabled');
			$(this).closest('.options').append('<label class="small"><a href="#cancel">Cancel</a></label>');
			$(this).closest('.options').append('<label class="small"><a href="#confirm">Confirm</a></label>');
		});

		// Cancel deletion
		$(document).on('click', '[href*="#cancel"]', function(e){
			e.preventDefault();
			$(this).closest('.options').find('[href*="location"]').closest('label').removeClass('disabled');
			$(this).closest('.options').find('[href*="confirm"]').closest('label').remove();
			$(this).closest('.options').find('[href*="cancel"]').closest('label').remove();
		});

		// Delete locations with confirmation
		$(document).on('click', '[href*="#confirm"]', function(e){
			e.preventDefault();
			var locationId = $(this).closest('.row').attr('data-post');
			$.post(ajaxurl, { 'action': 'delete_post', 'post_id': locationId }, function(response) { 
				// Remove row
				$('.locations [data-post=' + locationId + ']').remove();
			});
		});
	});
})(jQuery);
