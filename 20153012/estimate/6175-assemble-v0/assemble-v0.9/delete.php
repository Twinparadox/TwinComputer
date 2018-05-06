<?

########## 데이터베이스에 연결한다. ###########
include "dbconn.inc";


########## 데이터베이스에 입력값을 삭제한다. ##########
$query = "DELETE FROM assemble WHERE id = $delete_id"; 
$result = mysql_query($query);


/*
if (!result) {
   echo (" Error! 입력이 되지 않았습니다. "); }
else{   echo (" 입력성공!<br> ");
    }
echo (" $delete_id <br>");

*/

 ########## 리스트 출력화면으로 이동한다. ##########
   echo ("<meta http-equiv='Refresh' content='0; URL=list.html'>");


?>
