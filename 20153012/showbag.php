<?php
//showbag

if(!$UserID) {
	echo("<script>
	window.alert('�α����� �ʿ��� �����Դϴ�.\\n�α��� �� �̿��Ͻ� �� �ֽ��ϴ�.');
	location.replace('./login.html');
	</script>");
	exit;
}

?>
<html>
<head>
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#FFFFD2";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}
</script>
<style>
span.sort_divide_bar {
	border-left: 1px solid black;
    display: inline-block;
    border-right: 1px solid #fff;
    height: 10px;
    margin-top: 4px;
	margin-left:10px;
	margin-right:10px;
}
</style>
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

// ��ü ���ι� ���̺��� Ư�� ������� ���� �������� �о��

if($sorting=="") {
	$sorting=-1;
}
if(!($sorting==1 || $sorting==0)) {
	$hit=1;
}
if($hit=="") {
	$hit=0;
}

if($hit==1) {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by productCode",$con);
}
else if($sorting==0) {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by ea",$con);
}
else if($sorting==1) {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by ea desc",$con);
}
else {
	$result=mysql_query("select * from shoppingbag where id='$UserID' order by productCode",$con);
}
$total = mysql_num_rows($result);

echo ("<center>");
echo("<table border=0 style='margin-top:50px;width:880px margin-bottom:50px;'>");
echo("<tr><td><div style='width:880px; text-align: left; padding-top: 3px; font-size: 9pt; margin: auto;'>");
echo("<div style='width:440px; display:inline-block;'>");
if($hit==1) {
	echo("<b><span><a href='showbag.php?hit=1&sorting=-1'>ǰ��</a></span></b>");
}
else {
	echo("<span><a href='showbag.php?hit=1&sorting=-1'>ǰ��</a></span>");
}
echo("<span class='sort_divide_bar'></span>");
if($sorting==0) {
	echo("<b><span><a href='showbag.php?hit=0&sorting=0'>���� ���ŷ� ��</a></span></b>");
}
if($sorting!=0){
	echo("<span><a href='showbag.php?hit=0&sorting=0'>���� ���ŷ� ��</a></span>");
}	
echo("<span class='sort_divide_bar'></span>");
if($sorting==1) {
	echo("<b><span><a href='showbag.php?hit=0&sorting=1'>���� ���ŷ� ��</a></span></b>");
}
if($sorting!=1) {
	echo("<span><a href='showbag.php?hit=0&sorting=1'>���� ���ŷ� ��</a></span>");
}	
echo("</div></div></td></tr></table>");
echo("<table border=0 width=880 style='margin-top:10px; border-collapse:collapse; border-top:2px solid black;'>
    <tr style='border-bottom:1px solid silver;'><td width=35% align=center><font size=2>��ǰ����</td>
	<td width=20% align=center><font size=2>��ǰ�̸�</td>
	<td width=12% align=center><font size=2>����(�ܰ�)</td>
	<td width=6% align=center><font size=2>����</td>
	<td width=12% align=center><font size=2>ǰ���հ�</td>
	<td width=10% align=center><font size=2>��������<br></td>
	<td width=5% align=center><font size=2>����</td></tr>
");

if (!$total) {
     echo("<tr><td colspan=7 align=center><font size=2>���ι鿡 ��� ��ǰ�� �����ϴ�.</td></tr></table>");
}
else {

    $counter=0;
    $totalprice=0;    // �� ���� �ݾ�  

    while ($counter < $total) {
		$productCode = mysql_result($result, $counter, "productCode");
		$ea = mysql_result($result, $counter, "ea");
		
		$isDesktop=substr($productCode,0,7);
	
		if($isDesktop!="desktop") {
			$subresult = mysql_query("select * from goodsDB where code='$productCode'", $con);
			$userfile = mysql_result($subresult, 0, "userfile");
			$savedir="./list/goods";

			$pname = mysql_result($subresult, 0, "name");
			$pbrand=mysql_result($subresult,0,"brand");
			$isDC=mysql_result($subresult,0,"isDC");
			
			if($isDC==0) {
				$price = mysql_result($subresult, 0, "price");
			}
			else {
				$price = mysql_result($subresult,0,"discount");
			}
			$point = mysql_result($subresult,0,"point");
			
			$grade=mysql_result($subresult,0,"grade");
			$grader=mysql_result($subresult,0,"grader");
		}
		else {
			$subresult=mysql_query("select * from desktopDB where code='$productCode'",$con);
			$ComputerCase=mysql_result($subresult,0,"ComputerCase");
			$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
			$userfile=mysql_result($case_result,0,"userfile");
			$savedir="./list/desktop/";
			
			$pname = mysql_result($subresult, 0, "name");
			$pbrand="Ʈ�� ��ǻ��";
			
			$price=mysql_result($subresult,0,"price");
			$point=mysql_result($subresult,0,"point");
			
			$grade=mysql_result($subresult,0,"grade");
			$grader=mysql_result($subresult,0,"grader");
		}

		$subtotalprice = $ea * $price;
		$totalprice = $totalprice + $subtotalprice; 

		$price=number_format($price);
		$subtotalprice=number_format($subtotalprice);


		$subtotalpoint = $ea * $point;
		$totalpoint = $totalpoint + $subtotalpoint;
		$subtotalpoint=number_format($subtotalpoint);

		echo ("<tr onmouseover='changeColor1(this)' onmouseout='changeColor2(this)' title='���� : $grade ( ���ο� : $grader )'>
		<td align=center><a href=# onclick=\"window.open('$savedir/$userfile', '_new', 'width=450,   height=450')\"><img src='$savedir/$userfile' width=80% height=200></a></td>");
		
		if($isDesktop!="desktop") {
			echo("<td align=center><font size=2><a href='./goods_detail.php?code=$productCode'>$pbrand<br>$pname</a></td>");
		}
		else {
			echo("<td align=center><font size=2><a href='./desktop_detail.php?code=$productCode'>$pbrand<br>$pname</a></td>");
		}
		
		echo("<td align=center><font size=2>$price&nbsp;��</td>
		<td align=center>
		<form method=post action='./bag_modify.php?productCode=$productCode'><input type=text name=mea size=3 value=$ea>&nbsp;<input type=submit value=����>
		</td></form>
		<td align=center><font size=2>$subtotalprice&nbsp;��</td>
		<td align=center><font size=2>$subtotalpoint&nbsp;</td>
		<td align=center><form method=post action='./bag_delete.php?productCode=$productCode'>
		<input type=submit value=����></td></form>
		</tr>");

		$counter++;
	}
 	$totalprice=number_format($totalprice);
	$totalpoint=number_format($totalpoint);
    echo("<tr style='border-top:1px solid silver;'><td colspan=7 align=center><font size=2>�� ���� �ݾ�: $totalprice �� <br>�� ���� ����Ʈ : $totalpoint ����Ʈ</td></tr></table>");
}

mysql_close($con);	//�����ͺ��̽� ��������

echo ("<table width=880 border=0 style=' margin-bottom:100px;'>
		<tr><td colspan = 6><hr></td></tr><tr><td align=center><font size=2>[<a href='./buy.php'>���Ű���</a>] &nbsp; [<a href='./index.html'>���ΰ��</a>]</td></tr>	<tr><td colspan = 6><hr></td></tr></table></center>");

?>

<?php
include("./bottom.html");
?>