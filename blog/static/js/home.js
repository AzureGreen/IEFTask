
require(['jquery', 'articleGroup', 'toTop', 'pressEffect'], function ($, articleGroup, toTop, pressEffect) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {

		articleGroup.showArticleGroup();

		pressEffect.init();

		$('.to-top').on('click', toTop.move);
		$(window).on('scroll', function() {
			toTop.hide(100);
		});
		toTop.hide(100);		

		/* add text to showmore btn */
		var showMore = $('.showmore');
		var showMoreSpan = showMore.children('span');
		showMore.on('click', articleGroup.showMoreArticle);
		showMoreSpan.html(showMoreSpan.data('article'));
	});
});
