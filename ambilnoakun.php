<?php
include_once("include.php");
$kota = $_GET['kota'];
$subpesanan = mysql_query("SELECT id_noakun FROM p_noakun WHERE ketegori = 1 and id_noakun='$kota' order by id_noakun");
echo "<option>-- Pilih Id --</option>";
while($k = mysql_fetch_array($subpesanan)){
    echo "<option value=\"".$k['id_noakun']."\">";
}
?>