<!DOCTYPE html>
<?php
if(!$UserID) {
	echo("
    <script>
		window.alert('로그인이 필요한 서비스입니다.\\n로그인 후 이용하실 수 있습니다.');
		location.replace('./login.html');
    </script>");
	exit;
}
if($id=="QnA" && $isAdmin!=1) {
	echo("<script>
	window.alert('작성권한이 없습니다.');
	history.go(-1);
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
				//SmartEditor2Skin.html 파일이 존재하는 경로
				sSkinURI: "SmartEditor2Skin.html",
				htParams : {
					// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
					bUseToolbar : true,
					// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
					bUseVerticalResizer : true,
					// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
					bUseModeChanger : true,
					fOnBeforeUnload : function(){

					}
				},
				fOnAppLoad : function(){
					//기존 저장된 내용의 text 내용을 에디터상에 뿌려주고자 할때 사용
					//oEditors.getById["wContent"].exec("PASTE_HTML", []);
				},
				fCreator: "createSEditor2"
			});
        });
    </script>
	<script type="text/javascript">
		function submitContents(elClickedObj) {
		oEditors.getById["wContent"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다. 
		// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

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
echo("
	<center>
	<div class='editor'>
    <form action='reply_input.php?no=$no&id=$id' method=post id='frm' class='frm'>
        <table style='border:none; width:100%'>");
?>

<?php
if($id=="QnA")
{
}
?>
<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$tablename=$id."DB";
$result=mysql_query("select * from $tablename where num=$no",$con);
$p_title=mysql_result($result,0,"title");
$p_content=mysql_result($result,0,"content");

$title="[RE]".$p_title;

echo("
		<tr style='text-align:left; border:1px solid silver;'>
			<td width='5%'>제 목</td>
			<td><input type='text' style='width:100%;' name='wTitle' value='$title'/></td>
		</tr>
		<tr>
			<td colspan=2><textarea id='wContent' name='wContent' rows=30 style='width:100%'></textarea></td>
		</tr>
	</table>
	<table style='border:none; width:100%; text-align:center;'>
		<tr><td><input type='image' src='img/button/btn_accept.png' onclick='submitContents(this)' width=120/>&nbsp;<a href='#' onclick='history.back();'><img src='img/button/btn_cancel.png' width=120/></a></td></tr>
	</table>
</form>
</div>
</center>");

mysql_close($con);
?>
<?php
include("./bottom.html");
?>