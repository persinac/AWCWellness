<?php session_start(); ?>
<?php
require_once('Connections/wellnessConn.php');

echo "Starting...";
echo ", Username: " . $_SESSION['MM_Username'];
echo ", UserID: " . $_SESSION['MM_UserID'];
echo ", POST name: " . $_POST['password'];


$colname_getUserStrength = "-1";
if (isset($_SESSION['MM_UserID'])) {
  $colname_getUserStrength = $_SESSION['MM_UserID'];
}
mysql_select_db($database_wellConn, $wellConn);

$t_user_id = $_SESSION['MM_UserID'];
$t_password = $_POST['password'];

$t_string_builder = ""; //nice to have

#######
#
# MySql insert
#
#######

$query_update_pw = "update work_login set password = '{$t_password}' where user_id = '{$t_user_id}'";
//echo $query_insert_wod;
$retval = mysql_query( $query_update_pw, $wellConn );
if(! $retval )
{
  die('Could not enter data: ' . mysql_error());
}
echo "Changed Password Successfully\n";
mysql_close($wellConn);
?>