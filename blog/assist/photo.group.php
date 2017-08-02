<?php

	include_once 'database.php';
	
	/**
	* a class manage groups of photo
	*/
	class PhotoGroup extends Database
	{
		private $photoNum = null;   // int 文章总数
		private $groupNum = null;     // int 文章分块数
		private $groupSize = null;    // int 每一分组有多少篇文章

		private $wantedGroup = null;    // int 指示当前获取、显示哪一块

		/**
		 * construct function
		 * @param int $groupSize the size of each photo group
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
			$sql = "SELECT COUNT(*) FROM lifeimage";

			if ($result = $this->query($sql)) {
				$this->photoNum = $result[0]["COUNT(*)"];
				$this->groupNum = ceil($this->photoNum / $this->groupSize);
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

			$sql = "SELECT ti_Id AS id, ti_Title AS title, ti_Image AS image, ti_Date AS date, ti_Introduction AS introduction FROM lifeimage WHERE ti_Hide != 1 ORDER BY ti_Date DESC LIMIT ".($this->groupSize * ($this->wantedGroup - 1)).",".$this->groupSize;

			return $this->query($sql);
		}
	}

?>