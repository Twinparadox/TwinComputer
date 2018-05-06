<?
if (!isset($UserID)) {
	echo ("<script>
	window.alert('로그인 사용자만 이용하실 수 있어요');
	history.go(-1);
	</script>");
	exit;
}
?>

<html>
<head>
<script type="text/javascript">
function changeColor1(obj) {
	obj.style.backgroundColor="#D4F4FA";
}
function changeColor2(obj) {
	obj.style.backgroundColor="#FFFFFF";
}	
</script>
<script>
function recent() {
	window.open('./recent_receiver.php','최근 배송지','width=800, height=700, scrollbars=yes');
}
</script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
	//본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
	function DaumPostcode() {
		new daum.Postcode({
			oncomplete: function(data) {
				// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

				// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
				// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
				var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
				var extraRoadAddr = ''; // 도로명 조합형 주소 변수

				// 법정동명이 있을 경우 추가한다. (법정리는 제외)
				// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
				if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
					extraRoadAddr += data.bname;
				}
				// 건물명이 있고, 공동주택일 경우 추가한다.
				if(data.buildingName !== '' && data.apartment === 'Y'){
				   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				}
				// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
				if(extraRoadAddr !== ''){
					extraRoadAddr = ' (' + extraRoadAddr + ')';
				}
				// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
				if(fullRoadAddr !== ''){
					fullRoadAddr += extraRoadAddr;
				}

				// 우편번호와 주소 정보를 해당 필드에 넣는다.
				document.getElementById('postcode').value = data.zonecode; //5자리 새우편번호 사용
				document.getElementById('roadAddress').value = fullRoadAddr;
				document.getElementById('jibunAddress').value = data.jibunAddress;

				
				// 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
				if (data.autoRoadAddress) {
					//예상되는 도로명 주소에 조합형 주소를 추가한다.
					var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
					document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
					document.getElementById('roadAddress').value = expRoadAddr;

				} else if (data.autoJibunAddress) {
					var expJibunAddr = data.autoJibunAddress;
					document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
					document.getElementById('jibunAddress').value = expJibunAddr;

				} else {
					document.getElementById('guide').innerHTML = '';
				}
			}
		}).open();
	}
</script>
</head>
</html>

<?php
include("./top.html");
?>

<?
if(!$spoint) $spoint=0;
// 전체 쇼핑백 테이블에서 특정 사용자의 구매 정보만을 읽어낸다
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result = mysql_query("select * from shoppingbag where id = '$UserID'", $con);
$user_result = mysql_query("select * from userDB where userID = '$UserID'", $con);
$total = mysql_num_rows($result);
$user_point = mysql_result($user_result, 0, "userPoint");
$userName=mysql_result($user_result,0,"userName");
$userCellPhone=mysql_result($user_result,0,"userCellPhone");
$userPostcode=mysql_result($user_result,0,"PostCode");
$userRoadAddress=mysql_result($user_result,0,"RoadAddress");
$userJibunAddress=mysql_result($user_result,0,"JibunAddress");
$userRestAddress=mysql_result($user_result,0,"RestAddress");

echo ("<center><table border=0 width=880 style='border-collapse:collapse; border-top:2px solid black; margin-top:50px;'>
<tr><td width=35% align=center><font size=2>상품사진</td>
<td width=20% align=center><font size=2>상품이름</td>
<td width=13% align=center><font size=2>가격(단가)</td>
<td width=9% align=center><font size=2>수량</td>
<td width=13% align=center><font size=2>품목별합계</td>
<td width=10% align=center><font size=2>적립예정<br>포인트</td></tr>
<tr><td colspan = 6><hr></td></tr>
");

// 바로구매하기로 구매시
if($right == 1)
{
	$result = mysql_query("select * from rightbuy where id = '$UserID'", $con);
	$code = mysql_result($result, 0, "pcode");
	$ea = mysql_result($result, 0, "ea");
	
	$isDesktop=substr($code,0,7);
	
	if($isDesktop!="desktop") {
		$subresult = mysql_query("select * from goodsDB where code='$code'", $con);
		$userfile = mysql_result($subresult, 0, "userfile");
		$name = mysql_result($subresult, 0, "name");
		$brand=mysql_result($subresult,0,"brand");
		$isDC=mysql_result($subresult,0,"isDC");
		if($isDC==0) {
			$price = mysql_result($subresult, 0, "price");
		}
		else {
			$price=mysql_result($subresult,0,"discount");
		}
		$point = mysql_result($subresult, 0, "point");
		$savedir="./list/goods";
	}
	else {
		$subresult=mysql_query("select * from desktopDB where code='$code'",$con);
		
		$ComputerCase=mysql_result($subresult,0,"ComputerCase");
		$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
		$userfile=mysql_result($case_result,0,"userfile");
		
		$name=mysql_result($subresult,0,"name");
		$price=mysql_result($subresult,0,"price");
		$point=mysql_result($subresult,0,"point");
		
		$savedir="./list/desktop";
	}
	
	$subtotalprice = $ea * $price;
	$subtotalpoint = $ea * $point;
	
	$totalpoint=$subtotalpoint;
	$totalprice = $subtotalprice;
	$oldtotalprice=$totalprice;
	$oldtotalprice=number_format($oldtotalprice);
	
	$subtotalprice=number_format($subtotalprice);
	$subtotalpoint=number_format($subtotalpoint);
	
	$price=number_format($price);
	echo("<tr><td align=center><a href=# onclick=\"window.open('$savedir/$userfile', '_new', 'width=450, height=450')\"><img src='$savedir/$userfile' width=80% height=178></a></td>
	<td align=center><font size=2><a href='goods_detail.php?code=$code'>$brand<br>$name</a></td>
	<td align=center><font size=2>$price&nbsp;원</td>
	<td align=center><font size=2>$ea&nbsp;개</td>
	<td align=center><font size=2>$subtotalprice&nbsp;원</td>
	<td align=center><font size=2>$subtotalpoint&nbsp;원</td></tr>");
	
	$user_point = $user_point-$spoint;
	$totalprice = $totalprice-$spoint;
	$tp = $totalprice-$spoint;
	
	$tpoint=$totalpoint;
	$tprice=$totalprice;
	
	$tp=number_format($tp);
	$totalpoint=number_format($totalpoint);
	$totalprice=number_format($totalprice);
	$up=number_format($user_point);
    echo("<tr><td colspan = 6><hr></td></tr><tr><td colspan=6 align=center><font size=2>총 구매 금액 : $oldtotalprice 원 <br>사용가능 포인트 : $up 포인트<br><form method=post action='point.php?spoint=$spoint&right=$right'>포인트 할인 :	<input type=text name=spoint value=$spoint size=10>
	<input type=submit value=적용></form><br> 할인적용 구매 금액: ");
	echo $totalprice; 
	echo("원 <br>총 적립 포인트 : $totalpoint 포인트</td></tr></table>");
}
//장바구니를 통해 구입시
else{
if (!$total) {
    echo("<tr><td colspan=6 align=center><font   size=2><b>쇼핑백에 담긴 상품이 없습니다.</b></font></td></tr></table>");
}
else {
    $counter=0;
    $totalprice=0;    // 총 구매 금액  

    while ($counter < $total) {
		$code = mysql_result($result, $counter, "productCode");
		$ea = mysql_result($result, $counter, "ea");
		
		$isDesktop=substr($code,0,7);
	
		if($isDesktop!="desktop") {
			$subresult = mysql_query("select * from goodsDB where code='$code'", $con);
			$userfile = mysql_result($subresult, 0, "userfile");
			$name = mysql_result($subresult, 0, "name");
			$brand=mysql_result($subresult,0,"brand");
			$isDC=mysql_result($subresult,0,"isDC");
			if($isDC==0) {
				$price = mysql_result($subresult, 0, "price");
			}
			else {
				$price=mysql_result($subresult,0,"discount");
			}
			$point = mysql_result($subresult, 0, "point");
			$savedir="./list/goods";
		}
		else {
			$subresult=mysql_query("select * from desktopDB where code='$code'",$con);
		
			$ComputerCase=mysql_result($subresult,0,"ComputerCase");
			$case_result=mysql_query("select * from partsDB where code='$ComputerCase'",$con);
			$userfile=mysql_result($case_result,0,"userfile");
			
			$name=mysql_result($subresult,0,"name");
			$price=mysql_result($subresult,0,"price");
			$point=mysql_result($subresult,0,"point");
			
			$savedir="./list/desktop";
		}


		$subtotalprice = $ea * $price;
		$totalprice = $totalprice + $subtotalprice; 
		$subtotalprice=number_format($subtotalprice);

		$subtotalpoint = $ea * $point;
		$totalpoint = $totalpoint + $subtotalpoint;
		$subtotalpoint=number_format($subtotalpoint);

		$price=number_format($price);
		echo("<tr><td align=center><a href=# onclick=\"window.open('$savedir/$userfile', '_new', 'width=450, height=450')\"><img src='$savedir/$userfile' width=80% height=178></a></td>
		<td align=center><font size=2><a href='goods_detail.php?code=$code'>$brand<br>$name</a></td>
		<td align=center><font size=2>$price&nbsp;원</td>
		<td align=center><font size=2>$ea&nbsp;개</td>
		<td align=center><font size=2>$subtotalprice&nbsp;원</td>
		<td align=center><font size=2>$subtotalpoint&nbsp;원</td></tr>");
		$counter++;
	}	
	$user_point = $user_point-$spoint;
	$oldtotalprice=$totalprice;
	$totalprice = $totalprice-$spoint;
	
	$tpoint=$totalpoint;
	$tprice=$totalprice;
	
	$tp=number_format($tp);
	$oldtotalprice=number_format($oldtotalprice);
	$totalpoint=number_format($totalpoint);
	$totalprice=number_format($totalprice);
	
	$up=number_format($user_point);
    echo("<tr><td colspan = 6><hr></td></tr><tr><td colspan=6 align=center><font size=2>총 구매 금액 : $oldtotalprice 원 <br>사용가능 포인트 : $up 포인트<br><form method=post action='point.php?spoint=$spoint'>포인트 할인 :	<input type=text name=spoint value=$spoint size=10>
	<input type=submit value=적용></form><br> 할인적용 구매 금액: ");
	echo $totalprice; 
	echo("원 <br>총 적립 포인트 : $totalpoint 포인트</td></tr></table>");
}}

mysql_close($con);	//데이터베이스 연결해제

echo ("<table border=0 width=880 style='border-top:1px solid black; border-bottom:1px solid black;'> 
<tr><td align=left><font size=2>저희 트윈 컴퓨터(Twin Computer)에서는 계좌이체로만 결제를 하실 수 있습니다.<br>그러므로 아래 계좌로 입금을 해주시기 바랍니다.<br><br>입금 계좌: <b> 농협 453123-52-168753 (예금주: 남원우)</b><br><br>
* 구입하신 물품은 입금 확인후 배송되며 배송기간은 평균적으로 1-2일 정도가 소요되며 <br>물량이 많을 경우 더 늦쳐질 수 있습니다. 이점 참고하시길 바랍니다.<br> * 주문 진행 상황은 My Page에서 확인하실 수 있습니다.<br>
* 물품 배송 이전에 주문 취소를 원하시면 My Page에서 직접 주문 취소 요청을 하시면 됩니다.<br>
* <font color=red><b>단 배송이 시작되면 주문을 취소하실수가 없으니 그 전에 취소해주시기바랍니다.</b></font><br>
* 물품을 배송 받으신 후에 구매 취소를 원하시면 고객센터(전화:070-1234-5678)로 연락주세요.
</td></tr>
</table>");

echo("<br><br><table width=880 border=0>
<tr><td align=center><font size=3><b>배송정보 입력</b></td></tr>
<tr><td align=center><a href='javascript:recent()'><img src='./img/button/btn_recent.png' width=100></a></td></tr>
</table>

<table width=880 border=0 style='margin-bottom:100px;font-size:9pt'>
<form method=post action='endshopping.php?right=$right&getpoint=$tpoint&uprice=$totalprice&usepoint=$spoint' name=buy>
<tr><td>*</td><td>받는이</td><td><input type=text id=receiver name=receiver size=10></td></tr>
<tr><td>*</td><td>전화번호</td><td><input type=text id=phone name=phone size=20></td></tr>
<tr><td width=5%>*</td><td width=15%>배송주소</td>
<td>
<input type=text size=10 name=wPostCode id=postcode placeholder='우편번호' readonly=readonly onclick=DaumPostcode()>
<input type=button onclick=DaumPostcode() value='우편번호 찾기'><br><br />
<input type=text size=30 name=wRoadAddress id=roadAddress placeholder='도로명주소' readonly=readonly onclick=DaumPostcode()>
<input type=text size=30 name=wJibunAddress id=jibunAddress placeholder='지번주소' readonly=readonly onclick=DaumPostcode()>
<br /><span id=guide style='color:#999;font-size:9px;'></span>   
<br /><br /><input type=text name=wRestAddress id=restAddress placeholder='나머지 주소' size=70 /><br><br>
</td></tr>
<tr><td>*</td><td><font size=2>주문요구사항</td><td><textarea name=message id=message rows=3 cols=65></textarea></td></tr>
<tr><td align=center colspan=3><input type=image src='./img/button/btn_buy.png' width=120></td></tr></table></form></center>");
?>
<?php
include("./bottom.html");
?>