<?
if (!isset($UserID)) {
	echo ("<script>
	window.alert('�α��� ����ڸ� �̿��Ͻ� �� �־��')
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
// ��ü ���ι� ���̺��� Ư�� ������� ���� �������� �о��
$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
$result = mysql_query("select * from shoppingbag where id = '$UserID'", $con);
$uresult = mysql_query("select * from member where uid = '$UserID'", $con);
$total = mysql_num_rows($result);
		$upoint = mysql_result($uresult, 0, "point");
echo ("
	<table border=0 width=690 cellpadding=0>
	<tr><td colspan = 13><hr></td></tr>
    <tr><td width=100 align=center><font size=2>��ǰ����</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=250 align=center><font size=2>��ǰ�̸�</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=90 align=center><font size=2>����(�ܰ�)</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=50 align=center><font size=2>����</td><td width=2><img src= skin/line.png width=2 height=35></td>
	<td width=100 align=center><font size=2>ǰ���հ�</td><td width=2><img src= skin/line.png width=2 height=35></td>
		<td width=100 align=center><font size=2>��������<br>����Ʈ</td><td width=2><img src= skin/line.png width=2 height=35></td></tr><tr><td colspan = 13><hr></td></tr>
");

// �ٷα����ϱ�� ���Ž�
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
			<td align=right><font size=2>$price&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=center><font size=2>$quantity&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalprice&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalpoint&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td></tr>");
     echo("<tr><td colspan = 13><hr></td></tr><tr><td colspan=13 align=center><font size=2> �� ���� �ݾ�: $subtotalprice �� <br><form method=post action=point.php?right=1&spoint=$spoint>����Ʈ ���� :	<input type=text name=spoint   value = $upoint size=10>
	 	<input type=submit value=����></form><br> �������� ���� �ݾ�: ");echo $totalprice; 
		echo("�� <br>�� ���� ����Ʈ : $subtotalpoint ����Ʈ</td></tr></table>");
	}
		//��ٱ��ϸ� ���� ���Խ�
		else{
if (!$total) {
     echo("<tr><td colspan=13 align=center><font   size=2><b>���ι鿡 ��� ��ǰ��   �����ϴ�.</b>
        </font></td></tr></table>");
} else {

    $counter=0;
    $totalprice=0;    // �� ���� �ݾ�  

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
			<td align=right><font size=2>$price&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=center><font size=2>$quantity&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalprice&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td>
			<td align=right><font size=2>$subtotalpoint&nbsp;��</td><td width=2><img src= skin/line.png width=2 height=70></td></tr>");

		$counter++;

    endwhile;
 $upoint = $upoint-$spoint;
 $totalprice = $totalprice-$spoint; 
 $tp = $totalprice+$spoint;
     echo("<tr><td colspan = 13><hr></td></tr><tr><td colspan=13 align=center><font size=2> �� ���� �ݾ�: $tp �� <br><form method=post action=point.php?spoint=$spoint>����Ʈ ���� :	<input type=text name=spoint   value = $upoint size=10>
	 	<input type=submit value=����></form><br> �������� ���� �ݾ�: ");echo $totalprice; 
		echo("�� <br>�� ���� ����Ʈ : $totalpoint ����Ʈ</td></tr></table>");
}
}

mysql_close($con);	//�����ͺ��̽� ��������

echo ("
		<table border=0 width=690><tr><td colspan = 13><hr></td></tr>
        <tr><td align=center><font size=2>���� �ð��� �ð����� ���θ������� ������ü�θ� ������ �Ͻ� �� �ֽ��ϴ�.<br>�׷��Ƿ� �Ʒ� ���·� �Ա��� ���ֽñ� �ٶ��ϴ�.<br><br>�Ա� ����: <b> �泲���� 595-910154-33707 (������: �����)</b><br><br>
		* �����Ͻ� ��ǰ�� �Ա� Ȯ���� ��۵Ǹ� ��۱Ⱓ�� ��������� 1-2�� ������ �ҿ�Ǹ� <br>������ ���� ��� �� ������ �� �ֽ��ϴ�. ���� �����Ͻñ� �ٶ��ϴ�.<br> * �ֹ� ���� ��Ȳ�� My Page���� Ȯ���Ͻ� �� �ֽ��ϴ�.<br>
		* ��ǰ ��� ������ �ֹ� ��Ҹ� ���Ͻø� My Page���� ���� �ֹ� ��� ��û�� �Ͻø� �˴ϴ�.<br>
		* <font color=red><b>�� ����� ���۵Ǹ� �ֹ��� ����ϽǼ��� ������ �� ���� ������ֽñ�ٶ��ϴ�.</b></font><br>
		* ��ǰ�� ��� ������ �Ŀ� ���� ��Ҹ� ���Ͻø� ������(��ȭ:1577-8624)�� �����ּ���.
       </td></tr><tr><td colspan = 13><hr></td></tr>
       </table>");

echo("
    <br><br>
	<table width=690 border=0><tr><td colspan = 13><hr></td></tr>
	<tr><td align=center><font size=3><b>������� �Է�</b></td></tr><tr><td colspan = 13><hr></td></tr>
	</table>

	<table width=690 border=0>
	<form method=post action=endshopping.php?right=$right&upoint=$upoint&uprice=$totalprice&spoint=$spoint name=buy>
	<tr><td align=right><font size=2>�޴���</td>
	<td><input type=text name=receiver size=10></td>
	</tr><tr><td colspan = 13><hr></td></tr>
	<tr>
	<td align=right><font size=2>��ȭ��ȣ</td>
	<td><input type=text name=phone   size=20></td>
	</tr><tr><td colspan = 13><hr></td></tr>
	<tr><td height=30 align=right><font size=2>����ּ�</td>
	<td align=left><input type=text size=6 name=zip readonly=readonly>
	<font size=2>[<a href='javascript:go_zip()'>�����ȣ�˻�</a>]<br>
	<input type=text size=55 name=addr readonly=readonly style='font-size:10pt; font-family:Tahoma;'>
	<input type=text size=30 name=readdr   style='font-size:10pt; font-family:Tahoma;'></td>
	</tr><tr><td colspan = 13><hr></td></tr><tr><td align=right><font size=2>�ֹ��䱸����</td>
	<td><textarea name=message rows=3 cols=65></textarea></td></tr><tr><td colspan = 13><hr></td></tr>
	<tr><td align=center colspan=2>
	<input type=submit value=���ſϷ�></td></tr>
	<tr><td colspan = 13><hr></td></tr>
	</table>
	</form>
	</center>
");

?>
<?php
include("./bottom.html");
?>