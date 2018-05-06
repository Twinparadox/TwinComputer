<html>
<head>
<link rel="stylesheet" type="text/css" href="css/recent_receiver.css">
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#D4F4FA";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}
function choice(obj) {
	if(obj==-1) {
		opener.buy.receiver.value=document.recent.userName.value;
		opener.buy.phone.value=document.recent.userPhone.value;
		opener.buy.wPostCode.value=document.recent.userPost.value;
		opener.buy.wRoadAddress.value=document.recent.userRoad.value;
		opener.buy.wJibunAddress.value=document.recent.userJibun.value;
		opener.buy.wRestAddress.value=document.recent.userRest.value;
		this.close();
	}
	else {
		name="name"+obj;
		phone="phone"+obj;
		post="post"+obj;
		road="road"+obj;
		jibun="jibun"+obj;
		rest="rest"+obj;
		opener.buy.receiver.value=document.getElementsByName(name)[0].value;
		opener.buy.phone.value=document.getElementsByName(phone)[0].value;
		opener.buy.wPostCode.value=document.getElementsByName(post)[0].value;
		opener.buy.wRoadAddress.value=document.getElementsByName(road)[0].value;
		opener.buy.wJibunAddress.value=document.getElementsByName(jibun)[0].value;
		opener.buy.wRestAddress.value=document.getElementsByName(rest)[0].value;
		this.close();
	}
}
</script>
</head>
<body>
<form method=post action=recent_receiver.php name=recent>

<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from recentReceiver where userID='$UserID' order by rdate desc");
$total=mysql_num_rows($result);

echo("<center><table style='border-collapse:collapse;' width=750>
<tr class=devide><td>번호</td>
<td>받는이</td>
<td>전화번호</td>
<td>우편번호</td>
<td>주소</td></tr>");

if($total) {
	$i=0;
	while($i<$total) {
		$num=$i+1;
		$receiverName=mysql_result($result,$i,"receiverName");
		$receiverPhone=mysql_result($result,$i,"receiverPhone");
		$postcode=mysql_result($result,$i,"PostCode");
		$roadAddress=mysql_result($result,$i,"RoadAddress");
		$jibunAddress=mysql_result($result,$i,"JibunAddress");
		$restAddress=mysql_result($result,$i,"RestAddress");
		
		$name="name".$num;
		$phone="phone".$num;
		$post="post".$num;
		$road="road".$num;
		$jibun="jibun".$num;
		$rest="rest".$num;
		
		echo("<tr onclick='choice($num)' onmouseout='changeColor2(this)' onmouseover='changeColor1(this)'>
		<td>$num</td>
		<td>$receiverName<input type=hidden name='$name' value='$receiverName'></td>
		<td>$receiverPhone<input type=hidden name='$phone' value='$receiverPhone'></td>
		<td>$postcode<input type=hidden name='$post' value='$postcode'></td>
		<td>$roadAddress<input type=hidden name='$road' value='$roadAddress'>
		<br>$jibunAddress<input type=hidden name='$jibun' value='$jibunAddress'>
		<br>$restAddress<input type=hidden name='$rest' value='$restAddress'></td></tr>");
		
		$i++;
	}		
}
else {
	echo("<tr><td colspan=8>최근 등록된 배송지가 없습니다.</td></tr>");
}
echo("</table>");
echo("<table style='border-collapse:collapse;' width=750>
<tr class=devide><td>받는이</td>
<td>전화번호</td>
<td>우편번호</td>
<td>주소</td></tr>");

$result=mysql_query("select * from userDB where userID='$UserID'",$con);
$userName=mysql_result($result,0,"userName");
$userCellPhone=mysql_result($result,0,"userCellPhone");
$postcode=mysql_result($result,0,"PostCode");
$roadAddress=mysql_result($result,0,"RoadAddress");
$jibunAddress=mysql_result($result,0,"JibunAddress");
$restAddress=mysql_result($result,0,"restAddress");

echo("<tr onclick='choice(-1)' onmouseout='changeColor2(this)' onmouseover='changeColor1(this)'>
<td>$userName<input type=hidden name=userName value='$userName'></td>
<td>$userCellPhone<input type=hidden name=userPhone value='$userCellPhone'></td>
<td>$postcode<input type=hidden name=userPost value='$postcode'></td>
<td>$roadAddress<input type=hidden name=userRoad value='$roadAddress'>
<br>$jibunAddress<input type=hidden name=userJibun value='$jibunAddress'>
<br>$restAddress<input type=hidden name=userRest value='$restAddress'></td></tr>");

echo("</table></center>");
?>

</form>
</body>
</html>