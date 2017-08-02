<?php

	// header("Content-Type: text/plain;charset=utf-8");
	// header('Access-Control-Allow-Origin:*');
	// header('Access-Control-Allow-Methods:POST,GET');
	// header('Access-Control-Allow-Credentials:true'); 
	header("Content-Type: application/json;charset=utf-8"); 

	include_once './article.detail.php';

	$articleDetailObject = new ArticleDetail();

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		getArticleDetail(intval($_GET["articleid"]));
	} 

	function getArticleDetail($articleId)
	{
		/* first of all, update view */
		$GLOBALS["articleDetailObject"]->updateViewNum($articleId);  /* update view*/
		
		if ($articleId > 0) {
			$articleDetailInfo = $GLOBALS["articleDetailObject"]->getDetailInfo($articleId);  /* get content of article*/

			$articlePreInfo = $GLOBALS["articleDetailObject"]->getPreInfo($articleId);  /* get previous title of current article*/

			$articleNextInfo = $GLOBALS["articleDetailObject"]->getNextInfo($articleId);  /* get next title of current article*/
		} else {
			$articleDetailInfo = $GLOBALS["articleDetailObject"]->getAboutDetailInfo($articleId);  /* get content of about page*/
			$articlePreInfo = $articleNextInfo = null;
		}

		if (!$articleDetailInfo) {
			echo json_encode("");
			return;
		}

		/* if return null, showed that no pre or next */
		if (!$articlePreInfo) {
			$articlePreInfo[] = array("a_Id" => "", "a_Title" => "");
		}

		if (!$articleNextInfo) {
			$articleNextInfo[] = array("a_Id" => "", "a_Title" => "");
		}

		$item = array();
		$item["title"] = $articleDetailInfo[0]["title"];
		$item["date"] = $articleDetailInfo[0]["date"];
		$item["content"] = $articleDetailInfo[0]["content"];
		$item["view"] = $articleDetailInfo[0]["view"];
		$item["pre"] = $articlePreInfo[0];
		$item["next"] = $articleNextInfo[0];

		echo json_encode($item);
	}

?>