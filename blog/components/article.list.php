<?php

	$currentDir = dirname(__FILE__);

	include_once($currentDir.'\..\assist\article.block.php');    /* 因为跨文件夹了 */
 
	$blockObject = new ArtilceBlock(1, 2);

	$blockInfoArray = $blockObject->getBlockInfo();


?>


<div class="article-block">
	
	<?php
		foreach ($blockInfoArray as $key => $value) {
	?>
		<div class="article">
			<div class="block">
				<h3>
					<a href="article.detail.php?id=<?php echo $value["id"] ?>">
						<!-- 文章标题 --> 
						<?php echo $value["title"] ?>
					</a>
				</h3>
				<h4>
					<!-- 文章发布时间 -->
					<?php echo $value["dateline"] ?>
				</h4>
				<p>
					<!-- 文章简介 --> 
					<?php echo $value["description"] ?>
				</p>
			</div>
		</div>

		
	<?php
		}	
	?>

</div>

