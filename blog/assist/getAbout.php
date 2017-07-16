<?php

	header("Content-Type: text/plain;charset=utf-8");
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods:POST,GET');
	header('Access-Control-Allow-Credentials:true'); 
	header("Content-Type: application/json;charset=utf-8"); 

	include_once './about.detail.php';

	$aboutDetailObject = new AboutDetail();

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		getAboutDetail(intval($_GET["about"]));
	} 

	function getAboutDetail($articleId)
	{
		if ($articleId != 0) {
			echo json_encode("");
			return;
		}

		/* first of all, update view */
		$GLOBALS["aboutDetailObject"]->updateViewNum();  /* update view*/
		
		$aboutDetailInfo = $GLOBALS["aboutDetailObject"]->getDetailInfo();  /* get content of article*/

		if (!$aboutDetailInfo) {
			//echo '{"feedback":""}';
			echo json_encode("");
			return;
		}

		$item = array();
		$item["title"] = $aboutDetailInfo[0]["title"];
		$item["date"] = $aboutDetailInfo[0]["date"];
		$item["content"] = $aboutDetailInfo[0]["content"];
		$item["view"] = $aboutDetailInfo[0]["view"];

		echo json_encode($item);
		//echo json_encode("");
	}
?>