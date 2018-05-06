<?php
// 주문배송조회
if(!$UserID) {
	echo("<script>
			window.alert('로그인이 필요한 서비스입니다.\\n로그인 후 이용하실 수 있습니다.');
			history.go(-1);			
			location.replace('./login.html');
			</script>");
	exit;
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/board.css">
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#E6FFFF";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}
function selectOpt(a)
{
	location.replace("./check.php?period="+a);
}
</script>
</head>
</html>

<?php
include("./top.html");
?>
<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

if($period=="0" || $period=="-1" || $period=="") {
	$period=0;
	$result=mysql_query("select * from receivers where userID='$UserID' order by date desc",$con);
	$total=mysql_num_rows($result);
}
else {
	$current_date = date("Y-m-d H:i:s");
	list($year,$month,$day,$hour,$minute,$second) = split("[- :]",$current_date);
	$before=date("Y-m-d H:i:s", mktime($hour, $minute, $second, $month-1, $day, $year ));
	$result=mysql_query("select * from receivers where userID='$UserID' and date > '$before' order by date desc",$con);
	$total=mysql_num_rows($result);
}

echo("<center><table width=880 border=0 style='margin-top:100px;'>
<tr><td align=center><b>구매내역</b></td></tr>
<tr><td>* 주문 물품이 배송 이전 단계이면 온라인으로 주문 취소가 가능합니다.</td></tr>
<tr><td>* 배송중이거나 구매 완료된 제품에 대한 반품 및 환불 요청은 당사 고객센터(전화 : 070-1234-5678)로 문의바랍니다.</td></tr>
<tr><form name=pfrm><td><input type=hidden value='$period' name=per>날짜 조회 : &nbsp;
<select name=period onchange='selectOpt(this.options[this.selectedIndex].value);'>
<option value=-1>선택</option>
<option value=0>전체</option>
<option value=1>최근 1개월</option>
<option value=3>최근 3개월</option>
<option value=6>최근 6개월</option></select>
</td><form></tr>
</table>");

echo("<table width=880 style='border-top:2px solid black; border-bottom:2px solid black; border-collapse:collapse; margin-top:30px; margin-bottom:100px; font-size:9pt;'>
<tr style='border-bottom:1px solid black'><td align=center>구매번호</td>
<td align=center>구매일자</td>
<td align=center>주문내역</td>
<td align=center>금액</td>
<td align=center>주문상태</td></tr>");

$entireprice=0;
$entirepoint=0;

if($total>0) {
	$i=0;
	while($i<$total) {
		$session=mysql_result($result,$i,"session");
		$date=mysql_result($result,$i,"date");
		$ordernum=mysql_result($result,$i,"ordernum");
		$status=mysql_result($result,$i,"status");
		$oldstatus=$status;
		$usedpoint=mysql_result($result,$i,"point");
		
		switch($status) {
			case 1:
			$status="주문신청";
			break;
			case 2:
			$status="주문접수";
			break;
			case 3:
			$status="배송준비중";
			break;
			case 4:
			$status="배송중";
			break;
			case 5:
			$status="배송완료";
			break;
			case 6:
			$status="판매완료";
			break;
		}
		
		$subresult=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
		$subtotal=mysql_num_rows($subresult);
		
		$counter=0;
		$totalprice=0;
		
		while($counter < $subtotal) {
			$code=mysql_result($subresult, $counter, "code");
			$ea=mysql_result($subresult,$counter,"ea");
			$price=mysql_result($subresult,$counter,"price");
			
			$isDesktop=substr($code,0,7);
	
			if($isDesktop!="desktop") {
				$tmpresult=mysql_query("select * from goodsDB where code='$code'",$con);
				$pname=mysql_result($tmpresult,0,"name");
				$brand=mysql_result($tmpresult,0,"brand");
				
				
			}
			else {
				$tmpresult=mysql_query("select * from desktopDB where code='$code'",$con);
				$pname=mysql_result($tmpresult,0,"name");
				$brand="트윈 컴퓨터";
			}
			$subtotalprice=$ea*$price;
			$totalprice=$totalprice+$subtotalprice;
			$counter++;
		}
		$items=$subtotal-1;
		$totalprice=$totalprice-$usedpoint;
		$entireprice=$entireprice+$totalprice;
		$entirepoint=$entirepoint+$usedpoint;
		$totalprice=number_format($totalprice);
		echo("<tr onmouseover='changeColor1(this)' onmouseout='changeColor2(this)' style='border-bottom:1px dotted silver; height:50px;'><td align=center><a href=# onclick=\"window.open('detail_check.php?ordernum=$ordernum','_new','width=940, height=500, scrollbars=yes');\">$ordernum</a></td>
		<td align=center>$date</td>");
		if($items>0) {
			echo("<td align=center>$brand&nbsp;$pname 외 $items 종</td>");
		}
		else {
			echo("<td align=center>$brand&nbsp;$pname</td>");
		}
		
		echo("<td align=right>$totalprice 원</td>");
		if($oldstatus!=5)
		{
			echo("<td align=center><font color=51afff><b>$status</b></font>");
		}
		else {
			echo("<td align=center><a href='changestatus.php?ordernum=$ordernum'><font color=red><b>$status</b></font></a>");
		}
		if($oldstatus==6) {
			echo("<br><a href=# onclick=\"window.open('./after.php?ordernum=$ordernum','후기 작성','width=800, height=700, scrollbars=yes');\"><font color=red><b>후기작성</b></font></a>");
		}
		if($oldstatus<4) {
			echo("<br><b><a href='order_cancel.php?ordernum=$ordernum'>주문취소</a></b>");
		}
		echo("</td></tr>");
		$i++;
	}
}
else {
	echo("<tr style='height:50px'><td align=center colspan=5><b style='color:#FF0000;'>주문 내역이 존재하지 않습니다.</td></tr>");
}
$entireprice=number_format($entireprice);
$entirepoint=number_format($entirepoint);

echo("<tr style='height:50px; border-top:1px solid black;'><td align=center colspan=5><b>총 구매액 : $entireprice 원<br>총 사용포인트 : $entirepoint 포인트</b></td></tr>");
echo("</table></center>");
mysql_close($con);
?>

<?php
include("./bottom.html");
?>