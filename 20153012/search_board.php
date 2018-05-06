<?php
if(!$wSearch) {
	echo("<script>
	window.alert('검색어를 입력하세요.');
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
<link rel="stylesheet" type="text/css" href="css/board.css">
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#FAFAFA";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}	
</script>
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
$result=mysql_query("select * from $tablename where $field like '%$wSearch%' order by num desc",$con);
$total=mysql_num_rows($result);
$i=0;

echo("<center><div class='board_title_wrapper'>");
if($id=="QnA") {
	echo("<div class='board_title_image'><img src='img/title/qna_title.png' width=100%></div>");
}
else if($id=="Event") {
	echo("<div class='board_title_image'><img src='img/title/event_title.png' width=100%></div>");
}
else if($id=="After") {
	echo("<div class='board_title_image'><img src='img/title/after_title.png' width=100%></div>");
}
echo("<div class='board_title_button'><a href='board.php?id=$id'>[목록으로]</a></div></div>");
echo("<table class='b_subject' style='border-bottom:1px solid black;' width=1080>
<tr align=center><td class='b_subject' width='7%'>글번호</td><td class='b_subject' width='65%'>제목</td><td class='b_subject'>게시자</td><td class='b_subject'>게시일</td><td class='b_subject'>조회수</td>");
if(!$total) {
	echo("<tr><td colspan=5 align=center height=50>검색된 글이 없습니다.</td></tr>");
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
	echo("[<a href='search_board.php?id=$id&cblock=1&cpage=1&wSearch=$wSearch&field=$field'>1</a>]");
}
if($pblock>0) {
	echo("<a href='search_board.php?id=$id&cblock=$pblock&cpage=$pstartpage&wSearch=$wSearch&field=$field'>◀</a>");
}
$i=$startpage;
while($i<$nstartpage)
{
	if($i>$totalpage) {
		break;
	}
	echo("[<a href='search_board.php?id=$id&cblock=$cblock&cpage=$i&wSearch=$wSearch&field=$field'>$i</a>]");
	$i++;
}
if($nstartpage<=$totalpage) {
	echo("<a href='search_board.php?id=$id&cblock=$nblock&cpage=$nstartpage&wSearch=$wSearch&field=$field'>▶</a>");
}
if($cblock!=$totalblock && $totalpage!=0) {
	echo("[<a href='search_board.php?id=$id&cblock=$totalblock&cpage=$totalpage&wSearch=$wSearch&field=$field'>$totalpage</a>]");
}
echo("</td></tr></table></center>");
?>
<?php
include("./bottom.html");
?>