<?php
	header("Content-Type: text/plain;charset=utf-8");
	header('Access-Control-Allow-Origin:*');
	header('Access-Control-Allow-Methods:POST,GET');
	header('Access-Control-Allow-Credentials:true'); 
	header("Content-Type: application/json;charset=utf-8"); 

	include_once './article.block.php';

	$artilceBlockObject = new ArtilceBlock(3);					/* 传入分块数 */
	$showedBlockNum = 1;

	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		
	} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		getWantedBlock();
	}

	function getWantedBlock()
	{	
		$showedBlockNum = $_POST["wantedblock"];

		if ($showedBlockNum > $GLOBALS["artilceBlockObject"]->getBlockNum()) {
			echo '{"success":false, "msg":"没有更多文章啦！"}';
			return;
		}

		$artilceBlockInfoArray =  $GLOBALS["artilceBlockObject"]->getBlockInfo($showedBlockNum);    /* 传入想要的第几块的编码 */

		$msg = "[";

		foreach ($artilceBlockInfoArray as $key => $value) {

			if ($artilceBlockInfoArray['0'] != $value) {
				$msg .= ',';
			}

			$msg .= '{
				"id":"'.$value["id"].'",
				"title":"'.$value["title"].'",
				"dateline":"'.$value["dateline"].'",
				"description":"'.$value["description"].'"
			}';
		}

		$msg .= "]";

		echo '{"success":true, "msg":' . $msg . '}';
		
	}


?>