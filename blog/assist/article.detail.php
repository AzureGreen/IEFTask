<?php 

	include_once 'database.php';

	/**
	* a class about the detail info of article
	*/
	class ArticleDetail extends Database
	{
		private $aboutId = 0;

		function __construct()
		{
			if (!$this->getConnect()) {
				echo "connect db error";
				exit;
			}
		}

		/**
		 * update view num of articles
		 * @param  int $id 
		 * @return void     
		 */
		public function updateViewNum($id)
		{
			$sql = "UPDATE article SET a_View = a_View + 1 WHERE a_id = ".$id;

			$this->update($sql);
		}

		/**
		 * get detail info of article, especially the content
		 * @param  int $id 
		 * @return array     array of article detail info
		 */
		public function getDetailInfo($id)
		{
			$sql = "SELECT a_Title AS title, a_Date AS date, a_Content AS content, a_View AS view FROM article WHERE a_id = ".$id." AND a_Hide !=1";

			return $this->query($sql);
		}

		/**
		 * get detail info of article, especially the content
		 * @return array     array of article detail info
		 */
		public function getAboutDetailInfo()
		{
			$sql = "SELECT a_Title AS title, a_Date AS date, a_Content AS content, a_View AS view FROM article WHERE a_id = ".$this->aboutId;

			return $this->query($sql);
		}

		/**
		 * get previous article info
		 * @param  int $id 
		 * @return array     
		 */
		public function getPreInfo($id)
		{
			$sql = "SELECT a_Id AS id, a_Title AS title FROM article WHERE a_Id < ".$id." AND a_Hide !=1 ORDER BY a_Date DESC LIMIT 1";

			return $this->query($sql);
		}

		/**
		 * get next article info
		 * @param  int $id
		 * @return array
		 */
		public function getNextInfo($id)
		{
			$sql = "SELECT a_Id AS id, a_Title AS title FROM article WHERE a_Id > ".$id." AND a_Hide !=1 ORDER BY a_Date ASC LIMIT 1";

			return $this->query($sql);
		}
	}

?>