<?php 

	include_once 'database.php';

	/**
	* a class about the detail info of article
	*/
	class ArticleDetail
	{
		private $dbObject = null;    // object database object 

		function __construct()
		{
			$this->dbObject = new Database();  // 创建数据库对象并连接数据库

			if (!$this->dbObject) {
				echo "创建数据库连接错误";
				exit;
			}

			if (!$this->dbObject->getConnect()) {
				echo "error";
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
			$sql = "SELECT title, dateline, content FROM article WHERE id = ".$id;

			return $this->dbObject->query($sql);
		}

		public function getPreInfo($id)
		{
			$sql = "SELECT id, title FROM article WHERE id < ".$id." ORDER BY dateline DESC";

			return $this->dbObject->query($sql);
		}

		public function getNextInfo($id)
		{
			$sql = "SELECT id, title FROM article WHERE id > ".$id." ORDER BY dateline ASC";

			return $this->dbObject->query($sql);
		}
	}


?>