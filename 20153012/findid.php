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
	window.alert('입력하신 정보와 일치하는 아이디가 없습니다.');
	history.go(-1);
	</script>");
	exit;
}
else {
	$id=mysql_result($result,0,"userID");
	echo("<script>
	window.alert('귀하의 아이디는 $id 입니다.');
	self.close();
	</script>");
	exit;
}

mysql_close($con);
?>