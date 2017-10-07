<?php
include_once("include.php");
$kota = $_GET['kota'];
echo $kota;
$subpesanan = mysql_query("SELECT id_sublayanan FROM p_sublayanan 
WHERE id_sublayanan='$kota' 
and (tgl_habis is null or tgl_habis='0000-00-00')
ORDER BY detail_layanan");
echo "<option>-- Pilih Id --</option>";
while($k = mysql_fetch_array($subpesanan)){
    echo "<option value=\"".$k['id_sublayanan']."\">";
}
echo $subpesanan;
?>