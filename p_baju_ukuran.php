
<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// ARIESTA ADITYA TIMUR

include_once("include.php");

function js_submit()
{
        echo "<script language=javascript>\n";
        echo "function submit_form() {\n";
        echo "  document.forms[0].submit();\n";
        echo "}\n";
        echo "</script>\n";

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


if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_layanan, id_tipe_baju, tipe_ukuran_baju,jumlah,id_ukuran_baju from p_ukuran_baju where id_ukuran_baju='$id'";
        #echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		
		$id_layanan = $row[id_layanan];
		$id_tipe_baju = $row[id_tipe_baju];
		$id_ukuran_baju = $row[tipe_ukuran_baju];
		$jumlah = $row[jumlah];
        $id=$row[id_ukuran_baju];   
	};//if
};//if-id

if (strlen($run) > 1){ 

	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_ukuran_baju (id_layanan,id_tipe_baju,tipe_ukuran_baju,jumlah) VALUES ('$id_layanan','$id_tipe_baju','$id_ukuran_baju','$jumlah')";
		#echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_ukuran_baju set id_tipe_baju='$id_tipe_baju',tipe_ukuran_baju='$id_ukuran_baju',jumlah='$jumlah' where id_ukuran_baju='$id'";
		#echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
   # pre($daerah);
?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Baju</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
             <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=p_baju_ukuran";?>"><b>Tambah Ukuran baju</b></a>
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=p_baju_detail";?>"><b>List Baju</b></a>
              <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=p_list_ukuran_baju";?>"><b>List Ukuran baju</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
              
        <tr>
            <td width="35%" align="right">Kategori</td>
            <td width="65%"><select name="id_tipe_baju">
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
                <font color="#FF0000"><b>*</b></font> <?=$iid_tipe_baju;?></td>
        </tr>
	<tr>
			<td width="35%" align="right">Baju</td>
            <td width="65%"><?
$sqlpetugas="select distinct id_layanan, layanan from p_baju
union select 0,'--Pilih Baju--' from dual";
generate_select("id_layanan",$sqlpetugas,$id_layanan); 
?><font color="#FF0000"><b>*</b></font> <?=$ilayanan;?></td>
        </tr>
        
        <tr>
			<td width="35%" align="right">Tipe Ukuran Baju</td>
            <td width="65%"><?
$sqlp="select distinct id_ukuran_baju, nama_ukuran_baju from p_jenis_ukuran_baju
			 union select 0,'--Pilih Ukuran Baju--' from dual";
			generate_select("id_ukuran_baju",$sqlp,$id_ukuran_baju);

?></td>
        </tr>
	<tr>
			<td width="35%" align="right">Jumlah</td>
            <td width="65%"><input type="text" name="jumlah" value="<?=$jumlah;?>" size="30"> <font color="#FF0000"><b>*</b></font></td>
        </tr>
		
<tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%">
            <input type="hidden" name="id" value="<?=$id;?>"><br>
			<input type="submit" value="Simpan" name="run" class="button">
      </td>
		</tr>
		<tr>
			<td width="100%" colspan="2" align="left">
			Keterangan : <br>
      - Pastikan anda telah memasukan data isian dengan lengkap dan benar!<br>
			- Tanda <font color="#FF0000"><b>*</b></font> wajib diisi tidak boleh kosong.
		  </td>
		</tr>
	 </table>

   </td>
  </tr>
  </form>
</table>
<?php

} else {
//registerInvalid

	$runSQL = "select id_layanan, id_tipe_baju, tipe_ukuran_baju, jumlah, id_ukuran_baju from p_ukuran_baju where id_ukuran_baju='$id' ";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id = $row[id_ukuran_baju];
		$id_layanan = $row[id_layanan];
		$id_tipe_baju = $row[id_tipe_baju];
		$id_ukuran_baju = $row[tipe_ukuran_baju];
		$jumlah = $row[jumlah];
		
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Baju</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		
        <tr valign=top>
            <td width="35%" align="right">Kategori : </td>
            <td width="65%"><font class="datafield"><?=$id_tipe_baju?></font></td>
        </tr>
        <tr valign=top>
            <td width="35%" align="right">Baju : </td>
            <td width="65%"><font class="datafield"><?=$id_layanan?></font></td>
        </tr>
		<tr valign=top>
            <td width="35%" align="right">Tipe Ukuran Baju : </td>
            <td width="65%"><font class="datafield"><?=$id_ukuran_baju?></font></td>
        </tr>
		
        <tr valign=top>
            <td width="35%" align="right">jumlah : </td>
            <td width="65%"><font class="datafield"><?=$jumlah?></font></td>
        </tr>
		 
	 </table>

		 <div align="right">
		 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="220" align="right">
		 <font size='1'><?=$inforecord;?></font>
		 </div>

		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=p_baju_ukuran";?>"><b>Input Ukuran Baju Lagi</b></a>
   </td>
  </tr>
  </form>
</table>
<?php };//registerInvalid ?>