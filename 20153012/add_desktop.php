<?php
include("./top.html");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./css/add_desktop.css">
<script language="Javascript">
	function operating() {
		var cpu, mainboard, ram, vga, ssd, hdd, odd, computercase, psu;
		cpu=document.getElementsByName("CPU")[0].value.split(",");
		mainboard=document.getElementsByName("Mainboard")[0].value.split(",");
		ram=document.getElementsByName("RAM")[0].value.split(",");
		vga=document.getElementsByName("VGA")[0].value.split(",");
		ssd=document.getElementsByName("SSD")[0].value.split(",");
		hdd=document.getElementsByName("HDD")[0].value.split(",");
		odd=document.getElementsByName("ODD")[0].value.split(",");
		computercase=document.getElementsByName("ComputerCase")[0].value.split(",");
		psu=document.getElementsByName("PSU")[0].value.split(",");
		
		var data=new Array(9);
		data[0]=cpu[1];
		data[1]=mainboard[1];
		data[2]=ram[1];
		data[3]=vga[1];
		data[4]=ssd[1];
		data[5]=hdd[1];
		data[6]=odd[1];
		data[7]=computercase[1];
		data[8]=psu[1];
		
		var total=0;
		
		for(var i=0;i<data.length;i++) {
			if(data[i]=="") {
				data[i]="0";
			}
			total+=parseInt(data[i]);
		}
		document.getElementById("source").value=total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"원";
	}
</script>
<script type="text/javascript" src="SmartEditor/js/HuskyEZCreator.js"></script>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript">
	var oEditors = [];
	$(function(){
		nhn.husky.EZCreator.createInIFrame({
			oAppRef: oEditors,
			elPlaceHolder: "content",
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
	oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다. 
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

	try {
	elClickedObj.form.submit();
	}
	catch(e) {}
	}
</script>
</head>
</html>
<?php
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

echo("<center><form method=post action='add_desktop_process.php' name=dekstop>
<table width=1080 border=0 style='margin-top:100px; margin-bottom:30px;'>
<tr><td colspan=2 align=center>[견적내용]</td></tr>");

echo("<tr><td>CPU</td><td><select onchange='operating()' name=CPU>");
$cpu_result=mysql_query("select * from partsDB where kind='CPU' order by price",$con);
$cpu_total=mysql_num_rows($cpu_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$cpu_total) {
	$code=mysql_result($cpu_result,$i,"code");
	$name=mysql_result($cpu_result,$i,"name");
	$price=mysql_result($cpu_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>메인보드</td><td><select onchange='operating()' name=Mainboard>");
$mainboard_result=mysql_query("select * from partsDB where kind='Mainboard' order by price",$con);
$mainboard_total=mysql_num_rows($mainboard_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$mainboard_total) {
	$code=mysql_result($mainboard_result,$i,"code");
	$name=mysql_result($mainboard_result,$i,"name");
	$price=mysql_result($mainboard_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>RAM</td><td><select onchange='operating()' name=RAM>");
$ram_result=mysql_query("select * from partsDB where kind='RAM' order by price",$con);
$ram_total=mysql_num_rows($ram_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$ram_total) {
	$code=mysql_result($ram_result,$i,"code");
	$name=mysql_result($ram_result,$i,"name");
	$price=mysql_result($ram_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>그래픽카드</td><td><select onchange='operating()' name=VGA>");
$vga_result=mysql_query("select * from partsDB where kind='VGA' order by price",$con);
$vga_total=mysql_num_rows($vga_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$vga_total) {
	$code=mysql_result($vga_result,$i,"code");
	$name=mysql_result($vga_result,$i,"name");
	$price=mysql_result($vga_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>SSD</td><td><select onchange='operating()' name=SSD>");
$ssd_result=mysql_query("select * from partsDB where kind='SSD' order by price",$con);
$ssd_total=mysql_num_rows($ssd_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$ssd_total) {
	$code=mysql_result($ssd_result,$i,"code");
	$name=mysql_result($ssd_result,$i,"name");
	$price=mysql_result($ssd_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>HDD</td><td><select onchange='operating()' name=HDD>");
$hdd_result=mysql_query("select * from partsDB where kind='HDD' order by price",$con);
$hdd_total=mysql_num_rows($hdd_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$hdd_total) {
	$code=mysql_result($hdd_result,$i,"code");
	$name=mysql_result($hdd_result,$i,"name");
	$price=mysql_result($hdd_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>ODD</td><td><select onchange='operating()' name=ODD>");
$odd_result=mysql_query("select * from partsDB where kind='ODD' order by price",$con);
$odd_total=mysql_num_rows($odd_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$odd_total) {
	$code=mysql_result($odd_result,$i,"code");
	$name=mysql_result($odd_result,$i,"name");
	$price=mysql_result($odd_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>케이스</td><td><select onchange='operating()' name=ComputerCase>");
$case_result=mysql_query("select * from partsDB where kind='ComputerCase' order by price",$con);
$case_total=mysql_num_rows($case_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$case_total) {
	$code=mysql_result($case_result,$i,"code");
	$name=mysql_result($case_result,$i,"name");
	$price=mysql_result($case_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr>");

echo("<tr><td>파워서플라이</td><td><select onchange='operating()' name=PSU>");
$psu_result=mysql_query("select * from partsDB where kind='PSU' order by price",$con);
$psu_total=mysql_num_rows($psu_result);
$i=0;
echo("<option value=','>선택</option>");
while($i<$psu_total) {
	$code=mysql_result($psu_result,$i,"code");
	$name=mysql_result($psu_result,$i,"name");
	$price=mysql_result($psu_result,$i,"price");
	echo("<option value='$code,$price'>$name</option>");
	$i++;
}
echo("</select></td></tr></table>");
echo("<table width=1080 border=0 style='margin-top:30px; margin-bottom:100px;'>
<tr><td colspan=2 align=center>[상품내용]</td></tr>
<tr><td>원가</td><td><input type=text id=source readonly style='border:none;'></td></tr>
<tr><td>판매가</td><td><input type=text name=price></td></tr>
<tr><td>포인트</td><td><input type=text name=point value='0'></td></tr>
<tr><td>상품이름</td><td><input type=text name=name></td></tr>
<tr><td>상품설명</td><td><textarea id=content name=content row=20 style='width:100%;'></textarea></td></tr>");
echo("<tr><td colspan=2><input type=submit value='상품 등록' onclick='submitContents(this)'>&nbsp;&nbsp;<a href='./add_parts.html'><input type=button value='부품 등록'></a></td></tr></table></form></center>");
mysql_close($con);
?>

<?php
include("./bottom.html");
?>