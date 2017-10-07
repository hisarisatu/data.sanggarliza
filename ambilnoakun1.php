<?php
include_once("include.php");
$kota = $_GET['kota'];
$subpesanan = mysql_query("SELECT id_noakun FROM p_noakun WHERE id_noakun='$kota' and kategori=2 order by id_noakun");
echo "<option>-- Pilih Id --</option>";
while($k = mysql_fetch_array($subpesanan)){
    echo "<option value=\"".$k['id_noakun']."\">";
}
?>