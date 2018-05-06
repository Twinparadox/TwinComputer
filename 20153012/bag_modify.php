<?
if(!$mea)
{
	echo("<script>
	window.alert('수량을 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
?>

<?php 
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$isDesktop=substr($productCode,0,7);
	
if($isDesktop!="desktop") {
	$result=mysql_query("select * from goodsDB where code='$productCode'",$con);
	$remain=mysql_result($result,0,"quantity");
	if($remain<$mea) {
		echo("<script>
		window.alert('재고가 없습니다.');
		history.go(-1);
		</script>");
		exit;
	}
}

$i=mysql_query("update shoppingbag set ea=$mea where productCode='$productCode' and id='$UserID'",$con);
mysql_close($con);
echo("<script>location.replace('./showbag.php')</script>");
?>