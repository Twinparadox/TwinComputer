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
<option value=''>����</option>
<option value=1000>��Ʈ��</option>
<option value=2000>�����</option>
<option value=3000>�Է���ġ</option>
<option value=4000>������ġ</option>
<option value=5001>�������� ������</option><option value=5002>���� ���ű�</option><option value=5003>���̺�</option><option value=5004>��ũ�� ������</option><option value=5005>������ ��� ������</option><option value=5006>������ �÷� ������</option>
<option value=6001>USB</option><option value=6002>����HDD</option><option value=6003>����ODD</option>
<option value=7000>����Ʈ����</option>
</select></div>");

echo("<center><table border=0 width=1080 style='border-top:2px solid black; border-bottom:1px solid black; border-collapse:collapse; text-align:center; margin-bottom:100px; font-size:9pt;'><tr style='border-bottom:1px solid black;'>
<td align=center>ī�װ�</td>
<td align=center>�귣��</td>
<td align=center>��ǰ��</td>
<td align=center>��ǰ���</td>
<td align=cenetr>��ǰ����</td>
<td align=center>���ΰ���</td>
<td align=center>��������Ʈ</td>
<td align=center>���ο���</td>
<td align=center>Ȯ��</td></tr>");

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
		echo("��Ʈ��");
		break;
		
		case 2000:
		echo("�����");
		break;
		
		case 3000:
		echo("�Է���ġ");
		break;
		
		case 4000:
		echo("������ġ");
		break;
		
		case 5001:
		echo("�������� ������");
		break;
		
		case 5002:
		echo("���� ���ű�");
		break;
		
		case 5003:
		echo("���̺�");
		break;
		
		case 5004:
		echo("��ũ�� ������");
		break;
		
		case 5005:
		echo("������ ��� ������");
		break;
		
		case 5006:
		echo("������ �÷� ������");
		break;
		
		case 6001:
		echo("USB");
		break;
		
		case 6002:
		echo("����HDD");
		break;
		
		case 6003:
		echo("����ODD");
		break;
		
		case 7000:
		echo("����Ʈ����");
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
	echo("<td><input type=submit value='Ȯ��'></td></form></tr>");
	$i++;
}

echo("</table></center>");
?>
<?php
include("./bottom.html");
?>