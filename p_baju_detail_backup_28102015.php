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
	$filterSQL = " and upper(layanan) like upper('%$cariSQL%') ";
};//if

if($id_tipe_baju!=""){
	$filterSQL .= " and a.id_tipe_baju like '$id_tipe_baju' ";
}


if($id_warna!=""){
	$filterSQL .= " and warna like '$id_warna' ";
}

$runSQL = "select count(*) total from p_baju a where 1=1 $filterSQL";
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
 , b.id_tipe_baju
 , b.keterangan
 ,a.qty, a.warna
 ,IFNULL(c.nama,'-')nama
   from p_baju a
  join p_baju_tipe b on b.id_tipe_baju=a.id_tipe_baju 
  left join daerah c on  a.daerah=c.id
  where 1=1 $filterSQL
order by id_tipe_baju,id_layanan LIMIT $offsetRecord, $listRecord";

#echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {  
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[keterangan] </td>
                  <td> $row[layanan] </td>
		  <td align=center> $row[qty] </td>
                  <td align=center> $row[nama] </td>
		  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=p_baju_add&id=$row[id_layanan]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
           &nbsp;&nbsp;
          <a href='#' onclick='deleteconfirm(\"$row[id_layanan]\")'><img border='0' src='images/DeleteRed.png' title='Delete Data'></a></a>
		  </td>
	  </tr>
	";//htmlData
};//end-while
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
<table  border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Baju</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
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
			<b>Cari :<input type="text" name="cari" value="<?=$cari;?>" size="10">
<b>Warna:
<?
js_submit();
$sqlpetugas="select distinct id_warna, nama_warna from warna
union select 0,'--Pilih Warna--' from dual";
generate_select_event("id_warna",$sqlpetugas,$id_warna,"submit_form()"); 
?>
			 <input type="submit" name="run" value="Go" class="button">
       

		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=p_baju_detail";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=p_baju_add";?>">Tambah</a>| <a href="<?="?menu=$menu&uid=$uid&page=p_baju_tipe";?>">Tambah Katagori</a></b>
		 </td>
		 </form>
	  </tr>
		<tr><td colspan="2"><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='700' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
                        <td align='center'>Kategori</td>
                        <td align='center'>Detail</td>
                        <td align='center'>Quantity</td>
                        <td align='center'>Daerah</td>
                        <td align='center'>EDIT<br>LIHAT</td>
		</tr>
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