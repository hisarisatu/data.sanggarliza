<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");

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
                echo "<option value=0>-- Pilih --</option>\n";
        }
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
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
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}


if (($SAH[id_group]==1))
{
if($_GET['id_param']!=''){
    $sql_delete="delete from p_baju where id_layanan ='".$_GET['id_param']."'";
    $result = mysql_query($sql_delete, $connDB);
     if($result){
        $text_alert="Data Berhasil Dihapus";
     }else{
        $text_alert="Data Gagal Dihapus";
     }
}

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(a.layanan) like upper('%$cariSQL%') ";
};//if

if($id_tipe_baju!=""){
	$filterSQL .= " and b.id_tipe_baju like '$id_tipe_baju' ";
}


if($id_warna!=""){
	$filterSQL .= " and a.warna like '$id_warna' ";
}

$runSQL = "select count(*) total from (select distinct 
 a.id_layanan
 , a.layanan 
,a.kode
 , b.id_tipe_baju
 , b.keterangan
 ,IFNULL(d.nama,'-')daerah, IFNULL(e.nama_warna,'-')warna
 
   from p_baju a
    left join p_baju_tipe b on a.id_tipe_baju=b.id_tipe_baju 
   left join daerah d on  a.daerah=d.id
   left join warna e on a.warna=e.id_warna
 
where 
 1=1   $filterSQL group by a.id_layanan) b
  ";
$result = mysql_query($runSQL, $connDB);
if ($row = @mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
/*$runSQL = "select a.id_layanan, a.layanan, b.id_tipe_baju, b.keterangan,a.qty from p_baju a, p_baju_tipe b 
where b.id_tipe_baju=a.id_tipe_baju $filterSQL 
order by id_tipe_baju,id_layanan 
LIMIT $offsetRecord, $listRecord";
 */
$runSQL="select 
 a.id_layanan
 , a.layanan 
,a.kode
 , b.id_tipe_baju
 , b.keterangan
 ,IFNULL(d.nama,'-')daerah, IFNULL(e.nama_warna,'-')warna
 
   from p_baju a
    left join p_baju_tipe b on a.id_tipe_baju=b.id_tipe_baju 
   
   left join daerah d on  a.daerah=d.id
   left join warna e on a.warna=e.id_warna
 
where 
 1=1   $filterSQL
  group by a.id_layanan
  
order by id_tipe_baju,id_layanan LIMIT $offsetRecord, $listRecord";

//echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {  
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[keterangan] </td>
                  <td> $row[kode] </td>
                  <td> $row[layanan] </td>
				  
                  <td align=center> $row[daerah] </td>
				   <td align=center> $row[warna] </td>
				   <td align='center' nowrap>
				      <a href=\"javascript:void(window.open('p_baju_detail_ukuran.php?id=$row[id_layanan]','operator','toolbar=0,width=900,height=200,top=0, left=60'));\"><img border='0' src='images/view.png'></a>
					  <td align='center' nowrap>
					  <a href='?menu=$menu&uid=$uid&page=p_lihat_baju_gambar&id=$row[id_layanan]'><img border='0' src='images/view.png'></a>
		  
           
		  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=p_baju_add&id=$row[id_layanan]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
           &nbsp;&nbsp;
        
	  </tr>
	";//htmlData
};//end-while

/* <td align=center> $row[L1] </td>
				    <td align=center> $row[L2] </td>
					 <td align=center> $row[L3] </td>
					  <td align=center> $row[L4] </td>
					   <td align=center> $row[L5] </td>
					   <td align=center> $row[L6] </td>
				    <td align=center> $row[L7] </td>
					 <td align=center> $row[L8] </td>
					  <td align=center> $row[S] </td>
					   <td align=center> $row[M] </td>
					   <td align=center> $row[L] </td>
				    <td align=center> $row[XL] </td>
					 <td align=center> $row[XXL] </td>
					  <td align=center> $row[B55] </td>
					   <td align=center> $row[B56] </td>
					   <td align=center> $row[B57] </td>
				    <td align=center> $row[B58] </td>
					 <td align=center> $row[B59] </td>
					  <td align=center> $row[B60] </td>
					   <td align=center> $row[B61] </td>
		             <td align=center> $row[B62] </td>
					  <td align=center> $row[B63] </td>
					   <td align=center> $row[B64] </td>
					 <td align=center> $row[jumlah] </td>*/
					 
					 
					  /*   <td rowspan='2'>NO</td>
                        <td rowspan='2'>Kategori</td>
                        <td rowspan='2'>Detail</td>
                        <td colspan='8'>Beskap</td>
						<td colspan='5'>Kebaya</td>
                        <td colspan='10'>Blangkon</td>
                        <td rowspan='2'>Jumlah</td>
                        <td rowspan='2'>Daerah</td>
                       <td rowspan='2'>Warna</td>
                       <td rowspan='2'>LIHAT<br>UKURAN</td>
                       <td rowspan='2'>EDIT<br>LIHAT</td>
                          <tr bgcolor='#A7A7A7' height="25" align="center">
                        <td>L1</td>
                        <td>L2</td>
                        <td>L3</td>
                        <td>L4</td>
                        <td>L5</td>
                        <td>L6</td>
                        <td>L7</td>
                        <td>L8</td>
                        
                        
                        <td>S </td>
                        <td>M </td>
                        <td>L </td>
                        <td>XL</td>
                        <td>XLL</td>
                        
                        <td>55</td>
                        <td>56</td>
                        <td>57</td>
                        <td>58</td>
                        <td>59</td>
                        <td>60</td>
                        <td>61</td>
                        <td>62</td>
                        <td>63</td>
                        <td>64</td>
                      
                       
		</tr>
						
						*/

$uiddd=$_REQUEST['uid'];
?>
<script type="text/javascript">
function deleteconfirm(id){
    //alert(id);
    var tanya=confirm('Anda Yakin Akan Menghapus Data Ini '+id+' ?');
    if(tanya){
            window.location.href ='http://data.sanggarliza.com/?menu=4&uid=<?=$uiddd?>&page=p_baju_detail&id_param='+id;        
    }else{
        return false;
    }
   
}
</script>
<h3 style="color: red;"><?=@$text_alert?></h3>
<table  border="0" width="900" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Baju</b></font>

	 <table width="98%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
		<td valign="bottom"> <b>Filter :
			 <select name="id_tipe_baju" onchange="javascript:this.form.submit();">
				<option value='%'>--All--</option>
				<?php
				$sql="select id_tipe_baju,keterangan from p_baju_tipe";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_baju");
				if ($idp==$id_tipe_baju)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";
				} ?>
			</select>
            <b>Warna :
            <select name="id_warna" onchange="javascript:this.form.submit();">
				<option value='%'>--All--</option>
				<?php
				$sql="select id_warna,nama_warna from warna";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_warna");
				if ($idp==$id_warna)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"nama_warna");
				echo "</option>";
				} ?>
			</select>
            
			<b>Cari :<input type="text" name="cari" value="<?=$cari;?>" size="10">
			 <input type="submit" name="run" value="Go" class="button">
       

		 </td>
     <td valign="bottom" align="left">
		<img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=p_baju_detail";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=p_baju_add";?>">Tambah</a>| <a href="<?="?menu=$menu&uid=$uid&page=p_baju_tipe";?>">Tambah Katagori</a></b>
		 </td>
		 </form>
	  </tr>
		<tr><td colspan="2"><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='837' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25" align="center">
			<td width="37">NO</td>
                        <td width="161" >Kategori</td>
                        <td width="161" >Code</td>
                        <td width="226" >Detail</td>
                        
                        <td width="98" >Daerah</td>
                       <td width="97" >Warna</td>
                       <td width="90" >Lihat<br>Ukuran</td>
                       <td width="90" >Lihat<br>Baju</td>
                       <td width="91" >Edit<br>Lihat</td>
                 
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>


<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>