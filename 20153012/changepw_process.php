<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("update userDB set userPW='$wUserPW' where userID='$uid'",$con);

if($result) {
	echo("<script>
	window.alert('��й�ȣ ���濡 �����Ͽ����ϴ�.');
	window.open('about:blank','_self').close();
	</script>");
	exit;
}
else {
	echo("<script>
	window.alert('��й�ȣ ���濡 �����Ͽ����ϴ�.');
	history.go(-1);
	</script>");
	exit;
}
?>