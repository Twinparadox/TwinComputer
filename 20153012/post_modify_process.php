<?php
if(!$wTitle) {
	echo("<script>
	window.alert('');
	</script>");
	exit;
}

$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );
$tablename=$id."DB";
$mdate = date("Y-m-d H:i:s");
mysql_query("update $tablename set title='$wTitle', content='$wContent', wdate='$mdate' where num=$no",$con);

echo("<meta http-equiv='Refresh' content='0;url=./show.php?no=$no&id=$id'>");
mysql_close($con);
?>