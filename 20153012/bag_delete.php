<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("delete from shoppingbag where productCode='$productCode' and id='$UserID'",$con);
if($result)
{
	echo("<script>
	window.alert('��ٱ��Ͽ��� �����Ͽ����ϴ�.');
	location.replace('./showbag.php');
	</script>");
	exit;
}
else {
	echo("<script>
	window.alert('��ǰ ���� ����.');
	history.go(-1);
	</script>");
	exit;
}
mysql_close($con);
?>