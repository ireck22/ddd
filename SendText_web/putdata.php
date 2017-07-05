<?php require_once('Connections/connSendText.php'); 
	header("Content-Type:text/html; charset=utf-8");
	date_default_timezone_set('Asia/Taipei');
	if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
			if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}

			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue); //防止sql攻擊

			switch ($theType) {
				case "text":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;    
				case "long":
				case "int":
					$theValue = ($theValue != "") ? intval($theValue) : "NULL";
					break;
				case "double":
					$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
					break;
				case "date":
					$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
					break;
				case "defined":
					$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
					break;
			}
			return $theValue;
		}
	}

	$queryID='';
	$putText='';
	$putusername='';
 
 
	if (!empty($_POST['使用者']) | !empty($_POST['歌名'])) {
		//$queryID=GetSQLValueString($_POST['id'], "int");
		$putText=GetSQLValueString($_POST['歌名'], "text");  //傳過來的歌名放到變數$putText裡
		$putusername=GetSQLValueString($_POST['使用者'],"text");  //傳過來的使用者放到變數$putusername裡
	
	}
 
	else {
		echo "Hello";  //不打字直接傳會出現hello
		exit;
	}
	session_start();
/* 更新
-------------------------------------------------- */
	$Result = mysqli_query($connSendText,"INSERT INTO `message`(`歌名`,`使用者`) VALUES ($putText,$putusername)");//插入資料庫
	
	$rows=mysqli_query($connSendText,"SELECT 排序 FROM `message` WHERE `歌名`=$putText ORDER BY 排序 desc") ;
	$num=mysqli_num_rows($rows);
	if($num>0){	
		$row=mysqli_fetch_array($rows);
		$_SESSION["songid"]=$row["排序"];
	};
	echo $_SESSION["songid"];  //顯示現在播放id


/*mysqli_query($connSendText, $updateSQL); // 插入資料庫
mysqli_query($connSendText,"INSERT INTO 'message'('mytext') VALUES ($putText) WHERE id= $queryID");
mysqli_query($connSendText,"INSERT INTO `message`('id','mytext','editTime') VALUES ('$queryID','123','123')");*/
?>