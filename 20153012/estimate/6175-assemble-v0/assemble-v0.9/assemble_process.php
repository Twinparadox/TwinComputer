<?

########## �����ͺ��̽��� �����Ѵ�. ###########
include "dbconn.inc";

########## ���������� �Ѿ�� ��ǰ��� ������ $id[]�� �����Ѵ�. ###########
$id[0] = $mother_name;
$id[1] = $cpu_name;
$id[2] = $ram_name;
$id[3] = $hdd_name;
$id[4] = $vga_name;
$id[5] = $case_name;
$id[6] = $sound_name;
$id[7] = $moniter_name;
$id[8] = $printer_name;
$id[9] = $scanner_name;
$id[10] = $speaker_name;
$id[11] = $keyboard_name;
$id[12] = $cdrom_name;
$id[13] = $cdrw_name;
$id[14] = $fdd_name;
$id[15] = $mouse_name;
$id[16] = $tvcard_name;
$id[17] = $cam_name;
$id[18] = $power_name;
$id[19] = $lancard_name;
$id[20] = $lanherb_name;

##########  ���������� �Ѿ�� ������ $es[] �� �����Ѵ�. ##########
$ea[0] = $mother_ea;
$ea[1] = $cpu_ea;
$ea[2] = $ram_ea;
$ea[3] = $hdd_ea;
$ea[4] = $vga_ea;
$ea[5] = $case_ea;
$ea[6] = $sound_ea;
$ea[7] = $moniter_ea;
$ea[8] = $printer_ea;
$ea[9] = $scanner_ea;
$ea[10] = $speaker_ea;
$ea[11] = $keyboard_ea;
$ea[12] = $cdrom_ea;
$ea[13] = $cdrw_ea;
$ea[14] = $fdd_ea;
$ea[15] = $mouse_ea;
$ea[16] = $tvcard_ea;
$ea[17] = $cam_ea;
$ea[18] = $power_ea;
$ea[19] = $lancard_ea;
$ea[20] = $lanherb_ea;
?> 
<p align="center"> <b>PC ���� ���</b>
<p>
<table width="600" border="0" cellpadding="1" cellspacing="0" bgcolor="#666666" align="center">

<tr> 
    <td>
       
      <table border="0" width="600" align="center" cellspacing="1" cellpadding="3">
        <tr bgcolor="#999999"> 
          <td align="center" width=400><font size="2" color="#FFFFFF">�����Ͻ� ��ǰ��</font></td>
          <td align="center" width=120><font size="2" color="#FFFFFF">��ǰ����(�ܰ�)</font></td>
          <td align="center" width="80"><font size="2" color="#FFFFFF">�� ��</font></td>
        </tr>

<?
for($i = 0; $i < 21; $i++) {
     
    if (!($id[$i]=='null')) {
   
       $query = "SELECT * FROM assemble WHERE id = $id[$i]";
       $result= mysql_query($query);

       $col = mysql_fetch_array($result); 
       $my_name= $col[name]; 
       $my_price= $col[price];  
       
       $t_price = $my_price * $ea[$i];
       $total_price = $total_price + $t_price ;   ### ���� �հ� ###
       
       echo("<tr bgcolor='#FFFFFF'>");
       echo("   <td width='400'><font size=2>$my_name</font></td>");
       echo("   <td align='right' width='120'><font size=2>@ $my_price ��</font></td>");
       echo("   <td align='center' width='80'><font size=2>$ea[$i] ��</font></td>");  
       echo("</tr>");   
    }
 }  
 
 echo("</table>");
?>

    </td>
  </tr>
</table>
 

<table width="600" border="0" cellpadding="1" cellspacing="0" align="center">
  <tr>
    <td bgcolor="#666666"> 
      <table width="600" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td bgcolor="#999999" align="center"> <font size="2" color="#FFFFFF"><b>��ü 
            �հ� �ݾ� : 
          <?echo (" $total_price ");?> 
            ��</b>.</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p align="center"><a href="assemble.html">PC �������� ���ư���</a> </p>
<p align="center">
  <? include "footer.php"; ?>
</p>
