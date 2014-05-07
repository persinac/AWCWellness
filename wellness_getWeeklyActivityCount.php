<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');

$date = $_POST['date'];
//echo "Date: " . $date;
$colname_getUserStrength = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserStrength = $_SESSION['MM_UserID'];
}
mysql_select_db($database_wellConn, $wellConn);

$t_string_builder = ""; //nice to have

$query_getActivities = "select activity, COUNT(activity) AS activityCount
from work_activity_log wal
JOIN work_users wu ON wu.idwork_users = wal.user_id
WHERE yearweek('{$date}') = yearweek(CURRENT_DATE)
GROUP BY activity";

$getActivities = mysql_query($query_getActivities, $wellConn) or die(mysql_error());
$totalRows_getActivities = mysql_num_rows($getActivities);
//echo $totalRows_getAdminWODs;
$results = array();

for($i = 0; $i < $totalRows_getActivities; $i++)
{
	$results[] = mysql_fetch_assoc($getActivities);
}
echo json_encode($results);	
mysql_close($wellConn);
?>