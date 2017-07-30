
require(['jquery', 'articleDetail', 'pressEffect'], function ($, articleDetail, pressEffect) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {

		articleDetail.showArticleDetail(true);

		pressEffect.init();
	});
});
