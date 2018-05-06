<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

echo("<div class='comment_show'>");
$comment_result=mysql_query("select * from commentDB where parent=$no and topic='$id' order by wdate",$con);
$comment_total=mysql_num_rows($comment_result);
if(!$comment_total) {
	echo("<div class='comment_list' style='text-align:center;font-size:15pt;'>등록된 댓글이 없습니다.</div>");
}
else {
	$i=0;
	while($i<$comment_total) {
		$comment_writer=mysql_result($comment_result,$i,"writer");
		$comment_content=mysql_result($comment_result,$i,"content");
		$comment_wdate=mysql_result($comment_result,$i,"wdate");
		echo("<div class='comment_list'>
		<div class='comment_id'>$comment_writer</div><div class='comment_text'>$comment_content</div><div class='comment_date'>$comment_wdate</div>");
		echo("<div class='comment_modify'>");
		if($UserID==$comment_writer){
			echo("<a href=#>[M]</a>");
		}
		else {
			echo(" ");
		}
		echo("</div><div class='comment_delete'>");
		if($isAdmin==1 || $UserID==$comment_writer) {
			echo("<a href='comment_delete.php'>[X]</a>");
			
		}
		
		</div>");
		$i++;
	}
}
echo("</div>");
?>