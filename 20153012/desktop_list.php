<?php include("./top.html");?>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from desktopDB order by code",$con);
$total=mysql_num_rows($result);

echo("<center><table width=1080 border=1 style='border-collapse:collapse; text-align:center; margin-top:10px;'><tr>
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

		$ComputerCase=mysql_result($result,$counter,"ComputerCase");
		$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
		$userfile=mysql_result($case_result,0,"userfile");
		$savedir="./list/desktop";

		$price=mysql_result($result,$i,"price");
		$showprice=number_format($price);

		$point=mysql_result($result,$i,"point");
		$showpoint=number_format($point);
		
		echo("<tr>
		<td>$code</td>
		<td><img width=100 src='./$savedir/$userfile'></td>
		<td>$name</td>
		<td>$showprice</td>
		<td>$showdiscount</td>
		<td>$showpoint</td>
		<td><a href='desktop_delete.php?code=$code'>[X]</a></td></td>");
		$i++;
	}
}
echo("</table></center>");
echo("<a href='./add_desktop.php'>[추가 입력]</a>");
mysql_close($con);
?>
<?php include("./bottom.html");