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
	window.alert('�̹� ��ϵ� ��ǰ�Դϴ�.');
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
		window.alert('������ ���� �̸��� ������ �����մϴ�.');
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
	window.alert('����� �Ϸ�Ǿ����ϴ�.');
	</script>");
}
else {
	echo("<script>
	window.alert('��Ͽ� �����Ͽ����ϴ�. �ٽ� �õ����ּ���.');
	history.go(-1);
	</script>");
	exit;
}
mysql_close($con);
echo("<meta http-equiv='Refresh' content='0;url=./add_parts.html'>");
?>