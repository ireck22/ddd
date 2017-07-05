<?php
require_once('Connections/connSendText.php'); 
include("aider.php");

$keyword = $_REQUEST["keyword"];
if (isset($_POST["keyword"])) {
	echo getmu($_POST["keyword"]);  //收尋的關鍵字
}
//echo $keyword;
function getmu($keyword){
	global $connSendText;
 	if(!empty($keyword)) {
		$url="http://mymedia.yam.com/m/";
		$key = explode(" ",$keyword);
		$search_page=http_get("http://mymedia.yam.com/tag.php?key=" . $key[1],"http://mymedia.yam.com/");
		$aref=explode("\"/m/",$search_page["FILE"]);
		for($i=1;$i<count($aref);$i++){        //0不是我要的從1開始找音樂網址，用count把aref的大小用出來
			if (strpos ($aref[$i], $key[0])){
				$result = get_yam($url.explode("\"",$aref[$i])[0]);
				if ($result != "http") {       //遇到加密的會顯示http所以這裡設這個條件，才會找到使用者要的
					//mysqli_query($connSendText,"Update login SET musicwebsite='$result' WHERE id=16");
					
					return $result;
				}
			}
		
		}
	}
	
	return $url; //回傳網頁
	//echo $url;
}

 function get_yam($href){
		$href=explode("/",$href);//用/分割，把網址分割放到陣列
		$file=http_get("http://mymedia.yam.com/api/m/?pID=" . $href[4],"http://mymedia.yam.com/");   //抓網頁原始碼
		return return_between($file["FILE"],"http://",".mp3",INCL);
}



?>

