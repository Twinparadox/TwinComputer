<?
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$dbconn = mysql_connect($host,$ID,$PW) || die("�����ͺ��̽� ���ῡ �����Ͽ����ϴ�.");

$status = mysql_select_db("joapc");
if (!$status) {
   error("DB_ERROR");
   exit;
}
?>