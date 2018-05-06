<?php
if(!$receiver) {
	echo("<script>
	window.alert('수신자가 없습니다.');
	history.go(-1);
	</script>");
	exit;
}
if(!$phone) {
	echo("<script>
	window.alert('수신자 연락처가 없습니다.');
	history.go(-1);
	</script>");
	exit;
}
if(!$wRoadAddress || !$wRestAddress) {
	echo("<script>
	window.alert('배송 주소가 없습니다.');
	history.go(-1);
	</script>");
	exit;
}
?>

<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$buy_date=date("Y-m-d H:i:s");

$ordernum=substr($buy_date,2,2)."-".strtoupper($UserID)."-".strtoupper(substr($Session,0,4)).date("H:i:s");

$address="(".$wPostCode.")"."&nbsp;".$wRoadAddress."&nbsp;".$wRestAddress;

$result=mysql_query("select * from recentreceiver where userID='$UserID' order by rdate desc");
$total=mysql_num_rows($result);

if($total==3) {
	$remove=mysql_result($result,2,"rdate");
	mysql_query("delete from recentreceiver where userID='$UserID' and rdate='$remove'");
	mysql_query("insert into recentreceiver(userID,receiverName,receiverPhone,PostCode,RoadAddress,JibunAddress,RestAddress,rdate) 
	values('$UserID','$receiver','$phone','$wPostCode','$wRoadAddress','$wJibunAddress','$wRestAddress','$buy_date')",$con);
}
else {
	mysql_query("insert into recentreceiver(userID,receiverName,receiverPhone,PostCode,RoadAddress,JibunAddress,RestAddress,rdate) 
	values('$UserID','$receiver','$phone','$wPostCode','$wRoadAddress','$wJibunAddress','$wRestAddress','$buy_date')",$con);
}

mysql_query("insert into receivers(userID,session,send,receive,phone,address,message,date,ordernum,status,point,getpoint) 
values('$UserID','$Session','$UserName','$receiver','$phone','$address','$message','$buy_date','$ordernum',1,'$usepoint','$getpoint')",$con);

if($right==1) {
	$result=mysql_query("select * from rightbuy where id='$UserID'",$con);
	$total=mysql_num_rows($result);
	
	$pcode=mysql_result($result,0,"pcode");
	$ea=mysql_result($result,0,"ea");
	
	$isDesktop=substr($pcode,0,7);
	
	if($isDesktop!="desktop") {
		$subresult=mysql_query("select * from goodsDB where code='$pcode'",$con);
		$isDC=mysql_result($subresult,0,"isDC");
		
		if($isDC==0) {
			$price=mysql_result($subresult,0,"price");
		}
		else {
			$price=mysql_result($subresult,0,"discount");
		}	
		mysql_query("update goodsDB set quantity=quantity-$ea, sold=sold+$ea where code='$pcode'",$con);
	}
	else {
		$subresult=mysql_query("select * from desktopDB where code='$pcode'",$con);
		$price=mysql_result($subresult,0,"price");
		mysql_query("update desktopDB set sold=sold+$ea where code='$pcode'",$con);
	}
	
	mysql_query("update userDB set userPoint=userPoint-$usepoint where userID='$UserID'",$con);
	mysql_query("insert into orderlist(userID,session,code,ea,after,price,ordernum) values('$UserID','$Session','$pcode','$ea',0,'$price','$ordernum')",$con);
	mysql_query("delete from rightbuy where id='$UserID'",$con);
}
else {
$result=mysql_query("select * from shoppingbag where id='$UserID'",$con);
$total=mysql_num_rows($result);
$i=0;

while($i<$total) {
	$pcode=mysql_result($result,$i,"productCode");
	$ea=mysql_result($result,$i,"ea");
	
	$isDesktop=substr($pcode,0,7);
	
	if($isDesktop!="desktop") {
		$subresult=mysql_query("select * from goodsDB where code='$pcode'",$con);
		$isDC=mysql_result($subresult,0,"isDC");
		
		if($isDC==0) {
			$price=mysql_result($subresult,0,"price");
		}
		else {
			$price=mysql_result($subresult,0,"discount");
		}
		mysql_query("update goodsDB set quantity=quantity-$ea, sold=sold+$ea where code='$pcode'",$con);
	}
	else {
		$subresult=mysql_query("select * from desktopDB where code='$pcode'",$con);
		$price=mysql_result($subresult,0,"price");
		mysql_query("update desktopDB set sold=sold+$ea where code='$pcode'",$con);
	}
	
	mysql_query("insert into orderlist(userID,session,code,ea,after,price,ordernum) values('$UserID','$Session','$pcode','$ea',0,'$price','$ordernum')",$con);
	
	$i++;
}
mysql_query("update userDB set userPoint=userPoint-$usepoint where userID='$UserID'",$con);
mysql_query("delete from shoppingbag where id='$UserID'",$con);
}

mysql_close($con);

echo("<script>
window.alert('구매가 정상적으로 처리되었습니다. \\n주문 번호는 $ordernum');
location.replace('./check.php');
</script>");
?>
