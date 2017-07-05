<?php

define("WEBBOT_NAME", "Test Webbot");
define("CURL_TIMEOUT", 25);
define("COOKIE_FILE", "c:\cookie.txt");
define("HEAD", "HEAD");
define("GET",  "GET");
define("POST", "POST");
define("EXCL_HEAD", FALSE);
define("INCL_HEAD", TRUE);
define("EXCL", true);
define("INCL", false);
define("BEFORE", true);
define("AFTER", false);  

function http_get($target, $ref)
    {
    return http($target, $ref, $method="GET", $data_array="", EXCL_HEAD);
    }
	
function http($target, $ref, $method, $data_array, $incl_head)
	{  
	$ch = curl_init();
    if(is_array($data_array))
        {
	    
        foreach ($data_array as $key => $value) 
            {
            if(strlen(trim($value))>0)
                $temp_string[] = $key . "=" . urlencode($value);
            else
                $temp_string[] = $key;
            }
        $query_string = join('&', $temp_string);
        }
    if($method == HEAD)
        {
    	curl_setopt($ch, CURLOPT_HEADER, TRUE);                // No http head
	    curl_setopt($ch, CURLOPT_NOBODY, TRUE);                // Return body
        }
    else
        {
        if($method == GET)
            {
            if(isset($query_string))
                $target = $target . "?" . $query_string;
            curl_setopt ($ch, CURLOPT_HTTPGET, TRUE); 
            curl_setopt ($ch, CURLOPT_POST, FALSE); 
            }
        if($method == POST)
            {
            if(isset($query_string))
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $query_string);
            curl_setopt ($ch, CURLOPT_POST, TRUE); 
            curl_setopt ($ch, CURLOPT_HTTPGET, FALSE); 
            }
    	curl_setopt($ch, CURLOPT_HEADER, $incl_head);   // Include head as needed
	    curl_setopt($ch, CURLOPT_NOBODY, FALSE);        // 回傳 body
        }
	curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIE_FILE);   // Cookie 管理
	curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIE_FILE);
	curl_setopt($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT);    // Timeout
	curl_setopt($ch, CURLOPT_USERAGENT, WEBBOT_NAME);   // Webbot name
	curl_setopt($ch, CURLOPT_URL, $target);             // 目標網站
	curl_setopt($ch, CURLOPT_REFERER, $ref);            // Referer 值
	curl_setopt($ch, CURLOPT_VERBOSE, FALSE);           // Minimize logs(最小化日誌)
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // No certificate(沒有證書)
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);     // Follow redirects
	curl_setopt($ch, CURLOPT_MAXREDIRS, 4);             // Limit redirections to four
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);     // Return in string
    
    # Create return array
    $return_array['FILE']   = curl_exec($ch); 
    $return_array['STATUS'] = curl_getinfo($ch);
    $return_array['ERROR']  = curl_error($ch);
    
    # Close PHP/CURL handle
  	curl_close($ch);
    
    # Return results
  	return $return_array;
    }
function split_string($string, $delineator, $desired, $type)
    {
    # 不區分大小寫解析，轉換成字符串，並提取器為小寫
    $lc_str = strtolower($string);
	$marker = strtolower($delineator);
    
    # 再提取之前回傳字串
    if($desired == BEFORE)
        {
        if($type == EXCL)  // Return text ESCL of the delineator
            $split_here = strpos($lc_str, $marker);
        else               // Return text INCL of the delineator
            $split_here = strpos($lc_str, $marker)+strlen($marker);
        
        $parsed_string = substr($string, 0, $split_here);
        }
    # Return text AFTER the delineator
    else
        {
        if($type==EXCL)    // Return text ESCL of the delineator
            $split_here = strpos($lc_str, $marker) + strlen($marker);
        else               // Return text INCL of the delineator
            $split_here = strpos($lc_str, $marker) ;
        
        $parsed_string =  substr($string, $split_here, strlen($string));
        }
    return $parsed_string;
    }
function return_between($string, $start, $stop, $type)
    {
    $temp = split_string($string, $start, AFTER, $type);
    return split_string($temp, $stop, BEFORE, $type);
    }
function get_domain($url)
    {
    // Remove protocol from $url
    $url = str_replace("http://", "", $url);
    $url = str_replace("https://", "", $url);
    
    // Remove page and directory references
    if(stristr($url, "/"))
        $url = substr($url, 0, strpos($url, "/"));
    
    return $url;
    }
?>