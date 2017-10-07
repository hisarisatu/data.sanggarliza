<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
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


if (($SAH[id_group]==3) or ($SAH[id_group]==1) or ($SAH[id_group]==5))
{



if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_butik, nama, produk, tgl_acara, tgl_dateline, acara, hp, keterangan,harga from butik where id_butik='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_butik = $row[id_butik];
		$nama = $row[nama];
		$produk = $row[produk];
		$acara = $row[acara];
		$harga = $row[harga];
		$hp = $row[hp];
		$keterangan = $row[keterangan];
		$tanggal = $row[tgl_acara];
		$tmp_tanggal = explode("-",$tanggal);
        $new_tanggal = $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0]; 
		$tanggal1 = $row[tgl_dateline];
		$tmp_tanggal1 = explode("-",$tanggal1);
        $new_tanggal1 = $tmp_tanggal1[1]."/".$tmp_tanggal1[2]."/".$tmp_tanggal1[0]; 
		
	};//if
};//if-id

if (strlen($run) > 1){ 

		$nama = ucwords($nama);
		$produk = ucwords($produk);
		$acara = ucwords($acara);
		$harga = ucwords($harga);
        $hp = ucwords($hp);
		$keterangan = ucwords($keterangan);
		$tmp_tanggal = explode("/",$tanggal);
        $new_tanggal = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1]; 
$tmp_tanggal1 = explode("/",$tanggal1);
        $new_tanggal1 = $tmp_tanggal1[2]."-".$tmp_tanggal1[0]."-".$tmp_tanggal1[1]; 

	$ok = 1;
	//if (strlen($nama) < 5){ $inama = "<br><font color='#FF0000' size='1'><i>* Nama "; $ok=0; }
	//if (strlen($alamat_cpw) < 5){ $ialamat_cpw = "<br><font color='#FF0000' size='1'><i>* Alamat CPW tidak valid"; $ok=0; }
	//if ((($tlp_rumah_cpw*1) < 11111111) or (($tlp_rumah_cpw*1) > 99999999999) or (substr($tlp_rumah_cpw,0,1)<>"0")){ $itlp_rumah_cpw = "<br><font color='#FF0000' size='1'><i>* Telepon Rumah CPW tidak valid"; $ok=0; }
	//if ((($tlp_mobile_cpw*1) < 11111111) or (($tlp_mobile_cpw*1) > 99999999999) or (substr($tlp_mobile_cpw,0,1)<>"0")){ $itlp_mobile_cpw = "<br><font color='#FF0000' size='1'><i>* Nomor HP CPW tidak valid"; $ok=0; }

//if (strlen($email) < 5){ $iemail = "<br><font color='#FF0000' size='1'><i>* Email tidak valid"; $ok=0; }

//if (strlen($id_pegawai) < 1){ $iid_pegawai = "<br><font color='#FF0000' size='1'><i>* Petugas CS tidak valid"; $ok=0; }

		if (($ok == 1) and ($id == "")){
		$runSQL = "insert into butik (nama, produk, tgl_acara, tgl_dateline, acara, hp, keterangan, created, harga) VALUES ('$nama', '$produk', '$new_tanggal1','$new_tanggal','$acara','$hp','$keterangan', now(), $harga)";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update butik set nama='$nama', produk='$produk', tgl_acara='$new_tanggal1',tgl_dateline='$new_tanggal', acara='$acara', hp='$hp', keterangan='$keterangan', harga='$harga' where id_butik='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Butik</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=butik";?>"><b>Back Data Butik</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
         <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr><td colspan="2" width="100%" align="center"> <b>Data isian </b> </td></tr>
		<tr>
			<td width="100%" align="right">Nama Customer</td>
			<td width="65%"><input type="text" name="nama" size="40" value="<?=$nama;?>"> <font color="#FF0000"><b>*</b></font> <?=$inama;?></td>
		</tr>
        <tr>
			<td width="100%" align="right">Tanggal Acara</td><td> <input type='text' name='tanggal1' size='11' value='<?=$new_tanggal1?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tanggal1'}); </script>
			</td>
			</tr>
            <tr>
		<tr>
			<td width="100%" align="right">Nama Produk</td>
			<td width="65%"><textarea name="produk" cols="50" rows="5" ><?=$produk;?></textarea> <font color="#FF0000"><b>*</b></font> <?=$idetail;?></td>
		</tr>
         <tr>
			<td width="100%" align="right">Harga</td>
			<td width="65%"><input type="text" name="harga" size="15" value="<?=$harga;?>">			  <?=$iharga;?></td>
		</tr>
        
				<tr>
			<td width="100%" align="right">Deadline</td><td> <input type='text' name='tanggal' size='11' value='<?=$new_tanggal?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tanggal'}); </script>
			</td>
			</tr>
            <tr>
			<td width="100%" align="right">Acara</td>
			<td width="65%"><input type="text" name="acara" size="40" value="<?=$acara;?>">			  <?=$iacara;?></td>
		</tr>
         <tr>
			<td width="100%" align="right">Contact Person</td>
			<td width="65%"><input type="text" name="hp" size="15" value="<?=$hp;?>">			  <?=$ihp;?></td>
		</tr>
		<tr>
			<td width="100%" align="right">Keterangan</td>
			<td width="65%"><textarea name="keterangan" cols="50" rows="5" ><?=$keterangan;?></textarea> <font color="#FF0000"><b>*</b></font> <?=$idetail;?></td>
		</tr>
<!--
		<tr><td colspan="2" width="100%" align="center"> <br><b>Catatan Tambahan bila ada informasi khusus.</b> </td></tr>
		<tr>
			<td width="35%" align="right">Catatan</td>
			<td width="65%"><input type="text" name="catatan" size="55" value="<?=htmlentities(stripslashes($catatan));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Email CPW/CPP</td>
			<td width="65%"><input type="text" name="email" size="20" value="<?=htmlentities(stripslashes($email));?>"> <font color="#FF0000"><b>*</b></font> <?=$iemail;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Facebook</td>
			<td width="65%"><input type="text" name="facebook" size="20" value="<?=htmlentities(stripslashes($facebook));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Twiter</td>
			<td width="65%"><input type="text" name="twiter" size="20" value="<?=htmlentities(stripslashes($twiter));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Petugas CS</td>
			<td width="65%">
			<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?><font color="#FF0000"><b> *</b></font><?=$iid_pegawai;?>
			</td>
		</tr>
		 <tr>
			<td width="35%" align="right">Status</td>
			<td width="65%"><select name="status" style="margin:0px;"><option value="aktif"<?php if($status=='Aktif'){echo ' selected';};?>>Aktif</option><option value="close"<?php if($surat=='Close'){echo ' selected';};?>>Close</option></select> </td>
		  </tr> -->
<tr>
			<td width="100%" align="right">&nbsp;</td>
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
<?

} else {
//registerInvalid

	$runSQL = "select id_butik, nama, produk, tgl_acara, tgl_dateline, acara, hp, keterangan,harga from butik where id_butik='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
	$id_butik = $row[id_butik];
		$nama = $row[nama];
		$produk = $row[produk];
		$harga = $row[harga];
		$acara= $row[acara];
		$hp = $row[hp];
		$keterangan = $row[keterangan];
		$tanggal = $row[tgl_acara];
		
		$tanggal1 = $row[tgl_dateline];
		
	};

	
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Jadwal</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><a href='<?="?menu=$menu&uid=$uid&page=butik_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
			  <td colspan="2" align="center"> <b>Data  Butik</b> </td></tr>
			<tr>
				<td width="49%"  align="right">Nama  :</td>
				<td width="51%" ><font class="datafield"><?=$nama;?></font></td>
			</tr>
			<tr>
			  <td  align="right">Tanggal Acara:</td>
			  <td ><font class="datafield"><?=$tanggal1;?></font></td>
			  </tr>
			<tr>
			  <td  align="right">Nama Produk :</td>
			  <td ><font class="datafield"><?=$produk;?></font></td>
			  </tr>
              <tr>
			  <td  align="right">Harga :</td>
			  <td ><font class="datafield"><?=$harga;?></font></td>
			  </tr>
              
              <tr>
			  <td  align="right">Tanggal Deadline:</td>
			  <td ><font class="datafield"><?=$tanggal;?></font></td>
			  </tr>
			
               <tr>
			  <td  align="right">Acara :</td>
			  <td ><font class="datafield"><?=$acara;?></font></td>
			  </tr>
              
               <tr>
			  <td  align="right">Contact Person :</td>
			  <td ><font class="datafield"><?=$hp;?></font></td>
			  </tr>
              
               <tr>
			  <td  align="right">Keterangan :</td>
			  <td ><font class="datafield"><?=$keterangan;?></font></td>
			  </tr>
		 </table>

	

		 <div align="right">
		 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="70%" align="right">
		 <font size='1'><?=$inforecord;?></font>
		 </div>

		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=butik";?>"><b>Back Data Butik</b></a></td>
  </tr>
  </form>
</table>
<? };//registerInvalid 
}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }

?>