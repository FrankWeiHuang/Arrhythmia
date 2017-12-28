<?php
// 取得目前 Username，若取得不到表示沒有權限登入，導入回 index
$user = $connect->getCurrentUser();
if ($user != null) {
	echo '<div class="alert alert-success">' .
		'<strong>歡迎登入!</strong><br>' . $user->user . '您好! </div>';
} else {
	header("location:index.php");
}
?>