<?php
	// header("Content-Type: text/plain;charset=utf-8");
	// header('Access-Control-Allow-Origin:*');
	// header('Access-Control-Allow-Methods:POST,GET');
	// header('Access-Control-Allow-Credentials:true'); 
	header("Content-Type: application/json;charset=utf-8"); 

	include_once './photo.group.php';

	$photoGroupObject = new PhotoGroup(4);					/* 传入分块数 */
	$showedGroupNum = 1;

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		getWantedGroup();
	}

	function getWantedGroup()
	{	
		$showedGroupNum = intval($_GET["wantedgroup"]);

		if ($showedGroupNum > $GLOBALS["photoGroupObject"]->getGroupNum()) {  /* 没有查询到 */
			echo json_encode("");
			return;
		}

		$photoGroupInfoArray =  $GLOBALS["photoGroupObject"]->getGroupInfo($showedGroupNum);    /* 传入想要的第几块的编码 */

		echo json_encode($photoGroupInfoArray);
	}
?>