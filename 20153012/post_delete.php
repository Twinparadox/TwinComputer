<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$tablename=$id."DB";
$result=mysql_query("select num from $tablename where num=$no",$con);
$parent=mysql_result($result,0,"num");
echo($parent);

mysql_query("delete from commentDB where topic='$id' and parent=$parent",$con);
mysql_query("delete from $tablename where num=$no",$con);

echo("<script>window.alert('글이 삭제되었습니다.');</script>");

$tmp_result=mysql_query("select num from $tablename order by num desc",$con);
$last=mysql_result($tmp_result,0,"num");

$i=$no+1;
while($i<=$last)
{
	mysql_query("update commentDB set parent=parent-1 where topic='$id' and parent=$i",$con);
	mysql_query("update $tablename set num=num-1 where num=$i",$con);
	$i++;
}

echo("<meta http-equiv='Refresh' content='0;url=board.php?id=$id'>");

mysql_close($con); 
?>