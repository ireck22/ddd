<?php
session_start();           // 啟用交談期
if (isset($_GET["user"]))  // 表單送回
    $user = $_GET["user"]; // 指定使用者名稱
else
    $user = "";
if ($user != "") {   // 有使用者
    if ($user == "ok") {  // 登出
        $name = $_SESSION["user"];  // 取得Session變數
        // 建立離開聊天室的訊息文字
        $msg = "<div>使用者:<span class='name'>" . $name .
               "</span>離開聊天室</div>";
        $fp = fopen("messages.html", "a+");  // 開啟檔案
        fwrite($fp, $msg);                   // 寫入訊息        
        fclose($fp);                         // 關閉檔案
        session_destroy();                   // 關閉交談期
        header("Location:client.php");        // 轉址給自己
    }
    if (!isset($_SESSION["user"])) {  // 登入
        $_SESSION["user"] = $user;    // 建立Session變數
        $fp = fopen("messages.html", "a+");  // 開啟檔案
        // 建立進入聊天室的訊息文字
        $string = "<div>使用者:<span class='name'>" . $user .
                  "</span>進入聊天室</div>";
        fwrite($fp, $string);         // 寫入訊息
        fclose($fp);                  // 關閉檔案
    }
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Ajax聊天室</title>
		<link rel="stylesheet" href="chatroom.css">
		<script src="jquery-2.1.1.min.js"></script>
		<script>
			$(document).ready(function() {	
				$("form#chat-form").submit(function (e) { // Ajax送出表單
					e.preventDefault();
					var message = $("#chatmessage").val(); // 取得訊息
					// 使用HTTP POST方法送出Ajax請求至PHP程式
					$.post("writechat.php", {text: message});
					$("#chatmessage").val('');
					return false;
				});
				function loadContent() {  // 載入聊天訊息
					var oldHeight = $("#chatwindow").prop("scrollHeight") - 20;
					// 送出Ajax請求messages.html網頁
					$.ajax({
						url: "messages.html",
						cache: false,
						success: function(content) {
					// 插入聊天訊息至#chatwindow
							$("#chatwindow").html(content); 				
							var newHeight = $("#chatwindow").prop("scrollHeight") - 20;
							if ( newHeight > oldHeight ) {
						// 自動捲動div元素
								$("#chatwindow").animate({ scrollTop: newHeight }, 'slow'); 
							}				
						}
					});
				}
				setInterval(loadContent, 1000);  // 定時更新內容
			});
		</script>
	</head>
	<body>
		<div id="chatwrapper">
			<?php
				if (!isset($_SESSION['user'])) {  // 尚未登入聊天室
			?>
			<form id="nameform" action="client.php">
				使用者名稱: <input type="text" id="username" name="user"/>
				<input type="submit" value="登入" id="enterchat"/>
				<!--<input type ="button" onclick="javascript:location.href=''" value="回到首頁"></input>-->
				<input type ="button" onclick="javascript:location.href='/SendText_web/index.php'" value="回到首頁"></input>
				<!--<input type="submit" value="回到首頁" name="black"></input>-->
	
			</form>
			<?php } else { // 顯示聊天室標題文字  ?>
				<div id="chattitle">
					<div class="welcome">
						<p>歡迎使用者: <?php echo $_SESSION['user']; ?></p>
					</div>
					<div class="exit">
						<p><a href="client.php?user=ok" id="log">登出</a></p>
					</div>
				</div>
				<div id="chatwindow"></div> 
					<div id="chatform">
						<form id="chat-form" action="#">
							<input type="text" id="chatmessage" name ="message" />
							<input type="submit" id="send" value="送出"/>
						</form>
					</div>
			<?php } ?>
		</div>
	</body>
</html>