<?php
include("./top.html");
?> 

<?php
echo ("<center><table border=0 width=880 style='margin-top:100px'>
<tr><td align=center><font size=3><b>[주문 내역 조회]</b></td></tr>
</tr></table>");
	  	  
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);
	
$result = mysql_query("select * from receivers order by date desc", $con);
$total = mysql_num_rows($result);

echo ("<table border=1 width=880 style='border-collapse:collapse; margin-bottom:100px;'>
<tr valign=center>
<td align=center><font size=2><b>주문번호</b></td>
<td align=center><font size=2><b>주문일자</b></td>
<td align=center><font size=2><b>주문내역</b></td>
<td align=center><font size=2><b>주문총액</b></td>
<td align=center><font size=2><b>상태변경</b></td></tr>");	

if ($total > 0) {	

	$counter = 0;
		
	while($counter < $total){
		$session=mysql_result($result,$counter,"session");
		$buydate = mysql_result($result, $counter, "date");
		$ordernum = mysql_result($result, $counter, "ordernum");
		$status = mysql_result($result, $counter, "status");
		$id=mysql_result($result,$counter,"userID");
			 
		switch ($status) {
			case 1:
				$tstatus = "주문신청";
				break;
			case 2:
				$tstatus = "주문접수";
				break;
			case 3: 
				$tstatus = "배송준비중";
				break;
			case 4:
				$tstatus = "배송중";
				break;
			case 5:
				$tstatus = "배송완료";
				break;
			case 6:
				$tstatus = "구매완료";
				break;
		}
		  
		$subresult = mysql_query("select * from orderlist where ordernum='$ordernum'", $con);
		$subtotal = mysql_num_rows($subresult);
		$sub_receiver=mysql_query("select * from receivers where ordernum='$ordernum'",$con);
		$sub_point=mysql_result($sub_receiver,0,"point");
		$subcounter=0;
		$totalprice=0;

		while ($subcounter < $subtotal) {
			$pcode = mysql_result($subresult, $subcounter, "code");
			$ea = mysql_result($subresult, $subcounter, "ea");
			
			$isDesktop=substr($pcode,0,7);
	
			if($isDesktop!="desktop") {
				$tmpresult = mysql_query("select * from goodsDB where code='$pcode'", $con);
				$pname = mysql_result($tmpresult, 0, "name");
				$price = mysql_result($tmpresult, 0, "price");
			}
			else {
				$tmpresult=mysql_query("select * from desktopDB where code='$pcode'",$con);
				$pname = mysql_result($tmpresult, 0, "name");
				$price = mysql_result($tmpresult, 0, "price");
			}
		   
			$subtotalprice = $ea * $price;
			$totalprice = $totalprice+$subtotalprice;
			$subcounter++;
		}

		$items = $subtotal - 1;
		
		$totalprice=$totalprice-$sub_point;
		$totalprice=number_format($totalprice);
		
		echo ("<tr><td align=center><a href=#   onclick=\"window.open('detail_check.php?ordernum=$ordernum', '_new', 'width=940, height=250, scrollbars=yes');\"><font size=2>$ordernum</a></td>
		<td align=center><font size=2>$buydate</td>
		<td><font size=2>$pname 외 $items 종</td>
		<td align=right><font size=2>$totalprice 원</td>
		<td align=center><font size=2>");
		if ($status < 6) { 
			echo ("<a href=changestatus.php?ordernum=$ordernum><font color=51afff><b>$tstatus</b></font></a></td></tr>");
		}
		else {
			echo ("<b>$tstatus</b></td></tr>");
		}

		$counter++;
	}
}
else {
       echo ("<tr><td align=center colspan=5><font size=2><b>주문 내역이 존재하지 않습니다</b></td></tr>");
}

echo ("</table></center>");

mysql_close($con);

?>
<?php
include("./bottom.html");
?> 