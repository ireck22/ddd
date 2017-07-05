<?php
	session_start();                // 啟用交談期
	date_default_timezone_set("Asia/Taipei");
	if (isset($_SESSION["user"])) { // 使用者有登入
		$text = $_POST["text"];     // 取得表單送出訊息
		$date = date('H:i:s');      // 取得現在時間
		$fp = fopen("messages.html", "a+"); // 開啟檔案
		// 建立聊天訊息
		$msg = "<div class='message'><span class='name'>" . 
			$_SESSION["user"] . ":</span> " . 
			stripslashes(htmlspecialchars($text)) .
			"<span class='right'>" . $date ."</span></div>";
		fwrite($fp, $msg);  // 寫入檔案
		fclose($fp);        // 關閉檔案
	}
?>
