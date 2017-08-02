
require(['jquery', 'photoInfo', 'toTop', 'pressEffect'], function ($, photoInfo, toTop, pressEffect) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {

		photoInfo.showPhotoBlock();

		pressEffect.init();

		$('.to-top').on('click', toTop.move);
		$(window).on('scroll', function() {
			toTop.hide(100);
		});
		toTop.hide(100);		

		/* pop-up, to show big img */
		popUp = $('.pop-up');

		$('.time-line').on({
			mouseover: function (event) {
				event.preventDefault();
				console.log('1');
				let imgElement = event.toElement;
				photoInfo.setPopupImg(imgElement.src, imgElement.alt);
			},
			click: function (event) {
				event.preventDefault();
				photoInfo.popupImage(true);
			}
		}, 'img');

		popUp.on('click', function(event) {
			event.preventDefault();
			photoInfo.popupImage(false);
		});
		
		/* add text to showmore btn */
		var showMore = $('.showmore');
		var showMoreSpan = showMore.children('span');
		showMore.on('click', photoInfo.showMorePhoto);
		showMoreSpan.html(showMoreSpan.data('photo'));
	});
});
