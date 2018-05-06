<?php
include("./top.html");
?>
<html>
<head>
<script language="javascript">
function selectOpt(a)
{
	location.replace("./inventory.php?cate="+a);
}
function changeColor1(obj) {
	obj.style.backgroundColor="#E6FFFF";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}
</script>
</head>
</html>
<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

if($cate=="")
{
	$cate=1000;
}

$result=mysql_query("select * from goodsDB where category='$cate' order by quantity",$con);
$total=mysql_num_rows($result);

echo("<div width=1080 style='margin-top:100px; margin-bottom:10px;'><select name=cate onchange='selectOpt(this.options[this.selectedIndex].value);'>
<option value=''>선택</option>
<option value=1000>노트북</option>
<option value=2000>모니터</option>
<option value=3000>입력장치</option>
<option value=4000>음향장치</option>
<option value=5001>유·무선 공유기</option><option value=5002>무선 수신기</option><option value=5003>케이블</option><option value=5004>잉크젯 프린터</option><option value=5005>레이저 흑백 프린터</option><option value=5006>레이저 컬러 프린터</option>
<option value=6001>USB</option><option value=6002>외장HDD</option><option value=6003>외장ODD</option>
<option value=7000>소프트웨어</option>
</select></div>");

echo("<center><table border=0 width=1080 style='border-top:2px solid black; border-bottom:1px solid black; border-collapse:collapse; text-align:center; margin-bottom:100px; font-size:9pt;'><tr style='border-bottom:1px solid black;'>
<td align=center>카테고리</td>
<td align=center>브랜드</td>
<td align=center>제품명</td>
<td align=center>제품재고</td>
<td align=cenetr>제품가격</td>
<td align=center>할인가격</td>
<td align=center>적립포인트</td>
<td align=center>할인여부</td>
<td align=center>확인</td></tr>");

$i=0;
while($i<$total) {
	$code=mysql_result($result,$i,"code");
	$category=mysql_result($result,$i,"category");
	$brand=mysql_result($result,$i,"brand");
	$pname=mysql_result($result,$i,"name");
	$quantity=mysql_result($result,$i,"quantity");
	$price=mysql_result($result,$i,"price");
	$discount=mysql_result($result,$i,"discount");
	$point=mysql_result($result,$i,"point");
	$isDC=mysql_result($result,$i,"isDC");
	
	echo("<tr style='border-bottom:1px dotted silver;' onmouseover='changeColor1(this)' onmouseout='changeColor2(this)'><form action='inventory_input.php?code=$code' method=post><td>");
	switch($category) {
		case 1000:
		echo("노트북");
		break;
		
		case 2000:
		echo("모니터");
		break;
		
		case 3000:
		echo("입력장치");
		break;
		
		case 4000:
		echo("음향장치");
		break;
		
		case 5001:
		echo("유·무선 공유기");
		break;
		
		case 5002:
		echo("무선 수신기");
		break;
		
		case 5003:
		echo("케이블");
		break;
		
		case 5004:
		echo("잉크젯 프린터");
		break;
		
		case 5005:
		echo("레이저 흑백 프린터");
		break;
		
		case 5006:
		echo("레이저 컬러 프린터");
		break;
		
		case 6001:
		echo("USB");
		break;
		
		case 6002:
		echo("외장HDD");
		break;
		
		case 6003:
		echo("외장ODD");
		break;
		
		case 7000:
		echo("소프트웨어");
		break;
		
		default:
		break;
	}
	echo("</td>
	<td>$brand</td>
	<td>$pname</td>
	<td><input type=text value=$quantity name=wQauntity></td>
	<td><input type=text value=$price name=wPrice></td>
	<td><input type=text value=$discount name=wDiscount></td>
	<td><input type=text value=$point name=wPoint></td>");
	
	if($isDC==1) {
		echo("<td><input type=checkbox checked='checked' value='1' name=wIsDC></td>");
	}
	else {
		echo("<td><input type=checkbox value='1' name=wIsDC></td>");
	}
	echo("<td><input type=submit value='확인'></td></form></tr>");
	$i++;
}

echo("</table></center>");
?>
<?php
include("./bottom.html");
?>