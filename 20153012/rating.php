<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from receivers where ordernum='$ordernum'",$con);
$session=mysql_result($result,0,"session");

$order_result=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
$total=mysql_num_rows($order_result);

$i=0;
while($i<$total) {
	$num=$i+1;
	$rating=${"code".$num};
	if($rating=="") {
		echo("<script>
		window.alert('모든 상품을 평가해주시기 바랍니다.');
		history.go(-1);
		</script>");
		exit;
	}
	$i++;
}

$i=0;
while($i<$total) {
	$num=$i+1;
	$rating=${"code".$num};
	$code=mysql_result($order_result,$i,"code");
	
	$isDesktop=substr($code,0,7);
	
	if($isDesktop!="desktop") {
		$subresult=mysql_query("select * from goodsDB where code='$code'",$con);
		$grade=mysql_result($subresult,0,"grade");
		$grader=mysql_result($subresult,0,"grader");
		
		$sum=$grade+$rating;
		$grade=($sum)/($grader+1);
		
		mysql_query("update goodsDB set grade='$grade', grader=grader+1 where code='$code'",$con);
	}
	else {
		$subresult=mysql_query("select * from desktopDB where code='$code'",$con);
		$grade=mysql_result($subresult,0,"grade");
		$grader=mysql_result($subresult,0,"grader");
		
		$sum=$grade+$rating;
		$grade=($sum)/($grader+1);
		
		mysql_query("update desktopDB set grade='$grade', grader=grader+1 where code='$code'",$con);
	}
	mysql_query("update orderlist set after=1 where code='$code' and session='$session'",$con);
	$i++;
}

echo("<script>
window.alert('평가가 완료되었습니다.');
self.close();
</script>");
exit;

mysql_close($con);
?>