<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com; 0542-8012977
// 09 Oktober 2010, lastupdate 09 Oktober 2010

include_once("include.php");
if($id=="")$id=0;

//echo $act;//developer

if($act=="add"){
$hd=mysql_query("select harga_dasar from p_sublayanan where id_sublayanan='$subpesanan'");
$hrg_dsr=mysql_result($hd,0,"harga_dasar");
$harga=($hrg_dsr*$jml_orang);
$input_harga=$harga-(($diskon/100)*$harga);
$sql="insert into pesanan_plus(id_client,id_acara,id_sublayanan,jml_orang,harga) values('$id_client','$id_acara','$subpesanan','$jml_orang','$input_harga')";
//echo $sql;
mysql_query($sql);
$act=null;}
if($act=="delete"){
$sql="delete from pesanan_plus where id_client='$id_client' and id_acara='$id_acara' and id_plus='$id_plus'";//echo $sql;
mysql_query($sql);
$act=null;
}
?>
<link rel="stylesheet" href="images/style.css" type="text/css">
<FORM METHOD=POST>
<table border=0 cellpadding=4 cellspacing=0>
<tr><td><b>Tambahan Layanan</td><td><b>Volume</td><td><b>Diskon</td></tr>
<tr>
<td>
<SELECT NAME="subpesanan">
<OPTION selected label="none" value="none">None</OPTION>
<?
$sql="select id_layanan,layanan from p_layanan";
$r=mysql_query($sql);
for($b=0;$b<mysql_num_rows($r);$b++){
$sa=mysql_result($r,$b,"id_layanan");
$sb=mysql_result($r,$b,"layanan");
echo "<optgroup label='$sb'>";
$sql="select id_sublayanan,detail_layanan from p_sublayanan where id_layanan='$sa' and id_sublayanan not in (select id_sublayanan from paket_sub_paket where id_paket='$id_paket') order by detail_layanan";
echo $sql;//developer
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
    echo "<option value=\"";
    echo mysql_result($rs,$a,"id_sublayanan");
    echo "\">&nbsp;&nbsp;";
    echo mysql_result($rs,$a,"detail_layanan");
    echo " </option>";
}
echo "</optgroup>";
}
?>
</SELECT>
</td>
<td align=right><input type="text" name="jml_orang" size=4 value=1></td>
<td align=right><input type="text" name="diskon" size=4></td>
<td align=right>
<input type="hidden" name="id_acara" value="<?=$id_acara?>">
<input type="hidden" name="id_client" value="<?=$id_client?>">
<input type="hidden" name="menu" value="<?=$menu?>">
<input type="hidden" name="uid" value="<?=$uid?>">
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="act" value="add">
<INPUT TYPE="image" SRC="images/add.gif" HEIGHT="16" WIDTH="20" BORDER="0" ALT="Tambah Layanan" name="gambar" style="border-color:#FFFFFF;"> 
</td></tr>
</FORM>
<? 
$sql = "select b.id_sublayanan,b.detail_layanan,a.jml_orang,a.harga,a.id_plus from pesanan_plus a, p_sublayanan b where a.id_sublayanan=b.id_sublayanan and a.id_client='$id_client' and a.id_acara='$id_acara'";
$rs=mysql_query($sql);
//echo "<table>";
for($a=0;$a<@mysql_num_rows($rs);$a++){
$id_plus=mysql_result($rs,$a,"id_plus");
echo "
<tr>
 <td>&raquo;&nbsp;".mysql_result($rs,$a,"detail_layanan")."</td>
 <td align=right>&nbsp;".mysql_result($rs,$a,"jml_orang")."</td>
 <td align=right>&nbsp;".number_format(mysql_result($rs,$a,"harga"),0)."</td>
 <td><a href=\"?id_client=$id_client&id_acara=$id_acara&id_plus=$id_plus&act=delete&menu=$menu&uid=$uid&page=$page&id=$id\"><img src='images/delete.jpg' height=17 width=17 border=0></a></td>
</tr>";
}
echo "</table>";
?>
<!--<input type="button" value="simpan" onclick="javascript:self.parent.location.reload(true);">-->
<center>
<input type="button" value="selesai" onclick="javascript:self.parent.location.href='index.php?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&id=<?=$id?>';">