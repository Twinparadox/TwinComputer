<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$category=substr($code,0,4);
$result=mysql_query("delete from goodsDB where code='$code'",$con);

if($result) {
	echo("<script>
	window.alert('��ǰ�� �����Ǿ����ϴ�.');
	location.replace('./goods_list.php?category=$category');
	</script>");
}
else {
	echo("<script>
	window.alert('��ǰ�� ������ �����Ͽ����ϴ�. \\n �ٽ� �� �� �õ����ּ���.');
	history.go(-1);
	</script>");
}
mysql_close($con);

?>