<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$tablename=$id."DB";
$result=mysql_query("select space from $tablename where num=$no",$con);
$space=mysql_result($result,0,"space");
$space++;

$wdate = date("Y-m-d H:i:s");

$tmp_result=mysql_query("select num from $tablename",$con);  
$total=mysql_num_rows($tmp_result);

while($total>=$no) {
	mysql_query("update commentDB set parent=parent+1 where topic='$id' and parent=$total",$con);
	mysql_query("update $tablename set num=num+1 where num=$total",$con);
	$total--;
}

mysql_query("insert into $tablename(num,writer,wdate,title,content,space) 
values($no,'$UserID','$wdate','$wTitle','$wContent',$space)",$con);
mysql_close($con);

echo("<meta http-equiv='Refresh' content='0;url=board.php?id=$id'>");
?>