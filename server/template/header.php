<?php
// 檢查 GET ation 變數是否有 logout，若有表示登出，清除 user session 並導入回 index
if (isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'logout':
			unset($_SESSION['user']);
			header("location: index.php");
		break;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Arrhythmia</title>
	<!-- Bootstrap 3.3.7 -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>