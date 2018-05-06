<?php
//showbag

if(!$UserID) {
	echo("<script>
	window.alert('로그인이 필요한 서비스입니다.\\n로그인 후 이용하실 수 있습니다.');
	location.replace('./login.html');
	</script>");
	exit;
}

?>
<html>
<head>
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#FFFFD2";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}
</script>
<style>
span.sort_divide_bar {
	border-left: 1px solid black;
    display: inline-block;
    border-right: 1px solid #fff;
    height: 10px;
    margin-top: 4px;
	margin-left:10px;
	margin-right:10px;
}
</style>
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

// 전체 쇼핑백 테이블에서 특정 사용자의 구매 정보만을 읽어낸다

if($sorting=="") {
	$sorting=-1;
}
if(!($sorting==1 || $sorting==0)) {
	$hit=1;
}
if($hit=="") {
	$hit=0;
}

if($hit==1) {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by productCode",$con);
}
else if($sorting==0) {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by ea",$con);
}
else if($sorting==1) {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by ea desc",$con);
}
else {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by productCode",$con);
}
$total = mysql_num_rows($result);

echo ("<center>");
echo("<table border=0 style='margin-top:50px;width:880px margin-bottom:50px;'>");
echo("<tr><td><div style='width:880px; text-align: left; padding-top: 3px; font-size: 9pt; margin: auto;'>");
echo("<div style='width:440px; display:inline-block;'>");
if($hit==1) {
	echo("<b><span><a href='showbag.php?hit=1&sorting=-1'>품목별</a></span></b>");
}
else {
	echo("<span><a href='showbag.php?hit=1&sorting=-1'>품목별</a></span>");
}
echo("<span class='sort_divide_bar'></span>");
if($sorting==0) {
	echo("<b><span><a href='showbag.php?hit=0&sorting=0'>낮은 구매량 순</a></span></b>");
}
if($sorting!=0){
	echo("<span><a href='showbag.php?hit=0&sorting=0'>낮은 구매량 순</a></span>");
}	
echo("<span class='sort_divide_bar'></span>");
if($sorting==1) {
	echo("<b><span><a href='showbag.php?hit=0&sorting=1'>높은 구매량 순</a></span></b>");
}
if($sorting!=1) {
	echo("<span><a href='showbag.php?hit=0&sorting=1'>높은 구매량 순</a></span>");
}	
echo("</div></div></td></tr></table>");
echo("<table border=0 width=880 style='margin-top:10px; border-collapse:collapse; border-top:2px solid black;'>
    <tr style='border-bottom:1px solid silver;'><td width=35% align=center><font size=2>상품사진</td>
	<td width=20% align=center><font size=2>상품이름</td>
	<td width=12% align=center><font size=2>가격(단가)</td>
	<td width=6% align=center><font size=2>수량</td>
	<td width=12% align=center><font size=2>품목별합계</td>
	<td width=10% align=center><font size=2>적립예정<br></td>
	<td width=5% align=center><font size=2>삭제</td></tr>
");

if (!$total) {
     echo("<tr><td colspan=7 align=center><font size=2>쇼핑백에 담긴 상품이 없습니다.</td></tr></table>");
}
else {

    $counter=0;
    $totalprice=0;    // 총 구매 금액  

    while ($counter < $total) {
		$productCode = mysql_result($result, $counter, "productCode");
		$ea = mysql_result($result, $counter, "ea");
		
		$isDesktop=substr($productCode,0,7);
	
		if($isDesktop!="desktop") {
			$subresult = mysql_query("select * from goodsDB where code='$productCode'", $con);
			$userfile = mysql_result($subresult, 0, "userfile");
			$savedir="./list/goods";

			$pname = mysql_result($subresult, 0, "name");
			$pbrand=mysql_result($subresult,0,"brand");
			$isDC=mysql_result($subresult,0,"isDC");
			
			if($isDC==0) {
				$price = mysql_result($subresult, 0, "price");
			}
			else {
				$price = mysql_result($subresult,0,"discount");
			}
			$point = mysql_result($subresult,0,"point");
			
			$grade=mysql_result($subresult,0,"grade");
			$grader=mysql_result($subresult,0,"grader");
		}
		else {
			$subresult=mysql_query("select * from desktopDB where code='$productCode'",$con);
			$ComputerCase=mysql_result($subresult,0,"ComputerCase");
			$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
			$userfile=mysql_result($case_result,0,"userfile");
			$savedir="./list/desktop/";
			
			$pname = mysql_result($subresult, 0, "name");
			$pbrand="트윈 컴퓨터";
			
			$price=mysql_result($subresult,0,"price");
			$point=mysql_result($subresult,0,"point");
			
			$grade=mysql_result($subresult,0,"grade");
			$grader=mysql_result($subresult,0,"grader");
		}

		$subtotalprice = $ea * $price;
		$totalprice = $totalprice + $subtotalprice; 

		$price=number_format($price);
		$subtotalprice=number_format($subtotalprice);


		$subtotalpoint = $ea * $point;
		$totalpoint = $totalpoint + $subtotalpoint;
		$subtotalpoint=number_format($subtotalpoint);

		echo ("<tr onmouseover='changeColor1(this)' onmouseout='changeColor2(this)' title='평점 : $grade ( 평가인원 : $grader )'>
		<td align=center><a href=# onclick=\"window.open('$savedir/$userfile', '_new', 'width=450,   height=450')\"><img src='$savedir/$userfile' width=80% height=200></a></td>");
		
		if($isDesktop!="desktop") {
			echo("<td align=center><font size=2><a href='./goods_detail.php?code=$productCode'>$pbrand<br>$pname</a></td>");
		}
		else {
			echo("<td align=center><font size=2><a href='./desktop_detail.php?code=$productCode'>$pbrand<br>$pname</a></td>");
		}
		
		echo("<td align=center><font size=2>$price&nbsp;원</td>
		<td align=center>
		<form method=post action='./bag_modify.php?productCode=$productCode'><input type=text name=mea size=3 value=$ea>&nbsp;<input type=submit value=변경>
		</td></form>
		<td align=center><font size=2>$subtotalprice&nbsp;원</td>
		<td align=center><font size=2>$subtotalpoint&nbsp;</td>
		<td align=center><form method=post action='./bag_delete.php?productCode=$productCode'>
		<input type=submit value=삭제></td></form>
		</tr>");

		$counter++;
	}
 	$totalprice=number_format($totalprice);
	$totalpoint=number_format($totalpoint);
    echo("<tr style='border-top:1px solid silver;'><td colspan=7 align=center><font size=2>총 구매 금액: $totalprice 원 <br>총 적립 포인트 : $totalpoint 포인트</td></tr></table>");
}

mysql_close($con);	//데이터베이스 연결해제

echo ("<table width=880 border=0 style=' margin-bottom:100px;'>
		<tr><td colspan = 6><hr></td></tr><tr><td align=center><font size=2>[<a href='./buy.php'>구매결정</a>] &nbsp; [<a href='./index.html'>쇼핑계속</a>]</td></tr>	<tr><td colspan = 6><hr></td></tr></table></center>");

?>

<?php
include("./bottom.html");
?>