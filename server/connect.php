<?php
// 將設定好的 db 物件交由 connect 物件，並且此 class 負責所有與 db 有關的指令的部分，
// 並將處理完成的查詢，封裝成 FETCH_OBJ 物件，回傳操作
class Connect {
	public $connect;

	// 若 session 未啟用，則開啟 seesion
	public function __construct() {
		if (!isset($_SESSION)) {
			session_start();
		}

		// 導入 db 設定好的 pdo class
		require_once("configure.php");

		// 建立 pdo 物件，host、user、password、database
		$db = new DB("localhost", "root", "", "memberdb");
		$this->connect = $db->getPDO();
	}

	// 檢查目前是否已經有 user 登入的紀錄
	public function checkAuth() {
		return isset($_SESSION['user']);
	}

	// 若檢查有 user 登入，則回傳目前 session 所記錄的 username
	public function getCurrentUser() {
		if ($this->checkAuth()) {
			return $_SESSION['user'];
		} else {
			return null;
		}
	}

	// 當有登入需求時，透過此函式進行 user 查詢確認，user存在
	// 包含兩個需要登入的使用者名稱與密碼
	public function login($user, $pass) {
		try {
			$command = "SELECT * FROM `member` WHERE user = :user AND pass = :pass";
			$sth = $this->connect->prepare($command);
			$sth->bindParam(":user", $user);
			$sth->bindParam(":pass", $pass);
			$sth->execute();
			$fetch = $sth->fetch(PDO::FETCH_OBJ);

			// 若執行後且攝取的物件並不為空物件，將 fetch 內敏感資訊 password 的設定值解除
			// 並將目前 session 設定為 fetch 到的 user 物件 (例如: 名稱、電話...)
			// 本範例僅設名稱，因此於外部將使用 ($fetch->user) 取得 username
			if ($fetch != null) {
				unset($fetch->pass);
				$_SESSION['user'] = $fetch;
			}
			return $fetch;
		} catch (PDOExcption $e) {
			echo $e;
		}
	}

	// 註冊帳號時，透過此函式進行註冊
	// 包含兩個欲註冊的使用者名稱與密碼參數
	public function register($user, $pass) {
		try {
			// 先檢查是否有註冊過
			$command = "SELECT * FROM `member` WHERE `user` = :user";
			$sth = $this->connect->prepare($command);
			$sth->bindParam(":user", $user, PDO::PARAM_STR);
			$sth->execute();
			$fetch = $sth->fetch(PDO::FETCH_OBJ);

			// fecth 為空物件，表示目前的資訊可以註冊，並進行註冊
			if ($fetch == null) {
				$command = "INSERT INTO `member` (`user`, `pass`) VALUES (:user, :pass)";
				$sth = $this->connect->prepare($command);
				$sth->bindParam(":user", $user);
				$sth->bindParam(":pass", $pass);
				$rowCount = $sth->execute();

				// 將剛剛新增後最後一筆資料的 id 作為再搜尋的條件
				// 將使用 id 搜尋到的 fetch 物件設定至 session
				$id = $this->connect->lastInsertId();
				$command = "SELECT * FROM `member` WHERE `id` = :id";
				$sth = $this->connect->prepare($command);
				$sth->bindParam(":id", $id);
				$sth->execute();
				$fetch = $sth->fetch(PDO::FETCH_OBJ);

				if ($fetch != null) {
					unset($fetch->pass);
					$_SESSION['user'] = $fetch;
				}
				// 回傳是否新增成功的結果
				return $rowCount;
			} else {
				return 0;
			}
		} catch (PDOExcption $e) {
			echo $e;
		}
	}
	// 查詢心電圖的紀錄，條件為查詢表名稱、起始時間、終止時間
	public function getRecords($number, $start, $end) {
		try {
			$command = "SELECT * FROM `$number` WHERE time BETWEEN :start AND :end";
			$sth = $this->connect->prepare($command);
			$sth->bindParam(":start", $start);
			$sth->bindParam(":end", $end);
			$sth->execute();
			$fetch = $sth->fetchAll(PDO::FETCH_OBJ);

			if ($fetch != null) {
				return $fetch;
			} else {
				return null;
			}
		} catch (PDOException $e) {
			echo $e;
		}
	}
}
?>