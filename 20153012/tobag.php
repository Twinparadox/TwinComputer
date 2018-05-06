<?php
// to shoppingbag
if (! $UserID) {
	echo ("<script>
	window.alert('로그인이 필요한 서비스입니다.\\n로그인 후 이용하실 수 있습니다.');
	location.replace('./login.html');
	</script>");
	exit;
}

$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$isDesktop=substr($code,0,7);

// if over the quantity, return;
if($isDesktop!="desktop") {
	$remain_result=mysql_query("select * from goodsDB where code='$code'",$con);
	$remain=mysql_result($remain_result,0,"quantity");


	if($remain==0) {
		echo("<script>
		window.alert('현재 매진된 제품입니다.');
		history.go(-1);
		</script>");
		exit;
	}
	if ($remain<$ea) {
		echo ("<script>
		window.alert('구매량이 재고를 초과합니다.');
		history.go(-1);
		</script>");
		exit;
	}
	else if($ea<1) {
		echo("<script>
		window.alert('반드시 1개 이상 주문하여야 합니다.');
		history.go(-1);
		</script>");
		exit;
	}
}
else {
	if($ea<1) {
		echo("<script>
		window.alert('반드시 1개 이상 주문하여야 합니다.');
		history.go(-1);
		</script>");
		exit;
	}
}

if($right==1) {
	$result=mysql_query("select * from rightbuy where id='$UserID'",$con);
	$total=mysql_num_rows($result);
	if($total) {
		mysql_query("delete from rightbuy where id='$UserID'",$con);
	}
	mysql_query("insert into rightbuy(id,pcode,ea) values('$UserID','$code','$ea')",$con);
	echo("<meta http-equiv='Refresh' content='0; url=buy.php?right=$right'>");
}

else {
if (! isset ( $ea )) {
	$ea = 1;
}

// if already, add product
$result = mysql_query ( "select * from shoppingbag where session='$Session' and productCode='$code'", $con );
$total = mysql_num_rows ( $result );

if ($total) {
	$oldnum=mysql_result($result,0,"ea");
}

if($oldnum) {
	$ea=$oldnum+$ea;
	mysql_query("update shoppingbag set ea=$ea where session='$Session' and productCode='$code'",$con);
}
else {
	mysql_query("insert into shoppingbag(id,session,productCode,ea) values('$UserID','$Session','$code',$ea)",$con);
}

mysql_close($con);

echo("<meta http-equiv='Refresh' content='0;url=./goods_detail.php?code=$code'>");
?>

<script   language='Javascript'>
var answer = confirm("장바구니에 담았습니다. 장바구니로 가시겠습니까?")
if(answer == true) {
	window.location = "./showbag.php";
}
else {
}
</script>

<?php
}
?>