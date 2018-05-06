<?
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$dbconn = mysql_connect($host,$ID,$PW) || die("데이터베이스 연결에 실패하였습니다.");

$status = mysql_select_db("joapc");
if (!$status) {
   error("DB_ERROR");
   exit;
}
?>
