<?php
 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");

function ambil_periasId(){
  $periasId='';
  $sql_periasId=mysql_query("select * from p_perias");
  while($data_periasId=mysql_fetch_array($sql_periasId)){
  $periasId.='{ value: "'.stripslashes($data_periasId['id_perias']).'", label: "'.stripslashes($data_periasId['nama_perias']).'"},';
  }
  return(strrev(substr(strrev($periasId),1)));
}

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

<?php
if (($SAH[id_group]==1) or ($SAH[id_group]==5)) {

if ((strlen($run) < 1) and ($id_reperias <> "")){ 
  $runSQL = "select id_reperias,id_perias,id_client,tgl_acara1,tgl_acara2,id_user from retur_perias where id_reperias='$id_reperias'";
  //echo $runSQL;
  $result = mysql_query($runSQL, $connDB);
  if ($row = mysql_fetch_array ($result)) {

    $id_reperias    = $row[id_reperias];
    $id_perias      = $row[id_perias];
    $id_client      = $row[id_client];
    $tgl_acara3     = $row[tgl_acara3];
    $tmp_tanggal3   = explode("-",$tgl_acara3);
    $new_tanggal3   = $tmp_tanggal3[1]."/".$tmp_tanggal3[2]."/".$tmp_tanggal3[0];
    
    
  };//if
};//if-id

if (strlen($run) > 1){ 

  $id_client = $_GET['id_client'];

  $id_acara     = ucwords($id_acara);
  $id_perias    = ucwords($id_perias);
  $id_subperias = ucwords($id_subperias);
  $jam          = ucwords($jam);
  $tempat       = ucwords($tempat);
  $jml_orang    = ucwords($jml_orang);
  
  $tmp_tanggal3 = explode("/",$tgl_acara3);
  $new_tanggal3 = $tmp_tanggal3[2]."-".$tmp_tanggal3[0]."-".$tmp_tanggal3[1];

  $ok = 1;
  
  //if (strlen($alamat_cpw) < 5){ $ialamat_cpw = "<br><font color='#FF0000' size='1'><i>* Alamat CPW tidak valid"; $ok=0; }
  //if ((($tlp_rumah_cpw*1) < 11111111) or (($tlp_rumah_cpw*1) > 99999999999) or (substr($tlp_rumah_cpw,0,1)<>"0")){ $itlp_rumah_cpw = "<br><font color='#FF0000' size='1'><i>* Telepon Rumah CPW tidak valid"; $ok=0; }
  //if ((($tlp_mobile_cpw*1) < 11111111) or (($tlp_mobile_cpw*1) > 99999999999) or (substr($tlp_mobile_cpw,0,1)<>"0")){ $itlp_mobile_cpw = "<br><font color='#FF0000' size='1'><i>* Nomor HP CPW tidak valid"; $ok=0; }

//if (strlen($email) < 5){ $iemail = "<br><font color='#FF0000' size='1'><i>* Email tidak valid"; $ok=0; }

  if (($ok == 1) and ($id_reperias == "")){
    $registerInvalid = 1;
    
    $id_client = $_GET['id_client'];
    $sql_retur_perias = "SELECT * FROM retur_perias WHERE id_client = '$id_client' AND id_perias = '$_POST[id_perias]'";
    $query_retur      = mysql_query($sql_retur_perias);
      
    if(mysql_num_rows($query_retur) == 1) {

      $sql_subperias = "SELECT id_subperias, harga_dasar FROM p_subperias WHERE id_subperias = '$id_subperias' LIMIT 1";
      $hasil2        = mysql_query($sql_subperias);
      $tampil        = mysql_fetch_array($hasil2);
      $harga_perias  = $tampil['harga_dasar'];

      $tampil_retur     = mysql_fetch_array($query_retur);
      $alias_reperias   = $tampil_retur['id_reperias'];
    
      $sql = "INSERT INTO acara_perias (id_reperias,id_acara,id_client,tempat,tanggal,waktu,id_user,login_ip,created) VALUES ('$alias_reperias ','$id_acara','$id_client','$tempat','$new_tanggal3','$jam','$SAH[id_user]','$REMOTE_ADDR', now())";
        mysql_query($sql) or die('Gagal menyimpan data acara perias');

        $sql = "INSERT INTO pesanan_perias (id_reperias,id_acara,id_client,id_subperias,jml_orang,harga) VALUES ('$alias_reperias','$id_acara','$id_client','$id_subperias','$jml_orang','$harga_perias')";
        mysql_query($sql) or die('Gagal menyimpan data pesanan perias');

        echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=$page&id_client=$id_client'>";
      
      $id = mysql_insert_id($connDB);

    } else {

      $sql_subperias = "SELECT id_subperias, harga_dasar FROM p_subperias WHERE id_subperias = '$id_subperias' LIMIT 1";
      $hasil2      = mysql_query($sql_subperias);
      $tampil      = mysql_fetch_array($hasil2);
      $harga_perias  = $tampil['harga_dasar'];

      $kw=mysql_query("SELECT MAX(no_kw_retur) as no_kw_retur FROM retur_perias 
      where date_format(tanggal,'%Y')=date_format(curdate(),'%Y')");
      $no_kw_retur=mysql_result($kw,0,"no_kw_retur");
      $no_kw_retur+=1;

      $sql="INSERT INTO retur_perias (id_reperias,id_perias,id_client,id_user,login_ip,created,tanggal,no_kw_retur) VALUES ('','$id_perias','$id_client','$SAH[id_user]','$REMOTE_ADDR', now(), now(),'$no_kw_retur')";
      mysql_query($sql) or die('Gagal menyimpan data retur perias');

      //mencari id reperias
        $sql = "SELECT max(id_reperias) AS lastPerias_id FROM retur_perias LIMIT 1";
        $hasil = mysql_query($sql);
        $row = mysql_fetch_array($hasil);
        $lastPeriasId = $row['lastPerias_id'];

        $sql = "INSERT INTO pesanan_perias (id_reperias,id_acara,id_client,id_subperias,jml_orang,harga) VALUES ('$lastPeriasId','$id_acara','$id_client','$id_subperias','$jml_orang','$harga_perias')";
        mysql_query($sql) or die('Gagal menyimpan data pesanan perias');

        //mencari id reperias
        $sql2 = "SELECT max(id_rias) AS lastRias_id FROM pesanan_perias LIMIT 1";
        $hasil2 = mysql_query($sql2);
        $row2 = mysql_fetch_array($hasil2);
        $lastRiasId = $row2['lastRias_id'];

        $sql = "INSERT INTO acara_perias (id_reperias,id_acara,id_client,id_rias,tempat,tanggal,waktu,id_user,login_ip,created) VALUES ('$lastPeriasId','$id_acara','$id_client','$lastRiasId','$tempat','$new_tanggal3','$jam','$SAH[id_user]','$REMOTE_ADDR', now())";
        mysql_query($sql) or die('Gagal menyimpan data acara perias');

        echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=$page&id_client=$id_client'>";

      $id = mysql_insert_id($connDB);
    }
  }
};//end-if-submit

if ($act == "del_perias") {

    $sql_perias   = "SELECT * FROM acara_perias WHERE id_reperias = '$_GET[id_reperias]' AND id_client = '$id_client'";
    $query_perias = mysql_query($sql_perias);
    $jml_perias   = mysql_num_rows($query_perias);

    if ($jml_perias == 1) {
      
        $sql = "DELETE FROM acara_perias WHERE id_reperias = '$_GET[id_reperias]' AND id_client = '$id_client' AND id_acara = '$_GET[id_acara]' AND id_rias = '$_GET[id_rias]' ";
        mysql_query($sql) or die('Gagal menghapus data acara perias');

        $sql = "DELETE FROM pesanan_perias WHERE id_reperias = '$_GET[id_reperias]' AND id_client = '$id_client' AND id_acara = '$_GET[id_acara]' AND id_rias = '$_GET[id_rias]' ";
        mysql_query($sql) or die('Gagal menghapus data pesanan perias');

        $sql = "DELETE FROM retur_perias WHERE id_reperias = '$_GET[id_reperias]' AND id_client = '$id_client'";
        mysql_query($sql) or die('Gagal menghapus data retur perias');

        echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=$page&id_client=$id_client'>";
    
    } else {

        $sql = "DELETE FROM acara_perias WHERE id_reperias = '$_GET[id_reperias]' AND id_client = '$id_client' AND id_acara = '$_GET[id_acara]' AND id_rias = '$_GET[id_rias]' ";
        mysql_query($sql) or die('Gagal menghapus data acara perias');

        $sql = "DELETE FROM pesanan_perias WHERE id_reperias = '$_GET[id_reperias]' AND id_client = '$id_client' AND id_acara = '$_GET[id_acara]' AND id_rias = '$_GET[id_rias]'";
        mysql_query($sql) or die('Gagal menghapus data retur perias');

        echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=$page&id_client=$id_client'>";

    }
}

if ($registerInvalid <> 1){
?>

<link rel="stylesheet" href="calendar.css" type="text/css">
<script type="text/javascript" src="calendar_us.js"></script>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page&id_client=$id_client";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
   <font class="titledata"><b>Input/Edit Data Perias</b></font>

   <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
     <td valign="bottom">
     </td>
     <td valign="bottom" align="right">
       <img src="images/arrow2.gif" border="0">
       <a href="<?="?menu=$menu&uid=$uid&page=returan_baru";?>"><b>Back Data Perias</b></a>
     </td>
    </tr>
    <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
   </table>
   <table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tr><td width="45%" align="left">Nama Perias</td>
            <td width="55%"><input type="text" name="nama_perias" id="periasId" size="20" onChange="this.form.submit();" value="<?=$nama_perias;?>">  &nbsp; <input type="hidden" name="id_perias" id="id_perias" size="20" value="<?=$id_perias;?>">
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

    <!--<tr><td width="25%" align="left">Tanggal Acara</td>
            <td width="25%" align="left">
            <input type='text' name='tgl_acara1' size='11' value='<?=$new_tanggal1?>'>
      <script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_acara1'}); </script>
      - <input type='text' name='tgl_acara2' size='11' value='<?=$new_tanggal2?>'>
      <script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_acara2'}); </script>
      </td>
        </tr>-->

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

     <tr>
      <td width="45%" align="right">&nbsp;</td>
      <td width="55%">
      <input type="hidden" name="id" value="<?=$id;?>"><br>
      <input type="submit" value="Simpan" name="run" class="button">
      </td>
    </tr>
   </table>

   </td>
  </tr>
  </form>
</table>

<?

$id_client = $_GET['id_client'];

$sql = "SELECT
  p.id_reperias,
  p.id_perias,
  p.id_client,
  
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
  t.detail_perias,
  
  u.id_client, u.id_acara,
  v.id_client, w.id_acara, w.acara
FROM retur_perias p,
  acara_perias q,
  pesanan_perias r,
  p_perias s,
  p_subperias t,
  acara u, client v, p_acara w
WHERE p.id_perias = t.id_perias

    AND p.id_client = v.id_client
    
    AND q.id_acara = w.id_acara
    AND q.id_acara = u.id_acara
    AND q.id_reperias = p.id_reperias
    
    AND r.id_reperias = p.id_reperias
    AND r.id_acara = w.id_acara
    AND r.id_subperias = t.id_subperias
    AND r.id_acara = u.id_acara
    
    AND t.id_perias = s.id_perias
    AND u.id_client = v.id_client
    AND p.id_client = '$_GET[id_client]'
    AND q.id_client = '$_GET[id_client]'
    AND r.id_client = '$_GET[id_client]'
    AND u.id_client = '$_GET[id_client]' GROUP BY t.detail_perias, s.id_perias";
  $rk = mysql_query($sql);

echo "<br>";
  echo "<table width='100%' cellspacing='1' cellpadding='3'>";
  echo "<tr bgcolor='#A7A7A7' height='25'>";
  echo "<td><b>No</td><td><b>Nama</td><td>Layanan</td><td>Acara</td><td>Jumlah</td><td>Tanggal Rias</td><td>Lokasi</td><td>Update</td></tr>";
  for ($k=0;$k<@mysql_num_rows($rk);$k++){
    $ccc++;
      if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
      echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
    <td><?=mysql_result($rk,$k,"nama_perias")?></td>
    <td><?=mysql_result($rk,$k,"detail_perias")?></td>
    <td><?=mysql_result($rk,$k,"acara")?></td>
    <td><?=mysql_result($rk,$k,"jml_orang")?></td>
    <td><?=mysql_result($rk,$k,"tanggal")?></td>
    <td><?=mysql_result($rk,$k,"tempat")?></td>
    <td><a href='<?="?menu=$menu&uid=$uid&page=retur_perias_update&id_client=".$id_client."&id_acara=".mysql_result($rk,$k,'id_acara')."&id_reperias=".mysql_result($rk,$k,'id_reperias')."&id_perias=".mysql_result($rk,$k,'id_perias')."&id_rias=".mysql_result($rk,$k,'id_rias')."";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp;&nbsp;
    <a href='<?="?menu=$menu&uid=$uid&page=$page&act=del_perias&id_client=".$id_client."&id_acara=".mysql_result($rk,$k,'id_acara')."&id_reperias=".mysql_result($rk,$k,'id_reperias')."&id_rias=".mysql_result($rk,$k,'id_rias')."";?>' onclick="return confirm('Apakah Anda yakin mau menghapus data ini ?');"><img src='images/del.gif' border='0' title='Hapus Perias'></a></td>
</tr>
<?
}
echo "</table>";
}
}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Keuangan</b></font></div>"; }

?>