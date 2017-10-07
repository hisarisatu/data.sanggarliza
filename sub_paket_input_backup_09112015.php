<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com; 0542-8012977
// 09 Oktober 2010, lastupdate 09 Oktober 2010

include_once("include.php");
if($id=="")$id=0;

//echo $act;//developer

if($act=="add"){
$sql="insert into paket_sub_paket values('$id','$subpaket','$jml_orang','$satuan')";
mysql_query($sql);
$act=null;}
if($act=="delete"){
$sql="delete from paket_sub_paket where id_paket='$id' and id_sublayanan='$id_sub'";
mysql_query($sql);
$act=null;
}
?>
<link rel="stylesheet" href="images/style.css" type="text/css">
<FORM METHOD=POST>
<table><tr valign=top>
<td>
<SELECT NAME="subpaket">
<OPTION selected label="none" value="none">None</OPTION>
<?
$sql="select id_layanan,layanan from p_layanan";
$r=mysql_query($sql);
for($b=0;$b<mysql_num_rows($r);$b++){
$sa=mysql_result($r,$b,"id_layanan");
$sb=mysql_result($r,$b,"layanan");
echo "<optgroup label='$sb'>";
$sql="select id_sublayanan,detail_layanan from p_sublayanan 
where id_layanan='$sa' and id_sublayanan not in (select id_sublayanan from paket_sub_paket where id_paket='$id') 
and (tgl_habis is null or tgl_habis='0000-00-00')
order by detail_layanan";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
    $il=mysql_result($rs,$a,"id_sublayanan");
    $vl=mysql_result($rs,$a,"detail_layanan");
    $sz=strlen($vl);
    if($sz>75){
         $tz=str_split($vl,75);
         for($z=0;$z<count($tz);$z++){
              echo "<option value='$il'>&nbsp;&nbsp;";
              if($z!=0)echo "&raquo;&nbsp;";
              echo "$tz[$z]</option>";
         }
    }else{
         echo "<option value=\"$il\">&nbsp;&nbsp;$vl</option>";
    }
}
echo "</optgroup>";
}
?>
</SELECT>
</td>
<td><input type="text" name="jml_orang" size=4 value=0></td>
<td><select name="satuan">
<?
$rsat=mysql_query("select id_satuan,keterangan from p_satuan");
for($sat=0;$sat<@mysql_num_rows($rsat);$sat++){
	echo "<option value=\"";
	echo mysql_result($rsat,$sat,"id_satuan");
	echo "\">";
	echo mysql_result($rsat,$sat,"keterangan");
	echo "</option>";
}
?>
</select></td>
<td>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="act" value="add">
<INPUT TYPE="image" SRC="images/add.gif" HEIGHT="17" WIDTH="17" BORDER="0" ALT="Tambah Layanan" name="gambar" style="border-color:#FFFFFF;"> 
</td></tr></table>
</FORM>
<? 
$sql = "select b.id_sublayanan,b.detail_layanan,a.jml_orang from paket_sub_paket a, p_sublayanan b where a.id_sublayanan=b.id_sublayanan and a.id_paket='$id'";
$rs=mysql_query($sql);
echo "<table>";
for($a=0;$a<mysql_num_rows($rs);$a++){
$idsub=mysql_result($rs,$a,"id_sublayanan");
echo "
<tr>
 <td>&raquo;&nbsp;".mysql_result($rs,$a,"detail_layanan")."</td>
 <td>&nbsp;".mysql_result($rs,$a,"jml_orang")." orang</td>
 <td><a href=\"?id=$id&id_sub=$idsub&act=delete\"><img src='images/delete.jpg' height=17 width=17 border=0></a></td>
</tr>";
}
echo "</table>";
?>