<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
include_once("p_bulan.php");

if($bulan_rencana!="")
 $filterSQL = " and a.tanggal like '$thn_rencana-$bulan_rencana-%' ";
if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
$pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw";

$runSQL="select count(1)total
    from acara a
  join p_acara b on a.id_acara=b.id_acara
  join client c  on a.id_client=c.id_client 
  $filterSQL
  ";
$runSQL="select count(1)total
    from acara a
  join p_acara b on a.id_acara=b.id_acara
  join client c  on a.id_client=c.id_client  
  inner join (select  a.*,b.id_layanan,b.detail_layanan from pesanan_plus a join layanan_external b
          on a.id_sublayanan=b.id_sublayanan)d
        on a.id_acara=d.id_acara and a.id_client=d.id_client
  left join (select id_acara,id_client,id_pekerjaan, count(1)jml from pegawai_tugas
     group by id_acara,id_client,id_pekerjaan)e
     on a.id_acara=e.id_acara and a.id_client=e.id_client and d.id_layanan=e.id_pekerjaan      
    where 1=1  $filterSQL";
#echo "<pre>".print_r($runSQL,true)."</pre>";exit; 
#$runSQL = "SELECT count(*) total FROM `acara` a, p_acara b, client c 
#        WHERE a.id_acara = b.id_acara AND a.id_client = c.id_client $filterSQL";

$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
#$runSQL = "SELECT distinct date_format(a.tanggal,'%d-%m-%Y') tgl_acara, b.acara, c.nama_cpw, c.nama_cpp, a.tempat,a.id_client,a.id_acara
#FROM `acara` a, p_acara b, client c
#where a.id_client=c.id_client
#and a.id_acara=b.id_acara 
#$filterSQL order by tanggal desc 
#LIMIT $offsetRecord, $listRecord"; //echo $runSQL;//developer
$runSQL ="select a.id_client,CONCAT(c.nama_cpw, ' / ', c.nama_cpp) nama_cpwcpp
      ,c.nama_cpw, c.nama_cpp  
      ,date_format(a.tanggal,'%d-%m-%Y')tgl_acara,b.acara
      ,a.tempat,b.id_produk,a.id_acara 
    from acara a
  join p_acara b on a.id_acara=b.id_acara
  join client c  on a.id_client=c.id_client  
  inner join (select  a.*,b.detail_layanan from pesanan_plus a join layanan_external b
          on a.id_sublayanan=b.id_sublayanan)d
        on a.id_acara=d.id_acara and a.id_client=d.id_client
  $filterSQL order by tanggal desc 
  LIMIT $offsetRecord, $listRecord
  ";
$runSQL="select a.id_client,a.id_acara,CONCAT(c.nama_cpw, ' / ', c.nama_cpp) nama_cpwcpp
      ,c.nama_cpw, c.nama_cpp  
      ,date_format(a.tanggal,'%d-%m-%Y')tgl_acara,b.acara
      ,a.tempat,b.id_produk,a.id_acara 
      ,d.detail_layanan
      ,d.jml_orang
      ,e.jml
      ,case when d.jml_orang=jml then 'selesai' else 'belum' end as stss 
      ,d.id_layanan
    from acara a
  join p_acara b on a.id_acara=b.id_acara
  join client c  on a.id_client=c.id_client  
  inner join (select  a.*,b.id_layanan,b.detail_layanan from pesanan_plus a join layanan_external b
          on a.id_sublayanan=b.id_sublayanan)d
        on a.id_acara=d.id_acara and a.id_client=d.id_client
  left join (select id_acara,id_client,id_pekerjaan, count(1)jml from pegawai_tugas
     group by id_acara,id_client,id_pekerjaan)e
     on a.id_acara=e.id_acara and a.id_client=e.id_client and d.id_layanan=e.id_pekerjaan      
    where 1=1  $filterSQL  
   order by  tanggal desc,a.id_client 
  LIMIT $offsetRecord, $listRecord;
  ";



$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
    $array_acara[$row['id_client']][$row['id_acara']]
            =array('nama_cpwcpp'=>$row['nama_cpwcpp'],
                'tgl_acara'=>$row['tgl_acara'],
                'acara'=>$row['acara'],
                'tempat'=>$row['tempat'],
                'detail_layanan'=>$row['detail_layanan'],
                'jml_orang'=>$row['jml_orang'],
                'jml'=>$row['jml'],
                'id_layanan'=>$row['id_layanan'],
                'stss'=>$row['stss']
                
            );
}
#echo "<pre>".print_r($array_acara,true)."</pre>";
#exit;
$htmlData="";
$x=1;
$typp="";
foreach ($array_acara as $key_client=> $ls){
    if ($x%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
   foreach ($ls as $key_acara=> $lis){ 
       if($lis['stss']=='selesai'){
        $typp="<img src='images/ok.png' border=0 width=12 height=12>";
       }else{   
           $typp="";
       } 
    $htmlData.=" <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>";
    $htmlData.="<td>".($offsetRecord+$x)."</td>";
    $htmlData.="<td>".$lis['nama_cpwcpp']."</td>";
    $htmlData.="<td>".$lis['tgl_acara']."</td>";
    $htmlData.="<td>".$lis['acara']."</td>";
    $htmlData.="<td>".$lis['tempat']."</td>";
    $htmlData.="<td>".$lis['detail_layanan']."</td>";
        #$htmlData.="<td>".$lis['jml_orang']."</td>";
    $htmlData.="<td style='text-align: center'>".$typp."</td>";
    $htmlData.="<td align='center' nowrap>";
    $htmlData.="<a href='?menu=$menu&uid=$uid&page=assign_view&id_acara=$key_acara&id=$key_client'><img border='0' src='images/view.png' height=20 width=20 title='Lihat Petugas'></a>";
    $htmlData.="</td>";
    $htmlData.="<td align='center' nowrap>";
    $htmlData.="<a href='?menu=$menu&uid=$uid&page=acara_sumberdaya&id_client=$key_client&id_acara=$key_acara'><img border='0' src='images/edit.gif' height=16 width=16 title='Sumber Daya Acara'></a>";
    $htmlData.="</td>";
    $htmlData.="</tr>";
   }          
 $x++;   
}
#echo "<pre>".print_r($html,true)."</pre>";
#exit;
 
?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Pesanan External</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=pesanan_vendor";?>">
     <td valign="bottom"><b>Bulan Kegiatan: 
<select name="bulan_rencana">
<option value="%">-All-</option>
<?php
$rb=mysql_query("select distinct date_format(tanggal,'%m') bulan from acara");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$bulan=mysql_result($rb,$bl,"bulan");
echo "<option ";
if($bulan==$bulan_rencana)echo " selected ";
echo "value='$bulan'>".nama_bulan($bulan)."</option>";
}
?>
</select> - 
<select name="thn_rencana">
<option value="%">-All-</option>
<?php
$rb=mysql_query("select distinct date_format(tanggal,'%Y') thn from acara");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$thn=mysql_result($rb,$bl,"thn");
echo "<option ";
if($thn==$thn_rencana)echo " selected ";
echo "value='$thn'>$thn</option>";
}
?>
</select>

			<b> &nbsp; Nama CPW : <input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=sumberdaya";?>"><b>List All</b></a>
		 </td>
		 </form>
	  </tr>
	 </table>

	 <table width='100%' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
		  <hr size="1" color="#4B4B4B">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
                        <td align='center'>NAMA CPW / CPP</td>
			<td align='center'>TANGGAL</td>
			<td align='center'>ACARA</td>
			<td align='center'>TEMPAT</td>
                        <td align='center'>Ext Order</td>
                        <!--<td align='center'>JUMLAH</td>-->
                        <td align='center'>STATUS</td>
			<td align='center'>PEGAWAI</td>
                        <td align='center'>SUMBERDAYA</td>
		</tr>
		<?=$htmlData;?>
                <tr >
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>
<?php
$sql_detail="select  a.*,b.detail_layanan from pesanan_plus a join layanan_external b
 on a.id_sublayanan=b.id_sublayanan";
?>