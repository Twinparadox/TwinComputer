<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from partsDB where name='$partsName' and kind='$parts'",$con);
$total=mysql_num_rows($result);
if($total) {
	echo("<script>
	window.alert('이미 등록된 상품입니다.');
	history.go(-1);
	</script>");
}

$result=mysql_query("select * from partsDB where kind='$parts'",$con);
$total=mysql_num_rows($result);

$code=$parts.$total;

if($parts=="ComputerCase")
{
	$savedir="./list/desktop";
	$temp=$userfile_name;
	if(file_exists("$savedir/$temp")) {
		echo("<script>
		window.alert('동일한 파일 이름이 서버에 존재합니다.');
		history.go(-1);
		</script>");
	}
	else {
		copy($userfile,"$savedir/$temp");
		unlink($userfile);
	}
	$result=mysql_query("insert into partsDB(kind,name,price,code,userfile)
	values('$parts','$partsName','$partsPrice','$code','$userfile_name')",$con);
}
else {
	$result=mysql_query("insert into partsDB(kind,name,price,code) 
	values('$parts','$partsName','$partsPrice','$code')",$con);
}

if($result==1) {
	echo("<script>
	window.alert('등록이 완료되었습니다.');
	</script>");
}
else {
	echo("<script>
	window.alert('등록에 실패하였습니다. 다시 시도해주세요.');
	history.go(-1);
	</script>");
	exit;
}
mysql_close($con);
echo("<meta http-equiv='Refresh' content='0;url=./add_parts.html'>");
?>