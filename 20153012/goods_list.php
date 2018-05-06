<?php include("./top.html");?>
<html>
<head>
<script language="Javascript">
function selectOpt(a)
{
	location.replace("./goods_list.php?category="+a);
}
</script>
</head>
</html>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from goodsDB where category=$category order by num",$con);
$total=mysql_num_rows($result);

echo("<center><table width=1080 border=0 style='margin-top:100px;'><tr>
<td><select name=cate onchange='selectOpt(this.options[this.selectedIndex].value);'>
<option value=''>선택</option>
<option value=1000>노트북</option>
<option value=2000>모니터</option>
<option value=3000>입력장치</option>
<option value=4000>음향장치</option>
<option value=5001>유·무선 공유기</option><option value=5002>무선 수신기</option><option value=5003>케이블</option><option value=5004>잉크젯 프린터</option><option value=5005>레이저 흑백 프린터</option><option value=5006>레이저 컬러 프린터</option>
<option value=6001>USB</option><option value=6002>외장HDD</option><option value=6003>외장ODD</option>
<option value=7000>소프트웨어</option>
</select></td></tr>
</table>");

echo("<table width=1080 border=1 style='border-collapse:collapse; text-align:center; margin-top:10px;'><tr>
<td align=center>상품코드</td>
<td colspan=2 align=center>상품명</td>
<td align=center>가격</td>
<td align=center>할인가격</td>
<td align=center>적립포인트</td>
<td align=center>수정/삭제</td></tr>");

if(!$total) {
	echo("<tr><td colspan=6 align=center>등록된 상품 없음</td></tr>");
}
else {
	$i=0;
	while($i<$total) {
		$code=mysql_result($result,$i,"code");
		$name=mysql_result($result,$i,"name");
		$userfile=mysql_result($result,$i,"userfile");
		$price=mysql_result($result,$i,"price");
		$showprice=number_format($price);
		$discount=mysql_result($result,$i,"discount");
		$showdiscount=number_format($discount);
		$point=mysql_result($result,$i,"point");
		$showpoint=number_format($point);
		
		echo("<tr>
		<td>$code</td>
		<td><img width=100 src='./list/goods/$userfile'></td>
		<td>$name</td>
		<td>$showprice</td>
		<td>$showdiscount</td>
		<td>$showpoint</td>
		<td><a href='goods_modify.php?code=$code'>[M]</a>/<a href='goods_delete.php?code=$code'>[X]</a></td></td>");
		$i++;
	}
}
echo("</table></center>");
echo("<a href='./add_goods.html'>[추가 입력]</a>");
mysql_close($con);
?>
<?php include("./bottom.html");