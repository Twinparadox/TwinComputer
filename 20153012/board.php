<?php 
include("./top.html");
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/board.css">
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#E6FFFF";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}	
</script>
</head>
</html>

<?php
// board
$host="localhost";
$ID="root";
$PW="apmsetup";	
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);
$tablename=$id."DB";
$result=mysql_query("select * from $tablename order by num desc",$con);
$total=mysql_num_rows($result);

echo("<center><div class='board_title_wrapper'>");
if($id=="QnA") {
	echo("<img src='img/title/qna_title.png' width=50%>");
}
else if($id=="Event") {
	echo("<img src='img/title/event_title.png' width=50%>");
}
else if($id=="After") {
	echo("<img src='img/title/after_title.png' width=50%>");
}
echo("</div>");

echo("<table class='b_subject' width=1080>
<tr align=center><td class='b_subject' width='7%'>글번호</td><td class='b_subject' width='65%'>제목</td><td class='b_subject'>게시자</td><td class='b_subject'>게시일</td><td class='b_subject'>조회수</td>");
if(!total) {
}
else {
if($cpage=='') {
	$cpage=1;
}
$pagesize=5;
$totalpage=(int)($total/$pagesize);
if(($total%$pagesize)!=0) {
	$totalpage++;
}
$i=0;
while($i<$pagesize)
{
	$newcounter=($cpage-1)*$pagesize+$i;
	if($newcounter==$total) {
		break;
	}
	
	$writer=mysql_result($result,$newcounter,"writer");
	$title=mysql_result($result,$newcounter,"title");
	$wdate=mysql_result($result,$newcounter,"wdate");
	$wdate=substr($wdate,0,10);
	$view=mysql_result($result,$newcounter,"view");
	$num=mysql_result($result,$newcounter,"num");
	$adm=mysql_query("select * from adminDB where adminID='$writer'",$con);
	$comment_result=mysql_query("select * from commentDB where parent=$num and topic='$id' order by wdate desc",$con);
	$comment_total=mysql_num_rows($comment_result);
	$adm_total=mysql_num_rows($adm);
	echo("<tr align=center height=30px onmouseover='changeColor1(this)' onmouseout='changeColor2(this)'><td class='b_subject1'>$num</td><td class='b_subject1' align=left><a href='show.php?no=$num&id=$id'>$title [$comment_total]</a></td><td class='b_subject1'>");
	if($adm_total)
	{
	echo("<img src='./img/main_logo.png' width=50>");
	}
	else
	{
	echo("$writer");
	}
	echo("</td><td class='b_subject1'>$wdate</td><td class='b_subject1'>$view</td></tr>");
	$i++;
}
echo("</table>");
}

echo("<table width=1080 class='b_search'><tr><td>");
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
	echo("[<a href='board.php?id=$id&cblock=1&cpage=1'>1</a>]");
}
if($pblock>0) {
	echo("<a href='board.php?id=$id&cblock=$pblock&cpage=$pstartpage'>◀</a>");
}
$i=$startpage;
while($i<$nstartpage)
{
	if($i>$totalpage) {
		break;
	}
	echo("[<a href='board.php?id=$id&cblock=$cblock&cpage=$i'>$i</a>]");
	$i++;
}
if($nstartpage<=$totalpage) {
	echo("<a href='board.php?id=$id&cblock=$nblock&cpage=$nstartpage'>▶</a>");
}
if($cblock!=$totalblock && $totalpage!=0) {
	echo("[<a href='board.php?id=$id&cblock=$totalblock&cpage=$totalpage'>$totalpage</a>]");
}
echo("</td><form action='search_board.php?id=$id' method=post><td align=right>
<select name=field><option value=writer>글쓴이</option><option value='title'>제목</option><option value='content'>내용</option></select>
<input type=text name=wSearch size=13>&nbsp;<input type='submit' value='찾기'></td></form></tr>
<tr><td align=center colspan=2><a href='write.php?id=$id'><img width=120 src='img/button/btn_write.png'></a></td></tr></table></center>");
mysql_close($con);
?>

<?php
include("./bottom.html");
?>