<?php
//join2.php
//register.php�� DB��ȯ
if(!$useagree || $useagree=="no") {
	echo("<script>
			window.alert('�̿����� �����ؾ� ������ �����մϴ�.');
			history.go(-1);
			</script>");
	exit;
}
if(!$informagree || $informagree=="no") {
	echo("<script>
			window.alert('�������� ��ȣ��å�� �����ؾ� ������ �����մϴ�.');
			history.go(-1);
			</script>");
	exit;
}
include("./top.html");
include("./join2.html");
include("./bottom.html");
?>