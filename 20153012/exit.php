<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$result=mysql_query("select * from userDB where userID='$UserID'",$con);
$pw=mysql_result($result,0,"userPW");

if(strcmp($pas,$pw)) {
	echo("<script>
	window.alert('��й�ȣ�� ��ġ���� �ʽ��ϴ�.');
	history.go(-1);
	</script>");
	exit;
}

$receive_result=mysql_query("select * from receivers where userID='$UserID' and status<6",$con);
$total=mysql_num_rows($receive_result);

if($total) {
	echo("<script>
	window.alert('���� ���� ���� ��ǰ�� �־�, Ż�� �Ұ����մϴ�.');
	opener.location.href='./index.php';
	self.close();
	</script>");
	exit;
}
else {
	$result=mysql_query("delete from userDB where userID='$UserID'",$con);
	
	if($result) {
		SetCookie("UserID","",time());
		SetCookie("UserName","",time());
		SetCookie("Session","",time());
		SetCookie("isAdmin","",time());
		echo("<script>
		window.alert('Ż�� �Ϸ�Ǿ����ϴ�.\\n�̿����ּż� �����մϴ�.');
		opener.location.href='./index.php';
		self.close();
		</script>");
		exit;
	}
	else {
		echo("<script>
		window.alert('Ż�� �����߽��ϴ�. �ٽ� �õ����ּ���.');
		opener.location.href='./index.php';
		self.close();
		</script>");
		exit;
	}
}
mysql_close($con);
?>