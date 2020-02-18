(function($) {
	'use strict';
	
	// Add toggle function for ".doppler-list"
	$(document).on('click', '.doppler-list [aria-selected]', function(e) {
		e.preventDefault();
		var attr = 'aria-selected';
		var ariaSelected = $(this).attr(attr);
		$(this).attr(attr, (ariaSelected == 'false' ? true : false)); // toggle true/false
	});

	// Add slider functionality
	$(document).ready(function(){
		if ($('.doppler-slider').length) {
			$('.doppler-slider').slick({ dots: true });
		}
	});
	
})(jQuery);
