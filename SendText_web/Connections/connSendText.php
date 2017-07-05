<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connHome = "localhost";
$database_connHome = "musicyou";
$username_connHome = "root";
$password_connHome = "123";
$connSendText = mysqli_connect($hostname_connHome, $username_connHome, $password_connHome, $database_connHome) or trigger_error(mysqli_connect_errno(),E_USER_ERROR);
mysqli_query($connSendText, "SET NAMES UTF8");
?>