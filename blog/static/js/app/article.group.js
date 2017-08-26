define(['jquery'], function ($) {

	var currentWantedGroup = 1,    /* int */
		
		bNoMore = false,           /* bool */
		
		/**
		 * request for article group from server
		 * @return {void} 
		 */
		showArticleGroup = function () {

			$.ajax({
				url: 'assist/getGroup.php?wantedgroup=' + currentWantedGroup,
				type: 'GET',
				dataType: 'json',
				
			})
			.done(function(data) {
				
				if (!data.length) {
					bNoMore = true;
					return;
				}

				/* var innerHTML = ''; */
				/* insert innerhtml */
				data.forEach(function (value, index, array) {
					
					let template = $('.ab-template').html();
					let temp = $(template);
					temp.find('.title').children('a').attr('href', 'article.php?id='+array[index]["id"]);
					temp.find('.title').children('a').children('span').text(array[index]["title"]);
					temp.find('.date').text(array[index]["date"]);
					temp.find('.introduction').text(array[index]["introduction"]);

					$('.article-block').append(temp);

					/*innerHTML += '<div class="article"><div class="block"><h2 class="title block-title"><a href="article.php?id=' + 
					array[index]["id"] + '"><span>' + 
					array[index]["title"] + '</span></a></h2><p class="text-right"> \
					<i class="fa fa-calendar"></i><time class="date">' + 
					array[index]["date"] + '</time></p>\
					<p class="introduction">' + 
					array[index]["introduction"] + ' </p></div></div>';	*/


				});
				
				/* $('.article-block').append(innerHTML); */
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
				currentWantedGroup++;

				showArticleGroup();

				console.log("showMoreArticle: " + currentWantedGroup);
			} else {
				console.log("No more articles");
			}
		};

	return {

		showArticleGroup: showArticleGroup,

		showMoreArticle: showMoreArticle
	};
});