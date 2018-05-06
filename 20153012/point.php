<?
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from userDB where userID='$UserID'",$con);
$total=mysql_num_rows($result);
$point = mysql_result($result, 0, "userPoint");
if($point < $spoint){
	echo("<script>
	window.alert('포인트가 부족합니다.');
	history.go(-1);
	</script>");
	exit;
}
if($spoint<=0) {
	echo("<script>
	history.go(-1);
	</script>");
}
if($right=="1")
{
	echo("<meta http-equiv='Refresh' content='0;url=buy.php?right=1&spoint=$spoint'>");	
}
//show.php 프로그램을 호출하면서 테이블 이름을 전달
else
{
	echo("<meta http-equiv='Refresh' content='0;url=buy.php?spoint=$spoint'>");
}
?>
