<?php
if ($_FILES ["upload"] ["size"] > 0) {
	// ����ð� ���� $current_time = time();
	
	$time_info = getdate ( $current_time );
	$date_filedir = $time_info ["year"] . $time_info ["mon"] . $time_info ["time"] . $time_info [seconds] . $time_info [minutes] . $time_info [hours];
	
	// �������� ���� �̸�.Ȯ���� $ext =
	$ext = substr ( strrchr ( $_FILES ["upload"] ["name"], "." ), 1 );
	$ext = strtolower ( $ext );
	$savefilename = $date_filedir . "_editor_image" . "." . $ext;
	$uploadpath = $_SERVER ['DOCUMENT_ROOT'] . "Shopmall/upload/image";
	$uploadsrc = $_SERVER ['HTTP_HOST'] . "Shopmall/upload/image";
	$http = 'http' . ((isset ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] == 'on') ? 's' : '') . '://';
	
	// php ���Ͼ��ε��ϴ� �κ�
	if ($ext == "jpg" or $ext == "gif" or $ext == "png") {
		if (move_uploaded_file ( $_FILES ['upload'] ['tmp_name'], $uploadpath . "/" . $savefilename )) {
			$uploadfile = $savefilename;
			echo ("<script type='text/javascript'>alert('���ε强��');</script>;");
		}
	}
	else {
		echo ("<script type='text/javascript'>alert('jpg,gif,png���ϸ� ���ε尡���մϴ�.');</script>");
	}
}
else {
	exit ();
}	
echo ("<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '" . $http . $uploadsrc . "$uploadfile');</script>
;");
?>
