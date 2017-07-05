<?php require_once('Connections/connSendText.php'); 
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei');

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
//$id2="";
//$id2=$_REQUEST["id"];
$id=1;

/* 更新
-------------------------------------------------- */

	//$selectSQL = "select mytext from message order by id='".$id."' asc";
	$selectSQL = "select * from message where id=1";	
	$Result = mysqli_query($connSendText, $selectSQL); // 插入資料庫
	$nowTime = date('Y-m-d H:i:s');
	while($gear = mysqli_fetch_array($Result)) {
		//if (strtotime($nowTime) - strtotime($gear['editTime']) > 5) {
		//echo strtotime($nowTime) - strtotime($gear['editTime']);
		$ad=$gear['mytext'];
		$ab=$gear['id'];
		//$ab=$gear['id'];
		$ac=$ad.'^'.$ab;
		//echo $gear['mytext'];
		echo $ac;
		//echo $gear['username'];
    //}
	
		//else {
		//echo "noChange";
		//}
	
	}	 




?>