<link rel='stylesheet' type='text/css' href='css/mypage.css' />
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
<script>
	function isSame() {
		var pw = document.modify.mUserPW.value;
        var confirmPW = document.modify.mUserPWConfirm.value;
		if (pw.length < 6 || pw.length > 16) {
			window.alert('��й�ȣ�� 6���� �̻�, 16���� ���ϸ� �̿� �����մϴ�.');
			document.getElementById('pw').value=document.getElementById('pwCheck').value='';
			document.getElementById('same').innerHTML='';			
		}
		if(document.getElementById('pw').value!='' && document.getElementById('pwCheck').value!='') {
			if(document.getElementById('pw').value==document.getElementById('pwCheck').value) {
				document.getElementById('same').innerHTML='��й�ȣ�� ��ġ�մϴ�.';
				document.getElementById('same').style.color='blue';
			}
			else {
				document.getElementById('same').innerHTML='��й�ȣ�� ��ġ���� �ʽ��ϴ�.';
				document.getElementById('same').style.color='red';
			}
		}
	}
	function confirmExit() {
		if(confirm("������ Ż���Ͻðڽ��ϱ�?")==true) {
			window.open('exit.html','ȸ��Ż�� Ȯ��','width=400, height=200, scrollbars=no');
		}
		else {
			return;
		}
	}
</script>
<?php
// mypage
if(!$UserID) {
	echo("<script>
			window.alert('�α����� �ʿ��� �����Դϴ�.\\n�α��� �� �̿��Ͻ� �� �ֽ��ϴ�.');		
			location.replace('./login.html');
			</script>");
	exit;
}?>

<?php
include ("./top.html");
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );
$result=mysql_query("select * from userdb where userID='$UserID'",$con);

$userPW=mysql_result($result,0,"userPW");
$userGender=mysql_result($result,0,"userGender");
if($userGender==1) {
	$userGender="����";
}
else {
	$userGender="����";
}
$userHomePhone=mysql_result($result,0,"userHomePhone");
$userCellPhone=mysql_result($result,0,"userCellPhone");
$userEmail=mysql_result($result,0,"userEmail");
$PostCode=mysql_result($result,0,"PostCode");
$RoadAddress=mysql_result($result,0,"RoadAddress");
$JibunAddress=mysql_result($result,0,"JibunAddress");
$RestAddress=mysql_result($result,0,"RestAddress");

if($right=="") {
	$right=0;
}

echo("<center>");


if($right==0) {
echo("<table><tr height=40><td align=center><b>[�������� ����]</b></td></tr></table>");	
echo("<form action='modify_register.php' method='post' name=modify>
<table width=700 height=600 cellpadding=0 style='border-collapse:collapse; font-size:9pt;'>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>ȸ�� ID</td>
		<td>$UserID</td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>���� ��й�ȣ</td>
		<td><input type=password name=pUserPW></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>���� ��й�ȣ</td>
		<td><input type=password name=mUserPW id=pw onchange='isSame()'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>��й�ȣ Ȯ��</td>
		<td><input type=password name=mUserPWConfirm id=pwCheck onchange='isSame()'>&nbsp;&nbsp;<span id=same style='font-size:9pt;'></span></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>�� ��</td>
		<td>$UserName</td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>�� ��</td>
		<td>$userGender</td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>����ȭ</td>
		<td><input type=tel name=mUserHomePhone value='$userHomePhone'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>�޴���ȭ</td>
		<td><input type=tel name=mUserCellPhone value='$userCellPhone'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>�̸���</td>
		<td><input type=tel name=mUserEmail value='$userEmail'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr>
		<td width='5%' align=center>*</td>
		<td width='15%' align>�ּ�</td>
		<td>
			<input type=text size=10 name=mPostCode value='$PostCode' readonly=readonly onclick='DaumPostcode()'>
			<input type=button onclick='DaumPostcode()' value='�����ȣ ã��'><br><br>
			<input type=text size=30 name=mRoadAddress id=roadAddress value='$RoadAddress' readonly=readonly onclick='DaumPostcode()'>
			<input type=text size=30 name=mJibunAddress id=jibunAddress value='$JibunAddress' readonly=readonly onclick='DaumPostcode()'>
			<br><span id=guide style='color:#999;font-size:10px;'></span>
			<br><br><input type=text name=mRestAddress value='$RestAddress' size=70>
		</td>
	</tr></table><br>");
	echo("<table>
	<tr height=40>
		<td>
			<input width=120 type=image src='img/button/btn_accept.png'>&nbsp;<a href='index.php'><img src='img/button/btn_cancel.png' width=120></a>&nbsp;<a href=# onclick='confirmExit()'><img src='img/button/btn_exit.png' width=120 height=35></a>
		</td>
	</tr></table></form></center>");
}
include ("./bottom.html");
?>