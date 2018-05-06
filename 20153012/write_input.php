<?php
if(!$wTitle)
{
	echo("<script>
	window.alert('제목을 작성해주세요.');
	history.go(-1);
	</script>");
	exit;
}
if(!$wContent)
{
	echo("<script>
	window.alert('내용을 작성해주세요.');
	history.go(-1);
	<script>");
	exit;
}
?>
<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );

// QnA
$result=mysql_query("select * from $id",$con);

echo ("$UserID");
echo("$wTitle");

$wDate = date("Y-m-d H:i:s");

$tablename=$id."DB";
$total_result=mysql_query("select * from $tablename",$con);
$total=mysql_num_rows($total_result);

mysql_query("insert into $tablename(num,writer,wdate,title,content) values($total+1,'$UserID','$wDate','$wTitle','$wContent')",$con);

echo("<meta http-equiv='Refresh' content='0;url=./board.php?id=$id'>");
mysql_close($con);
?>