<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from userDB where userName='$uname' and userEmail='$email'",$con);
$total=mysql_num_rows($result);

if(!$total) {
	echo("<script>
	window.alert('�Է��Ͻ� ������ ��ġ�ϴ� ���̵� �����ϴ�.');
	history.go(-1);
	</script>");
	exit;
}
else {
	$id=mysql_result($result,0,"userID");
	echo("<script>
	window.alert('������ ���̵�� $id �Դϴ�.');
	self.close();
	</script>");
	exit;
}

mysql_close($con);
?>