<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$cate=substr($code,0,4);
if($wIsDC=="") {
	$wIsDC=0;
}
echo($cate);
$result=mysql_query("update goodsDB set quantity=$wQauntity, price=$wPrice, discount=$wDiscount, point=$wPoint, isDC=$wIsDC where code='$code'",$con);

if($result) {
	echo("<script>
	window.alert('수정이 완료되었습니다.');
	location.replace('inventory.php?cate=$cate');
	</script>");
}
else {
	echo("<script>
	window.alert('수정에 실패했습니다.');
	history.go(-1);
	</script>");
}
?>