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
$result=mysql_query("select * from goodsDB where code='$code'",$con);

mysql_query("update goodsDB set hit=hit+1 where code='$code'",$con);

$name=mysql_result($result,0,"name");
$brand=mysql_result($result,0,"brand");
$content=mysql_result($result,0,"content");
$isdc=mysql_result($result,0,"isDC");
$userfile=mysql_result($result,0,"userfile");
$quantity=mysql_result($result,0,"quantity");
$savedir="./list/goods";

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
<tr><td align=right width=20%>���ż��� : </td><td align=left width=70%><input type=text size=2 id=ea name=ea value='1'>&nbsp;&nbsp;<span id=soldout style='color:red; font-weight:bold;'></span><input id='right' type='hidden' name='right' value='0'></td></tr>
</table></div>
<div class='content_title_button'>
<input type=image width=32% src='./img/button/btn_buynow.png' onclick=document.getElementById('right').value='1';>&nbsp;<input type=image width=32% src='./img/button/btn_showbag.png'>&nbsp;<a href='./goods_show.php?category=$category'><img width=32% src='./img/button/btn_list.png'></a>
</div>
</div></form></div>");

echo("<div class='content_detail_wrapper'>$content</div>");

echo("</div></center>");

if($quantity<1) {
?>
<script language="Javascript">
	document.getElementById("ea").value="";
	document.getElementById("ea").disabled='true';
	document.getElementById("soldout").innerHTML="������ ��ǰ�Դϴ�. ��� �߰� �ñ��� ���عٶ��ϴ�.";
</script>
<?php
}
?>


<?php
include("./bottom.html");
?>