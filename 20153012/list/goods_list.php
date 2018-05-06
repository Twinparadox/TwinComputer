<?php
// goods_list
	
	$host="localhost";
	$ID="root";
	$PW="apmsetup";
	$DB="shopmall";
	
	$con=mysql_connect($host,$ID,$PW);
	mysql_select_db($DB,$con);
	
	echo("<table width=100%></table>");
?>