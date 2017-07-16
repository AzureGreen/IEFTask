window.onload = function () {
	
	showArticleDetail();

};


function showArticleDetail() {
	
	var articleDetailDiv = document.getElementsByClassName("article-detail");

	var id = 0;

	var innerHTML = '';

	var request = new XMLHttpRequest();
	request.open("GET", "assist/getAbout.php?about=" + id);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			if (request.status === 200) {
				var data = JSON.parse(request.responseText);
				
				if (!data) {
					// id 非法（查不到），也回去吧
					console.log("no more");
					window.history.back(-1);
					return;
				}

				/* show article */
				innerHTML += '<div class="article"><div class="block"><h2 class="title text-center">' + 
				data["title"] + '</h2><p class="text-center"> \
				<i class="fa fa-calendar"></i><time class="date">' + 
				data["date"] + '</time><i class="fa fa-eye"></i><span>' + 
				data["view"] + '</span></p><div class="content">' + 
				data["content"] + '</div>';

				
				innerHTML += '</div></div>';

				articleDetailDiv[0].innerHTML = innerHTML;

				document.title = data["title"];

			} else {
				console.log("ajax: 请求文章详细内容 失败" + request.status);
			}
		}
	}
}