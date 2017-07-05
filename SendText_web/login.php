<?php
	require_once('send_open.inc');
	session_start(); //啟用
	$_SESSION["login_session"]="";
	
	
	$wr="";
	$name="";
	$password="";
	$msg="";
	//取得表單欄位
	if(isset($_POST["Name"])){
		$name=$_POST["Name"];}
	if(isset($_POST["Password"])){
		$password=$_POST["Password"];
	}
	$_SESSION["NAME"]=$name;
	if (isset($_GET["logout"])) {
		$logout = $_GET["logout"];
		if($logout=="true") {
			$_SESSION["login_session"] = false;
			
		}
	}
	
	echo $_SESSION["NAME"];
	//檢查是否有輸入帳號密碼
     echo $name,$password;
	if($name !="" && $password !="") {
		//建立sql指令字串
		
		$sql="SELECT * FROM login WHERE password='";
		$sql.=$password."' AND name='".$name."'";  //sql和password字串連接
		$rows=mysqli_query($link, $sql);//執行sql字串
		//是否查詢到紀錄
		if($dfg=mysqli_fetch_array($rows) != false){
			//成功登入,指定session變數
			$aw="SELECT keyid FROM login WHERE name='".$name."'"; //根據帳號叫出keyid
			$sss = mysqli_query($link, $aw) or die(mysqli_error());
			$status=mysqli_fetch_array($sss);       //防止一個帳號多人用，辦定家如keyid=1的話就不能登入，1是使用中、0是登出
			if($status[0]==0 ){
				$_SESSION["login_session"] =true;
				$_SESSION["name"]=$name;
				$sql2="UPDATE login SET keyid='1' WHERE name='".$name."'"; //插入使用狀態1
				$ad=mysqli_query($link,$sql2);
				echo $ad;
			}else{
				echo '<script language="javascript">';
				echo "alert('使用者中');";        //當帳號在使用的時候另外一個人想登入就會跳出 使用中的視窗
				echo "</script>";
			}
		
		}else {
			echo '<script language="javascript">';
			echo "alert('使用者名稱或密碼錯誤');";
			echo "</script>";
		}
		
			
		mysqli_close($link);//關閉資料庫連結
	}
	
	if($_SESSION["login_session"] == true) {
		header("Location:index.php"); //轉址登入首頁
	}
	
?>
<html>
	<head>
		<meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
		<title>音你而在 登入頁</title>
		<style type="text/css">
			body{
				background-image:url('picture/a5.jpg');
			}
			table{
				font-size:35px;
				font-family: Microsoft JhengHei; 
			}
			h2{
				font-size:35px;
				font-family: Microsoft JhengHei; 
			}
			input{
				font-size:20px;
				font-family: Microsoft JhengHei; 
			}
			small{
				font-size:20px;
				font-family: Microsoft JhengHei; 
			}
	
		</style>
	</head>
	<body>
		<center>
			<h2>即時分享音你而在<h2>
			<div style="width:600px;height:500px;overflow:auto;border:;background:"> 
				<form action="login.php" method="post">
					<center>
						<br>
						<br>
						<br>
						<table>
							<tr>
								<td>帳號:</td>
								<td><input type="text" name="Name" size="19" maxlength="10"></td>
							</tr>
							<tr>
								<td>密碼:</td>
								<td><input type="password" name="Password"size="19" maxlength="10"></td>
							</tr>
						</table><br/>
					</center>
					<input type="submit" value="登入網站"><br/><br/>
					<small><a href="Register.php">註冊新使用者</a></small>
				</form>
			</div>
		</center>
	</body>
</html>
	
	
	


		