<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');
echo "Starting..."
echo "Username: ";// . $_SESSION['MM_Username'];
echo " UserID: ";// . $_SESSION['MM_UserID'];
$colname_getUser = "-1";
echo $colname_getUser;
#mysql_select_db($database_wellConn, $wellConn);

###
# Defualt view 
###
/*
$query_getUserFirstName = "select f_name from work_users where idwork_users = 1000";
$getUserFirstName = mysql_query($query_getUserFirstName, $wellConn) or die(mysql_error());
$totalRows_getUserFirstName = mysql_num_rows($getUserFirstName);
echo $totalRows_getUserFirstName;
echo $colname_getUser;
$results = array();

for($i = 0; $i < $totalRows_getUserFirstName; $i++)
{
	$results[] = mysql_fetch_assoc($getUserFirstName);
}
echo json_encode($results);	
*/
?>