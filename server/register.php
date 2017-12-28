<?php
require_once("connect.php");
$connect = new connect();

// 檢查是否已有登入者，若有則不允許註冊，需先登出
if ($connect->checkAuth() != null) {
  $error = "請先登出目前的使用者，再行註冊!'";
  header("location: index.php");
}

// 檢查再次輸入密碼與密碼欄位是否一致，且 user 欄位是否不為空
if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['checkpass'])) {
	if ($_POST['pass'] != $_POST['checkpass']) {
		$error = "您所輸入的兩次密碼不相同!";
	} else {
		if ($connect->register($_POST['user'], $_POST['pass'])) {
      echo "alert('恭喜您，已成為會員，即將導向登入頁面!')";
			header("location:index.php");
		} else {
      $error .= "，此用戶名稱已有使用者註冊，請換個名稱。";
		}
	}
	if (isset($error)) {
		echo '<div class="alert alert-danger">' .
  		'<strong>失敗!</strong>' . $error . '</div>';
	}
}
include("template/header.php");
?>
<div class="container">
  <form class="form-signin" method="post">
    <h2 class="form-signin-heading">心律不整資料庫 - 用戶註冊</h2>
    <label for="user" class="sr-only">使用者名稱</label>
    <input type="account" name="user" id="user" class="form-control" placeholder="peter" maxlength="20" required autofocus>
    <label for="pass" class="sr-only">密碼</label>
    <input type="password" name="pass" id="pass" class="form-control" placeholder="your password" maxlength="20" required>
    <label for="checkpass" class="sr-only">請再次輸入密碼</label>
    <input type="password" name="checkpass" id="checkpass" class="form-control" placeholder="請再次輸入" maxlength="20" required>
    <hr>
    <button class="btn btn-lg btn-primary btn-block" type="submit">立即註冊</button>
  </form>
</div> <!-- /container -->
<?php include("template/footer.php"); ?>