<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );
mysql_query("delete from commentDB where parent=$no and topic='$id' and wdate='$wdate'",$con);

echo("<script>
window.alert('댓글이 삭제되었습니다.');
location.replace('./show.php?no=$no&id=$id');
</script>");

mysql_close($con);
?>