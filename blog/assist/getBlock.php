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
		getWantedBlock();
	}

	function getWantedBlock()
	{	
		$showedBlockNum = intval($_GET["wantedblock"]);

		if ($showedBlockNum > $GLOBALS["artilceBlockObject"]->getBlockNum()) {
			echo '{"feedback":""}';
			return;
		}

		$artilceBlockInfoArray =  $GLOBALS["artilceBlockObject"]->getBlockInfo($showedBlockNum);    /* 传入想要的第几块的编码 */

		$feedback = "[";

		foreach ($artilceBlockInfoArray as $key => $value) {

			if ($artilceBlockInfoArray['0'] != $value) {
				$feedback .= ',';
			}

			$feedback .= '{
				"id":"'.$value["a_Id"].'",
				"title":"'.$value["a_Title"].'",
				"date":"'.$value["a_Date"].'",
				"introduction":"'.$value["a_Introduction"].'"
			}';
		}

		$feedback .= "]";

		echo '{"feedback":' . $feedback . '}';
		
	}


?>