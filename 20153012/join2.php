<?php
//join2.php
//register.php와 DB교환
if(!$useagree || $useagree=="no") {
	echo("<script>
			window.alert('이용약관에 동의해야 가입이 가능합니다.');
			history.go(-1);
			</script>");
	exit;
}
if(!$informagree || $informagree=="no") {
	echo("<script>
			window.alert('개인정보 보호정책에 동의해야 가입이 가능합니다.');
			history.go(-1);
			</script>");
	exit;
}
include("./top.html");
include("./join2.html");
include("./bottom.html");
?>