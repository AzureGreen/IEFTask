<?php

	header("Content-Type: text/plain;charset=utf-8");
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods:POST,GET');
	header('Access-Control-Allow-Credentials:true'); 
	header("Content-Type: application/json;charset=utf-8"); 

	include_once './article.detail.php';

	$articleDetailObject = new ArticleDetail();

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		getArticleDetail(intval($_GET["articleid"]));
	} 

	function getArticleDetail($articleId)
	{
		$articleDetailInfo = $GLOBALS["articleDetailObject"]->getDetailInfo($articleId);  /* get content of article*/

		$articlePreInfo = $GLOBALS["articleDetailObject"]->getPreInfo($articleId);  /* get previous title of current article*/

		$articleNextInfo = $GLOBALS["articleDetailObject"]->getNextInfo($articleId);  /* get next title of current article*/

		if (!$articleDetailInfo) {
			echo '{"feedback":""}';
			return;
		}

		/* if return null, showed that no pre or next */
		if (!$articlePreInfo) {
			$articlePreInfo[] = array("a_Id" => "", "a_Title" => "");
		}

		if (!$articleNextInfo) {
			$articleNextInfo[] = array("a_Id" => "", "a_Title" => "");
		}

		$feedback = '{
			"title":"'.$articleDetailInfo[0]["a_Title"].'",
			"date":"'.$articleDetailInfo[0]["a_Date"].'",
			"content":"'.$articleDetailInfo[0]["a_Content"].'",
			"pre":{
				"id":"'.$articlePreInfo[0]["a_Id"].'",
				"title":"'.$articlePreInfo[0]["a_Title"].'"
			},
			"next":{
				"id":"'.$articleNextInfo[0]["a_Id"].'",
				"title":"'.$articleNextInfo[0]["a_Title"].'"
			}
		}';

		echo '{"feedback":' . $feedback . '}';
	}

?>