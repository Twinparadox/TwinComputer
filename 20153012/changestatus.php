<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from receivers where ordernum='$ordernum'",$con);
$total=mysql_num_rows($result);

if($total>0){
	$status=mysql_result($result,0,"status");
	$status++;
}
else {
	$status=1;
}

if($status==6) {
	$userID=mysql_result($result,0,"userID");
	$session=mysql_result($result,0,"session");
	$getpoint=mysql_result($result,0,"getpoint");
	$order_result=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
	$order_total=mysql_num_rows($order_result);
	
	mysql_query("update userDB set userPoint=userPoint+$getpoint where userID='$userID'",$con);
}
$result=mysql_query("update receivers set status=$status where ordernum='$ordernum'",$con);
if($isAdmin==1) {
	echo("<meta http-equiv='Refresh' content='0;url=./order_list.php'>");
}
else {
	echo("<meta http-equiv='Refresh' content='0;url=./check.php'>");
}

mysql_close($con);
?>