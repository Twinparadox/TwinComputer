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
	window.alert('비밀번호 변경에 성공하였습니다.');
	window.open('about:blank','_self').close();
	</script>");
	exit;
}
else {
	echo("<script>
	window.alert('비밀번호 변경에 실패하였습니다.');
	history.go(-1);
	</script>");
	exit;
}
?>