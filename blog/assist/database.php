<?php

	header("Content-type: text/html; charset=utf-8");

	/**
	* operations about database
	*/
	class Database
	{
		private $pdo;     /* interface to db */
		
		const DBMS = 'mysql';
		const USERNANE = 'username';
		const PASSWORD = 'password';
		const HOST = 'hostname';
		const DB = 'dbname';


		/**
		 * connect to db
		 * @return bool ,if connect succ ret true, otherwise false
		 */
		public function getConnect() 
		{
			$dbms = self::DBMS;
			$userName = self::USERNANE;
			$passWord = self::PASSWORD;
			$host = self::HOST;
			$db = self::DB;
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 

			$this->pdo = new PDO("$dbms:dbname=$db;host=$host", $userName, $passWord, $options);

			return $this->pdo ? true : false;
		}


		/**
		 * query db with defined sql
		 * @param  string $sql sql string
		 * @return array      ret of query
		 */
		public function query($sql)
		{
			$rows = array();
			$result = $this->pdo->prepare($sql);
			if ($result->execute()) {
				while ($res = $result->fetch(PDO::FETCH_ASSOC)) {
					$rows[] = $res;
				}
			}
			return $rows;
		}

		/**
		 * update tables' property values
		 * @param  string $sql 
		 * @return int      affected columns
		 */
		public function update($sql)
		{
			return $this->pdo->exec($sql);
		}


	}


?>