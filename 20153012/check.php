<?php
// �ֹ������ȸ
if(!$UserID) {
	echo("<script>
			window.alert('�α����� �ʿ��� �����Դϴ�.\\n�α��� �� �̿��Ͻ� �� �ֽ��ϴ�.');
			history.go(-1);			
			location.replace('./login.html');
			</script>");
	exit;
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/board.css">
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#E6FFFF";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}
function selectOpt(a)
{
	location.replace("./check.php?period="+a);
}
</script>
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

if($period=="0" || $period=="-1" || $period=="") {
	$period=0;
	$result=mysql_query("select * from receivers where userID='$UserID' order by date desc",$con);
	$total=mysql_num_rows($result);
}
else {
	$current_date = date("Y-m-d H:i:s");
	list($year,$month,$day,$hour,$minute,$second) = split("[- :]",$current_date);
	$before=date("Y-m-d H:i:s", mktime($hour, $minute, $second, $month-1, $day, $year ));
	$result=mysql_query("select * from receivers where userID='$UserID' and date > '$before' order by date desc",$con);
	$total=mysql_num_rows($result);
}

echo("<center><table width=880 border=0 style='margin-top:100px;'>
<tr><td align=center><b>���ų���</b></td></tr>
<tr><td>* �ֹ� ��ǰ�� ��� ���� �ܰ��̸� �¶������� �ֹ� ��Ұ� �����մϴ�.</td></tr>
<tr><td>* ������̰ų� ���� �Ϸ�� ��ǰ�� ���� ��ǰ �� ȯ�� ��û�� ��� ������(��ȭ : 070-1234-5678)�� ���ǹٶ��ϴ�.</td></tr>
<tr><form name=pfrm><td><input type=hidden value='$period' name=per>��¥ ��ȸ : &nbsp;
<select name=period onchange='selectOpt(this.options[this.selectedIndex].value);'>
<option value=-1>����</option>
<option value=0>��ü</option>
<option value=1>�ֱ� 1����</option>
<option value=3>�ֱ� 3����</option>
<option value=6>�ֱ� 6����</option></select>
</td><form></tr>
</table>");

echo("<table width=880 style='border-top:2px solid black; border-bottom:2px solid black; border-collapse:collapse; margin-top:30px; margin-bottom:100px; font-size:9pt;'>
<tr style='border-bottom:1px solid black'><td align=center>���Ź�ȣ</td>
<td align=center>��������</td>
<td align=center>�ֹ�����</td>
<td align=center>�ݾ�</td>
<td align=center>�ֹ�����</td></tr>");

$entireprice=0;
$entirepoint=0;

if($total>0) {
	$i=0;
	while($i<$total) {
		$session=mysql_result($result,$i,"session");
		$date=mysql_result($result,$i,"date");
		$ordernum=mysql_result($result,$i,"ordernum");
		$status=mysql_result($result,$i,"status");
		$oldstatus=$status;
		$usedpoint=mysql_result($result,$i,"point");
		
		switch($status) {
			case 1:
			$status="�ֹ���û";
			break;
			case 2:
			$status="�ֹ�����";
			break;
			case 3:
			$status="����غ���";
			break;
			case 4:
			$status="�����";
			break;
			case 5:
			$status="��ۿϷ�";
			break;
			case 6:
			$status="�ǸſϷ�";
			break;
		}
		
		$subresult=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
		$subtotal=mysql_num_rows($subresult);
		
		$counter=0;
		$totalprice=0;
		
		while($counter < $subtotal) {
			$code=mysql_result($subresult, $counter, "code");
			$ea=mysql_result($subresult,$counter,"ea");
			$price=mysql_result($subresult,$counter,"price");
			
			$isDesktop=substr($code,0,7);
	
			if($isDesktop!="desktop") {
				$tmpresult=mysql_query("select * from goodsDB where code='$code'",$con);
				$pname=mysql_result($tmpresult,0,"name");
				$brand=mysql_result($tmpresult,0,"brand");
				
				
			}
			else {
				$tmpresult=mysql_query("select * from desktopDB where code='$code'",$con);
				$pname=mysql_result($tmpresult,0,"name");
				$brand="Ʈ�� ��ǻ��";
			}
			$subtotalprice=$ea*$price;
			$totalprice=$totalprice+$subtotalprice;
			$counter++;
		}
		$items=$subtotal-1;
		$totalprice=$totalprice-$usedpoint;
		$entireprice=$entireprice+$totalprice;
		$entirepoint=$entirepoint+$usedpoint;
		$totalprice=number_format($totalprice);
		echo("<tr onmouseover='changeColor1(this)' onmouseout='changeColor2(this)' style='border-bottom:1px dotted silver; height:50px;'><td align=center><a href=# onclick=\"window.open('detail_check.php?ordernum=$ordernum','_new','width=940, height=500, scrollbars=yes');\">$ordernum</a></td>
		<td align=center>$date</td>");
		if($items>0) {
			echo("<td align=center>$brand&nbsp;$pname �� $items ��</td>");
		}
		else {
			echo("<td align=center>$brand&nbsp;$pname</td>");
		}
		
		echo("<td align=right>$totalprice ��</td>");
		if($oldstatus!=5)
		{
			echo("<td align=center><font color=51afff><b>$status</b></font>");
		}
		else {
			echo("<td align=center><a href='changestatus.php?ordernum=$ordernum'><font color=red><b>$status</b></font></a>");
		}
		if($oldstatus==6) {
			echo("<br><a href=# onclick=\"window.open('./after.php?ordernum=$ordernum','�ı� �ۼ�','width=800, height=700, scrollbars=yes');\"><font color=red><b>�ı��ۼ�</b></font></a>");
		}
		if($oldstatus<4) {
			echo("<br><b><a href='order_cancel.php?ordernum=$ordernum'>�ֹ����</a></b>");
		}
		echo("</td></tr>");
		$i++;
	}
}
else {
	echo("<tr style='height:50px'><td align=center colspan=5><b style='color:#FF0000;'>�ֹ� ������ �������� �ʽ��ϴ�.</td></tr>");
}
$entireprice=number_format($entireprice);
$entirepoint=number_format($entirepoint);

echo("<tr style='height:50px; border-top:1px solid black;'><td align=center colspan=5><b>�� ���ž� : $entireprice ��<br>�� �������Ʈ : $entirepoint ����Ʈ</b></td></tr>");
echo("</table></center>");
mysql_close($con);
?>

<?php
include("./bottom.html");
?>