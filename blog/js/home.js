
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

	var request = new XMLHttpRequest();
	request.open("POST", "assist/getBlock.php");
	var data = "wantedblock=" + currentWantedBlock;
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.send(data);
	request.onreadystatechange = function () {
		if (request.readyState === 4) {
			if (request.status === 200) {
				var data = JSON.parse(request.responseText);
				if (data.success) {
					
					/* insert innerhtml */
					data.msg.forEach(function (value, index, array) {
						articleBlockDiv[0].innerHTML += '<div class="article"><div class="block"><h3 class="article-title"><a href="article.php?id=' + 
						array[index]["id"] + '"><span>' + 
						array[index]["title"] + '</span></a></h3><h4 class="article-date">' + 
						array[index]["dateline"] + '</h4><p class="description">' + 
						array[index]["description"] + ' </p></div></div>';
					});
				} else {
					console.log(data.msg);
				}
			} else {
				console.log("ajax: 请求文章块 失败" + request.status);
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

	showArticleBlock();

	console.log("showMoreArticle: " + currentWantedBlock);

}
