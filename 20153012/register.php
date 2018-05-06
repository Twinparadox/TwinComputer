<?php
// register.php

// input filtering
if (! $wUserID) {
	echo ("<script>
			window.alert('사용자 ID를 입력하세요.');
			history.go(-1);
		</script>");
	exit ();
}
if (! $wUserPW) {
	echo ("<script>
			window.alert('사용자 비밀번호를 입력하세요.');
			history.go(-1);
		</script>");
	exit ();
}
if (! $wUserPWConfirm) {
	echo ("<script>
		window.alert('사용자 비밀번호 확인을 입력하세요.');
		history.go(-1);
		</script>");
	exit ();
}
if($wUserPW != $wUserPWConfirm) {
	echo("<script>
			window.alert('비밀번호가 일치하지 않습니다.');
			history.go(-1);
			</script>");
	exit;
}
if (! $wUserName) {
	echo ("<script>
		window.alert('사용자 이름을 입력하세요.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserHomePhone) {
	echo ("<script>
		window.alert('사용자 집전화를 입력하세요.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserCellPhone) {
	echo ("<script>
		window.alert('사용자 휴대전화를 입력하세요.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserEmail) {
	echo ("<script>
		window.alert('사용자 이메일주소를 입력하세요.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserHomePhone) {
	echo ("<script>
		window.alert('사용자 집전화를 입력하세요.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wPostCode || (! $wRoadAddress && ! $wJibunAddress) || ! $wRestAddress) {
	echo ("<script>
				window.alert('주소를 입력하세요.');
				history.go(-1);
				</script>");
	exit ();
}

// init.
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

// time var
$time = date ( "Ymdhi" );

// count register in same time
$result = mysql_query ( "select * from userDB where userCode like '$time%'", $con );
if (! $result) {
	$cnt = 0;
} else {
	$cnt = mysql_num_rows ( $result );
}

// create user's characteristic code
$UserCode = $time.$cnt;

// insert
$result = mysql_query ( "insert into userDB(userID, userPW, userName, userGender, userHomePhone, userCellPhone, userEmail, userCode, PostCode, RoadAddress, JibunAddress, RestAddress) 
			values('$wUserID', '$wUserPW', '$wUserName', '$wUserGender', '$wUserHomePhone', '$wUserCellPhone', '$wUserEmail', '$wUserCode', '$wPostCode','$wRoadAddress','$wJibunAddress','$wRestAddress')", $con );

// data check
if ($result) {
	echo ("<script>
		window.alert('Twin Computer 회원 가입을 축하드립니다.\\n 로그인 후 이용해주세요.');
		location.replace('./index.html');
		</script>");
} else {
	echo ("<script>
		window.alert('회원 가입에 실패했습니다. 다시 한 번 시도해주세요.');
		history.go(-1);
		</script>");
}

mysql_close ( $con );
?>