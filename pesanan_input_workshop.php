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
<style>
            .custom-combobox {
                position: relative;
                display: inline-block;
            }
            .custom-combobox-toggle {
                position: absolute;
                top: 0;
                bottom: 0;
                margin-left: -1px;
                padding: 0;
            }
            .custom-combobox-input {
                margin: 0;
                padding: 5px 10px;
            }
            *{
                font-size: 12.5px;
            }
        </style>
<script>



            (function($) {
                $.widget("custom.combobox", {
                    _create: function() {
                        this.wrapper = $("<span>")
                                .addClass("custom-combobox")
                                .insertAfter(this.element);
                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                    },
                    _createAutocomplete: function() {
                        var selected = this.element.children(":selected"),
                                value = selected.val() ? selected.text() : "";
                        this.input = $("<input>")
                                .appendTo(this.wrapper)
                                .val(value)
                                .attr("title", "")
                                .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                                .autocomplete({
                                    delay: 0,
                                    minLength: 0,
                                    source: $.proxy(this, "_source")
                                })
                                .tooltip({
                                    tooltipClass: "ui-state-highlight"
                                });
                        this._on(this.input, {
                            autocompleteselect: function(event, ui) {
                                ui.item.option.selected = true;
                                this._trigger("select", event, {
                                    item: ui.item.option
                                });
                            },
                            autocompletechange: "_removeIfInvalid"
                        });
                    },
                    _createShowAllButton: function() {
                        var input = this.input,
                                wasOpen = false;
                        $("<a>")
                                .attr("tabIndex", -1)
                                .attr("title", "Show All Items")
                                .tooltip()
                                .appendTo(this.wrapper)
                                .button({
                                    icons: {
                                        primary: "ui-icon-triangle-1-s"
                                    },
                                    text: false
                                })
                                .removeClass("ui-corner-all")
                                .addClass("custom-combobox-toggle ui-corner-right")
                                .mousedown(function() {
                                    wasOpen = input.autocomplete("widget").is(":visible");
                                })
                                .click(function() {
                                    input.focus();
        // Close if already visible
                                    if (wasOpen) {
                                        return;
                                    }
        // Pass empty string as value to search for, displaying all results
                                    input.autocomplete("search", "");
                                });
                    },
                    _source: function(request, response) {
                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                        response(this.element.children("option").map(function() {
                            
                            var text = $(this).text(),category = $(this).closest("optgroup").attr("label");
                            
                            if (this.value && (!request.term || matcher.test(text)))
                                return {
                                    label: text,
                                    value: text,
                                    option: this
                                };
                        }));
                    },
                    _removeIfInvalid: function(event, ui) {
        // Selected an item, nothing to do
                        if (ui.item) {
                            return;
                        }
        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                                valueLowerCase = value.toLowerCase(),
                                valid = false;
                        this.element.children("option").each(function() {
                            if ($(this).text().toLowerCase() === valueLowerCase) {
                                this.selected = valid = true;
                                return false;
                            }
                        });
        // Found a match, nothing to do
                        if (valid) {
                            return;
                        }
        // Remove invalid value
                        this.input
                                .val("")
                                .attr("title", value + " didn't match any item")
                                .tooltip("open");
                        this.element.val("");
                        this._delay(function() {
                            this.input.tooltip("close").attr("title", "");
                        }, 2500);
                        this.input.autocomplete("instance").term = "";
                    },
                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    }
                });
            })(jQuery);
            $(function() {
                $(".combobox").combobox();
                $('.ui-autocomplete-input').css('width','260px');
            });
            
            
            
        </script>
        <style>
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;   /* prevent horizontal scrollbar */
    overflow-x: hidden; /* add padding to account for vertical scrollbar */
    z-index:1000 !important;
}
        </style>
<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 11 oktober 2010, lastupdate 11 oktober 2010

include_once("include.php");
include_once("konversi.php");




if (($SAH[id_group]==9) or ($SAH[id_group]==1))
{

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
                echo "<option value=0>-- Pilih Datel --</option>\n";
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



if($id_siswa=="")$id_siswa=$id;


if($act=="update_acara_proses"){
//print_r($_POST);
$newdate = explode("/",$tanggal1);
$tanggal = $newdate[2]."-".$newdate[0]."-".$newdate[1];
$sql="update tb_acara_workshop set 
id_paket=$id_paket, 
tanggal='$tanggal1', 
tempat='$tempat1',
catatan='$catatan1',
waktu='$waktu1'
where id_siswa=$id_siswa and id_acara=$id_c";
//$sql="insert into acara values('$id_siswa','$id_acara','$id_gaya','$id_paket','$tanggal','$waktu','$tempat','$catatan','$SAH[id_user]','$REMOTE_ADDR',now(),'$SAH[id_user]','$REMOTE_ADDR',now())";
//echo $sql;
mysql_query($sql);
$act=null;
}

if($act=="add_acara_proses"){
//print_r($_POST);
$newdate = explode("/",$tanggal);
$tanggal = $newdate[2]."-".$newdate[0]."-".$newdate[1];
$sql="insert into tb_acara_workshop values('$id_siswa','$id_acara','$id_paket','$tanggal','$waktu','$tempat','$catatan','$SAH[id_user]','$REMOTE_ADDR',now(),'$SAH[id_user]','$REMOTE_ADDR',now())";//echo $sql;
mysql_query($sql);
$act=null;
}

if($act=="add_extra_proses"){
	$hd                = mysql_query("select harga_dasar from p_sublayanan where id_sublayanan='$kota'");
	$hrg_dsr           = mysql_result($hd,0,"harga_dasar");
	$harga             = ($hrg_dsr * $jml_layanan);
	$input_harga       = $harga-(($diskon/100)*$harga);
	$sql="insert into tb_pesanan_workshop(id_siswa,id_acara,id_sublayanan,jml_orang,harga,satuan) values('$id_siswa','$id_acara','$kota','$jml_layanan','$input_harga','$id_satuan')";
	
    //echo $sql;
	echo "Input Layanan Tambahan Sukses !!!!";
	mysql_query($sql);
	$act=null;
}

if($act=="add_noextra_proses"){
$harga_bebas1=$_POST[harga_bebas];
$jml_layanan1=$_POST[jml_layanan];
$total12=$harga_bebas1*$jml_layanan1;
    //echo $SAH[id_group];

    if ($harga_bebas<0 and $SAH[id_group]<>1) 
    {
    echo "Maaf Anda Tidak Berhak memberikan Diskon !!!!!!!!!";
    } else
	{$sql="insert into pesanan_bebas(id_siswa,id_acara,id_sublayanan,detail_layanan,jml_orang,harga,satuan) values('$id_siswa','$id_acara','$id_layanan','$layanan_bebas','$jml_layanan','$total12','$id_satuan')";
	echo "Input Pesanan Bebas Sukses!!!!";
	//echo $sql;
	mysql_query($sql);
	$act=null;
	}  
}

if($act=="add_paket_proses"){
	$hd=mysql_query("select tanggal,waktu,tempat from tb_acara_workshop where id_siswa='$id_siswa' and id_acara='$id_acara'");
	$tgl = mysql_result($hd,0,"tanggal");
	$waktu = mysql_result($hd,0,"waktu");
	$tempat= mysql_result($hd,0,"tempat");
	$sql="insert into tb_acara_workshop values('$id_siswa','$id_acara','$sel_paket','$tgl','$waktu','$tempat','-','$SAH[id_user]', '$REMOTE_ADDR', now(),null,null,null)";
	mysql_query($sql);//echo $sql;
	$sql="delete from tb_acara_workshop where id_siswa='$id_siswa' and id_acara='$id_acara' and id_paket='0'";
	mysql_query($sql);
	$act=null;
}



 $rc=mysql_query("select id_bebas from pesanan_bebas");
$ne=0;
 for($d=0;$d<@mysql_num_rows($rc);$d++){
	
	$id_bebas=mysql_result($rc,$d,"id_bebas");
	
 }

if($act=="del_extra"){
$n=mysql_query("select distinct a.id_sublayanan jml
from p_sublayanan a, tb_pesanan_workshop b 
where a.id_sublayanan=b.id_sublayanan and b.id_siswa='$id_siswa' and b.id_acara='$id_acara' 
and b.id_workshop='$id_workshop'");
$m=@mysql_result($n,0,"jml");//echo $m;
$sql_bebas1="delete from client_busana where id_siswa='$id_siswa' and id_acara='$id_acara' 
and id_workshop='$m'";
mysql_query($sql_bebas1);//echo $sql_bebas1;

$sql="delete from tb_pesanan_workshop where id_siswa ='$id_siswa' and id_acara='$id_acara' and id_workshop='$id_workshop'";
	mysql_query($sql);
	
$sql_bebas="delete from pesanan_bebas where id_siswa='$id_siswa' and id_acara='$id_acara' and id_bebas='$id_workshop'";
mysql_query($sql_bebas);


	$act=null;
}


if($act=="del_paket"){
	$n=mysql_query("select count(*) jml from tb_pesanan_workshop where id_siswa='$id_siswa' and id_acara='$idc' and id_paket=0");
	$m=@mysql_result($n,0,"jml");//echo $m;
	if($m>0)mysql_query("delete from tb_pesanan_workshop where id_siswa='$id_siswa' and id_acara='$idc' and id_paket=0");
	$sql="update tb_acara_workshop set id_paket=0 where id_siswa='$id_siswa' and id_acara='$idc' and id_paket='$id_paket'";//echo $sql;
	$d=mysql_query($sql);
	$act=null;
}

if($act=="del_acara"){
	$sql1="delete from tb_acara_workshop where id_siswa='$id_siswa' and id_acara='$id_acara'";
	mysql_query($sql1);
	$sql2="delete from tb_pesanan_workshop where id_siswa='$id_siswa' and id_acara='$id_acara'";
	mysql_query($sql2);
	$act=null;
}



?>


<div align=right><a href="<?="?menu=$menu&uid=$uid&page=view_workshop&id=$id_siswa"?>">Selesai</a></div>
<table cellpadding=5 cellspacing=0 border=0 width="850">
<tr>
	<td colspan=2 style='border:1px solid #000000'><b>Acara&nbsp;
	<a href="<?="?menu=$menu&uid=$uid&page=$page&act=add_acara&id_siswa=$id_siswa"?>"><img src='images/add.gif' height='16' width='16' border=0></a>
	&nbsp
	<a href="<?="?menu=$menu&uid=$uid&page=$page&act=update_acara&id_siswa=$id_siswa"?>"><img src='images/edit.gif' height='16' width='16' border=0></a>
	</td>
	<td style='border:1px solid #000000'><b>Tanggal</td>
	<td style='border:1px solid #000000'><b>Tempat</td>
	<td style='border:1px solid #000000'><b>Harga</td>
	<td style='border:1px solid #000000'><b>Acara</td>
	<td style='border:1px solid #000000'><b>Paket</td>
	<td style='border:1px solid #000000'><b>Extra</td>
</tr>
	<?php
	if($id_siswa=="")$id_siswa=$id;
	$sql="select distinct a.id_acara,b.acara,a.tanggal,a.tempat from tb_acara_workshop a, p_acara b where a.id_siswa='$id_siswa' and a.id_acara=b.id_acara";
	//echo $sql;
	$res=mysql_query($sql);
	for($a=0;$a<mysql_num_rows($res);$a++){
		$id_acara=mysql_result($res,$a,"id_acara");
		echo "<tr>";
		echo "<td colspan=2>";
		echo mysql_result($res,$a,"acara");
		echo "</td><td>&nbsp;";
		echo mysql_result($res,$a,"tanggal");
		echo "</td><td>&nbsp;";
		echo mysql_result($res,$a,"tempat");
		echo "&nbsp;</td><td>&nbsp;</td>";
echo "<td align=center>
		<a href=\"?menu=$menu&uid=$uid&page=$page&act=del_acara&id_siswa=$id_siswa&id_acara=$id_acara\"><img src='images/del.gif' border=0 title='Hapus Acara'></a>
		&nbsp
		<a href=\"?menu=$menu&uid=$uid&page=$page&act=update_acara&id_siswa=$id_siswa&id_c=$id_acara\"><img src='images/edit.gif' border=0 title='Hapus Acara'></a>
		</td>
		<td align=center>";
					echo " <a href=\"?menu=$menu&uid=$uid&page=$page&act=add_paket&id_siswa=$id_siswa&idc=$id_acara\"><img src='images/add.gif' width=16 height=16 border=0 title='Tambah Paket'></a>";			
		echo "<td align=center>";
			echo " <a href=\"?menu=$menu&uid=$uid&page=$page&act=add_extra&id_siswa=$id_siswa&idc=$id_acara\"><img src='images/add.gif' width=16 height=16 border=0 title='Tambah Extra'></a>";
		echo "</tr>";
		$sql="select a.id_paket,b.nama_paket,b.harga_paket from tb_acara_workshop a, paket b where a.id_acara='$id_acara' and a.id_siswa='$id_siswa' and a.id_paket=b.id_paket";
		$rs2=mysql_query($sql);
		for($b=0;$b<mysql_num_rows($rs2);$b++){
			$id_paket=mysql_result($rs2,$b,"id_paket");
			echo "<tr><td>&raquo;</td><td nowrap>";
			echo mysql_result($rs2,$b,"nama_paket");
			echo "</td><td colspan=2 align=right>&nbsp;</td><td align=right>Rp. ";
			echo number_format(mysql_result($rs2,$b,"harga_paket"),0);
			echo "</td><td>&nbsp;</td>";
			echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=del_paket&id_siswa=$id_siswa&idc=$id_acara&id_paket=$id_paket\"><img src='images/del.gif' border=0 title='Hapus Paket'></a></td></tr>";
		}
		$sql="select b.detail_layanan,a.jml_orang,a.harga,b.id_layanan,a.id_workshop,a.satuan,c.keterangan 
		from tb_pesanan_workshop a, p_sublayanan b, p_satuan c 
		where a.id_sublayanan=b.id_sublayanan 
		and a.id_siswa='$id_siswa' and id_acara='$id_acara' and a.satuan=c.id_satuan"; 
		//echo $sql;
		$rs3=mysql_query($sql);
		for($c=0;$c<mysql_num_rows($rs3);$c++){
			$id_workshop=mysql_result($rs3,$c,"id_workshop");
			
			echo "<tr><td>&raquo;</td><td>";
			echo mysql_result($rs3,$c,"detail_layanan");
			echo "</td><td colspan=2 align=right>&nbsp;</td><td align=right>Rp. ";
			echo number_format(mysql_result($rs3,$c,"harga"),0);
			echo "</td><td>&nbsp;</td><td>&nbsp;</td>";
			echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=del_extra&id_siswa=$id_siswa&id_acara=$id_acara&id_workshop=$id_workshop\"><img src='images/del.gif' border=0 title='Hapus Extra'></a></td></tr>";
		}	
		echo "<td colspan=2>&nbsp;";
		echo "</td><td>&nbsp;";
		//echo mysql_result($res,$a,"tanggal");
		echo "</td><td>&nbsp;";
		//echo mysql_result($res,$a,"tempat");
		echo "</td>";
		echo "<td>&nbsp;</td>";
	}
$sql="select sum(jumlah) total
from 
(
SELECT SUM( harga_paket ) jumlah
FROM tb_acara_workshop a, paket b
WHERE id_siswa ='$id_siswa'
AND a.id_paket = b.id_paket
union all
select sum(harga) jumlah from tb_pesanan_workshop where id_siswa='$id_siswa'
and id_acara in (select id_acara from tb_acara_workshop where id_siswa='$id_siswa')
union all
select sum(harga) jumlah from pesanan_bebas where id_siswa='$id_siswa'
and id_acara in (select id_acara from acara where id_siswa='$id_siswa')
) a";
$rt=mysql_query($sql);
$total=@mysql_result($rt,0,"total");
?>
<tr>
	<td colspan=4 style='border:1px solid #000000' align=right><b>Total</td>
	<td colspan=4 style='border:1px solid #000000' align=right><b><font style="font-size:larger;"><u>Rp. <?=number_format($total,0)?></td>
</tr>
<tr>
	<td colspan=8 style='border:1px solid #000000' align=center><b><?=katakan($total)?></td>
</tr>
</table>

	

<?
if($act=="add_extra"){
?>

   
<div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:24px;padding:10px;padding-left:0px;">
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_extra_proses&id_siswa=$id_siswa&id_acara=$idc"?>" name: "qa">
<table>
<tr><td>Pilih Group Layanan </td><td>:	<select name="propinsi" id="propinsi" > 
<option>--Pilih Grup Layanan--</option>
<?php
$propinsi = mysql_query("SELECT * FROM p_layanan ORDER BY layanan asc");
while($p=mysql_fetch_array($propinsi)){
echo "<option value=\"$p[id_layanan]\">$p[layanan]</option>\n";
}?>
</select>
<select name="kota" id="kota" >
     <option>--Pilih Sublayanan--</option>
     <?php
$kota = mysql_query("SELECT * FROM p_sublayanan where (tgl_habis is null or tgl_habis='0000-00-00')
ORDER BY detail_layanan asc");
while($p=mysql_fetch_array($propinsi)){
echo "<option value=\"$p[id_sublayanan]\">$p[detail_layanan]</option>\n";
}
?>
   </select>
</td></tr>
<tr><td>Jumlah Layanan </td><td>:&nbsp<input type="text" name="jml_layanan" ></td></tr>
<tr><td>Pilih Satuan :</td><td>:	<?
			$sqlsatuan=" select id_satuan,keterangan from p_satuan union select 0,'--Pilih Satuan --' from dual";
			generate_select("id_satuan",$sqlsatuan,$id_satuan);
			?></td></tr>
<tr><td><input type="submit" value="Add">
<? echo "<a href=\"?menu=$menu&uid=$uid&page=$page&act=add_noextra&id_siswa=$id_siswa&idc=$idc\">[Tidak Ada Pilihan Layanan]</a>";?></td></tr>
</table>
	</form>
	<?
}


if($act=="add_noextra"){
	?>

   
<div style="font-family:Arial;font-size:12px;padding:3px ">
<div style="font-size:24px;padding:10px;padding-left:0px;">
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_noextra_proses&id_siswa=$id_siswa&id_acara=$idc"?>" name: "qa">

<table>
<tr><td>Pilih Group Layanan </td><td>:	<?
			$sqllayanan=" select distinct id_layanan,layanan from p_layanan union select 0,'--Pilih Group Layanan --' from dual";
			generate_select("id_layanan",$sqllayanan,$id_layanan);
			?></td></tr>
<tr><td>Input Layanan Bebas </td><td>:&nbsp;<input type="text" name="layanan_bebas" size="60" ></td></tr>
<tr><td>Harga Satuan </td><td>:&nbsp;<input type="text" name="harga_bebas" ></td></tr>
<tr><td>Jumlah Layanan </td><td>:&nbsp;<input type="text" name="jml_layanan" ></td></tr>
<tr><td>Pilih Satuan :</td><td>:	<?
			$sqlsatuan=" select id_satuan,keterangan from p_satuan union select 0,'--Pilih Satuan --' from dual";
			generate_select("id_satuan",$sqlsatuan,$id_satuan);
			?></td></tr>
<tr><td><input type="submit" value="simpan" name="tombol"></td></tr>
</table>

	</form>
	<?
}


if($act=="add_paket"){
	?>
    <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:24px;padding:10px;padding-left:0px;">
	<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_paket_proses&id_siswa=$id_siswa&id_acara=$idc"?>">
		<center>
<table width="564" height="105" border="0">
  <tr>
    <td width="115"><strong>Tambah Paket</strong></td>
    <td width="10">:</td>
     <td style="width: 300px"><SELECT NAME="sel_paket">
				<OPTION selected label="none" value="none">None</OPTION>
				<?
				$sql="select id_paket,nama_paket from paket where id_paket not in (select id_paket from tb_acara_workshop where id_acara='$idc' and id_siswa='$id_siswa')";
				$r=mysql_query($sql);
				for($b=0;$b<mysql_num_rows($r);$b++){
				$sa=mysql_result($r,$b,"id_paket");
				$sb=mysql_result($r,$b,"nama_paket");
					echo "<option value=\"$sa\">$sb</option>";
				}
				?>
	</SELECT><?//=$sql?></td>
  </tr>
  <tr>
    <td><strong>Adat</strong></td>
    <td>:</td>
     <td style="width: 300px"><SELECT NAME="sel_gaya">
				<?
				$sql="select id_gaya,gaya from p_gaya ";
				$r=mysql_query($sql);
				for($b=0;$b<mysql_num_rows($r);$b++){
				$sa=mysql_result($r,$b,"id_gaya");
				$sb=mysql_result($r,$b,"gaya");
					echo "<option value=\"$sa\">$sb</option>";
				}
				?>
			</SELECT><?//=$sql?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width: 300px"><INPUT TYPE="submit" SRC="images/add.gif" BORDER="0" ALT="Tambah Layanan" name="gambar" style="border-color:#FFFFFF;" value="Add"></td>
  </tr>
 
</table>
</center>
	</form>
	<?php
}

if($act=="add_acara"){
?>
<?php
		$vrb_acara = "id_acara";
		$vlu_acara = $$vrb_acara;
		$vrb_paket = "id_paket";
		$vlu_paket = $$vrb_paket;
		$vrb_tanggal = "tanggal";
		$vlu_tanggal = $$vrb_tanggal;
		$vrb_waktu = "waktu";
		$vlu_waktu = $$vrb_waktu;
		$vrb_tempat = "tempat";
		$vlu_tempat = $$vrb_tempat;
		$vlu_tempat = ucwords($vlu_tempat);
		$vrb_catatan = "catatan";
		$vlu_catatan = $$vrb_catatan;
		$vlu_catatan = ucwords($vlu_catatan);

		unset($selectacara);
		$selectacara = "<option value=''>-- Pilih Acara --</option>\n"; 
		$runSQL2 = "select id_acara, acara from p_acara where id_acara not in (select distinct id_acara from tb_acara_workshop where id_siswa='$id_siswa')";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$selectacara .= "<option value='".$row2[id_acara]."'>$row2[acara]</option>\n"; 
		};//while
		$selectacara = "<select size=1 name='$vrb_acara' class='edyellow combobox'> $selectacara </select>";
		
		unset($selectgaya);
		$selectgaya = "<option value=''>-- Pilih Gaya --</option>\n"; 
		$runSQL2 = "select id_gaya, gaya from p_gaya where (tgl_habis is null or tgl_habis='0000-00-00') order by gaya asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$selectgaya .= "<option value='".$row2[id_gaya]."'>$row2[gaya]</option>\n"; 
		};//while
		$selectgaya = "<select size=1 name='$vrb_gaya' class='edyellow combobox'> $selectgaya </select>";

		unset($selectgaya1);
		$selectgaya1 = "<option value=''>-- Pilih Model Sanggul --</option>\n"; 
		$runSQL2 = "select id_sanggul, model_sanggul from p_model_sanggul order by id_sanggul asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$selectgaya1 .= "<option value='".$row2[id_sanggul]."'>$row2[model_sanggul]</option>\n"; 
		};//while
		$selectgaya1 = "<select size=1 name='$vrb_model' class='edyellow combobox'> $selectgaya1 </select>";
		
                unset($ii,$selectpaket);
		$selectpaket = "<option value=''>-- Pilih Paket --</option>\n"; 
		$runSQL2 = "select id_paket, nama_paket, harga_paket from paket where tgl_expire > SYSDATE( ) order by nama_paket asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$ii++;
			if ($row2[harga_paket] > 0){ $infoharga=" - Rp.".number_format($row2[harga_paket],0); }else{ unset($infoharga); }
			$selectpaket .= "<option value='".$row2[id_paket]."' > $row2[nama_paket]$infoharga</option>\n"; 
		};//while
		$selectpaket = "<select size=1 name='$vrb_paket' class='edyellow combobox'> $selectpaket </select>";

		$ccc++;
		if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$htmlData .= "
			<tr bgcolor='$color'>
				<td>
				 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
					<tr>
					 <td> Acara </td><td> : </td><td> $selectacara
					 </td>
					</tr>
					<tr>
					 <td> Tanggal </td><td> : </td><td> <input type='text' name='$vrb_tanggal' size='11' value='$vlu_tanggal'>
					 <script language='JavaScript'> new tcal ({'formname': 'form','controlname': '$vrb_tanggal'}); </script>
					 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <input type='text' name='$vrb_waktu' size='10' value=\"".htmlentities(stripslashes($vlu_waktu))."\">
					 </td>
					</tr>
                                        <tr>
					 <td> Ket </td><td> : </td><td><input type='text' name='$vrb_catatan' size='35' value='$vlu_catatan'>
					 </td>
					</tr>
					<tr>
					 <td> Paket </td><td> : </td><td> $selectpaket </td>
					</tr>
					<tr>
					 <td> Lokasi </td><td> : </td><td> <input type='text' name='$vrb_tempat' size='70' value=\"".htmlentities(stripslashes($vlu_tempat))."\"></td>
					</tr>
				 </table>
				</td>
			</tr>
		";//htmlData
//	};//end-while
?>

   <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_acara_proses&id_siswa=$id_siswa";?>">
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td colspan="2" valign="top" align="center">
		 <script language="JavaScript" src="calendar_us.js"></script>
			 <table width='600' cellspacing='1' cellpadding='3'>
			  <?=$htmlData;?>
				<tr>
					<td width="100%" colspan="2" align="center">
					 <input type="hidden" name="id" value="<?=$id;?>"><br>
					 <input type="submit" value="Simpan" name="run" class="button">
					 <span style="width: 300px">
					 <?//=$sql?>
				    </span></td>
				</tr>
			 </table>
		 </td>
		</tr>
	 </table>
   </form>
<?php
}

if($act=="update_acara"){
?>
<?php
		$vrb_acara = "id_acara";
		$vlu_acara = $$vrb_acara;
		$vlu_gaya = $$vrb_gaya;
		$vrb_paket = "id_paket";
		$vlu_paket = $$vrb_paket;
		$vrb_tanggal = "tanggal";
		$vlu_tanggal = $$vrb_tanggal;
		$vrb_waktu = "waktu";
		$vlu_waktu = $$vrb_waktu;
		$vrb_tempat = "tempat";
		$vlu_tempat = $$vrb_tempat;
		$vlu_tempat = ucwords($vlu_tempat);
		$vrb_catatan = "catatan";
		$vlu_catatan = $$vrb_catatan;
		$vlu_catatan = ucwords($vlu_catatan);

		
		$sql="select distinct a.id_acara,b.acara,a.tanggal,a.tempat,
                a.catatan,a.waktu,a.id_gaya,a.id_paket,a.id_sanggul 
                from tb_acara_workshop a, p_acara b where a.id_siswa=$id_siswa 
                and a.id_acara=$id_c 
		and a.id_acara=b.id_acara";

		//echo $sql;
		$res=mysql_query($sql);
		for($a=0;$a<mysql_num_rows($res);$a++){
		$id_acar=mysql_result($res,$a,"id_acara");
		$acara=mysql_result($res,$a,"acara");
		$vlu_tanggal=mysql_result($res,$a,"tanggal");
		$vlu_tempat=mysql_result($res,$a,"tempat");
		$vlu_catatan=mysql_result($res,$a,"catatan");
		$vlu_waktu=mysql_result($res,$a,"waktu");
		$id_paket=mysql_result($res,$a,"id_paket");}
		
		$sqlgaya = "select id_gaya, gaya from p_gaya where (tgl_habis is null or tgl_habis='0000-00-00') order by gaya asc";
		$sqlpaket = "select id_paket, concat_ws('-',nama_paket,harga_paket) paket from paket order by id_paket asc";
                $sqlsanggul = "select id_sanggul, model_sanggul from p_model_sanggul order by id_sanggul asc";
		
                $ccc++;
		if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$htmlData .= "
			<tr bgcolor='$color'>
				<td>
				 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
					<tr>
					 <td> Acara </td><td> : </td><td> $acara
					 </td>
					</tr>
					<tr>
					 <td> Tanggal </td><td> : </td><td> <input type='text' name='$vrb_tanggal' size='11' value='$vlu_tanggal'>
					 <script language='JavaScript'> new tcal ({'formname': 'form','controlname': '$vrb_tanggal'}); </script>
					 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <input type='text' name='$vrb_waktu' size='10' value=\"".htmlentities(stripslashes($vlu_waktu))."\">
					 </td>
					</tr>
                                       <tr>
					 <td> Ket </td><td> : </td><td><input type='text' name='$vrb_catatan' size='35' value='$vlu_catatan'>
					 </td>
					</tr>	
					<tr>
					 <td> Paket </td><td> : </td><td> $selectpaket </td>
					</tr>
					<tr>
					 <td> Lokasi </td><td> : </td><td> <input type='text' name='$vrb_tempat' size='70' value=\"".htmlentities(stripslashes($vlu_tempat))."\"></td>
					</tr>
				 </table>
				</td>
			</tr>
		";//htmlData
//	};//end-while
?>

<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page&act=update_acara_proses&id_siswa=$id_siswa&id_c=$id_c";?>">
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td colspan="2" valign="top" align="center">
		 <script language="JavaScript" src="calendar_us.js"></script>
			 <table width='600' cellspacing='1' cellpadding='3'>
			<tr bgcolor=<?=$color;?>>
				<td>
				 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
					<tr>
					 <td> Acara </td><td> : </td><td><?=$acara;?></td>
					</tr>
					<tr>
					 <td> Tanggal </td><td> : </td><td> <input type='text' name='tanggal1' size='11' value=<?=$vlu_tanggal;?>>
					 <script language='JavaScript'> new tcal ({'formname': 'form','controlname':'$vrb_tanggal'}); </script>
					 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <input type='text' name='waktu1' size='10' value=<?=$vlu_waktu;?>>
					 </td>
					</tr>
                    <tr>
					 <td> Keterangan </td><td> : </td><td><input type='text' name='catatan1' size='35' value='<?=$vlu_catatan;?>'>
					 </td>
					</tr>
					<tr>
					 <td> Paket </td><td> : </td><td> <?=generate_select("id_paket",$sqlpaket,$id_paket);?></td>
					</tr>
					<tr>
<?php
echo "<td> Lokasi </td><td> : </td><td>";
echo "<input type='text' name='tempat1' size='70' value='$vlu_tempat'></td>";
?>
					</tr>
				 </table>
				</td>
			</tr>				<tr>
					<td width="100%" colspan="2" align="center">
					 <input type="hidden" name="id" value="<?=$id;?>"><br>
					 <input type="submit" value="Simpan" name="run" class="button">
					</td>
				</tr>
			 </table>
		 </td>
		</tr>
	 </table>
   </form>
<?php
}
}else{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>