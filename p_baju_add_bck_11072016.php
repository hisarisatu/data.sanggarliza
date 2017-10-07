  <link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
<script src="./src/js/ui.datepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

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
	$runSQL = "select id_layanan, id_tipe_baju, layanan,warna, daerah, gambar, harga,tanggal from p_baju where id_layanan='$id'";
        #echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_layanan = $row[id_layanan];
		$id_tipe_baju = $row[id_tipe_baju];
		$layanan = $row[layanan];
	$tanggal=$row[tanggal];
	$tmp_tanggal = explode("-",$tanggal);
        $new_tanggal = $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0]; 
	
                $daerah = $row[daerah];
				$id_warna = $row[warna];
				$gambar = $row[gambar];
				$harga= $row[harga];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$layanan = ucwords($layanan);
	$fileName = $_FILES['gambar']['name'];
		$tmp_tanggal = explode("/",$tanggal);
        $new_tanggal = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1]; 
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		    $hehe=$_POST['id_tipe_baju'];
		    $jenis = $_POST['level'];
			$query = "SELECT max(kode) as maxID FROM p_baju WHERE kode LIKE '$jenis%'";
			$hasil = mysql_query($query);
			$data  = mysql_fetch_array($hasil);
			$idMax = $data['maxID'];
			$noUrut = (int) substr($idMax, 4, 4);
			$noUrut++;
			$newID = $jenis . sprintf("%04s", $noUrut);
			
		$runSQL = "insert into p_baju(id_tipe_baju,layanan,daerah,warna,gambar,harga,kode,tanggal) VALUES ('$id_tipe_baju','$layanan','$daerah', '$id_warna','$fileName','$harga','$newID','$new_tanggal')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
		move_uploaded_file($_FILES['gambar']['tmp_name'], "gambar/".$_FILES['gambar']['name']);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_baju set id_tipe_baju='$id_tipe_baju',layanan='$layanan',daerah='$daerah', warna='$id_warna', gambar='$fileName', harga='$harga', tanggal='$new_tanggal'  where id_layanan='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
		move_uploaded_file($_FILES['gambar']['tmp_name'], "gambar/".$_FILES['gambar']['name']);
		
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
   # pre($daerah);
?>
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script>
     $(document).ready(function(){
        $('#daerah').val('<?=$daerah?>'); 
		
      
     });   
</script>
  <script language="JavaScript" src="calendar_us.js"></script>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>" enctype="multipart/form-data">
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

<tr>
			<td width="35%" align="right">Kode</td>
			<td><select name="level" style="margin:0px;"><option value="BPT"<?php if($level=='BPT'){echo ' selected';};?>>BESKAP PAYET (BPT)</option><option value="BBR"<?php if($level=='BBR'){echo ' selected';};?>>BESKAP BORDIR(BBR)</option><option value="KRS"<?php if($level=='KRS'){echo ' selected';};?>>KEBAYA CPW READY STOCK (KRS)</option><option value="KEX"<?php if($level=='KEX'){echo ' selected';};?>>KEBAYA CPW EXLUSIVE A (KEX)</option><option value="BCP"<?php if($level=='BCP'){echo ' selected';};?>>BESKAP CPP (BCP)</option><option value="DMT"<?php if($level=='DMT'){echo ' selected';};?>>DODOT MANTEN (DMT)</option><option value="DSN"<?php if($level=='DSN'){echo ' selected';};?>>DODOT SIRAMAN (DSN)</option><option value="RMI"<?php if($level=='RMI'){echo ' selected';};?>>ROMPI (RMI)</option><option value="BSN"<?php if($level=='BSN'){echo ' selected';};?>>BESKAP SORJAN (BSN)</option><option value="BLG"<?php if($level=='BLG'){echo ' selected';};?>>BESKAP LANDUNG (BLG)</option><option value="BOU"<?php if($level=='BOU'){echo ' selected';};?>>BLANGKON ORTU (BOU)</option><option value="BLN"<?php if($level=='BLN'){echo ' selected';};?>>BLANGKON (BLN)</option><option value="KPH"<?php if($level=='KPH'){echo ' selected';};?>>KOPIAH (KPH)</option><option value="KOU"<?php if($level=='KOU'){echo ' selected';};?>>KAIN ORTU (KOU)</option><option value="KIN"<?php if($level=='KIN'){echo ' selected';};?>>KAIN (KIN)</option><option value="SNT"<?php if($level=='SNT'){echo ' selected';};?>>SONGKET (SNT)</option><option value="BAK"<?php if($level=='BAK'){echo ' selected';};?>>BESKAP ANAK (BAK)</option><option value="CPO"<?php if($level=='CPO'){echo ' selected';};?>>CELANA PANJANAG ORANG TUA (CPO)</option><option value="ROK"<?php if($level=='ROK'){echo ' selected';};?>>ROK (ROK)</option><option value="CNE"<?php if($level=='CNE'){echo ' selected';};?>>CINDE (CNE)</option><option value="EFK"<?php if($level=='EFK'){echo ' selected';};?>>EFEK (EFK)</option><option value="BRO"<?php if($level=='BRO'){echo ' selected';};?>>BORO (BRO)</option><option value="KBA"<?php if($level=='KBA'){echo ' selected';};?>>KEBAYA (KBA)</option><option value="CNM"<?php if($level=='CNM'){echo ' selected';};?>>CELANA MANTEN (CMN)</option><option value="KMN"<?php if($level=='KMN'){echo ' selected';};?>>KAIN MANTEN (KMN)</option><option value="KAT"<?php if($level=='KAT'){echo ' selected';};?>>KAIN AMONG TAMU / KELUARGA (KAT)</option><option value="RMN"<?php if($level=='RMN'){echo ' selected';};?>>ROK MANTEN (RMN)</option></select> <em>PILIH KODE</em></td>
		  </tr>

                <font color="#FF0000"><b>*</b></font> <?=$iid_tipe_baju;?></td>
        </tr>
        <tr>
                 <td width="35%" align="right">Daerah</td>
                 <td width="65%">
                 <?= create_dd('daerah',array('id','nama'),"select * from daerah");?>
                 </td>    
             </tr>   
	<tr>
			<td width="35%" align="right">Baju</td>
            <td width="65%"><textarea name="layanan" cols="50" rows="3"><?=htmlentities(stripslashes($layanan));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$ilayanan;?></td>
        </tr>
	
		<tr>
			<td width="35%" align="right">Warna</td>
            <td width="65%"><?
$sqlpetugas="select distinct id_warna, nama_warna from warna
			 union select 0,'--Pilih Warna--' from dual";
			generate_select("id_warna",$sqlpetugas,$id_warna);

?></td>
        </tr>
        <tr>
			<td width="35%" align="right"> Tanggal </td><td> <input type='text' name='tanggal' size='11' value='<?=$new_tanggal?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tanggal'}); </script>
		
			</td>
			</tr>
        <tr>
			<td width="35%" align="right">Harga</td>
            <td width="65%"><input name="harga" id="harga" type="text" value="<?=$harga?>" /><font color="#FF0000"><b>*</b></font> <?=$ilayanan;?></td>
        </tr>
        
        <tr>
			<td width="35%" align="right">Gambar</td>
            <td width="65%">
              <input type="file" name="gambar" id="gambar" value="<?=$gambar;?>"/>
            </td>
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
  	<script  type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#input').datepicker({ dateFormat: 'yy-mm-dd', changeMonth : true,
                changeYear : true }); 
      
    });
	 //]]></script>
</table>
<?php

} else {
//registerInvalid

	$runSQL = "select id_layanan, id_tipe_baju,layanan,warna,gambar from p_baju where id_layanan='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_layanan = $row[id_layanan];
		$id_tipe_baju = $row[id_tipe_baju];
		$layanan = $row[layanan];
	
		$id_warna = $row[warna];
		$gambar = $row[gambar];
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
		<tr>
			<td width="35%" align="right">Kategori : </td>
			<td width="65%"><font class="datafield">
<?php
$sl="select keterangan from p_baju_tipe where id_tipe_baju='$id_tipe_baju'";
$rl=mysql_query($sl);
echo mysql_result($rl,0,"keterangan");
?></font></td>
		</tr>
        <tr valign=top>
            <td width="35%" align="right">Baju : </td>
            <td width="65%"><font class="datafield"><?=$layanan;?></font></td>
        </tr>
		 <tr valign=top>
            <td width="35%" align="right">Warna : </td>
            <td width="65%"><font class="datafield"><?=$id_warna;?></font></td>
        </tr>
          </tr>
		 <tr valign=top>
            <td width="35%" align="right">Gambar : </td>
            <td width="65%"><font class="datafield"><?=$gambar;?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_baju_detail";?>"><b>List Baju</b></a>
   </td>
  </tr>
  </form>
</table>
<?php };//registerInvalid ?>
