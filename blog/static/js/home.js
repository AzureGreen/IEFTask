
require(['jquery', 'articleBlock', 'pressEffect'], function ($, articleBlock, pressEffect) {

	/**
	 * initialize sth
	 * @return {void} 
	 */
	$(document).ready(function () {

		articleBlock.showArticleBlock();

		pressEffect.init();

		$('.showmore').on('touchend click', articleBlock.showMoreArticle);
	});
});
