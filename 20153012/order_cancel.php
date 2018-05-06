<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from receivers where ordernum='$ordernum'",$con);
$total=mysql_num_rows($result);
$usedpoint=mysql_result($result,0,"point");


if($total) {
	$session=mysql_result($result,0,"session");
	mysql_query("delete from receivers where ordernum='$ordernum'",$con);
	$order_result=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
	$code=mysql_result($order_result,0,"code");
	$ea=mysql_result($order_result,0,"ea");
	
	$isDesktop=substr($code,0,7);
	
	if($isDesktop!="desktop") {
		mysql_query("update goodsDB set quantity=quantity+$ea, sold=sold-$ea where code='$code'",$con);
	}
	else {
		mysql_query("update desktopDB set sold=sold-$ea where code='$code'",$con);
	}
	
	mysql_query("delete from orderlist where ordernum='$ordernum'",$con);
	mysql_query("update userDB set userPoint=userPoint+$usedpoint where userID='$UserID'",$con);
}
echo("<meta http-equiv='Refresh' content='0;url=./check.php'>");
mysql_close($con);
?>