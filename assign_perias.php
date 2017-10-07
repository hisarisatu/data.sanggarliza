<link rel="stylesheet" href="calendar.css" type="text/css">
<script type="text/javascript" src="calendar_us.js"></script>

<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010



include_once("include.php");

function ambil_periasId(){
	$periasId='';
	$sql_periasId=mysql_query("select * from p_perias");
	while($data_periasId=mysql_fetch_array($sql_periasId)){
	$periasId.='{ value: "'.stripslashes($data_periasId['id_perias']).'", label: "'.stripslashes($data_periasId['nama_perias']).'"},';
	}
	return(strrev(substr(strrev($periasId),1)));
}

?>

<head>
<link rel="stylesheet" href="js/jquery-ui.css">
  <script src="js/jquery-1.9.1.js"></script>
  <script src="js/jquery-ui.js"></script>
<script>
  $(function() {
    var DaftarPeriasId = [<?php echo ambil_periasId();?> ];
    $( "#periasId" ).autocomplete({
		source: DaftarPeriasId,
		focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		},
		select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#id_perias").val(ui.item.value);
		}
    });
  });
  </script>
 </head>

<form method="POST" name="form" action="<?="?id_client=$id_client";?>">
<table border="0" cellspacing="0" cellpadding="5" align=left width="100%">
<tr><td width="100%" align="center" vAlign="center"><font class="titledata"><b>TAMBAH/EDIT PERIAS</b></font>
	<table border="1" cellpadding="5" cellspacing="0" width="1000">
	    <tr><td width="25%" align="Center">Keterangan</td>
	    <td width="25%" align="center">Kolom Input</td></tr>
		
		<tr><td width="25%" align="left">Nama Perias</td>
            <td width="25%"><input type="text" name="nama_perias" id="periasId" size="20" onChange="this.form.submit();" value="<?=$nama_perias;?>">  &nbsp; <input type="hidden" name="id_perias" id="id_perias" size="20" value="<?=$id_perias;?>">
            <font color="#FF0000"><b>*</b></font></td>
        </tr>

		<tr><td width="25%" align="left">Layanan Perias</td>
            <td width="25%" align="left"><select name="id_subperias" value="<?=$id_subperias;?>">
			<?
				$sql="select p.*, q.* from p_perias p, p_subperias q where p.id_perias = q.id_perias and q.id_perias='$id_perias' order by q.detail_perias asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idl=mysql_result($rs,$a,"id_subperias");
				echo " value=\"$idl\">";
				echo mysql_result($rs,$a,"detail_perias");
				echo "</option>";
				} 
			?>
			</select></td>
        </tr>        

        <tr><td width="25%" align="left">Acara</td>
            <td width="25%" align="left">
            <?php
            	$selectacara = "<option value=''>-- Pilih Acara --</option>\n"; 
            	$id_client = $_GET['id_client'];
		
				$runSQL2 = "SELECT a.id_acara, a.tempat, b.acara, b.id_acara FROM acara a, p_acara b WHERE b.id_acara = a.id_acara AND a.id_client = '$id_client'";
		
		 		/*$runSQL2 = "select id_acara,acara from p_acara where id_acara not in (select distinct a.id_acara from acara a, retur_perias b where b.id_reperias='$id_client' AND a.id_client='$clientId' )";*/
		 
				$result2 = mysql_query($runSQL2, $connDB);
				while ($row2 = mysql_fetch_array ($result2)) {
					$selectacara .= "<option value='".$row2[id_acara]."'>$row2[acara]</option>\n"; 
				};//while
				$selectacara = "<select size=1 name='id_acara' class='edyellow combobox' value='<?=id_acara;?>'> $selectacara </select>";
            ?>
            <?=$selectacara?>
            </td>
        </tr>

		<tr><td width="25%" align="left">Tanggal</td>
            <td width="25%" align="left">
            <input type='text' name='tgl_acara1' size='11' value='<?=$new_tanggal1?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_acara1'}); </script>
			- <input type='text' name='tgl_acara2' size='11' value='<?=$new_tanggal2?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_acara2'}); </script>
			</td>
        </tr>

        <tr><td width="25%" align="left">Tanggal Rias</td>
            <td width="25%" align="left">
            <input type='text' name='tgl_acara3' size='11' value='<?=$new_tanggal3?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_acara3'}); </script>
			</td>
        </tr>
        
		<tr><td width="25%" align="left">Jam</td>
            <td width="25%"><input type="text" name="jam" value="<?=$jam;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>
        

		<tr><td width="25%" align="left">Lokasi</td>
            <td width="25%" align="left">
            <?php
            	$selectlokasi = "<option value=''>-- Pilih Lokasi --</option>\n"; 
            	$id_client = $_GET['id_client'];
		
				$runSQLLokasi = "SELECT a.id_acara, a.tempat, b.acara, b.id_acara FROM acara a, p_acara b WHERE b.id_acara = a.id_acara AND a.id_client = '$id_client'";
		
		 		/*$runSQL2 = "select id_acara,acara from p_acara where id_acara not in (select distinct a.id_acara from acara a, retur_perias b where b.id_reperias='$id_client' AND a.id_client='$clientId' )";*/
		 
				$resultLokasi = mysql_query($runSQLLokasi, $connDB);
				while ($rowLokasi = mysql_fetch_array ($resultLokasi)) {
					$selectlokasi .= "<option value='".$rowLokasi[tempat]."'>$rowLokasi[tempat]</option>\n"; 
				};//while
				$selectlokasi = "<select size=1 name='tempat' class='edyellow combobox' value='<?=tempat;?>''> $selectlokasi </select>";
            ?>
            <?=$selectlokasi?>
            </td>
        </tr>
        <tr>
          	<td width="25%" align="left">Jumlah Layanan</td>
            <td width="25%"><input type="text" name="jml_orang" value="<?=$jml_orang;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>
		</table>

		<table border="0" cellspacing="0" cellpadding="5" align=Center width="1000">    
		<tr>
			<td width="25%">
			<input type="submit" value="Simpan" name="tombol">
			<input type="hidden" name="act" value="<?=$act;?>">
      		</td>
		</tr> 
		</table>
   </td>
  </tr>
</table>
</form>
<?

if ($tombol) {

	if($act=="update") {

		echo "update";

	} else {

		$id_subperias = trim(strip_tags($_POST['id_subperias']));

        $tmp_tanggal1 = explode("/",$tgl_acara1);
        $new_tanggal1 = $tmp_tanggal1[2]."-".$tmp_tanggal1[0]."-".$tmp_tanggal1[1]; 
		$tmp_tanggal2 = explode("/",$tgl_acara2);
        $new_tanggal2 = $tmp_tanggal2[2]."-".$tmp_tanggal2[0]."-".$tmp_tanggal2[1];
        $tmp_tanggal3 = explode("/",$tgl_acara3);
        $new_tanggal3 = $tmp_tanggal3[2]."-".$tmp_tanggal3[0]."-".$tmp_tanggal3[1];

		$sql_subperias = "SELECT id_subperias, harga_dasar FROM p_subperias WHERE id_subperias = '$id_subperias' LIMIT 1";
		$hasil2 	   = mysql_query($sql_subperias);
		$tampil 	   = mysql_fetch_array($hasil2);
		$harga_perias  = $tampil['harga_dasar'];

		$sql="INSERT INTO retur_perias (id_reperias,id_perias,id_client,id_acara,tgl_acara1,tgl_acara2,id_user,login_ip,created) VALUES ('',$id_perias,$id_client,$id_acara,'$new_tanggal1','$new_tanggal2','$SAH[id_user]','$REMOTE_ADDR', now())";
		mysql_query($sql) or die('Gagal menyimpan data retur perias');

		//mencari id reperias
    	$sql = "SELECT max(id_reperias) AS lastPerias_id FROM retur_perias LIMIT 1";
    	$hasil = mysql_query($sql);
    	$row = mysql_fetch_array($hasil);
    	$lastPeriasId = $row['lastPerias_id'];

    	$sql = "INSERT INTO acara_perias (id_reperias,id_acara,id_client,tempat,tanggal,waktu,id_user,login_ip,created) VALUES ('$lastPeriasId','$id_acara','$id_client','$tempat','$new_tanggal3','$jam','$SAH[id_user]','$REMOTE_ADDR', now())";
    	mysql_query($sql) or die('Gagal menyimpan data acara perias');

   	 	$sql = "INSERT INTO pesanan_perias (id_reperias,id_acara,id_client,id_subperias,jml_orang,harga) VALUES ('$lastPeriasId','$id_acara','$id_client','$id_subperias','$jml_orang','$harga_perias')";
    	mysql_query($sql) or die('Gagal menyimpan data pesanan perias');

    	echo "Data Berhasil Di Tambahkan";
	} 

	
}
	
	
$sql = "SELECT
  p.id_reperias,
  p.id_perias,
  p.id_client,
  p.id_acara,
  p.tgl_acara1,
  p.tgl_acara2,
  q.id_reperias,
  q.id_acara,
  q.tempat,
  q.tanggal,
  q.waktu,
  r.id_reperias,
  r.id_acara,
  r.id_rias,
  r.id_subperias,
  r.jml_orang,
  s.id_perias,
  s.nama_perias,
  t.id_subperias,
  t.id_perias,
  t.detail_layanan,
  u.id_client, u.id_acara,
  v.id_client
FROM retur_perias p,
  acara_perias q,
  pesanan_perias r,
  p_perias s,
  p_subperias t,
  acara u, client v
WHERE p.id_perias = s.id_perias
    AND p.id_acara = u.id_acara
    AND p.id_client = v.id_client
    AND q.id_acara = p.id_acara
    AND r.id_acara = p.id_acara
    AND r.id_subperias = t.id_subperias
    AND t.id_perias = s.id_perias
    AND u.id_client = v.id_client
    AND p.id_client = '$id_client'
    AND u.id_client = '$id_client'
    AND v.id_client = '$id_client';";
	$rk = mysql_query($sql);
	echo "<br>";
	echo "<table width='100%' cellspacing='1' cellpadding='3'>";
	echo "<tr bgcolor='#A7A7A7' height='25'>";
	echo "<td><b>No</td><td><b>Nama</td><td>Layanan</td><td>Acara</td><td>Jumlah</td><td>Tanggal</td><td>Tanggal Rias</td><td>Lokasi</td><td>Update</td></tr>";

	for ($k=0;$k<@mysql_num_rows($rk);$k++){
		$ccc++;
    	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    	echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
		<td><?=mysql_result($rk,$k,"nama_perias")?></td>
		<td><?=mysql_result($rk,$k,"detail_layanan")?></td>
		<td><?=mysql_result($rk,$k,"tempat")?></td>
		<td><?=mysql_result($rk,$k,"jml_orang")?></td>
		<td><?=mysql_result($rk,$k,"tgl_acara1")?> - <?=mysql_result($rk,$k,"tgl_acara2")?></td>
		<td><?=mysql_result($rk,$k,"tanggal")?></td>
		<td><?=mysql_result($rk,$k,"tempat")?></td>
		<td><a href='?menu=$menu&uid=<?=$uid?>&page=input_daftar_ukuran
&id_client=<?=mysql_result($rk,$k,"id_client")?>
&id_acara=<?=mysql_result($rk,$k,"id_acara")?>
&id_sublayanan=<?=mysql_result($rk,$k,"id_sublayanan")?>
&nama=<?=mysql_result($rk,$k,"nama")?>
&id_jabatan=<?=mysql_result($rk,$k,"id_jabatan")?>
&asal_pihak=<?=mysql_result($rk,$k,"asal_keluarga1")?>
&ukuran_beskap=<?=mysql_result($rk,$k,"ukuran_beskap1")?>
&ukuran_blangkon=<?=mysql_result($rk,$k,"ukuran_blangkon")?>
&ukuran_selop=<?=mysql_result($rk,$k,"ukuran_selop")?>
&ukuran_celana=<?=mysql_result($rk,$k,"ukuran_celana")?>
&id_ukur=<?=mysql_result($rk,$k,"id_ukur")?>
&jenis_daftar=<?=$jenis_daftar;?>
&detail_layanan=<?=$detail_layanan;?>
&jml_busana=<?=$jml_busana;?>
&act=update
'>
<img border='0' src='images/edit.gif' title='Edit Data'></a></td>
</tr>
<?
}
echo "</table>";
?>