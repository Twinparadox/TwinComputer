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
	window.alert('비밀번호가 일치하지 않습니다.');
	history.go(-1);
	</script>");
	exit;
}

$receive_result=mysql_query("select * from receivers where userID='$UserID' and status<6",$con);
$total=mysql_num_rows($receive_result);

if($total) {
	echo("<script>
	window.alert('현재 구매 중인 상품이 있어, 탈퇴가 불가능합니다.');
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
		window.alert('탈퇴가 완료되었습니다.\\n이용해주셔서 감사합니다.');
		opener.location.href='./index.php';
		self.close();
		</script>");
		exit;
	}
	else {
		echo("<script>
		window.alert('탈퇴에 실패했습니다. 다시 시도해주세요.');
		opener.location.href='./index.php';
		self.close();
		</script>");
		exit;
	}
}
mysql_close($con);
?>