<?

########## �����ͺ��̽��� �����Ѵ�. ###########
include "dbconn.inc";


########## �����ͺ��̽��� �Է°��� �����Ѵ�. ##########
$query = "DELETE FROM assemble WHERE id = $delete_id"; 
$result = mysql_query($query);


/*
if (!result) {
   echo (" Error! �Է��� ���� �ʾҽ��ϴ�. "); }
else{   echo (" �Է¼���!<br> ");
    }
echo (" $delete_id <br>");

*/

 ########## ����Ʈ ���ȭ������ �̵��Ѵ�. ##########
   echo ("<meta http-equiv='Refresh' content='0; URL=list.html'>");


?>
