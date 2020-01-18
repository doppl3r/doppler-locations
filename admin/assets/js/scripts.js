(function($) {
	'use strict';
	
	$(document).ready(function(){
		// Add post button(s)
		$(document).on('click', '.doppler-body [href*="add"]', function(e){
			e.preventDefault();
			var postType = $(this).attr('href').split("-")[1];
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': 'add_post', 'post_type': postType }, function(response) { 
				// Append new row
				var row = response;
				$('.posts').append(row);
				$('.doppler-body').removeClass('loading');
			});
		});

		// Add click listener for delete buttons
		$(document).on('click', '.doppler-body [href*="delete"]', function(e){
			e.preventDefault();
			$(this).closest('label').addClass('disabled');
			$(this).closest('.options').append('<label class="small"><a href="cancel">Cancel</a></label>');
			$(this).closest('.options').append('<label class="small"><a href="confirm">Confirm</a></label>');
		});

		// Cancel deletion
		$(document).on('click', '.doppler-body [href*="cancel"]', function(e){
			e.preventDefault();
			$(this).closest('.options').find('[href*="delete"]').closest('label').removeClass('disabled');
			$(this).closest('.options').find('[href*="confirm"]').closest('label').remove();
			$(this).closest('.options').find('[href*="cancel"]').closest('label').remove();
		});

		// Delete posts with confirmation
		$(document).on('click', '.doppler-body [href*="confirm"]', function(e){
			e.preventDefault();
			var postId = $(this).closest('.row').attr('data-post');
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': 'delete_post', 'post_id': postId }, function(response) { 
				// Remove row
				$('.doppler-body').removeClass('loading');
				$('.posts [data-post=' + postId + ']').remove();
			});
		});
	});
})(jQuery);
