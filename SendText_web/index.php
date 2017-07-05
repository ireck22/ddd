<?php
	require_once('send_open.inc');
	session_start(); //啟用交談
	//檢查是否有SESSION變數
	if($_SESSION["login_session"] != true) {
		header("Location:login.php"); //轉址進入登入頁
	}
	if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){  //logout==true 在使用者狀態插入0代表登出並轉只到登入頁
		$sql0="UPDATE login SET keyid='0' WHERE name='".$_SESSION["NAME"]."'";
		$status=mysqli_query($link,$sql0);
		echo $status;
		header("Location:login.php");
	}
	
	
 ?>
<html>
	<meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
	<head>
		<title>音你而在</title>
		<script src="js/jquery.min.js"></script>
		<script src="js/getShow.js" type="text/javascript"></script>
		<script type="text/javascript">getmessage();</script>
		<script src="js/time.js" type="text/javascript"></script><!--時間-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="js/song.js" type="text/javascript"></script>
		<link href="css/htmlstyle.css" rel="stylesheet" type="text/css"> <!--網頁修飾-->
		<div style="position: absolute; width: 220px; height: 25px; z-index: 1; right: 0px; top:50px" id="show"></div> <!--時間位置設定-->
	</head>

	<body onLoad="timeshow(); songlist();">  <!--timeshow() 現在時間-->

		<div id="was">
			<h2>正在播放:<span id="music_name"></span></h2> <!--歌名-->
		</div>	
		<!--<span id="you"></span><br>
			<span id="you2"></span> <!--程式測試區-->
		<div id="music_player"></div>  <!--音樂播放條-->	
		<div id="topnav">
				<ul>
					<li><a type="submit" style="font-size:25px;" onClick="location.href='?logout=true'">登出</a></li>
					<li><a href="音你而在.html">點曲資料</a></li>
					<li><a href="https://www.facebook.com/pages/%E5%8D%B3%E6%99%82%E5%88%86%E4%BA%AB%E9%9F%B3%E4%BD%A0%E8%80%8C%E5%9C%A8/1623985287891084?notif_t=page_admin">粉絲專頁</a></li>
					<li><a href="ajax/client.php">聊天室</a></li>
					
				</ul>
		</div>
		
			<div id="main1" class="distance">
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
			<div id="song">
			</div>
	
	
		<div id="fottor">
			
				<?php
					ob_start(); //打開输出缓衝
					$num=0;
					$dirpt="online";
					$reftime=1;
					if (is_dir($dirpt) && $dir = opendir($dirpt)) {
						while (($file = readdir($dir)) !== false) {
							if(strcmp($file,"..")==0 || strcmp($file,".")==0){
								continue;
							}
							$D_[date("Y-m-d H:i:s",filemtime($dirpt."/".$file))]=$file;//filemtime文件修改時間
							$num++;
							unset($cum);
						} 
						closedir($dir);
						$filename=session_id();
						$fp=fopen($dirpt."/".$filename,"w"); //打開文件online
						fputs($fp,"");    //寫入$fp
						fclose($fp);      //$fp關閉
						$ntime=date("Y-m-d H:i:s",mktime(date("H"),date("i")-1,0,date("m"),date("d"),date("Y"))); //
						$D_[$ntime]="-";
						krsort($D_);
						$onlinenumber=0;
						while(1){
							$vkey=key($D_);
							$onlinenumber++;
								if(strcmp($ntime,$vkey)==0){
									break;
								}else{
									array_shift($D_);
								}
							}
						array_shift($D_);
						reset($D_);
						while(count($D_)>0){
							$ckey=key($D_);
							unlink($dirpt."/".$D_[$ckey]);
								if(!next($D_)){
									break;
								}
						}
					}else{
						@chmod("..",0777);
						@mkdir($dirpt,0777);
					}
					$online=$onlinenumber-1;
					$retime=100000*$reftime;
					echo "當前在線<strong><font color=red>$online</font></strong>人<meta http-equiv=refresh content=\"{$retime},url=\">";
					ob_end_flush();//送出缓衝區内容，並關閉缓衝
				?><br>
				
			
		</div>
	</body>
</html>