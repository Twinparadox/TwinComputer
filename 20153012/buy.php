<?
if (!isset($UserID)) {
	echo ("<script>
	window.alert('�α��� ����ڸ� �̿��Ͻ� �� �־��');
	history.go(-1);
	</script>");
	exit;
}
?>

<html>
<head>
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#D4F4FA";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}	
</script>
<script>
function recent() {
	window.open('./recent_receiver.php','�ֱ� �����','width=800, height=700, scrollbars=yes');
}
</script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
	//�� ���������� ���θ� �ּ� ǥ�� ��Ŀ� ���� ���ɿ� ����, �������� �����͸� �����Ͽ� �ùٸ� �ּҸ� �����ϴ� ����� �����մϴ�.
	function DaumPostcode() {
		new daum.Postcode({
			oncomplete: function(data) {
				// �˾����� �˻���� �׸��� Ŭ�������� ������ �ڵ带 �ۼ��ϴ� �κ�.

				// ���θ� �ּ��� ���� ��Ģ�� ���� �ּҸ� �����Ѵ�.
				// �������� ������ ���� ���� ��쿣 ����('')���� �����Ƿ�, �̸� �����Ͽ� �б� �Ѵ�.
				var fullRoadAddr = data.roadAddress; // ���θ� �ּ� ����
				var extraRoadAddr = ''; // ���θ� ������ �ּ� ����

				// ���������� ���� ��� �߰��Ѵ�. (�������� ����)
				// �������� ��� ������ ���ڰ� "��/��/��"�� ������.
				if(data.bname !== '' && /[��|��|��]$/g.test(data.bname)){
					extraRoadAddr += data.bname;
				}
				// �ǹ����� �ְ�, ���������� ��� �߰��Ѵ�.
				if(data.buildingName !== '' && data.apartment === 'Y'){
				   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				}
				// ���θ�, ���� ������ �ּҰ� ���� ���, ��ȣ���� �߰��� ���� ���ڿ��� �����.
				if(extraRoadAddr !== ''){
					extraRoadAddr = ' (' + extraRoadAddr + ')';
				}
				// ���θ�, ���� �ּ��� ������ ���� �ش� ������ �ּҸ� �߰��Ѵ�.
				if(fullRoadAddr !== ''){
					fullRoadAddr += extraRoadAddr;
				}

				// �����ȣ�� �ּ� ������ �ش� �ʵ忡 �ִ´�.
				document.getElementById('postcode').value = data.zonecode; //5�ڸ� �������ȣ ���
				document.getElementById('roadAddress').value = fullRoadAddr;
				document.getElementById('jibunAddress').value = data.jibunAddress;

				
				// ����ڰ� '���� ����'�� Ŭ���� ���, ���� �ּҶ�� ǥ�ø� ���ش�.
				if (data.autoRoadAddress) {
					//����Ǵ� ���θ� �ּҿ� ������ �ּҸ� �߰��Ѵ�.
					var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
					document.getElementById('guide').innerHTML = '(���� ���θ� �ּ� : ' + expRoadAddr + ')';
					document.getElementById('roadAddress').value = expRoadAddr;

				} else if (data.autoJibunAddress) {
					var expJibunAddr = data.autoJibunAddress;
					document.getElementById('guide').innerHTML = '(���� ���� �ּ� : ' + expJibunAddr + ')';
					document.getElementById('jibunAddress').value = expJibunAddr;

				} else {
					document.getElementById('guide').innerHTML = '';
				}
			}
		}).open();
	}
</script>
</head>
</html>

<?php
include("./top.html");
?>

<?
if(!$spoint) $spoint=0;
// ��ü ���ι� ���̺��� Ư�� ������� ���� �������� �о��
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result = mysql_query("select * from shoppingbag where id = '$UserID'", $con);
$user_result = mysql_query("select * from userDB where userID = '$UserID'", $con);
$total = mysql_num_rows($result);
$user_point = mysql_result($user_result, 0, "userPoint");
$userName=mysql_result($user_result,0,"userName");
$userCellPhone=mysql_result($user_result,0,"userCellPhone");
$userPostcode=mysql_result($user_result,0,"PostCode");
$userRoadAddress=mysql_result($user_result,0,"RoadAddress");
$userJibunAddress=mysql_result($user_result,0,"JibunAddress");
$userRestAddress=mysql_result($user_result,0,"RestAddress");

echo ("<center><table border=0 width=880 style='border-collapse:collapse; border-top:2px solid black; margin-top:50px;'>
<tr><td width=35% align=center><font size=2>��ǰ����</td>
<td width=20% align=center><font size=2>��ǰ�̸�</td>
<td width=13% align=center><font size=2>����(�ܰ�)</td>
<td width=9% align=center><font size=2>����</td>
<td width=13% align=center><font size=2>ǰ���հ�</td>
<td width=10% align=center><font size=2>��������<br>����Ʈ</td></tr>
<tr><td colspan = 6><hr></td></tr>
");

// �ٷα����ϱ�� ���Ž�
if($right == 1)
{
	$result = mysql_query("select * from rightbuy where id = '$UserID'", $con);
	$code = mysql_result($result, 0, "pcode");
	$ea = mysql_result($result, 0, "ea");
	
	$isDesktop=substr($code,0,7);
	
	if($isDesktop!="desktop") {
		$subresult = mysql_query("select * from goodsDB where code='$code'", $con);
		$userfile = mysql_result($subresult, 0, "userfile");
		$name = mysql_result($subresult, 0, "name");
		$brand=mysql_result($subresult,0,"brand");
		$isDC=mysql_result($subresult,0,"isDC");
		if($isDC==0) {
			$price = mysql_result($subresult, 0, "price");
		}
		else {
			$price=mysql_result($subresult,0,"discount");
		}
		$point = mysql_result($subresult, 0, "point");
		$savedir="./list/goods";
	}
	else {
		$subresult=mysql_query("select * from desktopDB where code='$code'",$con);
		
		$ComputerCase=mysql_result($subresult,0,"ComputerCase");
		$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
		$userfile=mysql_result($case_result,0,"userfile");
		
		$name=mysql_result($subresult,0,"name");
		$price=mysql_result($subresult,0,"price");
		$point=mysql_result($subresult,0,"point");
		
		$savedir="./list/desktop";
	}
	
	$subtotalprice = $ea * $price;
	$subtotalpoint = $ea * $point;
	
	$totalpoint=$subtotalpoint;
	$totalprice = $subtotalprice;
	$oldtotalprice=$totalprice;
	$oldtotalprice=number_format($oldtotalprice);
	
	$subtotalprice=number_format($subtotalprice);
	$subtotalpoint=number_format($subtotalpoint);
	
	$price=number_format($price);
	echo("<tr><td align=center><a href=# onclick=\"window.open('$savedir/$userfile', '_new', 'width=450, height=450')\"><img src='$savedir/$userfile' width=80% height=178></a></td>
	<td align=center><font size=2><a href='goods_detail.php?code=$code'>$brand<br>$name</a></td>
	<td align=center><font size=2>$price&nbsp;��</td>
	<td align=center><font size=2>$ea&nbsp;��</td>
	<td align=center><font size=2>$subtotalprice&nbsp;��</td>
	<td align=center><font size=2>$subtotalpoint&nbsp;��</td></tr>");
	
	$user_point = $user_point-$spoint;
	$totalprice = $totalprice-$spoint;
	$tp = $totalprice-$spoint;
	
	$tpoint=$totalpoint;
	$tprice=$totalprice;
	
	$tp=number_format($tp);
	$totalpoint=number_format($totalpoint);
	$totalprice=number_format($totalprice);
	$up=number_format($user_point);
    echo("<tr><td colspan = 6><hr></td></tr><tr><td colspan=6 align=center><font size=2>�� ���� �ݾ� : $oldtotalprice �� <br>��밡�� ����Ʈ : $up ����Ʈ<br><form method=post action='point.php?spoint=$spoint&right=$right'>����Ʈ ���� :	<input type=text name=spoint value=$spoint size=10>
	<input type=submit value=����></form><br> �������� ���� �ݾ�: ");
	echo $totalprice; 
	echo("�� <br>�� ���� ����Ʈ : $totalpoint ����Ʈ</td></tr></table>");
}
//��ٱ��ϸ� ���� ���Խ�
else{
if (!$total) {
    echo("<tr><td colspan=6 align=center><font   size=2><b>���ι鿡 ��� ��ǰ�� �����ϴ�.</b></font></td></tr></table>");
}
else {
    $counter=0;
    $totalprice=0;    // �� ���� �ݾ�  

    while ($counter < $total) {
		$code = mysql_result($result, $counter, "productCode");
		$ea = mysql_result($result, $counter, "ea");
		
		$isDesktop=substr($code,0,7);
	
		if($isDesktop!="desktop") {
			$subresult = mysql_query("select * from goodsDB where code='$code'", $con);
			$userfile = mysql_result($subresult, 0, "userfile");
			$name = mysql_result($subresult, 0, "name");
			$brand=mysql_result($subresult,0,"brand");
			$isDC=mysql_result($subresult,0,"isDC");
			if($isDC==0) {
				$price = mysql_result($subresult, 0, "price");
			}
			else {
				$price=mysql_result($subresult,0,"discount");
			}
			$point = mysql_result($subresult, 0, "point");
			$savedir="./list/goods";
		}
		else {
			$subresult=mysql_query("select * from desktopDB where code='$code'",$con);
		
			$ComputerCase=mysql_result($subresult,0,"ComputerCase");
			$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
			$userfile=mysql_result($case_result,0,"userfile");
			
			$name=mysql_result($subresult,0,"name");
			$price=mysql_result($subresult,0,"price");
			$point=mysql_result($subresult,0,"point");
			
			$savedir="./list/desktop";
		}


		$subtotalprice = $ea * $price;
		$totalprice = $totalprice + $subtotalprice; 
		$subtotalprice=number_format($subtotalprice);

		$subtotalpoint = $ea * $point;
		$totalpoint = $totalpoint + $subtotalpoint;
		$subtotalpoint=number_format($subtotalpoint);

		$price=number_format($price);
		echo("<tr><td align=center><a href=# onclick=\"window.open('$savedir/$userfile', '_new', 'width=450, height=450')\"><img src='$savedir/$userfile' width=80% height=178></a></td>
		<td align=center><font size=2><a href='goods_detail.php?code=$code'>$brand<br>$name</a></td>
		<td align=center><font size=2>$price&nbsp;��</td>
		<td align=center><font size=2>$ea&nbsp;��</td>
		<td align=center><font size=2>$subtotalprice&nbsp;��</td>
		<td align=center><font size=2>$subtotalpoint&nbsp;��</td></tr>");
		$counter++;
	}	
	$user_point = $user_point-$spoint;
	$oldtotalprice=$totalprice;
	$totalprice = $totalprice-$spoint;
	
	$tpoint=$totalpoint;
	$tprice=$totalprice;
	
	$tp=number_format($tp);
	$oldtotalprice=number_format($oldtotalprice);
	$totalpoint=number_format($totalpoint);
	$totalprice=number_format($totalprice);
	
	$up=number_format($user_point);
    echo("<tr><td colspan = 6><hr></td></tr><tr><td colspan=6 align=center><font size=2>�� ���� �ݾ� : $oldtotalprice �� <br>��밡�� ����Ʈ : $up ����Ʈ<br><form method=post action='point.php?spoint=$spoint'>����Ʈ ���� :	<input type=text name=spoint value=$spoint size=10>
	<input type=submit value=����></form><br> �������� ���� �ݾ�: ");
	echo $totalprice; 
	echo("�� <br>�� ���� ����Ʈ : $totalpoint ����Ʈ</td></tr></table>");
}}

mysql_close($con);	//�����ͺ��̽� ��������

echo ("<table border=0 width=880 style='border-top:1px solid black; border-bottom:1px solid black;'> 
<tr><td align=left><font size=2>���� Ʈ�� ��ǻ��(Twin Computer)������ ������ü�θ� ������ �Ͻ� �� �ֽ��ϴ�.<br>�׷��Ƿ� �Ʒ� ���·� �Ա��� ���ֽñ� �ٶ��ϴ�.<br><br>�Ա� ����: <b> ���� 453123-52-168753 (������: ������)</b><br><br>
* �����Ͻ� ��ǰ�� �Ա� Ȯ���� ��۵Ǹ� ��۱Ⱓ�� ��������� 1-2�� ������ �ҿ�Ǹ� <br>������ ���� ��� �� ������ �� �ֽ��ϴ�. ���� �����Ͻñ� �ٶ��ϴ�.<br> * �ֹ� ���� ��Ȳ�� My Page���� Ȯ���Ͻ� �� �ֽ��ϴ�.<br>
* ��ǰ ��� ������ �ֹ� ��Ҹ� ���Ͻø� My Page���� ���� �ֹ� ��� ��û�� �Ͻø� �˴ϴ�.<br>
* <font color=red><b>�� ����� ���۵Ǹ� �ֹ��� ����ϽǼ��� ������ �� ���� ������ֽñ�ٶ��ϴ�.</b></font><br>
* ��ǰ�� ��� ������ �Ŀ� ���� ��Ҹ� ���Ͻø� ������(��ȭ:070-1234-5678)�� �����ּ���.
</td></tr>
</table>");

echo("<br><br><table width=880 border=0>
<tr><td align=center><font size=3><b>������� �Է�</b></td></tr>
<tr><td align=center><a href='javascript:recent()'><img src='./img/button/btn_recent.png' width=100></a></td></tr>
</table>

<table width=880 border=0 style='margin-bottom:100px;font-size:9pt'>
<form method=post action='endshopping.php?right=$right&getpoint=$tpoint&uprice=$totalprice&usepoint=$spoint' name=buy>
<tr><td>*</td><td>�޴���</td><td><input type=text id=receiver name=receiver size=10></td></tr>
<tr><td>*</td><td>��ȭ��ȣ</td><td><input type=text id=phone name=phone size=20></td></tr>
<tr><td width=5%>*</td><td width=15%>����ּ�</td>
<td>
<input type=text size=10 name=wPostCode id=postcode placeholder='�����ȣ' readonly=readonly onclick=DaumPostcode()>
<input type=button onclick=DaumPostcode() value='�����ȣ ã��'><br><br />
<input type=text size=30 name=wRoadAddress id=roadAddress placeholder='���θ��ּ�' readonly=readonly onclick=DaumPostcode()>
<input type=text size=30 name=wJibunAddress id=jibunAddress placeholder='�����ּ�' readonly=readonly onclick=DaumPostcode()>
<br /><span id=guide style='color:#999;font-size:9px;'></span>   
<br /><br /><input type=text name=wRestAddress id=restAddress placeholder='������ �ּ�' size=70 /><br><br>
</td></tr>
<tr><td>*</td><td><font size=2>�ֹ��䱸����</td><td><textarea name=message id=message rows=3 cols=65></textarea></td></tr>
<tr><td align=center colspan=3><input type=image src='./img/button/btn_buy.png' width=120></td></tr></table></form></center>");
?>
<?php
include("./bottom.html");
?>