<?php
if(!$name) {
	echo("<script>
	window.alert('상품이름을 입력하심시오.');
	history.go(-1);
	</script>");
	exit;
}
if(!$content) {
	echo("<script>
	window.alert('상품설명을 입력하심시오.');
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

$tmp=mysql_query("select * from desktopDB",$con);
$result=mysql_query("select * from desktopDB where name='$name'",$con);
$total=mysql_num_rows($result);
$cod=mysql_num_rows($tmp);
$code="desktop".$cod;

if($total) {
	echo("<script>
	window.alert('이미 등록된 상품입니다.');
	history.go(-1);
	</script>");
}

if($CPU==",") {
	$CPU="";
}
else {
	$CPU2=explode(',',$CPU);
	$CPU=$CPU2[0];
}

if($Mainboard==",") {
	$Mainboard="";
}
else {
	$Mainboard2=explode(',',$Mainboard);
	$Mainboard=$Mainboard2[0];
}

if($RAM==",") {
	$RAM="";
}
else {
	$RAM2=explode(',',$RAM);
	$RAM=$RAM2[0];
}

if($VGA==",") {
	$VGA="";
}
else {
	$VGA2=explode(',',$VGA);
	$VGA=$VGA2[0];
}

if($SSD==",") {
	$SSD="";
}
else {
	$SSD2=explode(',',$SSD);
	$SSD=$SSD2[0];
}

if($HDD==",") {
	$HDD="";
}
else {
	$HDD2=explode(',',$HDD);
	$HDD=$HDD2[0];
}

if($ODD==",") {
	$ODD="";
}
else {
	$ODD2=explode(',',$ODD);
	$ODD=$ODD2[0];
}

echo($ComputerCase);
if($ComputerCase==",") {
	$ComputerCase="";
}
else {
	$ComputerCase2=explode(',',$ComputerCase);
	$ComputerCase=$ComputerCase2[0];
}

if($PSU==",") {
	$PSU="";
}
else {
	$PSU2=explode(',',$PSU);
	$PSU=$PSU2[0];
}

$result=mysql_query("insert into desktopDB(CPU,Mainboard,RAM,VGA,SSD,HDD,ODD,ComputerCase,PSU,price,point,content,name,code) 
values('$CPU','$Mainboard','$RAM','$VGA','$SSD','$HDD','$ODD','$ComputerCase','$PSU','$price','$point','$content','$name','$code')",$con);

if($result) {
	echo("<script>
	window.alert('상품등록 완료.');
	</script>");
	echo("<meta http-equiv='Refresh' content='0;url=add_product.html'>");
	exit;
}
else {
	echo("<script>
	window.alert('상품등록 실패.');
	history.go(-1);
	</script>");
	exit;
}

mysql_close($con);
?>