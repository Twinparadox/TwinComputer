<?php
include("./top.html");
?>
<html>
<link rel="stylesheet" type="text/css" href="./css/show.css">
</html>
<?
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );
$tablename=$id."DB";
$result=mysql_query("select * from $tablename where num=$no",$con);
$content=mysql_result($result,0,"content");
$writer=mysql_result($result,0,"writer");
$wdate=mysql_result($result,0,"wdate");
$title=mysql_result($result,0,"title");
$view=mysql_result($result,0,"view");
$view=$view+1;

echo("<center><div class='review_img'>");

if($id=="QnA") {
	echo("<img src='img/title/qna_title.png' width=50%>");
}
else if($id=="After") {
	echo("<img src='img/title/after_title.png' width=50%>");
}
else if($id=="Event") {
	echo("<img src='img/title/event_title.png' width=50%>");
}

echo("</div><div class='review_title_wrapper'>
	<div class='review_title_subject'>$title</div><div class='review_title_user'>작성자 : $writer</div></div>
	<div class='review_write_date'>작성일 : $wdate</div></div>
	<div class='review_content'>$content</div>");
	
echo("<table width='1080'><tr>
		<td align=center><a href='./board.php?id=$id'><img src='./img/button/btn_list.png' width=120></a>");
?>

<?php
if(!strcmp($UserID,$writer)) {
echo("&nbsp;<a href='./post_modify.php?no=$no&id=$id'><img src='./img/button/btn_modify.png' width=120></a>");
}
if($id=="QnA" && $isAdmin==1) {
echo("&nbsp;<a href='./reply.php?no=$no&id=$id'><img src='./img/button/btn_reply.png' width=120></a>");
}	
if(!strcmp($UserID,$writer) || $isAdmin==1){
echo("&nbsp;<a href='./post_delete.php?no=$no&id=$id'><img src='./img/button/btn_delete.png' width=120></a>");
}
?>

<?php		
echo("</td></tr></table>");

echo("<div class='comment_wrapper'><div class='comment_input'>
<form action='comment_input.php?no=$no&id=$id' method=post name=frmComment>
<textarea name=wContent class='comment_in' id='comment_in' row=3></textarea><input type=image width=75 src='./img/button/btn_register.png'>
</form></div>");
echo("<div class='comment_show'>");

include ("comment_show.php");
?>

<?php
echo("</div></div>");


echo("<div class='review_next_prev'>");

$next_no=$no + 1;
$next_result=mysql_query("select * from $tablename where num=$next_no",$con);
$next_rows=mysql_num_rows($next_result);
if($next_rows) {
	echo($next_nu);
	$next="./show.php?no=$next_no&id=$id";
	$next_title=mysql_result($next_result,0,"title");
	echo("<div class='review_next'><a href='$next'>다음 페이지 : $next_title</a></div>");
}

echo("<div class='review_current'>현재 페이지 : $title</div>");	

$prev_no=$no - 1;
$prev_result=mysql_query("select * from $tablename where num=$prev_no",$con);
$prev_rows=mysql_num_rows($prev_result);
if($prev_rows) {
	$prev="./show.php?no=$prev_no&id=$id";
	$prev_title=mysql_result($prev_result,0,"title");
	echo("<div class='review_prev'><a href='$prev'>이전 페이지 : $prev_title</a></div>");
}
echo("</div></center>");
mysql_query("update $tablename set view=$view where num=$no",$con);
mysql_close($con);
?>
<?php
include("./bottom.html");
?>