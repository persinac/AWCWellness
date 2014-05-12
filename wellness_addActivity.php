<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');

echo "Starting...";
echo ", Username: " . $_SESSION['MM_Username'];
echo ", UserID: " . $_SESSION['MM_UserID'];
echo ", POST name: " . $_POST['name'];
echo ", POST date: " . $_POST['date'];
echo ", POST time: " . $_POST['time'];


$colname_getUserStrength = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserStrength = $_SESSION['MM_UserID'];
}
mysql_select_db($database_wellConn, $wellConn);

$t_user_id = $_SESSION['MM_UserID'];
$t_activity = $_POST['name'];
$t_date = $_POST['date'];
$t_duration = $_POST['time'];

$t_string_builder = ""; //nice to have

#######
#
# MySql insert
#
#######
$query_getMaxActivityID = "SELECT MAX(activity_id) FROM work_activity_log";
$getMaxActivityID = mysql_query( $query_getMaxActivityID, $wellConn );
$row = mysql_fetch_array($getMaxActivityID);

$maxID = $row[0];
$newMaxID = $maxID + 1;

$query_insert_wod = "insert into work_activity_log values ('{$t_user_id}', '{$t_activity}', '{$t_date}', '{$t_duration}', '{$newMaxID}')";
//echo $query_insert_wod;
$retval = mysql_query( $query_insert_wod, $wellConn );
if(! $retval )
{
  die('Could not enter data: ' . mysql_error());
}
echo "Entered data successfully\n";
mysql_close($wellConn);
?>
?>