<?php

	include_once 'database.php';
	
	/**
	* a class manage groups of articles
	*/
	class ArticleGroup extends Database
	{
		private $articleNum = null;   // int 文章总数
		private $groupNum = null;     // int 文章分块数
		private $groupSize = null;    // int 每一分组有多少篇文章

		private $wantedGroup = null;    // int 指示当前获取、显示哪一块

		/**
		 * construct function
		 * @param int $groupSize the size of each article group
		 */
		function __construct($groupSize)
		{
			$this->groupSize = $groupSize;

			if (!$this->getConnect()) {
				echo "connect error";
				exit;
			}

			$this->setGroupNum();
		}

		/**
		 * set the group num of articles
		 * @return void
		 */
		public function setGroupNum()
		{
			$sql = "SELECT COUNT(*) FROM article";

			if ($result = $this->query($sql)) {
				$this->articleNum = $result[0]["COUNT(*)"];
				$this->groupNum = ceil($this->articleNum / $this->groupSize);
			}
		}

		/**
		 * get the num of article group num
		 * @return int group num
		 */
		public function getGroupNum()
		{
			return $this->groupNum;
		}

		/**
		 * return private member of groupinfoarray
		 * @param  int $wantedGroup the group which is wanted
		 * @return array              array with group article info
		 */
		public function getGroupInfo($wantedGroup)
		{

			$this->wantedGroup = $wantedGroup;

			$sql = "SELECT a_Id AS id, a_Title AS title, a_Date AS date, a_View AS view, a_Introduction AS introduction FROM article WHERE a_Hide != 1 ORDER BY a_Date DESC LIMIT ".($this->groupSize * ($this->wantedGroup - 1)).",".$this->groupSize;

			return $this->query($sql);
		}
	}

?>