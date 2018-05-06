<html>
<head>
<style type="text/css">
#star ul.star { list-style: none; margin: 0; padding: 0; width: 85px; height: 20px; left: 10px; top: -5px; position: relative; float: left; background: url('./stars.gif') repeat-x; cursor: pointer; }
#star li { padding: 0; margin: 0; float: left; display: block; width: 85px; height: 20px; text-decoration: none; text-indent: -9000px; z-index: 20; position: absolute; padding: 0; }
#star li.curr { background: url('./stars.gif') left 25px; font-size: 1px; }
#star div.user { left: 15px; position: relative; float: left; font-size: 13px; font-family: arial; color: #888; }
td { text-align:center; font-size:9pt; }
</style>

<script type="text/javascript">
function $(v,o) { 
	return((typeof(o)=='object'?o:document).getElementById(v)); 
	}

function $S(o) { return((typeof(o)=='object'?o:$(o)).style); }
function agent(v) { return(Math.max(navigator.userAgent.toLowerCase().indexOf(v),0)); }
function abPos(o) { 
	var o=(typeof(o)=='object'?o:$(o)), z={X:0,Y:0}; 
	while(o!=null) { 
		z.X+=o.offsetLeft; 
		z.Y+=o.offsetTop; 
		o=o.offsetParent; 
		};
		return(z); 
}
function XY(e,v) { 
	var o=agent('msie')?{
	'X':event.clientX+document.body.scrollLeft,'Y':event.clientY+document.body.scrollTop}:{'X':e.pageX,'Y':e.pageY}; return(v?o[v]:o); }

star={};

star.mouse=function(e,o) { if(star.stop || isNaN(star.stop)) { star.stop=0;

	document.onmousemove=function(e) { var n=star.num;
	
		var p=abPos($('star'+n)), x=XY(e), oX=x.X-p.X, oY=x.Y-p.Y; star.num=o.id.substr(4);

		if(oX<1 || oX>84 || oY<0 || oY>19) { star.stop=1; star.revert(); }
		
		else {

			$S('starCur'+n).width=oX+'px';
			$S('starUser'+n).color='#111';
			$('starUser'+n).innerHTML=Math.round(oX/84*100);
		}
	};
} };

star.update=function(e,o) { var n=star.num, v=parseInt($('starUser'+n).innerHTML);

	n=o.id.substr(4); $('starCur'+n).title=v;

	req=new XMLHttpRequest(); req.open('GET','/AJAX_Star_Vote.php?vote='+(v/100),false); req.send(null);    

};

star.revert=function() { var n=star.num, v=parseInt($('starCur'+n).title);

	$S('starCur'+n).width=Math.round(v*84/100)+'px';
	$('starUser'+n).innerHTML=(v>0?Math.round(v):'');
	$('starUser'+n).style.color='#888';
	
	$('code'+n).value=(v>0?Math.round(v):'');
	document.onmousemove='';
};

star.num=0;

</script>
</head>
</html>

<?php
$host = "localhost";
$ID = "root";
$PW = "apmsetup";
$DB="db20153012";

$con=mysql_connect($host,$ID,$PW);
mysql_select_db($DB,$con);

$result=mysql_query("select * from receivers where ordernum='$ordernum'",$con);
$session=mysql_result($result,0,"session");

$order_result=mysql_query("select * from orderlist where ordernum='$ordernum'",$con);
$total=mysql_num_rows($order_result);

$i=0;

while($i<$total) {
	$after=mysql_result($order_result,$i,"after");
	if($after==1) {
		echo("<script>
		window.alert('이미 평가 완료되었습니다.');
		self.close();
		</script>");
		exit;
	}
	$i++;
}

$i=0;
echo("<form action='rating.php?ordernum=$ordernum' method=post><center><table width=750 border=0><div id='star'>
<tr><td>번호</td>
<td>브랜드</td>
<td>제품 이름</td>
<td>평점</td></tr>");
while($i<$total) {
	$num=$i+1;
	$code=mysql_result($order_result,$i,"code");
	
	$isDesktop=substr($code,0,7);
	
	if($isDesktop!="desktop") {
		$p_result=mysql_query("select * from goodsDB where code='$code'",$con);
		$pname=mysql_result($p_result,0,"name");
		$pbrand=mysql_result($p_result,0,"brand");
		$pgrade=mysql_result($p_result,0,"grade");
	}
	else {
		$p_result=mysql_query("select * from desktopDB where code='$code'",$con);
		$pname=mysql_result($p_result,0,"name");
		$pbrand="트윈 컴퓨터";
		$pgrade=mysql_result($p_result,0,"grade");
	}
	
	$star="star".$num;
	$starCur="starCur".$num;
	$starUser="starUser".$num;
	$codes="code".$num;
	$ratingcode=$code;
	
	echo("<tr><td>$num<input type=hidden name='$codes' value='$code'></td>
	<td>$pbrand</td>
	<td>$pname</td>
	<td><div id='star'><ul id='$star' class='star' onmousedown='star.update(event,this)' onmousemove='star.mouse(event,this)' title=''>
		<li id='$starCur' class='curr' title=$pgrade style='width:25px;'></li>
	</ul>
	<div style='color: rgb(136, 136, 136);' id='$starUser' class='user'></div>
	<br style='clear:both;'></div><input type=hidden name='$codes' id='$codes'></td></tr>");
	$i++;
}
echo("</div>
<tr><td colspan=4><input type=submit value='평가하기'></td></tr></table></center></form>");
?>