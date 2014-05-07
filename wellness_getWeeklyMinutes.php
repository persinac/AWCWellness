<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');

$date = $_POST['dateArray'];
$t_value_array = array();
//echo "Date: " . $date;
$colname_getUserStrength = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserStrength = $_SESSION['MM_UserID'];
}
mysql_select_db($database_wellConn, $wellConn);

$t_string_builder = ""; //nice to have

#######
#
# MySql insert
#
#######
//echo "Count: " .count($date);
foreach ($date as &$value) {
    //echo $value ." ";
	
	$query_getDailyMinutes = "select SUM(duration_of_activity) AS WeeklyActivity
	from work_activity_log wal
	JOIN work_users wu ON wu.idwork_users = wal.user_id
	WHERE date_of_activity = '{$value}'";
	$getDailyMinutes = mysql_query($query_getDailyMinutes, $wellConn) or die(mysql_error());
	$totalRows_getAdminWODs = mysql_num_rows($getDailyMinutes);
	//echo $totalRows_getAdminWODs;
	$row = mysql_fetch_array($getDailyMinutes);
	$t_val = 0;
	if(is_null($row[0])) {
		$t_val = 0;
	} else {
		$t_val = $row[0];
	}
	array_push($t_value_array, $t_val);
}
echo json_encode($t_value_array);	
mysql_close($wellConn);
?>