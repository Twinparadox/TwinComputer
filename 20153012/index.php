<?php
include("./top.html");
include("./test.html");
include("./main-recommend.php");
include("./bottom.html");
?>
<script language="Javascript" type="text/javascript">
<!--
function setCookie( name, value, expirehours ) { 
 var todayDate = new Date(); 
 todayDate.setHours( todayDate.getHours() + expirehours ); 
 document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}
function closeWin() { 
 if(document.getElementById("pop_today").checked){
  setCookie( "mainPopcookie", "done" , 24 ); 
 }
 document.getElementById('layer_pop').style.display = "none";
}
-->
</script>
<div class="layer_popup" style="position:absolute; width:400px;left:50%; margin-left:-480px; top:500px; z-index:1;" id="layer_pop">
    <table width="400" border="0" cellpadding="0" cellspacing="0">
     <tr>
      <td><img src="img/popup.png" width="400" height="400" border="0" usemap="#m_pop" /></td>
     </tr>
     <tr>
      <td align="center" height="30" bgcolor="#eaeaea"><table width="95%" border="0" cellpadding="0" cellspacing="0">
       <tr>
        <td align="left" class="pop"><input type="checkbox" name="pop_today" id="pop_today" />오늘 하루 이 창 열지 않음</td>
        <td align="right" class="pop"><a href="javascript:closeWin();">닫기</a></td>
       </tr>
      </table></td>
     </tr>
 </table>
 <script language="Javascript" type="text/javascript">
     <!--
     cookiedata = document.cookie;
     // alert(cookiedata.indexOf("mainPopcookie=done"));
     if (cookiedata.indexOf("mainPopcookie=done") < 0){ 
      // alert("false");
      document.getElementById('layer_pop').style.display = "inline";
     } 
     else {
      // alert("true");
      document.getElementById('layer_pop').style.display = "none";
     }
     -->
</script>