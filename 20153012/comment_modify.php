<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

$date=date("Y-m-d H:i:s");
mysql_query("update commentDB set wdate='$date', content='$wContent' where parent=$no and topic='$id'",$con);

echo("<script>
window.alert('댓글이 수정되었습니다.');
location.replace('./show.php?no=$no&id=$id');
</script>");

mysql_close($con);
?>