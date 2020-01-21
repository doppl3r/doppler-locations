(function($) {
	'use strict';

	$(document).ready(function(){
		// Show document when ready
		$('.doppler-body').removeClass('loading');

		// Add post button(s)
		$(document).on('click', '.doppler-body [href*="add-location"], .doppler-body [href*="add-template"]', function(e){
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

		// Add delete confirmation
		$(document).on('click', '.doppler-body [href*="delete-post"]', function(e){
			e.preventDefault();
			$(this).closest('label').addClass('disabled');
			$(this).closest('.options').append('<label class="small"><a href="cancel">Cancel</a></label>');
			$(this).closest('.options').append('<label class="small"><a href="confirm">Confirm</a></label>');
		});

		// Cancel post deletion
		$(document).on('click', '.doppler-body [href*="cancel"]', function(e){
			e.preventDefault();
			$(this).closest('.options').find('[href*="delete"]').closest('label').removeClass('disabled');
			$(this).closest('.options').find('[href*="confirm"]').closest('label').remove();
			$(this).closest('.options').find('[href*="cancel"]').closest('label').remove();
		});

		// Delete posts when confirmation is clicked
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

		// Save posts
		$(document).on('click', '.doppler-body [href*="save"]', function(e){
			e.preventDefault();
			$('.doppler-body').addClass('loading');
			$('.doppler-body form').submit();
		});

		// Add post meta rows (ex: custom posts, links etc.)
		$(document).on('click', '.doppler-body [href*="add-post-meta"]', function(e){
			e.preventDefault();
			var elem = $(this);
			var href = $(this).attr('href');
			var pm_type = href.substring(href.indexOf('meta') + 5);
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': 'add_meta_row', 'pm_type': pm_type }, function(response) { 
				// Append new row
				var row = response;
				console.log(response);
				elem.closest('.container').find('.post-meta-group').append(row);
				$('.doppler-body').removeClass('loading');
			});
		});

		// Delete post meta rows (ex: custom posts, links etc.)
		$(document).on('click', '.doppler-body [href*="delete-post-meta"]', function(e){
			e.preventDefault();
			$(this).closest('.post-meta').remove();
		});

		// Add tab click functionality
		$(document).on('click', '.doppler-body .tabs .tab', function(e){
			e.preventDefault();
			selectTab($(this).index(), $(this));
		});

		function selectTab(index, elem) {
			var containers = $('.doppler-body .containers .container');
			var tabs = $('.doppler-body .tabs .tab');
			var tab = $('[name="tab"]');

			// Use form default value if not clicked
			if (index == null) index = tab.val();
			if (elem == null) elem = tabs.eq(index);
			
			// Deactivate all tabs/containers
			containers.removeClass('active');
			tabs.removeClass('active')

			// Activate tabs and update form value
			containers.eq(index).addClass('active');
			elem.addClass('active');
			tab.val(index);
		}

		// Activate default tab/container
		selectTab();
	});
})(jQuery);
