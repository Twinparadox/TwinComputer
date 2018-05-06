<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$wdate=date("Y-m-d H:i:s");
$tablename=$id."DB";

$result=mysql_query("select * from commentDB",$con);
mysql_query("insert into commentDB(writer,wdate,content,topic,parent) values('$UserID','$wdate','$wContent','$id',$no)",$con);

echo("<meta http-equiv='Refresh' content='0;url=./show.php?no=$no&id=$id'>");

mysql_close($con);
?>