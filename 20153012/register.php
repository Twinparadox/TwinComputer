<?php
// register.php

// input filtering
if (! $wUserID) {
	echo ("<script>
			window.alert('����� ID�� �Է��ϼ���.');
			history.go(-1);
		</script>");
	exit ();
}
if (! $wUserPW) {
	echo ("<script>
			window.alert('����� ��й�ȣ�� �Է��ϼ���.');
			history.go(-1);
		</script>");
	exit ();
}
if (! $wUserPWConfirm) {
	echo ("<script>
		window.alert('����� ��й�ȣ Ȯ���� �Է��ϼ���.');
		history.go(-1);
		</script>");
	exit ();
}
if($wUserPW != $wUserPWConfirm) {
	echo("<script>
			window.alert('��й�ȣ�� ��ġ���� �ʽ��ϴ�.');
			history.go(-1);
			</script>");
	exit;
}
if (! $wUserName) {
	echo ("<script>
		window.alert('����� �̸��� �Է��ϼ���.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserHomePhone) {
	echo ("<script>
		window.alert('����� ����ȭ�� �Է��ϼ���.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserCellPhone) {
	echo ("<script>
		window.alert('����� �޴���ȭ�� �Է��ϼ���.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserEmail) {
	echo ("<script>
		window.alert('����� �̸����ּҸ� �Է��ϼ���.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wUserHomePhone) {
	echo ("<script>
		window.alert('����� ����ȭ�� �Է��ϼ���.');
		history.go(-1);
		</script>");
	exit ();
}
if (! $wPostCode || (! $wRoadAddress && ! $wJibunAddress) || ! $wRestAddress) {
	echo ("<script>
				window.alert('�ּҸ� �Է��ϼ���.');
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
		window.alert('Twin Computer ȸ�� ������ ���ϵ帳�ϴ�.\\n �α��� �� �̿����ּ���.');
		location.replace('./index.html');
		</script>");
} else {
	echo ("<script>
		window.alert('ȸ�� ���Կ� �����߽��ϴ�. �ٽ� �� �� �õ����ּ���.');
		history.go(-1);
		</script>");
}

mysql_close ( $con );
?>