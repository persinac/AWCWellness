<?php session_start(); ?>
<?php 
require_once('Connections/wellnessConn.php');

unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['MM_UserID']);
unset($_SESSION['MM_Admin']);

header("Location: wellness_index.php");

?>