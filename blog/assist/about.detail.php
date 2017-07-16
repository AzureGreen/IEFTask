<?php 

	include_once 'database.php';

	/**
	* a class about the detail info of article
	*/
	class AboutDetail extends Database
	{
		private $aboutId = 100;

		function __construct()
		{
			if (!$this->getConnect()) {
				echo "connect db error";
				exit;
			}
		}

		/**
		 * update view num of about page
		 * @return [type]     [description]
		 */
		public function updateViewNum()
		{
			$sql = "UPDATE article SET a_View = a_View + 1 WHERE a_id = ".$this->aboutId;

			$this->update($sql);
		}

		/**
		 * get info of about page
		 * @param  int $id 
		 * @return array     array of article detail info
		 */
		public function getDetailInfo()
		{
			$sql = "SELECT a_Title AS title, a_Date AS date, a_Content AS content, a_View AS view FROM article WHERE a_id = ".$this->aboutId;

			return $this->query($sql);
		}
	}

?>