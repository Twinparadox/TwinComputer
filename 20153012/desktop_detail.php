<?php
include("./top.html");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./css/goods_detail.css">
</head>
</html>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);
$result=mysql_query("select * from desktopDB where code='$code'",$con);

mysql_query("update desktopDB set hit=hit+1 where code='$code'",$con);

$name=mysql_result($result,0,"name");
$content=mysql_result($result,0,"content");
//$isdc=mysql_result($result,0,"isDC");

$ComputerCase=mysql_result($result,$counter,"ComputerCase");
$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
$userfile=mysql_result($case_result,0,"userfile");
$savedir="./list/desktop";

$price=mysql_result($result,0,"price");
$showprice=number_format($price);
if($isdc==1) {
	$discount=mysql_result($result,0,"discount");
	$showdiscount=number_format($discount);
}

echo("<center><div class='content_wrapper'>");

echo("<div class='content_top_wrapper'>
<div class='content_image_wrapper'><img src='$savedir/$userfile' width=100% style='margin:auto'></div>");

echo("<div class='content_title_wrapper'><form action='./tobag.php?code=$code' method=post>
<div class='content_title_name'>$brand $name</div>
<div class='content_title_price'>
<table border=0 class='content_price'>
<tr><td align=right width=20%>�ǸŰ��� : </td><td align=left>");

if($isdc==0) {
	echo("<b><font color='#51afff'>$showprice</font>��</b></td></tr>");
}
else {
	echo("<b><strike><font color='#51afff'>$showprice</font>��</b></strike><br>
	<b><font color=red>$showdiscount</font>��</b></td></tr>");
}
$category = substr($code,0,4);
echo("<tr></tr>
</table></div>
<div class='content_title_etc'>
<table border=0 class='content_price'>
<tr><td align=right width=20%>��ǰ���� : </td><td align=left>�Ż�ǰ</td></tr>
<tr><td align=right width=20%>������� : </td><td align=left>��� 1~2�� �ҿ�(������, ����/�갣���� ����)</td></tr>
<tr><td align=right width=20%>AS���� : </td><td align=left>������ ��å ���� ����</td></tr>
</table></div>
<div class='content_title_ea'>
<table border=0 class='content_price'>
<tr><td align=right width=20%>���ż��� : </td><td align=left width=70%><input type=text size=2 name=ea value='1'><input id='right' type='hidden' name='right' value='0'></td></tr>
</table></div>
<div class='content_title_button'>
<input type=image width=32% src='./img/button/btn_buynow.png' onclick=document.getElementById('right').value='1';>&nbsp;<input type=image width=32% src='./img/button/btn_showbag.png'>&nbsp;<a href='./desktop.php'><img width=32% src='./img/button/btn_list.png'></a>
</div>
</div></form></div>");

echo("<div class='content_detail_wrapper'>$content</div>");
echo("<div class='content_detail_wrapper'></div>");

echo("</div></center>");
?>

<?php
include("./bottom.html");
?>