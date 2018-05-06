<?php
if(!$pUserPW) {
	echo("<script>
	window.alert('현재 비밀번호를 입력하세요.');
	history.go(-1);
	</script>");
	exit;
}
if(strcmp($mUserPW,$mUserPWConfirm)) {
	echo("<script>
	window.alert('변경할 비밀번호가 다릅니다.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mUserHomePhone) {
	echo("<script>
	window.alert('집 전화번호를 입력하세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mUserCellPhone) {
	echo("<script>
	window.alert('휴대전화번호를 입력하세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mUserEmail) {
	echo("<script>
	window.alert('이메일 주소를 입력하세요');
	history.go(-1);
	</script>");
	exit;
}
if(!$mPostCode) {
	echo("<script>
	window.alert('우편번호를 입력하세요');
	history.go(-1);
	</script>");
	exit;
}
if(!$mRoadAddress) {
	echo("<script>
	window.alert('도로명주소를 입력하세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mJibunAddress) {
	echo("<script>
	window.alert('지번주소를 입력하세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mRestAddress) {
	echo("<script>
	window.alert('나머지 주소를 입력하세요.');
	history.go(-1);
	</script>");
	exit;
}

$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$result=mysql_query("select * from userdb where userID='$UserID'",$con);
$userPW=mysql_result($result,0,"userPW");

if(strcmp($userPW,$pUserPW)){
	echo("<script>
	window.alert('비밀번호가 틀렸습니다.');
	history.go(-1);
	</script>");
	exit;
}
if($mUserPW=='') {
mysql_query("update userDB set userHomePhone='$mUserHomePhone', userCellPhone='$mUserCellPhone', userEmail='$mUserEmail', PostCode=$mPostCode, RoadAddress='$mRoadAddress', JibunAddress='$mJibunAddress', RestAddress='$mRestAddress' where userID='$UserID'",$con);	
}
else {
mysql_query("update userDB set userPW='$mUserPW', userHomePhone='$mUserHomePhone', userCellPhone='$mUserCellPhone', userEmail='$mUserEmail', PostCode=$mPostCode, RoadAddress='$mRoadAddress', JibunAddress='$mJibunAddress', RestAddress='$mRestAddress' where userID='$UserID'",$con);
}

echo("<script>
window.alert('비밀번호가 변경되었습니다.');
</script>");

echo("<meta http-equiv='Refresh' content='0;url=./mypage.php'>");

mysql_close($con);
?>