<?php require_once('Connections/wellnessConn.php'); ?>
<?php
session_start();
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
} #end function

mysql_select_db($database_wellConn, $wellConn);

$t_week_num = $_POST['week'];
$t_week_query = "";
if(strlen($t_week_num) > 0) {
	$t_week_num = "date_of_activity";
	$t_week_query = " AND yearweek(date_of_activity) = yearweek(CURRENT_DATE) ";
} else {
	$t_week_query = " AND yearweek('{$t_week_num}') = yearweek(date_of_activity) ";
}

###
# Defualt view 
###
$query_getAdminWeeklyTotals = "select user_id, CONCAT(wu.f_name, ' ', wu.l_name) AS Name, SUM(duration_of_activity) AS WeeklyActivity 
from work_activity_log wal
JOIN work_users wu ON wu.idwork_users = wal.user_id
AND yearweek(date_of_activity) = yearweek(CURRENT_DATE)
GROUP BY user_id
ORDER BY WeeklyActivity DESC";
$getAdminWeeklyTotals = mysql_query($query_getAdminWeeklyTotals, $wellConn) or die(mysql_error());
$totalRows_getAdminWeeklyTotals = mysql_num_rows($getAdminWeeklyTotals);
$results = array();

for($i = 0; $i < $totalRows_getAdminWeeklyTotals; $i++)
{
	$results[] = mysql_fetch_assoc($getAdminWeeklyTotals);
}
echo json_encode($results);	
?>