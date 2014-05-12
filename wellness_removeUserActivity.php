<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');
/*
echo "Starting...";
echo ", Username: " . $_SESSION['MM_Username'];
echo ", UserID: " . $_SESSION['MM_UserID'];
*/
$t_activity_id = $_POST['activity_id'];

$query_removeUserActivity = "DELETE FROM work_activity_log WHERE activity_id = $t_activity_id";
$removeUserActivity = mysql_query($query_removeUserActivity, $wellConn) or die(mysql_error());
$totalRows_getUserActivities = mysql_num_rows($removeUserActivity);
mysql_close($wellConn);
?>