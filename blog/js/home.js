
var currentWantedBlock = 1;   // int

/**
 * initialize showArticleBlock
 * @return {void} 
 */
window.onload = function () {

	showArticleBlock();

	if (document.addEventListener) {
		document.getElementsByClassName("showmore")[0].addEventListener("click", showMoreArticle);
	} else if (document.attachEvent) {
		document.getElementsByClassName("showmore")[0].attachEvent("onclick", showMoreArticle);	
	}
};


/**
 * request for article block from server
 * @return {void} 
 */
function showArticleBlock() {
	
	var articleBlockDiv = document.getElementsByClassName("article-block");

	var innerHTML = '';

	var request = new XMLHttpRequest();
	request.open("GET", "assist/getBlock.php?wantedblock=" + currentWantedBlock);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			if (request.status === 200) {
				var data = JSON.parse(request.responseText);

				if (!data.feedback) {
					console.log("没有更多文章啦！");
					return false;
				}

				/* insert innerhtml */
				data.feedback.forEach(function (value, index, array) {
					innerHTML += '<div class="article"><div class="block"><h3 class="title block-title"><a href="article.php?id=' + 
					array[index]["id"] + '"><span>' + 
					array[index]["title"] + '</span></a></h3><p class="date text-right">' + 
					array[index]["date"] + '</p><p class="introduction">' + 
					array[index]["introduction"] + ' </p></div></div>';
				});

				articleBlockDiv[0].innerHTML += innerHTML;
				return true;
			} else {
				console.log("ajax: 请求文章块 失败" + request.status);
				return false;
			}
		}
	};

}


/**
 * respond to the click of showmore
 * @return {void} 
 */
function showMoreArticle() {
	
	// 向服务器请求数据，新添加文章块
	
	currentWantedBlock++;

	var ret = showArticleBlock();

	console.log(typeof(ret));

	console.log("showMoreArticle: " + currentWantedBlock);

}
