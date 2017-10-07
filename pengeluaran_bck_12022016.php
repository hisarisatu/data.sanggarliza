<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<?php
//Last update : 10/30/2010
// by agusari@gmail.com

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

?>

 <script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

<?
// lastupdate 10/30/2010 by agusari@gmail.com


/*
if (!$tanggal) 
{
	$sqltgl="SELECT date_format( curdate( ) , '%Y-%m-%1' ) tgl";
	$result_tgl = mysql_query($sqltgl);
	while ($row = mysql_fetch_array ($result_tgl))
	{$tanggal = $row['tgl'];}
}
if (!$tanggal2) 
{
	$sqltgl2="SELECT date_format( curdate( )+1 , '%Y-%m-%d' ) tgl2";
	$result_tgl2 = mysql_query($sqltgl2);
	while ($row = mysql_fetch_array ($result_tgl2))
	{$tanggal2 = $row['tgl2'];}
}
*/
if($act=="input_penerima"){
	if($id!=""){
		$sql = " update p_penerima set penerima='$penerima' ";
	} else {
		$sql = " insert into p_penerima values(null,'$penerima')";
	}
	mysql_query($sql);
	$act="list_penerima";
}


if($act=="input_jenis_proses"){
	if($id!=""){
		$sql = " update p_pengeluaran set keterangan='$jenis_pengeluaran' ";
	} else {
		$sql = " insert into p_pengeluaran values(null,'$jenis_pengeluaran')";
	}
	mysql_query($sql);
	$act="list_jenis";
}


if($act=="delete"){
	$sql="delete from pengeluaran where id_pengeluaran='$id'";
	mysql_query($sql);
	$act=null;
}

if($act=="delete_jenis"){
	$sql="delete from p_pengeluaran where id_jenis_pengeluaran='$id'";
	mysql_query($sql);
	$act=null;
}
if($act=="delete_penerima"){
	$sql="delete from p_penerima where id_penerima='$id'";
	mysql_query($sql);
	$act=null;
}

?>
<br>
<hr size="1" color="#4B4B4B">
<br>
<form method=post action="?menu=<?=$menu?>&uid=<?=$uid?>&page=pengeluaran&act=input_pengeluaran">
<table>
<tr>
	<td><b>Periode Waktu</b></td>
	<td><b>:</b></td> 
	<td>   
		<input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
		<input type="submit" name="run" value="Re-List Client" class="button">
	</td>
</tr>
</form>
 <script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
    });
	 //]]></script>
</td></tr>
<tr>
	<td><b>Tanggal Pengeluaran</b></td>
	<td><b>:</b></td> 
	<td>
	<input type='text' name='tanggal3' id="tanggal3" size='11' value='<?=$tanggal3?>'>
	 <script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
	    $('#tanggal3').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true });
    });
	 //]]></script>
	</td>
</tr>
<tr>
	<td><b>Nama Client</b></td>
	<td><b>:</b></td> 
	<td>
	<?
		js_submit();
		$sqlclient="select distinct a.id_client,concat( `nama_cpw` , '/', `nama_cpp` ) namacp from client a,acara b 
		where a.id_client=b.id_client and tanggal BETWEEN '$tanggal' AND '$tanggal2'
		union select '0','--Biaya Non Client--' from dual";
		generate_select("id_client",$sqlclient,$id_client); 
	?>
	</td>
</tr>
<tr>
	<td><b>Jenis Pengeluaran</b></td>
	<td><b>:</b></td> 
	<td>
	<?
		js_submit();
		$sqljnskeluar="select distinct id_jenis_pengeluaran,keterangan from p_pengeluaran
		union select '0','--Pilih Jenis Pengeluaran--' from dual";
		generate_select("id_jenis_pengeluaran",$sqljnskeluar,$id_jenis_pengeluaran); 
	?>
	<a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis"><img src="images/add.gif" border=0 width=16 height=16> Add Jns Pengeluaran</a>
	</td>
</tr>
<tr>
	<td><b>Detail Pengeluaran</b></td>
	<td><b>:</b></td> 
	<td>
	<textarea name="detail" rows="3" cols="30"><?=$detail;?></textarea>
	</td>
</tr>
<tr>
	<td><b>Jumlah Pengeluaran</b></td>
	<td><b>:</b></td> 
	<td><input type="text" name="jumlah" value=<?=$jumlah;?>></td>
</tr>
<tr>
	<td><b>Penerima</b></td>
	<td><b>:</b></td> 
	<td>
	<?
		$sqlclient=" 
		select distinct id_penerima,penerima from
		(select distinct id_penerima,penerima from p_penerima 
		union select '0','--Pilih Penerima--' from dual) a order by penerima";
		generate_select("id_penerima",$sqlclient,$id_penerima); 	    
	?>
	</td>
</tr>
<tr>
	<td colspan=2 align=center><input type="submit" name="inputdata" value="Input">&nbsp;<input type="reset"></td>
</tr>
</form>
</table>
<br>
<hr size="1" color="#4B4B4B">
<br>

<?
if($act=="input_jenis"){
$act=null;
?>
<form method=post action="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>">
<?
if($id!=""){
	$rs=mysql_query("select keterangan from p_pengeluaran where id_jenis_pengeluaran='$id'");
	$ket=mysql_result($rs,0,"keterangan");
	echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
}else{
	$ket="";
}
?>
<input type="hidden" name="act" value="input_jenis_proses">
<table>
	<tr>
		<td>Jenis Pengeluaran</td>
		<td><input type="text" name="jenis_pengeluaran" value="<?=$ket?>"></td>
		<td><input type="submit" value="input"><input type="reset" value="reset"></td>
	</tr>
	</table>	
</form>
<?
}

if($act=="add_penerima"){
$act=null;
?>
<form method=post action="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>">
<?
if($id!=""){
	$rs=mysql_query("select penerima from p_penerima where id_penerima='$id'");
	$ket=mysql_result($rs,0,"penerima");
	echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
}else{
	$ket="";
}
?>
<input type="hidden" name="act" value="input_penerima">
<table>
	<tr>
		<td>Penerima</td>
		<td><input type="text" name="penerima" value="<?=$ket?>"></td>
		<td><input type="submit" value="input"><input type="reset" value="reset"></td>
	</tr>
	</table>	
</form>
<?
}

if($inputdata)
{
		if($id_jenis_pengeluaran!="")
		{    
		$sql="insert into pengeluaran 
		values(null,'$tanggal3','$id_acara','$id_client','$id_jenis_pengeluaran','$id_penerima','$detail','$jumlah')";
		}
	
	//echo $sql;
    mysql_query($sql);
     echo "--------Proses Input Pengeluaran Sukses !!!!!!!!!!!---------";
	 echo "<br>";
    //$act='list_pengeluaran';
}

?>


<? 


if($act=="list_jenis"){
	$id=null;$act=null;
?>
<table width='600' cellspacing='1' cellpadding='3'>
<tr align=center bgcolor='#A7A7A7' height='25'>
	<td colspan=15 align=right><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis"><img src="images/add.gif" border=0 width=16 height=16> Jenis</a> <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>"><img src="images/list.gif" border=0 width=16 height=16>Pengeluaran</a></td>
</tr>
<tr align=center>
	<td><b>No</td>
	<td><b>Jenis</td>
	<td><b>Edit</td>
</tr>
<?
$sql="select * from p_pengeluaran";
$result=mysql_query($sql);
for($a=0;$a<@mysql_num_rows($result);$a++){
	$id=mysql_result($result,$a,"id_jenis_pengeluaran");
	$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";?>
	<td><?=mysql_result($result,$a,"keterangan")?></td>
	<td align=center><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis&id=<?=$id?>"><img src="images/edit.gif" border=0></a> | <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=delete_jenis&id=<?=$id?>"><img src="images/del.gif" border=0></a></td>
</tr>
<? } ?>
</table>
<?
}
if($act=="list_pengeluaran"){
	$id=null;$act=null;
?>
<table width='600' cellspacing='1' cellpadding='3'>
<tr align=center bgcolor='#A7A7A7' height='25'>
	<td colspan=15 align=right><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis"><img src="images/add.gif" border=0 width=16 height=16> Jenis</a> <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>"><img src="images/list.gif" border=0 width=16 height=16>Pengeluaran</a></td>
</tr>
<tr align=center>
	<td><b>No</td>
	<td><b>Jenis</td>
	<td><b>Edit</td>
</tr>
<?
$sql="select * from pengeluaran where tanggal='$tanggal3'";
$result=mysql_query($sql);
for($a=0;$a<@mysql_num_rows($result);$a++){
	$id=mysql_result($result,$a,"id_jenis_pengeluaran");
	$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";?>
	<td><?=mysql_result($result,$a,"keterangan")?></td>
	<td align=center><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis&id=<?=$id?>"><img src="images/edit.gif" border=0></a> | <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=delete_jenis&id=<?=$id?>"><img src="images/del.gif" border=0></a></td>
</tr>
<? } ?>
</table>
<?
}
if($act=="list_penerima"){
	$id=null;$act=null;
?>
<table width='600' cellspacing='1' cellpadding='3'>
<tr align=center bgcolor='#A7A7A7' height='25'>
	<td colspan=15 align=right><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis"><img src="images/add.gif" border=0 width=16 height=16> Jenis</a> <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>"><img src="images/list.gif" border=0 width=16 height=16>Pengeluaran</a></td>
</tr>
<tr align=center>
	<td><b>No</td>
	<td><b>Jenis</td>
	<td><b>Edit</td>
</tr>
<?
$sql="select * from p_penerima";
$result=mysql_query($sql);
for($a=0;$a<@mysql_num_rows($result);$a++){
	$id=mysql_result($result,$a,"id_penerima");
	$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";?>
	<td><?=mysql_result($result,$a,"penerima")?></td>
	<td align=center><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_penerima&id=<?=$id?>"><img src="images/edit.gif" border=0></a> | <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=delete_penerima&id=<?=$id?>"><img src="images/del.gif" border=0></a></td>
</tr>
<? } ?>
</table>
<?
}
?>
