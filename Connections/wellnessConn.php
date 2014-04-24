<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_wellConn = "127.0.0.1";
$database_wellConn = "cbox";
$username_wellConn = "root";
$password_wellConn = "password!";
$cboxConn = mysql_pconnect($hostname_cboxConn, $username_cboxConn, $password_cboxConn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>