<?php
# FileName="wellnessConn.php"
# Type="MYSQL"
# HTTP="true"
$hostname_wellConn = "127.0.0.1";
$database_wellConn = "cbox";
$username_wellConn = "root";
$password_wellConn = "password!";
$wellConn = mysql_pconnect($hostname_wellConn, $username_wellConn, $password_wellConn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>