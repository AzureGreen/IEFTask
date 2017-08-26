define(['jquery'], function ($) {

	var id = 0,

		invalidHandler = function () {
			console.log("no such");
			window.history.back(-1);
			return;
		},

		/**
		 * request for article block from server
		 * @return {void} 
		 */
		showArticleDetail = function (bAbout) {

			console.log(bAbout);
			/* handle id common & about */
			if (bAbout) {
				id = 0;
			} else {
				var subString = "?id=";

				if ((id = parseInt(window.location.search.substr(subString.length))) <= 0) {
					invalidHandler();
					return;
				}
			}

			console.log(id);

			$.ajax({
				url: 'assist/getArticle.php?articleid=' + id,
				type: 'GET',
				dataType: 'json',
			})
			.done(function(data) {
				
				if (!data) {
					invalidHandler();
					return;
				}

				let template = $('.ad-template').html();
				let temp = $(template);
				temp.find('.title').text(data["title"]);
				temp.find('.date').text(data["date"]);
				temp.find('span').text(data["view"]);
				temp.find('.content').html(data["content"]);

				if (data["pre"]["id"]) {
					temp.find('.pre').children('a').attr('href', 'article.php?id='+ data["pre"]["id"]);
					temp.find('.pre').children('a').children('span').text('上一篇：'+ data["pre"]["title"]);
				} else {
					temp.find('.pre').css('display', 'none');
				}

				if (data["next"]["id"]) {
					temp.find('.next').children('a').attr('href', 'article.php?id='+data["next"]["id"]);
					temp.find('.next').children('a').children('span').text('下一篇：'+data["next"]["title"]);
				} else {
					temp.find('.next').css('display', 'none');
				}

				$('.article-detail').append(temp);

				/* var innerHTML = ''; */
				/* show article */
				/* innerHTML += '<div class="article"><div class="block"><h2 class="title text-center">' + 
				data["title"] + '</h2><p class="text-center"><i class="fa fa-calendar"></i><time class="date">' + 
				data["date"] + '</time><i class="fa fa-eye"></i><span>' + 
				data["view"] + '</span></p><div class="content">' + 
				data["content"] + '</div><div class="pre-next"><div class="pre">'; 

				if (data["pre"]["id"]) {
					innerHTML += '<a href="article.php?id=' + 
					data["pre"]["id"] + '"><span>上一篇：' + data["pre"]["title"] + '</span></a>';
				}

				innerHTML += '</div><div class="next">';

				if (data["next"]["id"]) {
					innerHTML += '<a href="article.php?id=' + 
					data["next"]["id"] + '"><span>下一篇：' + data["next"]["title"] + '</span></a>';
				}

				innerHTML += '</div></div></div></div>';
				
				/* $('.article-detail').append(innerHTML); */
			})
			.fail(function(jqXHR, textStatus) {
				console.log("ajax: 请求文章详细内容 失败" + textStatus);
			});
		};

	return {
		showArticleDetail: showArticleDetail
	};
});