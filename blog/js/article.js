window.onload = function () {
	
	showArticleDetail();

};


function showArticleDetail() {
	
	var articleDetailDiv = document.getElementsByClassName("article-detail");

	var subString = "?id=";

	var id = parseInt(window.location.search.substr(subString.length));

	// id 小于0，就回去吧
	if (id <= 0) {
		console.log("no more");
		window.history.back(-1);
		return;
	}

	var innerHTML = '';

	var request = new XMLHttpRequest();
	request.open("GET", "assist/getArticle.php?articleid=" + id);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			if (request.status === 200) {
				var data = JSON.parse(request.responseText);
				
				if (!data.feedback) {
					// id 非法（查不到），也回去吧
					console.log("no more");
					window.history.back(-1);
					return;
				}

				/* show article */
				innerHTML += '<div class="article"><div class="block"><h3 class="title text-center">' + 
				data.feedback["title"] + '</h3><p class="date text-center">' + 
				data.feedback["date"] + '</p><div class="parting-line"></div><div class="content">' + 
				data.feedback["content"] + '</div><div class="parting-line"></div><div class="pre-next"><div class="pre">';

				if (data.feedback["pre"]["id"]) {
					innerHTML += '<a href="article.php?id=' + 
					data.feedback["pre"]["id"] + '"><span>上一篇：' + data.feedback["pre"]["title"] + '</span></a>';
				}

				innerHTML += '</div><div class="next text-right">';

				if (data.feedback["next"]["id"]) {
					innerHTML += '<a href="article.php?id=' + 
					data.feedback["next"]["id"] + '"><span>下一篇：' + data.feedback["next"]["title"] + '</span></a>';
				}

				innerHTML += '</div></div></div></div>';

				articleDetailDiv[0].innerHTML = innerHTML;

				document.title = data.feedback["title"];

			} else {
				console.log("ajax: 请求文章详细内容 失败" + request.status);
			}
		}
	}

}