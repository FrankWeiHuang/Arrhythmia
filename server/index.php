<?php
// 導入 connect 類別，提供登入查詢使用 login()
require_once("connect.php");
$connect = new connect();

// 檢查表單內 post 的 user 與 pass 值是否存在
if (isset($_POST['user']) && isset($_POST['pass'])) {
	$user = $connect->login($_POST['user'], $_POST['pass']);
	
  // 若查詢的物件不存在，表示尚未註冊，否則導入 search 頁面
  if ($user == null) {
		$error = "您所輸入的帳號或密碼錯誤<br>";
	} else {
		header("location:search.php");
	}
  // 若 error 變數存在，表示有錯誤資訊，使用 alert 顯示
	if (isset($error)) {
		echo '<div class="alert alert-danger">' .
  		'<strong>登入失敗!</strong>' . $error . '</div>';
	}
}
include("template/header.php");
?>
<div class="container">
  <form class="form-signin" method="post" action="index.php">
    <h2 class="form-signin-heading">MIT-BIH Arrhythmia (心律不整) 資料庫</h2>
    <label for="user" class="sr-only">帳號</label>
    <input type="user" id="user" name="user" class="form-control" placeholder="Username" maxlength="20" required autofocus><hr>
    <label for="pass" class="sr-only">密碼</label>
    <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" maxlength="20" required><hr>
    <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
  </form>
  <hr><a href="register.php" class="btn btn-info" role="button">註冊</a>
</div> <!-- /container -->
<?php include("template/footer.php"); ?>