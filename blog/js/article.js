
window.onload = function () {
	
	showArticleDetail();


};


function showArticleDetail() {
	
	var articleDetailDiv = document.getElementsByClassName("article-detail");

	var subString = "?id=";

	var id = window.location.search.substr(subString.length);

	var innerHTML = '';

	var request = new XMLHttpRequest();
	request.open("POST", "assist/getArticle.php");
	var data = "articleid=" + id;
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			if (request.status === 200) {
				var data = JSON.parse(request.responseText);
				if (data.success) {
					
					/* show article */
					innerHTML += '<div class="article"><div class="block"><h2 class="title">' + 
					data.msg["title"] + '</h2><h4 class="date">' + 
					data.msg["dateline"] + '</h4><div class="parting-line"></div><div class="content">' + 
					data.msg["content"] + '</div><div class="parting-line"></div><div class="pre-next"><div class="pre">';

					if (data.msg["pre"]["id"]) {
						innerHTML += '<a href="article.php?id=' + 
						data.msg["pre"]["id"] + '"><span>上一篇：' + data.msg["pre"]["title"] + '</span></a>';
					}

					innerHTML += '</div><div class="next">';

					if (data.msg["next"]["id"]) {
						innerHTML += '<a href="article.php?id=' + 
						data.msg["next"]["id"] + '"><span>下一篇：' + data.msg["next"]["title"] + '</span></a>';
					}

					innerHTML += '</div></div></div></div>';

					articleDetailDiv[0].innerHTML = innerHTML;

					document.title = data.msg["title"];

				} else {
					alert(data.msg);
				}
			} else {
				console.log("ajax: 请求文章详细内容 失败" + request.status);
			}
		}
	}

}