<?php
// logout

$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

SetCookie("UserID","",time());
SetCookie("UserName","",time());
SetCookie("Session","",time());
SetCookie("isAdmin","",time());

echo("<meta http-equiv='Refresh' content='0;url=./index.html'>");
mysql_close($con);
?>