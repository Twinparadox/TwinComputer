<script language="Javascript">
function a() {
	var id=document.idcheck.newid.value;
	if(id=="") {
		window.alert("아이디를 입력해주세요");
	}
	else {
		if(id.length<5 || id.length>12) {
			window.alert("아이디는 5글자 이상 12글자 이하로 입력해주세요!");
		}
		else {
			document.idcheck.submit();
		}
	}
}
function b() {
	opener.twin.wUserID.value=document.idcheck.id.value;
	this.close();
}
</script>
<form method=post action=id_check.php name=idcheck>
<center>
<table width=80% height=80% style="border-collapse:collapse; border:1px solid silver">
<tr><td align=center>
<?php
// id_check
if(isset($newid)) {
	$id=$newid;
}
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from userDB where userID='$id'",$con);
$total=mysql_num_rows($result);

if($total==0) {
	echo("<b>$id</b>은(는) <font color=red><b>사용 가능한 아이디</b></font>입니다.<br>사용하시겠습니까?
	<br><br><a href='javascript:b()'><input type=hidden name=id value='$id'><img src='./img/button/btn_accept.png' width=120></a>
	<br><br>*&nbsp;<b>아이디</b>&nbsp;<input type=text name=newid size=20>&nbsp;&nbsp;<a href='javascript:a()'><button>중복검사</button></a>");
}
else {
	echo("<b>$id</b>은(는) 이미 사용 중인 아이디입니다.<br>다른 아이디를 입력해주세요.
	<br><br><br>*&nbsp;<b>아이디</b>&nbsp;<input type=text name=newid size=20>&nbsp;&nbsp;<a href='javascript:a()'><button>중복검사</button></a>");
}

mysql_close($con);
?>
</td></tr></table></center></form>