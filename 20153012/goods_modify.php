
<?php
include("./top.html");
?>
<html>
<head>
    <title>Writer</title>
    <script type="text/javascript" src="SmartEditor/js/HuskyEZCreator.js"></script>
    <script type="text/javascript" src="jquery-1.9.1.min.js"></script>
    <script type="text/javascript">
        var oEditors = [];
        $(function(){
			nhn.husky.EZCreator.createInIFrame({
				oAppRef: oEditors,
				elPlaceHolder: "mcontent",
				//SmartEditor2Skin.html ������ �����ϴ� ���
				sSkinURI: "SmartEditor2Skin.html",
				htParams : {
					// ���� ��� ���� (true:���/ false:������� ����)
					bUseToolbar : true,
					// �Է�â ũ�� ������ ��� ���� (true:���/ false:������� ����)
					bUseVerticalResizer : true,
					// ��� ��(Editor | HTML | TEXT) ��� ���� (true:���/ false:������� ����)
					bUseModeChanger : true,
					fOnBeforeUnload : function(){

					}
				},
				fOnAppLoad : function(){
					//���� ����� ������ text ������ �����ͻ� �ѷ��ְ��� �Ҷ� ���
					//oEditors.getById["wContent"].exec("PASTE_HTML", []);
				},
				fCreator: "createSEditor2"
			});
        });
    </script>
	<script type="text/javascript">
		function submitContents(elClickedObj) {
		oEditors.getById["mcontent"].exec("UPDATE_CONTENTS_FIELD", []);	// �������� ������ textarea�� ����˴ϴ�. 
		// �������� ���뿡 ���� �� ������ �̰����� document.getElementById("ir1").value�� �̿��ؼ� ó���ϸ� �˴ϴ�.

		try {
		elClickedObj.form.submit();
		}
		catch(e) {}
		}
		
		function init() {						
			window.alert(document.register.getElementById('cat').value);
			document.register.mcategory.value=document.register.getElementById('cat').value;
		}
		
		$(document).ready(function () {
			document.register.mcategory.value=document.register.cate.value;
		});
	</script>
	<style>
		div.editor {
			width:1080px;
			align:center;
		}
	</style>
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
$name=mysql_result($result,$i,"name");
$userfile=mysql_result($result,$i,"userfile");
$price=mysql_result($result,$i,"price");
$discount=mysql_result($result,$i,"discount");
$point=mysql_result($result,$i,"point");
$content=mysql_result($result,$i,"content");
$category=mysql_result($result,$i,"category");
$brand=mysql_result($result,$i,"brand");
$isDC=mysql_result($result,$i,"isDC");
$quantity=mysql_result($result,$i,"quantity");



echo("<center><form method=post action='goods_modify_process.php?code=$code' enctype='multipart/form-data' name=register><table width=1080>
<tr><td>��ǰ�з�<input type=hidden value='$category' name=cate></td>
<td><select name=mcategory id=mcategory>
<option value=''>����</option>
<option value=1000>��Ʈ��</option>
<option value=2000>�����</option>
<option value=3000>�Է���ġ</option>
<option value=4000>������ġ</option>
<option value=5001>�������� ������</option><option value=5002>���� ���ű�</option><option value=5003>���̺�</option><option value=5004>��ũ�� ������</option><option value=5005>������ ��� ������</option><option value=5006>������ �÷� ������</option>
<option value=6001>USB</option><option value=6002>����HDD</option><option value=6003>����ODD</option>
<option value=7000>����Ʈ����</option>
</select></td></tr>

<tr><td>�귣��</td><td><input type=text name=mbrand value='$brand'></td></tr>
<tr><td>��ǰ�̸�</td><td><input type=text name=mname value='$name'></td></tr>
<tr><td>��ǰ����</td><td><textarea id=mcontent name=mcontent rows=30 style='width:100%'>$content</textarea></td></tr>
<tr><td>�ǸŰ���</td><td><input type=text name=mprice value='$price' size=8></td>
<tr><td>�Ǹż���</td><td><input type=text name=mquantity value='$quantity' size=4></td>
<tr><td>���ΰ���</td><td><input type=text name=mdiscount value='$discount' size=8></td>");

if($isDC==1) {
	echo("<tr><td>���ο���</td><td><input type=checkbox name=mIsDC value='$isDC' checked=checked></td>");
}
else {
	echo("<tr><td>���ο���</td><td><input type=checkbox name=mIsDC value='$isDC'></td>");
}
echo("<tr><td>��������Ʈ</td><td><input type=text name=mpoint value='$point' size=6></td>
<tr><td>��ǰ����</td><td><input type=file name=muserfile value='$userfile'></td></tr>

</table><input type=image src='./img/button/btn_accept.png' onclick='submitContents(this)' width=120></form></center>");
?>

<?php
include("./bottom.html");
?>