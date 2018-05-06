<?php
// admin_login.html과 정보교환
if (!$w_id) {
	echo ("<script>
			window.alert('아이디를 입력하세요.');
			history.go(-1);
			</script>");
	exit ();
}
if (!$w_pw) {
	echo ("<script>
			window.alert('비밀번호를 입력하세요.');
			history.go(-1);
			</script>");
	exit ();
}

$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$result=mysql_query("select * from adminDB where adminID='$w_id'",$con);
if(!result) {
	echo("<script>
	window.alert('등록되지 않은 관리자입니다.');
	history.go(-1);
	</script>");
	exit;
}

$pw_result=mysql_result($result,0,"adminPW");
if($pw_result!=$w_pw) {
	echo("<script>
	window.alert('비밀번호가 일치하지 않습니다.');
	history.go(-1);
	</script>");
	exit;
}

$admin_result=1;
$id_result=mysql_result($result,0,"adminID");

SetCookie("UserID","$id_result",0);
SetCookie("isAdmin","$admin_result",0);

echo("<meta http-equiv='Refresh' content='0; url=./index.html'>");
mysql_close($con);
?>