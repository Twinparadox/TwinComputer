<?php
if(!$UserID) {
	echo("
    <script>
		window.alert('�α����� �ʿ��� �����Դϴ�.\\n�α��� �� �̿��Ͻ� �� �ֽ��ϴ�.');
		location.replace('./login.html');
    </script>");
	exit;
}
?>
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
				elPlaceHolder: "wContent",
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
		oEditors.getById["wContent"].exec("UPDATE_CONTENTS_FIELD", []);	// �������� ������ textarea�� ����˴ϴ�. 
		// �������� ���뿡 ���� �� ������ �̰����� document.getElementById("ir1").value�� �̿��ؼ� ó���ϸ� �˴ϴ�.

		try {
		elClickedObj.form.submit();
		}
		catch(e) {}
		}
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
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$tablename=$id."DB";
$result=mysql_query("select * from $tablename where num=$no",$con);
$writer_id=mysql_result($result,0,"writer");
if($writer_id!=$UserID) {
	echo("<script>
	window.alert('���� ������ �����ϴ�.');
	history.go(-1);</script>");
	exit;
}
$Title=mysql_result($result,0,"title");
$Content=mysql_result($result,0,"content");

echo("
	<center>
	<div class='editor'>
    <form action='post_modify_process.php?no=$no&id=$id' method=post id='frm' class='frm'>
        <table style='border:none; width:100%'>
            <tr>
                <td colspan=2></td>
            </tr>
            <tr style='text-align:left; border:1px solid silver;'>
                <td width='5%'>�� ��</td>
                <td><input type='text' style='width:100%;' name='wTitle' value='$Title' /></td>
            </tr>
            <tr>
                <td colspan=2><textarea id='wContent' name='wContent' rows=30 style='width:100%'>$Content</textarea></td>
            </tr>
        </table>
        <table style='border:none; width:100%; text-align:center;'>
            <tr><td><input type='image' src='img/button/btn_accept.png' onclick='submitContents(this)' width=120/>&nbsp;<a href='#' onclick='history.back();'><img src='img/button/btn_cancel.png' width=120/></a></td></tr>
        </table>
    </form>
	</div>
	</center>");
?>
<?php
include("./bottom.html");
?>