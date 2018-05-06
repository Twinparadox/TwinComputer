<link rel='stylesheet' type='text/css' href='css/mypage.css' />
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
<script>
	function isSame() {
		var pw = document.modify.mUserPW.value;
        var confirmPW = document.modify.mUserPWConfirm.value;
		if (pw.length < 6 || pw.length > 16) {
			window.alert('비밀번호는 6글자 이상, 16글자 이하만 이용 가능합니다.');
			document.getElementById('pw').value=document.getElementById('pwCheck').value='';
			document.getElementById('same').innerHTML='';			
		}
		if(document.getElementById('pw').value!='' && document.getElementById('pwCheck').value!='') {
			if(document.getElementById('pw').value==document.getElementById('pwCheck').value) {
				document.getElementById('same').innerHTML='비밀번호가 일치합니다.';
				document.getElementById('same').style.color='blue';
			}
			else {
				document.getElementById('same').innerHTML='비밀번호가 일치하지 않습니다.';
				document.getElementById('same').style.color='red';
			}
		}
	}
	function confirmExit() {
		if(confirm("정말로 탈퇴하시겠습니까?")==true) {
			window.open('exit.html','회원탈퇴 확인','width=400, height=200, scrollbars=no');
		}
		else {
			return;
		}
	}
</script>
<?php
// mypage
if(!$UserID) {
	echo("<script>
			window.alert('로그인이 필요한 서비스입니다.\\n로그인 후 이용하실 수 있습니다.');		
			location.replace('./login.html');
			</script>");
	exit;
}?>

<?php
include ("./top.html");
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con = mysql_connect ( $host, $ID, $PW );
mysql_select_db ( $DB, $con );
$result=mysql_query("select * from userdb where userID='$UserID'",$con);

$userPW=mysql_result($result,0,"userPW");
$userGender=mysql_result($result,0,"userGender");
if($userGender==1) {
	$userGender="남성";
}
else {
	$userGender="여성";
}
$userHomePhone=mysql_result($result,0,"userHomePhone");
$userCellPhone=mysql_result($result,0,"userCellPhone");
$userEmail=mysql_result($result,0,"userEmail");
$PostCode=mysql_result($result,0,"PostCode");
$RoadAddress=mysql_result($result,0,"RoadAddress");
$JibunAddress=mysql_result($result,0,"JibunAddress");
$RestAddress=mysql_result($result,0,"RestAddress");

if($right=="") {
	$right=0;
}

echo("<center>");


if($right==0) {
echo("<table><tr height=40><td align=center><b>[개인정보 수정]</b></td></tr></table>");	
echo("<form action='modify_register.php' method='post' name=modify>
<table width=700 height=600 cellpadding=0 style='border-collapse:collapse; font-size:9pt;'>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>회원 ID</td>
		<td>$UserID</td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>현재 비밀번호</td>
		<td><input type=password name=pUserPW></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>변경 비밀번호</td>
		<td><input type=password name=mUserPW id=pw onchange='isSame()'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>비밀번호 확인</td>
		<td><input type=password name=mUserPWConfirm id=pwCheck onchange='isSame()'>&nbsp;&nbsp;<span id=same style='font-size:9pt;'></span></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>이 름</td>
		<td>$UserName</td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>성 별</td>
		<td>$userGender</td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>집전화</td>
		<td><input type=tel name=mUserHomePhone value='$userHomePhone'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>휴대전화</td>
		<td><input type=tel name=mUserCellPhone value='$userCellPhone'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr class=register height=30>
		<td width='5%' align=center>*</td>
		<td width='15%'>이메일</td>
		<td><input type=tel name=mUserEmail value='$userEmail'></td>
	</tr>
	<tr height=7><td colspan=3><hr class=register></td></tr>
	<tr>
		<td width='5%' align=center>*</td>
		<td width='15%' align>주소</td>
		<td>
			<input type=text size=10 name=mPostCode value='$PostCode' readonly=readonly onclick='DaumPostcode()'>
			<input type=button onclick='DaumPostcode()' value='우편번호 찾기'><br><br>
			<input type=text size=30 name=mRoadAddress id=roadAddress value='$RoadAddress' readonly=readonly onclick='DaumPostcode()'>
			<input type=text size=30 name=mJibunAddress id=jibunAddress value='$JibunAddress' readonly=readonly onclick='DaumPostcode()'>
			<br><span id=guide style='color:#999;font-size:10px;'></span>
			<br><br><input type=text name=mRestAddress value='$RestAddress' size=70>
		</td>
	</tr></table><br>");
	echo("<table>
	<tr height=40>
		<td>
			<input width=120 type=image src='img/button/btn_accept.png'>&nbsp;<a href='index.php'><img src='img/button/btn_cancel.png' width=120></a>&nbsp;<a href=# onclick='confirmExit()'><img src='img/button/btn_exit.png' width=120 height=35></a>
		</td>
	</tr></table></form></center>");
}
include ("./bottom.html");
?>