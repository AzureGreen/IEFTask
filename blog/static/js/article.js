
require(['jquery', 'articleDetail', 'pressEffect'], function ($, articleDetail, pressEffect) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {

		articleDetail.showArticleDetail(false);

		pressEffect.init();
	});
});
