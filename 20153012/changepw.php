<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script language="Javascript">
	function isSame() {
		var pw = document.pass.wUserPW.value;
        var confirmPW = document.pass.wUserPWConfirm.value;
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
</script>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from userDB where userID='$uid' and userName='$uname' and userEmail='$email'",$con);
$total=mysql_num_rows($result);

if(!$total) {
	echo("<script>
	window.alert('�Է��Ͻ� ������ ��ġ�ϴ� ���̵� �����ϴ�.');
	history.go(-1);
	</script>");
	exit;
}
else {
	$id=mysql_result($result,0,"userID");
	echo("<center><form name=pass method=post action='changepw_process.php?uid=$id'><table align=center width='450' cellpadding='0' style='border-collapse:collapse; font-size:9pt;'>
	<tr class='register' height='30'>
		<td width='3%' align='center'>*</td>
		<td width='22%'>��й�ȣ</td>
		<td><input type='password' name='wUserPW' id='pw' onchange='isSame()' /></td>
	</tr>
	<tr class='register' height='30'>
		<td width='3%' align='center'>*</td>
		<td width='22%'>��й�ȣ Ȯ��</td>
		<td><input type='password' name='wUserPWConfirm' id='pwCheck' onchange='isSame()' />&nbsp;&nbsp;<span id='same'></span></td>
	</tr>
	<tr style='padding-top:20px;'><td align=center colspan=3><input type=submit value='��й�ȣ ����'></td></tr></table></form></center>");
}

mysql_close($con);
?>