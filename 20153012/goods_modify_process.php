<?php
if($mcategory=="") {
	echo("<script>
	window.alert('상품 분류를 선택해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mbrand) {
	echo("<script>
	window.alert('브랜드를 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mname) {
	echo("<script>
	window.alert('상품이름을 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mcontent) {
	echo("<script>
	window.alert('상품설명을 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mprice) {
	echo("<script>
	window.alert('상품가격을 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$mquantity) {
	echo("<script>
	window.alert('상품수량을 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if($mdiscount=="") {
	echo("<script>
	window.alert('할인가격을 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if($mpoint=="") {
	echo("<script>
	window.alert('적립포인트를 입력해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if($muserfile) {
	$fileexchange=1;
}
else {
	$fileexchange=0;
}
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from goodsDB where code='$code'",$con);
$category=mysql_result($result,$i,"category");
$brand=mysql_result($result,$i,"brand");
$len1=strlen($category);
$len2=strlen($brand);
$len3=strlen($code);
$sum1=$len1+$len2;
$sum2=$len3-$sum1;
$num=substr($code,$sum1,$sum2);

$newcode=$mcategory.$mbrand.$num;

$savedir="./list/goods";
if($fileexchange) {
	$temp=$muserfile_name;
	if(file_exists("$savedir/$temp")) {
	}
	else {
	}
}
else {
	if($mIsDC=="") {
		$mIsDC=0;
	}
	$insert_result=mysql_query("update goodsDB set code='$newcode', name='$mname', brand='$mbrand', category=$mcategory,
	content='$mcontent', price=$mprice, discount=$mdiscount, point=$mpoint, quantity=$mquantity, isDC=$mIsDC where code='$code'",$con);
}
if($insert_result) {
	echo("<script>
	window.alert('상품수정 완료.');
	</script>");
	echo("<meta http-equiv='Refresh' content='0;url=goods_list.php?category=$category'>");
	exit;
}
else {
	echo("<script>
	window.alert('상품수정 실패.');
	history.go(-1);
	</script>");
	exit;
}
mysql_close($con);
?>