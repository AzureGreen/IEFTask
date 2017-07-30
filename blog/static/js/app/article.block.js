define(['jquery'], function ($) {

	var currentWantedBlock = 1,    /* int */
		
		bNoMore = false,           /* bool */
		
		/**
		 * request for article block from server
		 * @return {void} 
		 */
		showArticleBlock = function () {

			$.ajax({
				url: 'assist/getBlock.php?wantedblock=' + currentWantedBlock,
				type: 'GET',
				dataType: 'json',
				
			})
			.done(function(data) {
				
				if (!data.length) {
					bNoMore = true;
					return;
				}

				var innerHTML = '';
				/* insert innerhtml */
				data.forEach(function (value, index, array) {
					innerHTML += '<div class="article"><div class="block"><h2 class="title block-title"><a href="article.php?id=' + 
					array[index]["id"] + '"><span>' + 
					array[index]["title"] + '</span></a></h2><p class="text-right"> \
					<i class="fa fa-calendar"></i><time class="date">' + 
					array[index]["date"] + '</time><i class="fa fa-eye"></i><span>' + 
					array[index]["view"] + '</span></p>\
					<p class="introduction">' + 
					array[index]["introduction"] + ' </p></div></div>';
				});
				
				$('.article-block').append(innerHTML);
			})
			.fail(function(jqXHR, textStatus) {
				console.log("ajax: 请求文章块 失败" + textStatus);
			});
		},

		/**
		 * respond to the click of showmore
		 * @return {void} 
		 */
		showMoreArticle = function () {
			/* 向服务器请求数据，新添加文章块 */
			if (!bNoMore) {
				currentWantedBlock++;

				showArticleBlock();

				console.log("showMoreArticle: " + currentWantedBlock);
			} else {
				console.log("No more articles");
			}
		};

	return {

		showArticleBlock: showArticleBlock,

		showMoreArticle: showMoreArticle
	};
});