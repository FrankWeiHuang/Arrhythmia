<?php
// 本頁負責建立 waveforms charts
require_once("connect.php");
$connect = new connect();
require_once("getCurrentUser.php");
include("template/header.php");	
?>
<div class="container">
	<a href="?action=logout" class="btn btn-info" role="button">登出</a>
</div>
<div id="chart-container"></div>
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="javascript/waveforms.js"></script>