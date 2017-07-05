<?php require_once('Connections/connSendText.php'); 
	header("Content-Type:text/html; charset=utf-8");
	date_default_timezone_set('Asia/Taipei');



	if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
			if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}
			//防止sql攻擊
			$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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


/* 更新
-------------------------------------------------- */

	$selectSQL = "select * from message group by 排序 asc limit 1";  //查詢資料表中的id並歸類成群組，從低到高做排列但只顯示最高的
	$Result = mysqli_query($connSendText, $selectSQL); // 
	$nowTime = date('Y-m-d H:i:s');
	while($gear = mysqli_fetch_array($Result)) {
		//if (strtotime($nowTime) - strtotime($gear['editTime']) < 5) {
		
		$ad=$gear['歌名'];  
		$ab=$gear['排序'];
		$ac=$ad.'^'.$ab;  //把$ad和$ab連起來中間用'^'隔開放到$ac
		//echo $gear['mytext'];
		echo $ac;    //回傳
		//echo $gear['username'];
		//}
	
		//else {
		//echo "noChange";
		//}

	}	 




?>