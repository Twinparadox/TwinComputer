<?php
if(!$category) {
	echo("<script>
	window.alert('��ǰ�з��� �����Ͻʽÿ�.');
	history.go(-1);
	</script>");
	exit;
}
if(!$brand) {
	echo("<script>
	window.alert('�귣�带 �Է��Ͻɽÿ�.');
	history.go(-1);
	</script>");
	exit;
}
if(!$name) {
	echo("<script>
	window.alert('��ǰ�̸��� �Է��Ͻɽÿ�.');
	history.go(-1);
	</script>");
	exit;
}
if(!$content) {
	echo("<script>
	window.alert('��ǰ������ �Է��Ͻɽÿ�.');
	history.go(-1);
	</script>");
	exit;
}
if(!$quantity) {
	echo("<script>
	window.alert('�Ǹż����� �Է��Ͻɽÿ�.');
	history.go(-1);
	</script>");
	exit;
}
if($discount=="") {
	echo("<script>
	window.alert('�������� �Է��Ͻɽÿ�.');
	history.go(-1);
	</script>");
	exit;
}
if(!$userfile) {
	echo("<script>
	window.alert('��ǰ������ �߰����ֽʽÿ�.');
	history.go(-1);
	</script>");
	exit;
}

?>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);
$result=mysql_query("select * from goodsDB where name='$name' and brand='$brand'",$con);
$total=mysql_num_rows($result);
if($total) {
	echo("<script>
	window.alert('�̹� ��ϵ� ��ǰ�Դϴ�.');
	history.go(-1);
	</script>");
}

$savedir="./list/goods";
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
$category_result=mysql_query("select * from goodsDB where category=$category",$con);
$category_total=mysql_num_rows($category_result);
$code=$category.$brand.$category_total;

if($isDC=="") {
	$isDC=0;
}

$result=mysql_query("insert into goodsDB(code,name,brand,category,content,price,discount,quantity,userfile,point,isDC) 
values('$code','$name','$brand',$category,'$content',$price,$discount,$quantity,'$userfile_name',$point,$isDC)",$con);

if($result) {
	echo("<script>
	window.alert('��ǰ��� �Ϸ�.');
	</script>");
	echo("<meta http-equiv='Refresh' content='0;url=goods_list.php?category=$category'>");
	exit;
}
else {
	echo("<script>
	window.alert('��ǰ��� ����.');
	history.go(-1);
	</script>");
	exit;
}
mysql_close($con);
?>