<?php
	require_once('Connections/connSendText.php'); 
	$keyword = $_REQUEST["keyword"];	
		global $connSendText;
		//echo $keyword;
		$keyword++;
		SetCookie('song',$keyword);
		//$sql="SELECT mytext FROM message order by editTime asc";
		$sql="SELECT 歌名 FROM message WHERE 排序='".$keyword."'";
		$row=mysqli_query($connSendText,$sql);
		$RESULT=mysqli_fetch_array($row);
		echo $RESULT[0];
		
?>