<?php include("./top.html");?>
<html>
<head>
<script language="Javascript">
function selectOpt(a)
{
	location.replace("./goods_list.php?category="+a);
}
</script>
</head>
</html>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from goodsDB where category=$category order by num",$con);
$total=mysql_num_rows($result);

echo("<center><table width=1080 border=0 style='margin-top:100px;'><tr>
<td><select name=cate onchange='selectOpt(this.options[this.selectedIndex].value);'>
<option value=''>����</option>
<option value=1000>��Ʈ��</option>
<option value=2000>�����</option>
<option value=3000>�Է���ġ</option>
<option value=4000>������ġ</option>
<option value=5001>�������� ������</option><option value=5002>���� ���ű�</option><option value=5003>���̺�</option><option value=5004>��ũ�� ������</option><option value=5005>������ ��� ������</option><option value=5006>������ �÷� ������</option>
<option value=6001>USB</option><option value=6002>����HDD</option><option value=6003>����ODD</option>
<option value=7000>����Ʈ����</option>
</select></td></tr>
</table>");

echo("<table width=1080 border=1 style='border-collapse:collapse; text-align:center; margin-top:10px;'><tr>
<td align=center>��ǰ�ڵ�</td>
<td colspan=2 align=center>��ǰ��</td>
<td align=center>����</td>
<td align=center>���ΰ���</td>
<td align=center>��������Ʈ</td>
<td align=center>����/����</td></tr>");

if(!$total) {
	echo("<tr><td colspan=6 align=center>��ϵ� ��ǰ ����</td></tr>");
}
else {
	$i=0;
	while($i<$total) {
		$code=mysql_result($result,$i,"code");
		$name=mysql_result($result,$i,"name");
		$userfile=mysql_result($result,$i,"userfile");
		$price=mysql_result($result,$i,"price");
		$showprice=number_format($price);
		$discount=mysql_result($result,$i,"discount");
		$showdiscount=number_format($discount);
		$point=mysql_result($result,$i,"point");
		$showpoint=number_format($point);
		
		echo("<tr>
		<td>$code</td>
		<td><img width=100 src='./list/goods/$userfile'></td>
		<td>$name</td>
		<td>$showprice</td>
		<td>$showdiscount</td>
		<td>$showpoint</td>
		<td><a href='goods_modify.php?code=$code'>[M]</a>/<a href='goods_delete.php?code=$code'>[X]</a></td></td>");
		$i++;
	}
}
echo("</table></center>");
echo("<a href='./add_goods.html'>[�߰� �Է�]</a>");
mysql_close($con);
?>
<?php include("./bottom.html");