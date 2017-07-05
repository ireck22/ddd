<?php require_once('Connections/connSendText.php');
//header("Content-Type:text/html; charset=utf-8");
header('content-type:application/json;charset=utf8');
date_default_timezone_set('Asia/Taipei');
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
	  global $connSendText;
	  if (PHP_VERSION < 6) {
	    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  }
		//防止sql攻擊
	  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connSendText, $theValue) : mysql_escape_string($theValue);

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
		

$queryVal='';

/* 
	Get query
*/
if (!empty($_POST['query'])) {
	$queryVal=GetSQLValueString($_POST['query'], "text");
} else {
	exit;
}

/*-------------------------------------------------- */

//
if ($queryVal == "'login'") { // login
	$tmpary = array();
	$tmpary["Result"] = '0';
	$tmpary["Msg"] = 'No';

	if (!empty($_POST['name']) && !empty($_POST['password'])) {

		$mname=GetSQLValueString($_POST['name'], "text");
		$mpassword=GetSQLValueString($_POST['password'], "text");

		try { 
			$querySQL = sprintf("SELECT * FROM `login` WHERE `name` = %s AND `password` = %s", $mname, $mpassword);  //去資料表找帳號密碼
			$queryResult = mysqli_query($connSendText, $querySQL);
			$totalRows_queryResult = mysqli_num_rows($queryResult);
			
			if ($totalRows_queryResult) {
				$tmpary["Result"] = '1';
				$tmpary["Msg"] = 'login OK';

				$tmpary2 = array();
				while($row = mysqli_fetch_assoc($queryResult)) {//登入訊息
					$tmpary2["name"] = $row["name"];
					$tmpary2["mobilephone"] = $row["mobilephone"];
					$tmpary2["musicwebsite"] = $row["musicwebsite"];
					$tmpary2["keyid"] = $row["keyid"];
				}
				$tmpary["Data"] = $tmpary2;

			}

			mysqli_free_result($queryResult);
		} catch (Exception $e) {}
  	}
  	//echo json_encode( $tmpary, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE );
  	echo jsonFormat($tmpary);
}

/* insert (m_account & m_phonenum Unique)
-------------------------------------------------- */
if ($queryVal == "'register'") { // register
	$tmpary = array();
	$tmpary["Result"] = '0';
	$tmpary["Msg"] = 'reg fail';

	if (!empty($_POST['m_account']) && !empty($_POST['m_password']) && !empty($_POST['name'])) {

		// check Values
		$m_account=GetSQLValueString($_POST['m_account'], "text");
		$m_password=GetSQLValueString($_POST['m_password'], "text");
		$m_phonenum=GetSQLValueString($_POST['name'], "text");

		try { 
			$querySQL = sprintf("SELECT * FROM $members_table WHERE m_account = %s OR m_phonenum = %s", $m_account, $m_phonenum);
			$queryResult = mysqli_query($connVertex, $querySQL);
			$totalRows_queryResult = mysqli_num_rows($queryResult);
			mysqli_free_result($queryResult);
			$tmpary["Msg"] = 'Y';
			if (empty($totalRows_queryResult)) { //
				$insertSQL = sprintf("INSERT INTO $members_table (m_account, m_password, m_phonenum, m_emergency_phonenum_n1, m_emergency_phonenum_n2, m_emergency_phonenum_n3) 
											VALUES (%s, %s, %s, %s, %s, %s)",
										 $m_account, GetMD5csum($m_password, "password"),
										 $m_phonenum, 
										 $m_emergency_phonenum_n1, $m_emergency_phonenum_n2, $m_emergency_phonenum_n3
							 );
					
				$Result = mysqli_query($connVertex, $insertSQL); //
				if ($Result) {
					$tmpary["Result"] = '1';
					$tmpary["Msg"] = 'OK';
				}
			}
		} catch (Exception $e) {}
	}
	//echo json_encode( $tmpary, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE );
	echo jsonFormat($tmpary);
}

/* update
-------------------------------------------------- */

//

/* del
-------------------------------------------------- */

/**
* @param  Mixed  $data
* @param  String $indent
* @return JSON
*/
function jsonFormat($data, $indent=null){

    array_walk_recursive($data, 'jsonFormatProtect');

    $data = json_encode($data);

    $data = urldecode($data);

    $ret = '';
    $pos = 0;
    $length = strlen($data);
    $indent = isset($indent)? $indent : '    ';
    $newline = "\n";
    $prevchar = '';
    $outofquotes = true;

    for($i=0; $i<=$length; $i++){

        $char = substr($data, $i, 1);

        if($char=='"' && $prevchar!='\\'){
            $outofquotes = !$outofquotes;
        }elseif(($char=='}' || $char==']') && $outofquotes){
            $ret .= $newline;
            $pos --;
            for($j=0; $j<$pos; $j++){
                $ret .= $indent;
            }
        }

        $ret .= $char;
        
        if(($char==',' || $char=='{' || $char=='[') && $outofquotes){
            $ret .= $newline;
            if($char=='{' || $char=='['){
                $pos ++;
            }

            for($j=0; $j<$pos; $j++){
                $ret .= $indent;
            }
        }

        $prevchar = $char;
    }

    return $ret;
}

/**
* @param String $val
*/
function jsonFormatProtect(&$val){
    if($val!==true && $val!==false && $val!==null){
        $val = urlencode($val);
    }
}
?>