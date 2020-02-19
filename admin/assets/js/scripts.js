(function($) {
	'use strict';

	$(document).ready(function(){
		// Show document when ready
		$('.doppler-body').removeClass('loading');

		// Add post meta drag and drop functionality for reordering
		$('.doppler-body .post-meta-group').sortable({ axis: "y" });

		// Add post button(s)
		$(document).on('click', '.doppler-body [href*="add-location"], .doppler-body [href*="add-template"]', function(e){
			e.preventDefault();
			// var postType = $(this).attr('href').split("-")[1];
			var postType = $(this).attr('value');
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': 'add_post', 'post_type': postType }, function(response) { 
				// Append new row
				var row = response;
				$('.posts').append(row);
				$('.doppler-body').removeClass('loading');
			});
		});

		// Add trash action
		$(document).on('click', '.doppler-body [href*="trash-post"]', function(e){
			e.preventDefault();
			var postId = $(this).closest('.row').attr('data-post');
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': 'trash_post', 'post_id': postId }, function(response) { 
				// Remove row
				$('.doppler-body').removeClass('loading');
				$('.posts [data-post=' + postId + ']').remove();
			});
		});

		// Add restore action
		$(document).on('click', '.doppler-body [href*="restore-post"]', function(e){
			e.preventDefault();
			var postId = $(this).closest('.row').attr('data-post');
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': 'restore_post', 'post_id': postId }, function(response) { 
				// Remove row
				$('.doppler-body').removeClass('loading');
				$('.posts [data-post=' + postId + ']').remove();
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

		// Save content dynamically
		$(document).on('click', '.doppler-body [href*="save"]', function(e){
			e.preventDefault();

			// Initialize variables for POST action
			var action = '';
			var data = '';
			var href = $(this).attr('href');
			var postType = href.substring(href.indexOf('-') + 1);

			// Define action type from button href
			if (postType == 'location') action = 'save_all_post_content';
			else if (postType == 'template') {
				window.htmlEditor.save(); // Save editor to textarea
				action = 'save_template';
			}

			// Serialize data from from
			data = $('.doppler-body form').serialize();

			// Perform ajax POST call
			$('.doppler-body').addClass('loading');
			$.post(ajaxurl, { 'action': action, 'data': data }, function(response) { 
				// Append new row
				$('.doppler-body').removeClass('loading');
				//console.log(response);
			});
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
				elem.closest('.container').find('.post-meta-group').append(row);
				$('.doppler-body').removeClass('loading');

				// Add listener to date range picker
				addDateRangePicker(); 
				updatePostOptions();
			});
		});

		// Delete post meta rows (ex: custom posts, links etc.)
		$(document).on('click', '.doppler-body [href*="delete-post-meta"]', function(e){
			e.preventDefault();
			$(this).closest('.post-meta').remove();
			updatePostOptions();
		});

		// Add tab click functionality
		$(document).on('click', '.doppler-body .tabs .tab', function(e){
			e.preventDefault();
			selectTab($(this).index(), $(this));
		});

		// Add rearrange function for post-meta types
		$(document).on('click', '.doppler-body [href*="order-post-meta"]', function (e) {
			e.preventDefault();
			var href = $(this).attr('href');
			var direction = href.substring(href.indexOf('meta') + 5);
			var row = $(this).closest('.post-meta');

			// update by direction
			if (direction == 'up') row.insertBefore(row.prev());
			else if (direction == 'down') row.insertAfter(row.next());
		});

		// Add media button
		$(document).on('click', '.doppler-body .upload_media_button', function (e) {
			e.preventDefault();
			var row = $(this).closest('.post-meta');
	  
			// Create the media frame.
			var file_frame = wp.media.frames.file_frame = wp.media({
			   title: 'Select or upload media',
			   button: { text: 'Select' },
			   multiple: false
			});
	  
			// When an image is selected, run a callback.
			file_frame.on('select', function () {
				var attachment = file_frame.state().get('selection').first().toJSON();
				var type = attachment.url.substring(attachment.url.lastIndexOf('.') + 1);
				row.find('.thumbnail div').attr("style", "background-image: url('" + attachment.url + "');");
				row.find('.thumbnail div').attr("data-type", type);
				row.find('.thumbnail div').html(type);
				row.find('[name*="medium_post_id"]').val(attachment.id);
				row.find('[name*="medium_url"]').val(attachment.url);
				updatePostOptions();
			});
			
			// Predefine selected
			file_frame.on('open', function() {
				var selection = file_frame.state().get('selection');
				var selected = row.find('[name*="medium_post_id"]').val();
				if (selected) {
					selection.add(wp.media.attachment(selected));
				}
			});

			// Finally, open the modal
			file_frame.open();
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

		function addDateRangePicker() {
			// Add datepicker functionality
			$('.doppler-body [name*="date"]').datepicker({
				changeMonth: true,
				changeYear: true
			});
		}

		function updatePostOption(plural, singular, targetKey, targetValue) {
			// Create a list of options
			var options = {};
			$('.container.' + plural + ' .post-meta').each(function(i, item) {
				var key = $(item).find('[name*="' + singular + '_' + targetKey + '"]').val();
				var value = $(item).find('[name*="' + singular + '_' + targetValue + '"]').val();
				options[key] = value;
			});

			// Update post link options
			$('[name*="custom_post_' + singular + '"]').each(function(i, select) {
				$(select).empty();
				$(select).append('<option value="none">none</option>');
				var selectValue = $(select).attr('data');
				for (var key in options) {
					var optionValue = options[key];
					var option = $("<option></option>").attr("value", optionValue);
					if (selectValue == optionValue) option.attr('selected', 'selected');
					option.text(key);
					$(select).append(option);
				}
			});
		}

		function updatePostOptions() {
			updatePostOption('media', 'medium', 'post_id', 'post_id');
		}

		// Initialize admin page
		selectTab();
		addDateRangePicker();
		updatePostOptions();
	});
})(jQuery);
