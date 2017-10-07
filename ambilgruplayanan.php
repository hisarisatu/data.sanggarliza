<?php
include_once("include.php");
$propinsi = $_GET['propinsi'];
$kota = mysql_query("SELECT id_sublayanan,detail_layanan 
FROM p_sublayanan WHERE id_layanan='$propinsi' 
and (tgl_habis is null or tgl_habis='0000-00-00')
order by detail_layanan");
echo "<option>-- Pilih Sublayanan --</option>";
while($k = mysql_fetch_array($kota)){
    echo "<option value=\"".$k['id_sublayanan']."\">".$k['detail_layanan']."</option>\n";
}
?>