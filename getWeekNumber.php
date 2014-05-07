<?php require_once('Connections/wellnessConn.php'); ?>
<?php 
session_start();

mysql_select_db($database_wellConn, $wellConn);
$query_getWeek = "select yearweek(CURRENT_DATE)";

$getWeek = mysql_query($query_getWeek, $wellConn) or die(mysql_error());
$totalRows_getAdminWODs = mysql_num_rows($getWeek);
####echo $totalRows_getAdminWODs;
$row = mysql_fetch_array($getWeek);

$result = $row[0];
$week = substr($result, 4);
echo $week - 17;
mysql_close($wellConn);
?>