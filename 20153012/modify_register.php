<?php
if(!$pUserPW) {
	echo("<script>
	window.alert('���� ��й�ȣ�� �Է��ϼ���.');
	history.go(-1);
	</script>");
	exit;
}
if(strcmp($mUserPW,$mUserPWConfirm)) {
	echo("<script>
	window.alert('������ ��й�ȣ�� �ٸ��ϴ�.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mUserHomePhone) {
	echo("<script>
	window.alert('�� ��ȭ��ȣ�� �Է��ϼ���.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mUserCellPhone) {
	echo("<script>
	window.alert('�޴���ȭ��ȣ�� �Է��ϼ���.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mUserEmail) {
	echo("<script>
	window.alert('�̸��� �ּҸ� �Է��ϼ���');
	history.go(-1);
	</script>");
	exit;
}
if(!$mPostCode) {
	echo("<script>
	window.alert('�����ȣ�� �Է��ϼ���');
	history.go(-1);
	</script>");
	exit;
}
if(!$mRoadAddress) {
	echo("<script>
	window.alert('���θ��ּҸ� �Է��ϼ���.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mJibunAddress) {
	echo("<script>
	window.alert('�����ּҸ� �Է��ϼ���.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mRestAddress) {
	echo("<script>
	window.alert('������ �ּҸ� �Է��ϼ���.');
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
	window.alert('��й�ȣ�� Ʋ�Ƚ��ϴ�.');
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
window.alert('��й�ȣ�� ����Ǿ����ϴ�.');
</script>");

echo("<meta http-equiv='Refresh' content='0;url=./mypage.php'>");

mysql_close($con);
?>