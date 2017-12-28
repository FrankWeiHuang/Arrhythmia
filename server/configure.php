<?php
// 由於資料量龐大，每個 table 都具有 60萬筆資料，
// 因此預防查詢資料量過大，將記憶體限制擴增至 1024M
ini_set("memory_limit","1024M");
class DB {
	protected $host;
	protected $user;
	protected $pass;
	protected $db;
	protected $pdo;

	public function __construct($host, $user, $pass, $db) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;

		$dsn = "mysql:host=$this->host;dbname=$this->db";
		$array = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';",			
		PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,);

		try {
			$this->pdo = new PDO($dsn, $user, $pass, $array);
		} catch (PDOException $e) {
			echo $e;
		}
	}
	public function getPDO() { 
		return $this->pdo;
	}
}
?>