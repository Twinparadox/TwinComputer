<?

########## �����ͺ��̽��� �����Ѵ�. ###########
include "dbconn.inc";


########## �����ͺ��̽��� �Է°��� �����Ѵ�. ##########
$query = "UPDATE assemble SET kind = '$new_kind', name = '$new_name', price = '$new_price' WHERE id  = $new_id";   
$result = mysql_query($query);

/*

if (!result) {
   echo (" Error! �Է��� ���� �ʾҽ��ϴ�. "); }
else{   echo (" �Է¼���!<br> ");
    }
echo (" $new_id <br>
        $new_kind <br>
        $new_name <br>
        $new_price <br>
      ");     

*/
 ########## ����Ʈ ���ȭ������ �̵��Ѵ�. ##########
   echo ("<meta http-equiv='Refresh' content='0; URL=list.html'>");


?>
