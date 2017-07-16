<?php

	include_once 'database.php';
	
	/**
	* a class manage blocks of articles
	*/
	class ArtilceBlock extends Database
	{
		private $articleNum = null;   // int 文章总数
		private $blockNum = null;     // int 文章分块数
		private $blockSize = null;    // int 每一分块有多少篇文章

		private $wantedBlock = null;    // int 指示当前获取、显示哪一块

		/**
		 * construct function
		 * @param int $blockSize the size of each article block
		 */
		function __construct($blockSize)
		{
			$this->blockSize = $blockSize;

			if (!$this->getConnect()) {
				echo "connect error";
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

			if ($result = $this->query($sql)) {
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

			$sql = "SELECT a_Id AS id, a_Title AS title, a_Date AS date, a_Introduction AS introduction FROM article WHERE a_Hide != 1 ORDER BY a_Date DESC LIMIT ".($this->blockSize * ($this->wantedBlock - 1)).",".$this->blockSize;

			return $this->query($sql);
		}
	}

?>