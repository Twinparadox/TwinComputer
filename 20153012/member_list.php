<?php
include("./top.html");
?>

<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from userDB order by userName",$con);
$total=mysql_num_rows($result);

echo("<center><table width=880 border=0 style='margin-top:100px;'>
<tr><td align=center><b>회원목록</b></td></tr></table>");

$i=0;

echo("<table border=1 style='border-collapse:collapse; margin-bottom:100px; font-size:10pt;'><tr>
<td align=center>ID</td>
<td align=center>이름</td>
<td align=center>주소</td>
<td align=center>자택전화</td>
<td align=center>휴대전화</td>
<td align=center>이메일</td></tr>");

while($i<$total){
	$userid=mysql_result($result,$i,"userID");
	$username=mysql_result($result,$i,"userName");
	$homephone=mysql_result($result,$i,"userHomePhone");
	$cellphone=mysql_result($result,$i,"userCellPhone");
	$postcode=mysql_result($result,$i,"PostCode");
	$roadaddress=mysql_result($result,$i,"RoadAddress");
	$restaddress=mysql_result($result,$i,"RestAddress");
	$email=mysql_result($result,$i,"userEmail");
	
	$address="(".$postcode.")"."&nbsp;".$roadaddress."<br>".$restaddress;
	
	echo("<tr>
	<td align=center>$userid</td>
	<td align=center>$username</td>
	<td align=center>$address</td>
	<td align=center>$homephone</td>
	<td align=center>$cellphone</td>
	<td align=center>$email</td></tr>");
	
	$i++;
}
echo("</table></center>");
?>

<?php
include("./bottom.html");
?>