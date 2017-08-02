
require(['jquery', 'articleDetail', 'toTop', 'pressEffect'], function ($, articleDetail, toTop, pressEffect) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {

		articleDetail.showArticleDetail(true);

		pressEffect.init();

		$('.to-top').on('click', toTop.move);
		$(window).on('scroll', function() {
			toTop.hide(100);
		});
		toTop.hide(100);
	});
});
