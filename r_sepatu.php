<? 
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


if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(layanan) like upper('%$cariSQL%') ";
};//if

if($id_tipe_sepatu!=""){
	$filterSQL .= " and a.id_tipe_sepatu like '$id_tipe_sepatu' ";
}
if($id_warna!=""){
	$filterSQL .= " and warna like '$id_warna' ";
}
$runSQL = "select count(*) total from p_sepatu a where 1=1 $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = @mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select a.id_layanan, a.layanan, b.id_tipe_sepatu, b.keterangan,IFNULL(e.nama_warna,'-')warna
from p_sepatu a 
    left join p_sepatu_tipe b on a.id_tipe_sepatu=b.id_tipe_sepatu 
   
   left join warna e on a.warna=e.id_warna
   where 1=1 $filterSQL 
order by id_tipe_sepatu,id_layanan 
LIMIT $offsetRecord, $listRecord";
//echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[keterangan] </td>
                  <td> $row[layanan] </td>
				  <td align='center'> $row[warna] </td>
				  <td align='center' nowrap>
				      <a href=\"javascript:void(window.open('p_sepatu_detail_ukuran.php?id=$row[id_layanan]','operator','toolbar=0,width=900,height=200,top=0, left=60'));\"><img border='0' src='images/view.png'></a>
					  <td align='center' nowrap>
					  <a href=\"javascript:void(window.open('p_lihat_sepatu_gambar.php?id=$row[id_layanan]','operator','toolbar=0,width=900,height=500,top=0, left=60'));\"><img border='0' src='images/view.png'></a>
		 
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Sepatu</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
		<td valign="bottom"> <b>Filter :
			 <select name="id_tipe_sepatu" onchange="javascript:this.form.submit();">
				<option value='%'>--All--</option>
				<?
				$sql="select id_tipe_sepatu,keterangan from p_sepatu_tipe";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_sepatu");
				if ($idp==$id_tipe_sepatu)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";
				} ?>
			</select>
			<b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="10">
			<b>Warna:
        <select name="id_warna" onchange="javascript:this.form.submit();">
				<option value='%'>--All--</option>
				<?
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

			 <input type="submit" name="run" value="Go" class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=r_sepatu";?>">List All</a></b>
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
						<td align='center'>Warna</td>
						<td align='center'>Lihat Ukuran</td>
                        <td align='center'>Lihat Gambar</td>
                        
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
