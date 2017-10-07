<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="./src/js/jquery.js"></script>
<script type="text/javascript">
var htmlobjek;
$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=propinsi>
  $("#propinsi").change(function(){
    var propinsi = $("#propinsi").val();
    $.ajax({
        url: "ambilgruplayanan.php",
        data: "propinsi="+propinsi,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=kota>
            $("#kota").html(msg);
        }
    });
  });
  $("#kota").change(function(){
    var kota = $("#kota").val();
    $.ajax({
        url: "ambilsublayanan.php",
        data: "kota="+kota,
        cache: false,
        success: function(msg){
            $("#subpesanan").html(msg);
        }
    });
  });
});

</script>


<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com; 0542-8012977
// 09 Oktober 2010, lastupdate 09 Oktober 2010

include_once("include.php");
if($id=="")$id=0;

//echo $act;//developer

if($act=="add"){
$sql="insert into paket_sub_paket values('$id','$kota','$jml_orang','$satuan')";
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
<table>
<tr><td><select name="propinsi" id="propinsi" > 
<option>--Pilih Grup Layanan--</option>
<?php
$propinsi = mysql_query("SELECT * FROM p_layanan ORDER BY layanan");
while($p=mysql_fetch_array($propinsi)){
echo "<option value=\"$p[id_layanan]\">$p[layanan]</option>\n";
}?>
</select>
<select name="kota" id="kota" >
     <option>--Pilih Sublayanan--</option>
     <?php
$kota = mysql_query("SELECT * FROM p_sublayanan where (tgl_habis is null or tgl_habis='0000-00-00')
ORDER BY detail_layanan");
while($p=mysql_fetch_array($propinsi)){
echo "<option value=\"$p[id_sublayanan]\">$p[detail_layanan]</option>\n";
}
?>
   </select>
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