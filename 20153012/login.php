<?php
// login.html과 정보교환
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

// check id
$result = mysql_query ( "select * from userDB where userID='$w_id'", $con );
$total = mysql_num_rows($result);
if (!$total) {
	echo ("<script>
			window.alert('없는 아이디입니다.');
			history.go(-1);
			</script>");
	exit;
}

// check password
$pw_result = mysql_result ( $result, 0, "userPW" );
if ($pw_result != $w_pw) {
	echo ("<script>
			window.alert('비밀번호가 일치하지 않습니다.');
			history.go(-1);
			</script>");
	exit;
}

// id, password oK then...
$admin_result=0;
$name_result = mysql_result ( $result, 0, "userName" );
$id_result = mysql_result ( $result, 0, "userID" );
$session = md5(uniqid(rand()));
SetCookie ("Session", "$session", 0);
SetCookie ( "UserID", "$id_result", 0 );
SetCookie ( "UserName", "$name_result", 0 );
SetCookie ("isAdmin","$admin_result",0);

mysql_query("delete from shoppingbag where='$id_result'",$con);

echo ("<meta http-equiv='Refresh' content='0; url=./index.html'>	");
mysql_close ( $con );
?>