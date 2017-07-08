<?php

	header("Content-Type: text/plain;charset=utf-8");
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods:POST,GET');
	header('Access-Control-Allow-Credentials:true'); 
	header("Content-Type: application/json;charset=utf-8"); 

	include_once './article.detail.php';

	$articleDetailObject = new ArticleDetail();

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		
	} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		getArticleDetail($_POST["articleid"]);
	}

	function getArticleDetail($articleId)
	{
		$articleDetailInfo = $GLOBALS["articleDetailObject"]->getDetailInfo($articleId);  /* get content of article*/

		$articlePreInfo = $GLOBALS["articleDetailObject"]->getPreInfo($articleId);  /* get previous title of current article*/

		$articleNextInfo = $GLOBALS["articleDetailObject"]->getNextInfo($articleId);  /* get next title of current article*/

		/* if return null, showed that no pre or next */
		if (!$articlePreInfo) {
			$articlePreInfo[] = array("id" => "", "title" => "");
		}

		if (!$articleNextInfo) {
			$articleNextInfo[] = array("id" => "", "title" => "");
		}

		$msg = '{
			"title":"'.$articleDetailInfo[0]["title"].'",
			"dateline":"'.$articleDetailInfo[0]["dateline"].'",
			"content":"'.$articleDetailInfo[0]["content"].'",
			"pre":{
				"id":"'.$articlePreInfo[0]["id"].'",
				"title":"'.$articlePreInfo[0]["title"].'"
			},
			"next":{
				"id":"'.$articleNextInfo[0]["id"].'",
				"title":"'.$articleNextInfo[0]["title"].'"
			}
		}';

		echo '{"success":true, "msg":' . $msg . '}';
	}

?>