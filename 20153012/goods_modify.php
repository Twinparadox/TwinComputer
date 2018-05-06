
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
		oEditors.getById["mcontent"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다. 
		// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

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
<tr><td>상품분류<input type=hidden value='$category' name=cate></td>
<td><select name=mcategory id=mcategory>
<option value=''>선택</option>
<option value=1000>노트북</option>
<option value=2000>모니터</option>
<option value=3000>입력장치</option>
<option value=4000>음향장치</option>
<option value=5001>유·무선 공유기</option><option value=5002>무선 수신기</option><option value=5003>케이블</option><option value=5004>잉크젯 프린터</option><option value=5005>레이저 흑백 프린터</option><option value=5006>레이저 컬러 프린터</option>
<option value=6001>USB</option><option value=6002>외장HDD</option><option value=6003>외장ODD</option>
<option value=7000>소프트웨어</option>
</select></td></tr>

<tr><td>브랜드</td><td><input type=text name=mbrand value='$brand'></td></tr>
<tr><td>상품이름</td><td><input type=text name=mname value='$name'></td></tr>
<tr><td>상품설명</td><td><textarea id=mcontent name=mcontent rows=30 style='width:100%'>$content</textarea></td></tr>
<tr><td>판매가격</td><td><input type=text name=mprice value='$price' size=8></td>
<tr><td>판매수량</td><td><input type=text name=mquantity value='$quantity' size=4></td>
<tr><td>할인가격</td><td><input type=text name=mdiscount value='$discount' size=8></td>");

if($isDC==1) {
	echo("<tr><td>할인여부</td><td><input type=checkbox name=mIsDC value='$isDC' checked=checked></td>");
}
else {
	echo("<tr><td>할인여부</td><td><input type=checkbox name=mIsDC value='$isDC'></td>");
}
echo("<tr><td>적립포인트</td><td><input type=text name=mpoint value='$point' size=6></td>
<tr><td>상품사진</td><td><input type=file name=muserfile value='$userfile'></td></tr>

</table><input type=image src='./img/button/btn_accept.png' onclick='submitContents(this)' width=120></form></center>");
?>

<?php
include("./bottom.html");
?>