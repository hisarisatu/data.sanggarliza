<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />



<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010
// 07 Oktober 2015  

include_once("include.php");
include_once("p_bulan.php");



function js_submit()
{
        echo "<script language=javascript>\n";
        echo "function submit_form() {\n";
        echo "  document.forms[0].submit();\n";
        echo "}\n";
        echo "</script>\n";

}

function generate_select_event($name,$sql,$default,$onchange)
{
		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }
        echo "<select name=$name onchange=\"$onchange;\">\n";
        if (!$default) {
                echo "<option value=0 >-- Pilih --</option>\n";
        }
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected >$val</option>\n";
                } else {
                        echo "<option value=$key >$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected >$val</option>\n";
                } else {
                        echo "<option value=$key >$val</option>\n";
                }
        }
        echo "</select>";
}
/*
?>
    <script language="JavaScript" src="calendar_us.js"></script>


    <?
*/

/*
if($act=="delete_record"){
$sql="delete from client where id_client='$id'";
@mysql_query($sql);
$sql="delete from acara where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_bayar where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_busana where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_diskon where id_client='$id'";
@mysql_query($sql);
$sql="delete from konsultasi where id_client='$id'";
@mysql_query($sql);
$sql="delete from _tugas where id_client='$id'";
@mysql_query($sql);
$sql="delete from pengeluaran where id_client='$id'";
@mysql_query($sql);
$sql="delete from pesanan_plus where id_client='$id'";
@mysql_query($sql);
$act=null;
}
*/
//echo $bulan_rencana;
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%'  ";
};//if

if ($id_pegawai==0) {$id_pegawai='%';}

if($bulan_rencana!="")
 	$filterSQL .= " and tgl_tm like '$thn_rencana-$bulan_rencana' ";
if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
if($id_pegawai!="")
	$filterSQL .=" and a.id_pegawai like '%$id_pegawai%' ";
if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tgl_tm BETWEEN '$tanggal' AND '$tanggal2'";}		

$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw&id_pegawai=$id_pegawai";


$runSQL = "select count(*) total from (select a.id_client, a.nama_cpw, a.nama_cpp, a.tgl_rencana, ifnull(b.tgl_tm,'belum ada janji')tgl_tm, b.waktu_tm, b.lokasi, b.petugas_tm, b.keterangan, ifnull(c.nama,'-')nama
 from client a 
 left join jadwal_tm b on a.id_client=b.id_client 
 left join pegawai c on a.id_pegawai=c.id_pegawai
 where a.id_client=b.id_client $filterSQL) b";


//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);

//////query reminder jadwal fitting///////

 date_default_timezone_get('Asia/Jakarta');
 $tanggal_hari_ini = date('Y-m-d');
 $tambah_tanggal   = mktime(0,0,0,date('m'),date('d')+2,date('Y')); 
 $tanggal_reminder = date('d',$tambah_tanggal);

$today  = date("Y-m-$tanggal_reminder");
$runSQL2 = mysql_query("select a.id_client, a.nama_cpw, a.tlp_mobile_cpw, a.nama_cpp, a.tlp_mobile_cpp, a.tgl_rencana, b.tgl_tm, b.waktu_tm, b.lokasi, b.petugas_tm, b.keterangan, ifnull(c.nama,'-')nama
 from client a 
 left join jadwal_tm b on a.id_client=b.id_client 
 left join pegawai c on a.id_pegawai=c.id_pegawai
 where a.id_client=b.id_client and tgl_tm between'$tanggal_hari_ini' and '$today'");

/////////////////////////////////////////////

$runSQL = "select a.id_client, a.nama_cpw, a.tlp_mobile_cpw, a.nama_cpp, a.tlp_mobile_cpp, a.tgl_rencana, b.tgl_tm, b.waktu_tm, b.lokasi, b.petugas_tm, b.keterangan, ifnull(c.nama,'-')nama
 from client a 
 left join jadwal_tm b on a.id_client=b.id_client 
 left join pegawai c on a.id_pegawai=c.id_pegawai
 where a.id_client=b.id_client $filterSQL 
order by id_client desc LIMIT $offsetRecord, $listRecord";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td align='center'> $row[nama_cpw] </td>
		  <td align='center'> $row[tlp_mobile_cpw] </td>
		  <td align='center'> $row[nama_cpp] </td>
		  <td align='center'> $row[tlp_mobile_cpp] </td>
		  <td align='center'> $row[tgl_rencana] </td>
		  <td align='center'> $row[tgl_tm] </td>
		  <td align='center'> $row[waktu_tm] </td>
          <td align='center'> $row[lokasi] </td>
          <td align='center'> $row[petugas_tm] </td>
		  <td> $row[keterangan] </td> 
		  <td> $row[nama] </td> ";
$htmlData .= "<td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=jadwal_tm_lihat&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a>";
if($SAH[id_group]==1 || $SAH[id_group]==12){
$htmlData .= "</td><td align='center' nowrap>";
$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=jadwal_tm_input&id=$row[id_client]'><img border='0' src='images/edit.gif' title='Edit Data'></a>		  
";
}
$htmlData .= "</td>
</tr>";
//htmlData
};//end-while

?>


        <table border="1" align="center">
            <tr align="center">
                <td colspan="14" align="center">
                    <font color="black" size="3" face="comic sans ms"><b>Di Bawah ini Daftar Freelance yang akan TM tanggal</b></font> <b><font color="red" size="2" face="comic sans ms"><? echo $tanggal_hari_ini; ?></font></b>
                    <font face="comic sans ms" size="2"><b> sampai </font></b>
                        <font color="red" size="2" face="comic sans ms"><b> <? echo $today; ?> </b></font>
                </td>
            </tr>
            <tr bgcolor='#A7A7A7' height="25">
                <td width="4%" align='center'>NO</td>
                <td width="12%" align='center'>NAMA CPW</td>
                <td width="12%" align='center'>HP CPW</td>
                <td width="8%" align='center'>Nama CPP</td>
                <td width="12%" align='center'>HP CPP</td>
                <td width="10%" align='center'>TGL RENCANA</td>
                <td width="14%" align='center'>TGL TM</td>
                <td width="10%" align='center'>WAKTU TM</td>
                <td width="10%" align='center'>LOKASI</td>
                <td width="10%" align='center'>PETUGAS TM</td>
                <td width="10%" align='center'>KETERANGAN</td>
                <td width="10%" align='center'>PETUGAS CS</td>

                <td width="6%" align='center'>LIHAT</td>
                <? if($SAH[id_group]==1 || $SAH[id_group]==12){ ?>
                    <td width="8%" align='center'>EDIT</td>
                    <? } ?>
            </tr>
            <!--
<?
////  BUAT TRIGGER EMAIL DISINI /////
// $baris = mysql_num_rows($runSQL2);
 //if ($baris > 0){ 
    
//date_default_timezone_set('Asia/Jakarta');
//require_once 'class.phpmailer.php';

//$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

//try {
//  $mail->AddReplyTo('marvin.sanggarliza@gmail.com', 'admin');
//  $mail->AddAddress('zalfinm@gmail.com', 'zalfinm');
// $mail->SetFrom('marvin.sanggarliza@gmail.com', 'admin');
//  $mail->AddReplyTo('marvin.sanggarliza@gmail.com', 'admin');
//  $mail->Subject = 'test';
//  $mail->AltBody = 'ini isi email'; // optional - MsgHTML will create an alternate automatically
//  $mail->MsgHTML(file_get_contents('http://data.sanggarliza.com/coba/phpmailer/examples/content.php'));
//  $mail->Send();
//  echo "Message Sent OK</p>\n";
//} catch (phpmailerException $e) {
//  echo $e->errorMessage(); //Pretty error messages from PHPMailer
//} catch (Exception $e) {
//  echo $e->getMessage(); //Boring error messages from anything else!
//}

//} else {}
//?>
-->
            <?
while ($row2 = mysql_fetch_array ($runSQL2)) {
	$no++;
        
	if ($no%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
		<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>";
?>
                <td align="center">
                    <? echo $no; ?>
                </td>
                <td align="center">
                    <? echo $row2['nama_cpw']; ?>
                </td>
                <td align="center">
                    <? echo $row2['tlp_mobile_cpw']; ?>
                </td>
                <td align="center">
                    <? echo $row2['nama_cpp']; ?>
                </td>
                <td align="center">
                    <? echo $row2['tlp_mobile_cpp'] ?>
                </td>
                <td align="center">
                    <? echo $row2['tgl_rencana']; ?>
                </td>
                <td align="center">
                    <? echo $row2['tgl_tm']; ?>
                </td>
                <td align="center">
                    <? echo $row2['waktu_tm']; ?>
                </td>
                <td align="center">
                    <? echo $row2['lokasi']; ?>
                </td>
                <td align="center">
                    <? echo $row2['petugas_tm']; ?>
                </td>
                <td>
                    <? echo $row2['keterangan']; ?>
                </td>
                <td>
                    <? echo $row2['nama']; ?>
                </td>
                <td align='center' nowrap>
                    <a href="http://data.sanggarliza.com/?menu=<?echo $menu;?>&uid=<?echo $uid;?>&page=jadwal_tm_lihat&id=<?echo$row2['id_client'];?>"> <img border='0' src='images/view.png' title='Lihat Data'></a>
                    <? if($SAH['id_group']==1 || $SAH['id_group']==12){?>
                </td>
                <td align='center' nowrap>
                    <a href="http://data.sanggarliza.com/?menu=<?echo $menu;?>&uid=<?echo $uid;?>&page=jadwal_tm_input&id=<?echo$row2['id_client'];?>"><img border='0' src='images/edit.gif' title='Edit Data'></a>
                    <?
}
?>
                </td>
                </tr>
                <?}?>
        </table>

        <table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
            <tr>
                <td width="100%" align="center" vAlign="top">
                    <font class="titledata"><b>Data Client</b></font>

                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tr>
                            <form method="POST" name="form" action="<?=" ?menu=$menu&uid=$uid&page=$page ";?>">
                                <td align="center"><b>Tgl TM:
     <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
        
        

 

			 <b> &nbsp; Nama CPW : <input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="15"> 
			 <b> &nbsp; Petugas CS : 
<?
js_submit();
$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
generate_select_event("id_pegawai",$sqlpetugas,$id_pegawai,"submit_form()"); 
?>
			 <input type="submit" name="run" value="  Go  " class="button">
		 
         

		 </form>
         <script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
    });
	 //]]></script>
        <!-- <script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
    //]]></script>-->
         
         
	  </tr>
	 </table>

	 <div align="center"><font class="titledata"><b>Laporan Jadwal TM Tgl <font color="red"><?=$tanggal?></font> s.d <font color="red"><?=$tanggal2?></font></b></font>
                                    </div>

                                    <div align="right">

                                        <a href="print_report_jadwal_tm.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>" target="_blank"><img border="0" src="images/Printer.png" height="45" width="45" alt="Print to Excel" title="Cetak jadwal TM" /></a>
                                        &nbsp;&nbsp;&nbsp;

                                        <b><a href="<?="?menu=$menu&uid=$uid&page=report_jadwal_tm";?>">List All</a></b>
                                    </div>

                                    <table width='99%' cellspacing='1' cellpadding='3'>
                                        <tr>
                                            <td colspan="12" align="left">
                                                <hr size="1" color="#4B4B4B"> Halaman :
                                                <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman,
                                                    <?=$totalRecord?> record.
                                            </td>
                                        </tr>
                                        <!--=== bgcolor='#A7A7A7'====-->
                                        <tr bgcolor='#A7A7A7' height="25">
                                            <td width="4%" align='center'>NO</td>
                                            <td width="12%" align='center'>NAMA CPW</td>
                                            <td width="12%" align='center'>HP CPW</td>
                                            <td width="8%" align='center'>Nama CPP</td>
                                            <td width="12%" align='center'>HP CPP</td>
                                            <td width="10%" align='center'>TGL RENCANA</td>
                                            <td width="14%" align='center'>TGL TM</td>
                                            <td width="10%" align='center'>WAKTU TM</td>
                                            <td width="10%" align='center'>LOKASI</td>
                                            <td width="10%" align='center'>PETUGAS TM</td>
                                            <td width="10%" align='center'>KETERANGAN</td>
                                            <td width="10%" align='center'>PETUGAS CS</td>

                                            <td width="6%" align='center'>LIHAT</td>
                                            <? if($SAH[id_group]==1 || $SAH[id_group]==12){ ?>
                                                <td width="8%" align='center'>EDIT</td>
                                                <? } ?>
                                        </tr>
                                        <?	if($act!="cari"){
				echo $htmlData;
			}?>
                                            <tr>
                                                <td colspan="12" align="left">
                                                    Halaman :
                                                    <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman,
                                                        <?=$totalRecord?> record.
                                                </td>
                                            </tr>
                                    </table>

                                </td>
                        </tr>
                    </table>
