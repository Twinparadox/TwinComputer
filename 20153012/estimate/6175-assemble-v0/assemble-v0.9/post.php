<?

########## �����ͺ��̽��� �����Ѵ�. ###########
include "dbconn.inc";


########## �����ͺ��̽��� �Է°��� �����Ѵ�. ##########
$query = "INSERT INTO assemble (id, kind, name, price) VALUES ('$new_id', '$new_kind', '$new_name', '$new_price')";
$result = mysql_query($query);

/*
if (!result) {
   echo (" Error! �Է��� ���� �ʾҽ��ϴ�. "); }
else{   echo (" �Է¼���!<br> ");
    }
*/


 ########## ����Ʈ ���ȭ������ �̵��Ѵ�. ##########
   echo ("<meta http-equiv='Refresh' content='0; URL=list.html'>");


?>
