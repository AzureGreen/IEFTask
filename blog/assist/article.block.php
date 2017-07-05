<?php

	include_once 'database.php';
	
	/**
	* a class manage block of articles
	*/
	class ArtilceBlock
	{
		private $articleNum = null;   // 文章总数
		private $blockNum = null;     // 文章分块数
		private $blockSize = null;    // 每一分块有多少篇文章

		private $currentBlock = null;    // 指示当前获取、显示哪一块
		
		private $blockInfoArray = null;

		private $dbObject = null;

		function __construct($currentBlock, $blockSize)
		{
			$this->currentBlock = $currentBlock;
			$this->blockSize = $blockSize;

			$this->dbObject = new Database();  // 创建数据库对象并连接数据库

			if (!$this->dbObject) {
				echo "创建数据库连接错误";
				exit;
			}

			if (!$this->dbObject->getConnect()) {
				echo "error";
				exit;
			}

			$this->setBlockNum();

			$this->setBlockArray();
		}


		/**
		 * set the block num of articles
		 * @return void
		 */
		public function setBlockNum()
		{
			$sql = "SELECT COUNT(*) FROM article";

			if ($result = $this->dbObject->query($sql)) {
				$this->articleNum = $result[0]["COUNT(*)"];
				$this->blockNum = ceil($this->articleNum / $this->blockSize);
			}
		}

		/**
		 * set the block array of articles
		 * @return void
		 */
		public function setBlockArray()
		{
			$sql = "SELECT * FROM article ORDER BY dateline DESC LIMIT ".($this->blockSize * ($this->currentBlock - 1)).",".$this->blockSize;

			$this->blockInfoArray = $this->dbObject->query($sql);
		}

		/**
		 * return private member of blockinfoarray
		 * @return array :blockinfoarray
		 */
		public function getBlockInfo()
		{
			return $this->blockInfoArray;
		}
	}

?>