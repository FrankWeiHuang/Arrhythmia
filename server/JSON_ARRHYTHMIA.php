<?php
// 開啟 session，並且檢查 Arrhythmia 是否不為空物件
// 若存在，則將 Arrhythmia JSON物件印出
session_start();
if (isset($_SESSION['JSON_ARRHYTHMIA'])) {
	echo $_SESSION['JSON_ARRHYTHMIA'];
}
?>