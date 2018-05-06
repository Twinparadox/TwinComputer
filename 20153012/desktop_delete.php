<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$category=substr($code,0,4);
$result=mysql_query("delete from desktopDB where code='$code'",$con);

if($result) {
	echo("<script>
	window.alert('상품이 삭제되었습니다.');
	location.replace('./desktop_list.php');
	</script>");
}
else {
	echo("<script>
	window.alert('상품이 삭제에 실패하였습니다. \\n 다시 한 번 시도해주세요.');
	history.go(-1);
	</script>");
}
mysql_close($con);

?>