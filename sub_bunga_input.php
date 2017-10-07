<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="./src/js/jquery.js"></script>



<? 

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

// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com; 0542-8012977
// 09 Oktober 2010, lastupdate 09 Oktober 2010

include_once("include.php");
if($id=="")$id=0;

//echo $act;//developer

if($act=="add"){
$sql="insert into bunga_sub_paket (id_paket,id_bunga) values('$id','$id_bunga')";
mysql_query($sql);
$act=null;}
if($act=="delete"){
$sql="delete from bunga_sub_paket where id_paket='$id' and id_bunga='$id_sub'";
mysql_query($sql);
$act=null;
}
?>
<link rel="stylesheet" href="images/style.css" type="text/css">
<FORM METHOD=POST>
<table>
<tr><td>Pilih Bunga </td><td>:	
  	<?
			$sqlpetugas="select distinct id_bunga,detail_layanan from bunga_detail
			where (tgl_habis is null or tgl_habis='0000-00-00') union select 0,'--Pilih Bunga--' from dual";
			generate_select("id_bunga",$sqlpetugas,$id_bunga);
?>
<td>
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="act" value="add">
<INPUT TYPE="image" SRC="images/add.gif" HEIGHT="17" WIDTH="17" BORDER="0" ALT="Tambah Layanan" name="gambar" style="border-color:#FFFFFF;"> 
</td></tr></table>
</FORM>
<? 
$sql = "select b.id_bunga,b.detail_layanan from bunga_sub_paket a, bunga_detail b where a.id_bunga=b.id_bunga and a.id_paket='$id'";
$rs=mysql_query($sql);
echo "<table>";
for($a=0;$a<mysql_num_rows($rs);$a++){
$idsub=mysql_result($rs,$a,"id_bunga");
echo "
<tr>
 <td>&raquo;&nbsp;".mysql_result($rs,$a,"detail_layanan")."</td>
 
 <td><a href=\"?id=$id&id_sub=$idsub&act=delete\"><img src='images/delete.jpg' height=17 width=17 border=0></a></td>
</tr>";
}
echo "</table>";
?>