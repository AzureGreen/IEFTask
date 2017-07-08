<?php

	include_once 'database.php';
	
	/**
	* a class manage blocks of articles
	*/
	class ArtilceBlock
	{
		private $articleNum = null;   // int 文章总数
		private $blockNum = null;     // int 文章分块数
		private $blockSize = null;    // int 每一分块有多少篇文章

		private $wantedBlock = null;    // int 指示当前获取、显示哪一块

		private $dbObject = null;    // object database object 

		/**
		 * construct function
		 * @param int $blockSize the size of each article block
		 */
		function __construct($blockSize)
		{
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
		 * get the num of article block num
		 * @return int block num
		 */
		public function getBlockNum()
		{
			return $this->blockNum;
		}

		/**
		 * return private member of blockinfoarray
		 * @param  int $wantedBlock the block which is wanted
		 * @return array              array with block article info
		 */
		public function getBlockInfo($wantedBlock)
		{

			$this->wantedBlock = $wantedBlock;

			$sql = "SELECT id, title, dateline, description FROM article ORDER BY dateline DESC LIMIT ".($this->blockSize * ($this->wantedBlock - 1)).",".$this->blockSize;

			return $this->dbObject->query($sql);
		}
	}

?>