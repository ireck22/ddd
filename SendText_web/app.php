<html>
	<meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
	<head>
		<title>音你而在</title>
		<script src="js/jquery.min.js"></script>
		<script src="js/getShow1.js" type="text/javascript"></script>
		<script type="text/javascript">getmessage();</script>
		<style type="text/css">
		.right
		{
			position:absolute;
			right:20px;
		}	
		#sd{
			background-color:#FFFFFF; 
		}
		#wa{
			background-color:#FFFFFF; 
		}
		
		
		body{
			background-image:url(picture/ww.jpg);
			background-repeat:;
		}
		#container {width:800px}
		#header {background-color:#00DD00;}
		#menu {background-color:#00BBFF;height:200px;width:25%;float:left;}
		#content {background-color:#EEEEEE;height:200px;width:75%;float:left;}
		#footer {background-color:#9F0050;clear:both;text-align:center;}
		h1 {margin-bottom:0;}

		
		
		
		</style>
		
		
	</head>
	<body>
	<center>
		<div id="container">
			<!-- ▼以下DIV區是主圖banner區▼ -->
			<div id="header">
			<center>
			<h1 >即時分享。音你而在</h1>
			</center>
			</div>
			<!-- ▼以下DIV區是選單區▼ -->
			<div id="menu" >
				<a href="音你而在.html">點曲資料</a><br>
				<a href="https://www.facebook.com/pages/%E5%8D%B3%E6%99%82%E5%88%86%E4%BA%AB%E9%9F%B3%E4%BD%A0%E8%80%8C%E5%9C%A8/1623985287891084?notif_t=page_admin">粉絲專頁</a><br>
				<a href="ajax/client.php">聊天室</a><br>
				<br>
				<br>
				<div id="sd"  style="BORDER-RIGHT: #9999FF 10px inset; BORDER-TOP: #9999FF 10px inset; OVERFLOW: auto; BORDER-LEFT: #9999FF 10px inset; WIDTH: 180px; BORDER-BOTTOM: #9999FF 10px inset; HEIGHT:450px">
					<?php
						// 建立MySQL的資料庫連接 
						require_once("send_open.inc");
						$sql = "SELECT  `排序`,`歌名`  FROM  `message`  GROUP  BY  `歌名` ORDER BY `排序` DESC    "; // 把id從高到低
						// 送出utf8編碼的MySQL指令
						mysqli_query($link, 'SET CHARACTER SET UTF8');
						mysqli_query($link, "SET collation_connection = 'utf8_general_ci'");// 送出查詢的SQL指令		
						if ( $result = mysqli_query($link, $sql) ) { 
							echo "<b>熱播排行</b><br/>";  // 顯示查詢結果
						while( $row = mysqli_fetch_assoc($result) ){ 
							echo $row["排序"]."-".$row["歌名"]."<br/>";
						}     
						mysqli_free_result($result); // 釋放佔用記憶體
						} 
						require_once("send_close.inc")  // 關閉資料庫連接
					?>
				</div>
			</div>
			<div id="content">
				正在播放:<span id="music_name"></span>
				<br>
				<span id="music_player"></span>
				<br>
				<br>
				<br>
				<div id="wa" style="BORDER-RIGHT: #00BBFF 10px inset; BORDER-TOP:#00BBFF 10px inset; OVERFLOW: auto; BORDER-LEFT:#00BBFF 10px inset; WIDTH: 580px; BORDER-BOTTOM:#00BBFF 10px inset; HEIGHT: 450px">
					<?php
						require_once("message_open.inc"); 
						// 執行SQL查詢
						$result = mysqli_query($link, $sql);
						// 一筆一筆的以表格顯示記錄
						echo "<table  border=1><tr>";
						// 顯示欄位名稱
						while ( $meta = mysqli_fetch_field($result) )
							echo "<td>".$meta->name."</td>";
							echo "</tr>"; // 取得欄位數
						$total_fields = mysqli_num_fields($result);
						// 顯示每一筆記錄
						while ($row = mysqli_fetch_row($result)) {
							echo "<tr>"; // 顯示每一筆記錄的欄位值
							for ( $i = 0; $i <= $total_fields-1; $i++ )
								echo "<td>" . $row[$i] . "</td>";
								echo "</tr>";
						}
						echo "</table>";
						mysqli_free_result($result); // 釋放佔用記憶體  
						require_once("message_close.inc");
					?>
				</div>
			
			</div>
			
			<div id="footer">
			
			</div>
		</div>	
	</center>
	

	</body>
	</html>