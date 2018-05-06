<?php
include("./top.html");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./css/goods_show.css">
<script type="text/javascript">
	function changeColor1(obj)
	{
		obj.style.borderColor="#012972";
	}
	function changeColor2(obj)
	{
		obj.style.borderColor="#dddddd";
	}
	function clearText(obj)
	{
		if(obj.defaultValue==obj.value) {
			obj.value='';
		}
		else if(obj.value==''){
			obj.value=obj.defaultValue;
		}
	}
</script>
</head>
</html>
<?php
// goods_show
$host="localhost";
$ID="root";
$PW="apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

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
	$result = mysql_query("select * from goodsDB where category=$category order by hit desc", $con);
}
else if($sorting==0) {
	$result=mysql_query("select * from goodsDB where category=$category order by price",$con);
}
else if($sorting==1) {
	$result=mysql_query("select * from goodsDB where category=$category order by price desc",$con);
}
else {
	$result=mysql_query("select * from goodsDB where category=$category order by hit desc",$con);
}
$total = mysql_num_rows($result);

echo("<center>");
echo("<table border=0 style='margin-top:50px;width:1000px margin-bottom:50px;'>");
echo("<tr><td><div style='width:1000px; text-align: left; padding-top: 3px; font-size: 9pt; margin: auto;'>");
echo("<div style='width:500px; display:inline-block;'>");

if($hit==1) {
	echo("<b><span><a href='goods_show.php?category=$category&hit=1&sorting=-1'>조회수순</a></span></b>");
}
else {
	echo("<span><a href='goods_show.php?category=$category&hit=1&sorting=-1'>조회수순</a></span>");
}
echo("<span class='sort_divide_bar'></span>");
if($sorting==0) {
	echo("<b><span><a href='goods_show.php?category=$category&hit=0&sorting=0'>낮은가격순</a></span></b>");
}
if($sorting!=0){
	echo("<span><a href='goods_show.php?category=$category&hit=0&sorting=0'>낮은가격순</a></span>");
}	
echo("<span class='sort_divide_bar'></span>");
if($sorting==1) {
	echo("<b><span><a href='goods_show.php?category=$category&hit=0&sorting=1'>높은가격순</a></span></b>");
}
if($sorting!=1) {
	echo("<span><a href='goods_show.php?category=$category&hit=0&sorting=1'>높은가격순</a></span>");
}	
echo("</div>");

echo("<div style='width:500px; display:inline-block; text-align:right;'>");
echo("<form action='search_goods.php?category=$category' method=post>
<select name=field><option value='brand'>제조사</option><option value='name'>상품명</option></select>
<input type=text name=wSearch size=13 value='리스트 내 검색' onFocus='clearText(this)' onBlur='clearText(this)'>&nbsp;<input type='submit' value='찾기'></form>");
echo("</div></div></td></tr></table>");

//echo("<table border=0 style='margin-top:20px;width:1000px'><tr><td align=left>총 상품 수 : $total</td></tr></table>");
echo ("<table border=0 width=1000px style='border-collapse:collapse;' class='goods_show_list'><tr>");

if (!$total){
	echo ("<td align=center><font color=red>아직 등록된 상품이 없습니다</td>");
}

else {
	if($cpage=='') {
		$cpage=1;
	}
	$pagesize=8;
	$totalpage=(int)($total/$pagesize);
	if(($total%$pagesize)!=0) {
		$totalpage++;
	}
	

	$i=0;
	
	$counter = 0;

	while ($i<$pagesize) {
		$counter=($cpage-1)*$pagesize+$i;
		if ($counter > 0 && ($counter % 4) == 0) {
			echo ("</tr><tr>");
		}
		if($counter==$total) {
			break;
		}
		
		$code=mysql_result($result,$counter,"code");
		$name=mysql_result($result,$counter,"name");
		$userfile=mysql_result($result,$counter,"userfile");
		$isDC=mysql_result($result,$counter,"isDC");
		if($isDC) {
			$price=mysql_result($result,$counter,"discount");
			$price=number_format($price);
		}
		else {
			$price=mysql_result($result,$counter,"price");
			$price=number_format($price);
		}
		echo ("<td width='25%' height=250 align=center>
		<div style='width:220px; border:1px solid #dddddd' onmouseout='changeColor2(this)' onmouseover='changeColor1(this)'>
		<a href='goods_detail.php?code=$code'><img src='./list/goods/$userfile' width='220' height='220' border=0></a></div>
		<div style='margin:auto; width=170px; clear:borth;'>
		<div style='padding:5px; color:#666666; min-height:30px; text-align:center; center; margin-top:13px'><a href='goods_detail.php?code=$code'><font style='text-decoration:none; font-size:10pt;'>$name</a></font></div>
		<div style='padding-bottom:5px; padding-top:5px; margin-bottom:15px; text-align:center;'>");
		
		if($isDC) {
			echO("<b style='color:red; font-size:10pt; font-weight:bold;'>$price 원</b></div>");
		}
		else {
			echo("<b style='color:#51afff; font-size:10pt; font-weight:bold;'>$price 원</b></div>");
		}
		echo("</div></td>");
		$i++;
	}
	if ($counter%4!=0) {
		$rest=4-($counter%4);
		$i=0;
		while($i<$rest) {
			echo("<td width='25%' height=250 align=center></td>");
			$i++;
		}
	}
	echo ("</tr></table>");
}
echo("<table width=1000px border=0 style='margin-bottom:100px;'><tr><td align=center>");
if($cblock=='') {
	$cblock=1;
}
$blocksize=3;
$pblock=$cblock-1;
$nblock=$cblock+1;
$totalblock=(int)($totalpage/$blocksize);
if(($totalpage%$blocksize)!=0) {
	$totalblock++;
}
$startpage=($cblock-1)*$blocksize + 1;
$pstartpage=$startpage-1;
$nstartpage=$startpage+$blocksize;
if($cblock>1) {
	echo("[<a href='goods_show.php?category=$category&cblock=1&cpage=1'>1</a>]");
}
if($pblock>0) {
	echo("<a href='goods_show.php?category=$category&cblock=$pblock&cpage=$pstartpage'>◀</a>");
}
$i=$startpage;
while($i<$nstartpage)
{
	if($i>$totalpage) {
		break;
	}
	echo("[<a href='goods_show.php?category=$category&cblock=$cblock&cpage=$i'>$i</a>]");
	$i++;
}
if($nstartpage<=$totalpage) {
	echo("<a href='goods_show.php?category=$category&cblock=$nblock&cpage=$nstartpage'>▶</a>");
}
if($cblock!=$totalblock && $totalpage!=0) {
	echo("[<a href='goods_show.php?category=$category&cblock=$totalblock&cpage=$totalpage'>$totalpage</a>]");
}
echo("</td></tr></table>");
echo("</center>");
mysql_close($con);
?>
<?php
include("./bottom.html");
?>