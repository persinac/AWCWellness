<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');
/*
echo "Starting...";
echo ", Username: " . $_SESSION['MM_Username'];
echo ", UserID: " . $_SESSION['MM_UserID'];
*/
$colname_getUser = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUser = $_SESSION['MM_UserID'];
}

//echo $colname_getUser;

mysql_select_db($database_wellConn, $wellConn);

###
# Defualt view 
###

$query_getUserTotalActivities = "select activity, SUM(duration_of_activity) AS WeeklyActivity 
from work_activity_log wal
JOIN work_users wu ON wu.idwork_users = wal.user_id
AND yearweek(date_of_activity) = yearweek(CURRENT_DATE)
WHERE wu.idwork_users = '{$colname_getUser}'
GROUP BY activity";
$getUserFirstName = mysql_query($query_getUserTotalActivities, $wellConn) or die(mysql_error());
$totalRows_getUserFirstName = mysql_num_rows($getUserFirstName);
//echo $totalRows_getUserFirstName;
//echo $colname_getUser;
$results = array();

for($i = 0; $i < $totalRows_getUserFirstName; $i++)
{
	$results[] = mysql_fetch_assoc($getUserFirstName);
}
echo json_encode($results);	

?>