<?
if (!isset($UserID)) {
	echo ("<script>
	window.alert('로그인 사용자만 이용하실 수 있어요')
	history.go(-1)
	</script>");
	exit;
}
?>

<?php
include("./top.html");
?>

<?
if(!$spoint) $spoint=0;
// 전체 쇼핑백 테이블에서 특정 사용자의 구매 정보만을 읽어낸다
$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
$result = mysql_query("select * from shoppingbag where id = '$UserID'", $con);
$uresult = mysql_query("select * from member where uid = '$UserID'", $con);
$total = mysql_num_rows($result);
		$upoint = mysql_result($uresult, 0, "point");
echo ("
	<table border=0 width=690 cellpadding=0>
	<tr><td colspan = 13><hr></td></tr>
    <tr><td width=100 align=center><font size=2>상품사진</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=250 align=center><font size=2>상품이름</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=90 align=center><font size=2>가격(단가)</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=50 align=center><font size=2>수량</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=100 align=center><font size=2>품목별합계</td><td width=2><img src= skin/line.png width=2 height=35></td>
		<td width=100 align=center><font size=2>적립예정<br>포인트</td><td width=2><img src= skin/line.png width=2 height=35></td></tr><tr><td colspan = 13><hr></td></tr>
");

// 바로구매하기로 구매시
	if($right == 1)
	{
		$result = mysql_query("select * from rightbuy where id = '$UserID'", $con);
		$pcode = mysql_result($result, 0, "pcode");
		$quantity = mysql_result($result, 0, "quantity");
		
		$subresult = mysql_query("select * from product where code='$pcode'", $con);
		$userfile = mysql_result($subresult, 0, "userfile");
		$pname = mysql_result($subresult, 0, "name");
		$price = mysql_result($subresult, 0, "disprice");
		$point = mysql_result($subresult, 0, "point");
		$subtotalprice = $quantity * $price;
	 	   $subtotalpoint = $quantity * $point;
		    $upoint = $upoint-$spoint;
 $totalprice = $subtotalprice-$spoint; 
		echo("<tr><td align=center><a href=#   onclick=\"window.open('./photo/$userfile', '_new', 'width=450, height=450')\"><img src='./photo/$userfile' width=50 border=0></a></td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=left><font size=2><a href=p-show.php?code=$pcode>$pname</a></td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$price&nbsp;원</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=center><font size=2>$quantity&nbsp;개</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalprice&nbsp;원</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalpoint&nbsp;원</td><td width=2><img src= skin/line.png width=2 height=70></td></tr>");
     echo("<tr><td colspan = 13><hr></td></tr><tr><td colspan=13 align=center><font size=2> 총 구매 금액: $subtotalprice 원 <br><form method=post action=point.php?right=1&spoint=$spoint>포인트 할인 :	<input type=text name=spoint   value = $upoint size=10>
	 	<input type=submit value=적용></form><br> 할인적용 구매 금액: ");echo $totalprice; 
		echo("원 <br>총 적립 포인트 : $subtotalpoint 포인트</td></tr></table>");
	}
		//장바구니를 통해 구입시
		else{
if (!$total) {
     echo("<tr><td colspan=13 align=center><font   size=2><b>쇼핑백에 담긴 상품이   없습니다.</b>
        </font></td></tr></table>");
} else {

    $counter=0;
    $totalprice=0;    // 총 구매 금액  

    while ($counter < $total) :
		$pcode = mysql_result($result, $counter, "pcode");
		$quantity = mysql_result($result, $counter, "quantity");
      
		$subresult = mysql_query("select * from product where code='$pcode'", $con);
		$userfile = mysql_result($subresult, 0, "userfile");
		$pname = mysql_result($subresult, 0, "name");
		$price = mysql_result($subresult, 0, "disprice");
       $point = mysql_result($subresult, 0, "point");
		$subtotalprice = $quantity * $price;
		$totalprice = $totalprice + $subtotalprice; 
	 
	 	   $subtotalpoint = $quantity * $point;
       $totalpoint = $totalpoint + $subtotalpoint;
	   
		echo("<tr><td align=center><a href=#   onclick=\"window.open('./photo/$userfile', '_new', 'width=450, height=450')\"><img src='./photo/$userfile' width=50 border=0></a></td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=left><font size=2><a href=p-show.php?code=$pcode>$pname</a></td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$price&nbsp;원</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=center><font size=2>$quantity&nbsp;개</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalprice&nbsp;원</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalpoint&nbsp;원</td><td width=2><img src= skin/line.png width=2 height=70></td></tr>");

		$counter++;

    endwhile;
 $upoint = $upoint-$spoint;
 $totalprice = $totalprice-$spoint; 
 $tp = $totalprice+$spoint;
     echo("<tr><td colspan = 13><hr></td></tr><tr><td colspan=13 align=center><font size=2> 총 구매 금액: $tp 원 <br><form method=post action=point.php?spoint=$spoint>포인트 할인 :	<input type=text name=spoint   value = $upoint size=10>
	 	<input type=submit value=적용></form><br> 할인적용 구매 금액: ");echo $totalprice; 
		echo("원 <br>총 적립 포인트 : $totalpoint 포인트</td></tr></table>");
}
}

mysql_close($con);	//데이터베이스 연결해제

echo ("
		<table border=0 width=690><tr><td colspan = 13><hr></td></tr>
        <tr><td align=center><font size=2>저희 시계사랑 시계전문 쇼핑몰에서는 계좌이체로만 결제를 하실 수 있습니다.<br>그러므로 아래 계좌로 입금을 해주시기 바랍니다.<br><br>입금 계좌: <b> 경남은행 595-910154-33707 (예금주: 박충규)</b><br><br>
		* 구입하신 물품은 입금 확인후 배송되며 배송기간은 평균적으로 1-2일 정도가 소요되며 <br>물량이 많을 경우 더 늦쳐질 수 있습니다. 이점 참고하시길 바랍니다.<br> * 주문 진행 상황은 My Page에서 확인하실 수 있습니다.<br>
		* 물품 배송 이전에 주문 취소를 원하시면 My Page에서 직접 주문 취소 요청을 하시면 됩니다.<br>
		* <font color=red><b>단 배송이 시작되면 주문을 취소하실수가 없으니 그 전에 취소해주시기바랍니다.</b></font><br>
		* 물품을 배송 받으신 후에 구매 취소를 원하시면 고객센터(전화:1577-8624)로 연락주세요.
       </td></tr><tr><td colspan = 13><hr></td></tr>
       </table>");

echo("
    <br><br>
	<table width=690 border=0><tr><td colspan = 13><hr></td></tr>
	<tr><td align=center><font size=3><b>배송정보 입력</b></td></tr><tr><td colspan = 13><hr></td></tr>
	</table>

	<table width=690 border=0>
	<form method=post action=endshopping.php?right=$right&upoint=$upoint&uprice=$totalprice&spoint=$spoint name=buy>
	<tr><td align=right><font size=2>받는이</td>
	<td><input type=text name=receiver size=10></td>
	</tr><tr><td colspan = 13><hr></td></tr>
	<tr>
	<td align=right><font size=2>전화번호</td>
	<td><input type=text name=phone   size=20></td>
	</tr><tr><td colspan = 13><hr></td></tr>
	<tr><td height=30 align=right><font size=2>배송주소</td>
	<td align=left><input type=text size=6 name=zip readonly=readonly>
	<font size=2>[<a href='javascript:go_zip()'>우편번호검색</a>]<br>
	<input type=text size=55 name=addr readonly=readonly style='font-size:10pt; font-family:Tahoma;'>
	<input type=text size=30 name=readdr   style='font-size:10pt; font-family:Tahoma;'></td>
	</tr><tr><td colspan = 13><hr></td></tr><tr><td align=right><font size=2>주문요구사항</td>
	<td><textarea name=message rows=3 cols=65></textarea></td></tr><tr><td colspan = 13><hr></td></tr>
	<tr><td align=center colspan=2>
	<input type=submit value=구매완료></td></tr>
	<tr><td colspan = 13><hr></td></tr>
	</table>
	</form>
	</center>
");

?>
<?php
include("./bottom.html");
?>