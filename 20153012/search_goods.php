<?php
if(!$wSearch) {
	echo("<script>
	window.alert('�˻�� �Է��ϼ���.');
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
	echo($hit);
	echo($sorting);
}

if($hit==1) {
	$result = mysql_query("select * from goodsDB where category=$category and $field like'%$wSearch%' order by hit desc", $con);
}
else if($sorting==0) {
	$result=mysql_query("select * from goodsDB where category=$category and $field like'%$wSearch%' order by price",$con);
}
else if($sorting==1) {
	$result=mysql_query("select * from goodsDB where category=$category and $field like'%$wSearch%' order by price desc",$con);
}
else {
	$result=mysql_query("select * from goodsDB where category=$category and $field like'%$wSearch%' order by hit desc",$con);
}
$total = mysql_num_rows($result);

$i=0;

echo("<center><table border=0 style='margin-top:100px;width:1000px'><tr><td align=left>�˻��� ��ǰ �� : $total</td><td align=right><a href='goods_show.php?category=$category'>[�������]</a></td></tr></table>");
echo ("<table border=0 width=1000px style='border-collapse:collapse; margin-top:10px; margin-bottom:10px;'>
<tr><td><div style='width:1000px; text-align: left; padding-top: 3px; font-size: 9pt; margin: auto;'>
<div style='width:500px; display:inline-block;'>");

if($hit==1) {
	echo("<b><span><a href='search_goods.php?category=$category&hit=1&sorting=-1&field=$field&wSearch=$wSearch'>��ȸ����</a></span></b>");
}
else {
	echo("<span><a href='search_goods.php?category=$category&hit=1&sorting=-1&field=$field&wSearch=$wSearch'>��ȸ����</a></span>");
}
echo("<span class='sort_divide_bar'></span>");
if($sorting==0) {
	echo("<b><span><a href='search_goods.php?category=$category&hit=0&sorting=0&field=$field&wSearch=$wSearch'>�������ݼ�</a></span></b>");
}
if($sorting!=0){
	echo("<span><a href='search_goods.php?category=$category&hit=0&sorting=0&field=$field&wSearch=$wSearch'>�������ݼ�</a></span>");
}	
echo("<span class='sort_divide_bar'></span>");
if($sorting==1) {
	echo("<b><span><a href='search_goods.php?category=$category&hit=0&sorting=1&field=$field&wSearch=$wSearch'>�������ݼ�</a></span></b>");
}
if($sorting!=1) {
	echo("<span><a href='search_goods.php?category=$category&hit=0&sorting=1&field=$field&wSearch=$wSearch'>�������ݼ�</a></span>");
}	
echo("</div>");
echo("<div style='width:500px; display:inline-block;'>");
echo("</div></div></td></tr></table>");

echo ("<table border=0 width=1000px style='border-collapse:collapse;' class='goods_show_list'></tr>");
if (!$total){
	echo ("<td align=center><font color=red>�˻��� ��ǰ�� �����ϴ�</td>");
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
		<div style='padding-bottom:5px; padding-top:5px; margin-bottom:15px; text-align:center;'><b style='color:#51afff; font-size:10pt; font-weight:bold;'>$price ��</b></div>
		</div></td>");
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
	echo("[<a href='search_goods.php?category=$category&cblock=1&cpage=1&field=$field&wSearch=$wSearch'>1</a>]");
}
if($pblock>0) {
	echo("<a href='search_goods.php?category=$category&cblock=$pblock&cpage=$pstartpage&field=$field&wSearch=$wSearch'>��</a>");
}
$i=$startpage;
while($i<$nstartpage)
{
	if($i>$totalpage) {
		break;
	}
	echo("[<a href='search_goods.php?category=$category&cblock=$cblock&cpage=$i&field=$field&wSearch=$wSearch'>$i</a>]");
	$i++;
}
if($nstartpage<=$totalpage) {
	echo("<a href='search_goods.php?category=$category&cblock=$nblock&cpage=$nstartpage&field=$field&wSearch=$wSearch'>��</a>");
}
if($cblock!=$totalblock && $totalpage!=0) {
	echo("[<a href='search_goods.php?category=$category&cblock=$totalblock&cpage=$totalpage&field=$field&wSearch=$wSearch'>$totalpage</a>]");
}
echo("</td></tr></table></center>");

?>