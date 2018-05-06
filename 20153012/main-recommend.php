<html>
<head>
<link rel="stylesheet" type="text/css" href="css/main-recommend.css" />
<script type="text/javascript">
	function changeColor1(obj)
	{
		obj.style.opacity="0.5";
	}
	function changeColor2(obj)
	{
		obj.style.borderColor="#ffffff";
		obj.style.opacity="1";
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

echo("<div class='recommend_wrapper'><img src='./img/title/main_recommend.png' width='540' style='margin-top:50px;'></div>");
echo("<div class='recommend_wrapper'>");
$recommend_result=mysql_query("select * from goodsDB order by hit desc",$con);
$i=0;
$savedir="./list/goods";
while($i<4)
{
	$code=mysql_result($recommend_result,$i,"code");
	$userfile=mysql_result($recommend_result,$i,"userfile");
	$name=mysql_result($recommend_result,$i,"name");
	$brand=mysql_result($recommend_result,$i,"brand");
	$isDC=mysql_result($recommend_result,$i,"isDC");
	
	if($isDC==1) {
		$price=mysql_result($recommend_result,$i,"discount");
	}
	else {
		$price=mysql_result($recommend_result,$i,"price");
	}
	
	$price=number_format($price);
	
	echo("<div class='recommend_goods' onmouseout='changeColor2(this)' onmouseover='changeColor1(this)' onclick=\"location.href='./goods_detail.php?code=$code'\">
		<img src='$savedir/$userfile' width='250' height='250'/><br>
		<div style='padding:5px; color:#666666; min-height:30px; text-align:center; font-size:10pt; center; margin-top:13px'>$name</font></div>
		<div style='padding-bottom:5px; padding-top:5px; margin-bottom:15px; text-align:center;'>");
	if($isDC==1) {
		echo("<b style='color:#ff0000; font-size:10pt; font-weight:red;'>$price 원</b></div>");
	}
	else {
		echo("<b style='color:#51afff; font-size:10pt; font-weight:bold;'>$price 원</b></div>");
	}
	echo("</div>");
	$i++;
}
echo("</div>");

echo("<div class='best_wrapper'><img src='./img/title/main_best.png' width='540' style='margin-top:50px;'></div>");
echo("<div class='best_wrapper'>");
$best_result=mysql_query("select * from goodsDB order by sold desc",$con);
$i=0;
while($i<4)
{
	$code=mysql_result($best_result,$i,"code");
	$userfile=mysql_result($best_result,$i,"userfile");
	$name=mysql_result($best_result,$i,"name");
	$brand=mysql_result($best_result,$i,"brand");
	$isDC=mysql_result($best_result,$i,"isDC");
	
	if($isDC==1) {
		$price=mysql_result($best_result,$i,"discount");
	}
	else {
		$price=mysql_result($best_result,$i,"price");
	}
	$price=number_format($price);
	
	echo("<div class='best_goods' onmouseout='changeColor2(this)' onmouseover='changeColor1(this)' onclick=\"location.href='./goods_detail.php?code=$code'\">
		<img src='$savedir/$userfile' width='250' height='250'/><br>
		<div style='padding:5px; color:#666666; min-height:30px; text-align:center; font-size:10pt; center; margin-top:13px'>$name</font></div>
		<div style='padding-bottom:5px; padding-top:5px; margin-bottom:15px; text-align:center;'>");
	if($isDC==1) {
		echo("<b style='color:#ff0000; font-size:10pt; font-weight:red;'>$price 원</b></div>");
	}
	else {
		echo("<b style='color:#51afff; font-size:10pt; font-weight:bold;'>$price 원</b></div>");
	}
	echo("</div>");
	$i++;
}
echo("</div>");

echo("<div class='inform_wrapper'>");
echo("
<div class='inform_title'><img src='./img/title/main_customer.png' style='margin-top:50px; width:200px;'></div>
<div class='inform_title'><img src='./img/title/main_offline.png' style='margin-top:50px; width:200px;'></div>
<div class='inform_title'><img src='./img/title/main_account.png' style='margin-top:50px; width:200px;'></div>");

echo("
<div style='width:1080px; background-color:#F0F0F0; text-aiign:center; margin-bottom:70px;'>
<div class='inform_content'>
<b style='font-size:15pt; color:#4C4C4C;'>070-1234-5678</b><br>
<b style='font-size:8pt; color:#4C4C4C; font-weight:none;'>아침 10시 ~ 새벽 2시까지 (연중무휴)</b><br></div>
<div class='inform_content'>
<br><b style='font-size:9pt; color:#4C4C4C; font-weight:none;'>평 &nbsp;&nbsp;일 &nbsp;&nbsp;&nbsp;&nbsp;10:00am - 06:00pm</b><br>
<b style='font-size:9pt; color:#4C4C4C; font-weight:none;'>토요일 &nbsp;&nbsp;&nbsp;&nbsp;10:00am - 02:00pm</b><br>
<b style='font-size:9pt; color:#4C4C4C; font-weight:none;'>휴무일 &nbsp;&nbsp;&nbsp;&nbsp;공휴일 / 일요일</b></div>
<div class='inform_content'>
<br><b style='font-size:9pt; color:#4C4C4C; font-weight:none;'>농 &nbsp;&nbsp;협 &nbsp;&nbsp;&nbsp;&nbsp;453123 - 52 -168753</b><br>
<b style='font-size:9pt; color:#4C4C4C; font-weight:none;'>예금주 &nbsp;&nbsp;&nbsp;&nbsp;남원우</b></div>
<br><br><br>
</div>
");
echo("</div>");
?>