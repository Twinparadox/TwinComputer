<html>
<head>
<title>�ֹ� �� ����</title>
<style>
td {
	font-size:9pt;
	text-align:center;
}
</style>
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#FFFFD2";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}	
</script>
</head>
<html>

<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from receivers where ordernum='$ordernum'",$con);
$send=mysql_result($result,0,"send");
$receive=mysql_result($result,0,"receive");
$phone=mysql_result($result,0,"phone");
$address=mysql_result($result,0,"address");
$message=mysql_result($result,0,"message");
$point=mysql_result($result,0,"point");


$date=mysql_result($result,0,"date");
$status=mysql_result($result,0,"status");

$session=mysql_result($result,0,"session");

echo("<center>");
echo("<table border=1 style='border-collapse:collapse; width:700;'>
<tr bgcolor=#FFFFD2 height=30><td>������ ���</td>
<td>�޴� ���</td>
<td>�޴� ��� ��ȣ</td>
<td>�޴� ��� �ּ�</td></tr>
<tr height=40><td>$send</td>
<td>$receive</td>
<td>$phone</td>
<td>$address</td></tr>

<tr><td colspan=4 bgcolor=#FFFFD2 height=30>������ �޼���</td></tr>
<tr height=100><td colspan=4>$message</td></tr>");
echo("</table>");

$order_result=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
$order_total=mysql_num_rows($order_result);

echo("<table style='border-collapse:collapse; border-top:2px solid black; border-bottom:2px solid black; width:700; margin-top:10px;'>");
echo("<tr><td colspan=6>��ǰ ���� ����</td></tr>");
echo("<tr style='border-bottom:1px solid black;'>
<td width=20%>��ǰ����</td>
<td width=20%>��ǰ�̸�</td>
<td width=15%>����</td>
<td width=15%>���ż���</td>
<td width=15%>�����հ�</td>
<td width=15%>����Ʈ�հ�</td></tr>");

$i=0;

$total_point=0;
$total_price=0;
while($i<$order_total) {
	$code=mysql_result($order_result,$i,"code");
	$ea=mysql_result($order_result,$i,"ea");
	
	$isDesktop=substr($code,0,7);
	
	if($isDesktop!="desktop") {
		$product_result=mysql_query("select * from goodsDB where code='$code'",$con);
		$product_name=mysql_result($product_result,0,"name");
		$product_brand=mysql_result($product_result,0,"brand");
		$product_point=mysql_result($product_result,0,"point");
		$product_DC=mysql_result($product_result,0,"isDC");
		$product_pic=mysql_result($product_result,0,"userfile");
		$savedir="./list/goods/";
	}
	else {
		$product_result=mysql_query("select * from desktopDB where code='$code'",$con);
		$product_name=mysql_result($product_result,0,"name");
		$product_brand="Ʈ�� ��ǻ��";
		$product_point=mysql_result($product_result,0,"point");
		$ComputerCase=mysql_result($product_result,0,"ComputerCase");
		$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
		$product_pic=mysql_result($case_result,0,"userfile");
		$savedir="./list/desktop/";
	}
	
	$sub_point=$ea*$product_point;
	$total_point=$total_point+$sub_point;
	$sub_point=number_format($sub_point);

	$product_price=mysql_result($order_result,$i,"price");
	$sub_price=$product_price*$ea;
	$total_price=$total_price+$sub_price;
	$product_price=number_format($product_price);
	$sub_price=number_format($sub_price);
	
	echo("<tr style='border-bottom:1px dotted silver;' onmouseover='changeColor1(this)' onmouseout='changeColor2(this)'>
	<td><img src='$savedir/$product_pic' width=100px height=100px></td>
	<td>$product_name</td>
	<td>$product_price</td>
	<td>$ea</td>
	<td>$sub_price</td>
	<td>$sub_point</td></tr>");
	
	$i++;
}
$result_price=$total_price-$point;
$total_point=number_format($total_point);
$total_price=number_format($total_price);
$point=number_format($point);
$result_price=number_format($result_price);
echo("<tr style='border-top:1px solid black; border-bottom:1px dotted silver; height:30px;'><td colspan=4 align=center>�հ�</td><td>$total_price</td><td>$total_point</td>
<tr style='border-top:1px solid black; height:30px;'><td colspan=4 align=center>��� ����Ʈ</td><td colspan=2>$point</td></tr>
<tr style='border-top:1px solid black; height:30px;'><td colspan=4 align=center>���� �ݾ�</td><td colspan=2>$result_price</td></tr></table>");

echo("</center>");

?>