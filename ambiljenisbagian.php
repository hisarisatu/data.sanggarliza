<?php
include_once("include.php");
$propinsi = $_GET['propinsi'];
$kota = mysql_query("SELECT id_noakun,keterangan FROM p_noakun WHERE kategori = 1 and id_jenis_bagian='$propinsi' order by id_noakun");
echo "<option>-- Pilih No akun --</option>";
while($k = mysql_fetch_array($kota)){
    echo "<option value=\"".$k['id_noakun']."\">".$k['keterangan']."</option>\n";
}
?>
