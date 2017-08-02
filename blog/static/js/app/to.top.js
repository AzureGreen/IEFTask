define(['jquery'], function ($) {
	
	var move = function () {
			var el = $('html, body');
			/* move only when not at top & not animating */
			if ($(window).scrollTop() != 0) {
				if (!el.is(':animated')) {
					el.animate({scrollTop: 0}, 400);
				}
			}
		},

		hide = function (pos) {
			
			if ($(window).scrollTop() > pos) {
				$('.to-top').fadeIn(200);
			} else {
				$('.to-top').fadeOut(200);
			}
		};

	return {
		move: move,
		hide: hide
	};


});