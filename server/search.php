<?php
require_once("connect.php");
$connect = new connect();

// 列出目前登入使用者的身分
require_once("getCurrentUser.php");

// 導入 Arrhythmia 物件類別
require_once("Arrhythmia.php");

$arrhythmia = new Arrhythmia();

// 檢查所要查詢的紀錄下拉式選單是否不為空，且有起始時間與終止時間
if (isset($_POST['numbers'])  && isset($_POST['start-time']) && isset($_POST['end-time'])) {
	
	// 建立兩個空的 numbers 與 records 負責暫存
	$numbers = [];
	$records = [];

	// 列舉所有選擇的紀錄，使用 numbers 表示代號陣列， number 表示每筆紀錄的代號
	foreach ($_POST['numbers'] as $number) {

		// 將列舉的紀錄，每個分別進行查詢，獲得紀錄 record
		$record = $connect->getRecords($number, $_POST['start-time'], $_POST['end-time']);
		if ($record != null) {

			// 將列舉的 number 存入 numbers 陣列
			// 將列舉的 record 存入 records 陣列
			array_push($numbers, $number);
			array_push($records, $record);
		} else {
			$error = "<br>您所查詢的時間格式錯誤或該筆紀錄的時間不存在!";	
		}
		if (isset($error)) {
			echo '<div class="alert alert-danger">' .
	  		'<strong>查詢失敗!</strong>' . $error . '</div>';
		}
	}
	$arrhythmia->numbers = [];

	// 列舉 numbers 陣列
	for ($i = 0; $i < sizeof($numbers); ++$i) {

		// 將列舉的陣列複製到 arrhythmia 物件內的 numbers 陣列
		array_push($arrhythmia->numbers, $numbers[$i]);
		$arrhythmia->records[$i] = [];

		// 列舉 records 陣列中，所有紀錄內的 record，並將 record 加入 arrhythima 內
		foreach ($records[$i] as $record) {
			array_push($arrhythmia->records[$i], $record);
		}
	}

	// 將 arrhythmia 初始化且複製完物件內容後，編碼成 json 格式
	// 並存入 session，之後轉跳至 waveforms 畫面繪圖
	if ($arrhythmia != null) {
		$JSON_ARRHYTHMIA = json_encode($arrhythmia);
		$_SESSION['JSON_ARRHYTHMIA'] = $JSON_ARRHYTHMIA;

		if (isset($_SESSION['JSON_ARRHYTHMIA'])) {
			header("location:waveforms.php");
		}
	}
}
include("template/header.php"); 
?>
<div class="container">
  <form class="form-select" method="post">
  	<h2 class="form-signin-heading">48筆 - 心律不整的公開資料查詢 (繪製波形圖包含 MILL 與 V1 兩種結果)</h2>
  	<label for="numbers">紀錄資料</label>
	<select class="form-control" name="numbers[]" multiple>
		<option value="100">100</option>
		<option value="101">101</option>
		<option value="102">102</option>
		<option value="103">103</option>
		<option value="104">104</option>
		<option value="105">105</option>
		<option value="106">106</option>
		<option value="107">107</option>
		<option value="108">108</option>
		<option value="109">109</option>
		<option value="111">111</option>
		<option value="112">112</option>
		<option value="113">113</option>
		<option value="114">114</option>
		<option value="115">115</option>
		<option value="116">116</option>
		<option value="117">117</option>
		<option value="118">118</option>
		<option value="119">119</option>
		<option value="121">121</option>
		<option value="122">122</option>
		<option value="123">123</option>
		<option value="124">124</option>
		<option value="200">200</option>
		<option value="201">201</option>
		<option value="202">202</option>
		<option value="203">203</option>
		<option value="205">205</option>
		<option value="207">207</option>
		<option value="208">208</option>
		<option value="209">209</option>
		<option value="210">210</option>
		<option value="212">212</option>
		<option value="213">213</option>
		<option value="214">214</option>
		<option value="215">215</option>
		<option value="217">217</option>
		<option value="219">219</option>
		<option value="220">220</option>
		<option value="221">221</option>
		<option value="222">222</option>
		<option value="223">223</option>
		<option value="228">228</option>
		<option value="230">230</option>
		<option value="231">231</option>
		<option value="232">232</option>
		<option value="233">233</option>
		<option value="234">234</option>
	</select>	
	<label for="start-time">查詢起始時間</label>
	<input id="start-time" type="input" name="start-time" class="form-control" step="2">
	<label for="end-time">查詢終止時間</label>
	<input id="end-time" type="input" name="end-time" class="form-control" step="2">
	<button class="btn btn-lg btn-primary btn-block" type="submit">開始查詢</button>
  </form>
  <hr>
  <a href="?action=logout" class="btn btn-info" role="button">登出</a>
  <hr>
</div> <!-- /container -->
<?php include("template/footer.php"); ?>