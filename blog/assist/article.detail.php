<?php 

	include_once 'database.php';

	/**
	* a class about the detail info of article
	*/
	class ArticleDetail extends Database
	{
		function __construct()
		{
			if (!$this->getConnect()) {
				echo "connect db error";
				exit;
			}
		}

		/**
		 * get detail info of article, especially the content
		 * @param  int $id 
		 * @return array     array of article detail info
		 */
		public function getDetailInfo($id)
		{
			$sql = "SELECT a_Title, a_Date, a_Content FROM article WHERE a_id = ".$id;

			return $this->query($sql);
		}

		public function getPreInfo($id)
		{
			$sql = "SELECT a_Id, a_Title FROM article WHERE a_Id < ".$id." ORDER BY a_Date DESC";

			return $this->query($sql);
		}

		public function getNextInfo($id)
		{
			$sql = "SELECT a_Id, a_Title FROM article WHERE a_Id > ".$id." ORDER BY a_Date ASC";

			return $this->query($sql);
		}
	}


?>