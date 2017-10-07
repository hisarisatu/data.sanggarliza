<?php
include_once("include.php");
$propinsi = $_GET['propinsi'];
$kota = mysql_query("SELECT id_subperias,detail_perias 
FROM p_subperias WHERE id_perias='$propinsi' 
and (tgl_habis is null or tgl_habis='0000-00-00')
order by detail_perias");
echo "<option>-- Pilih Sublayanan --</option>";
while($k = mysql_fetch_array($kota)){
    echo "<option value=\"".$k['id_subperias']."\">".$k['detail_perias']."</option>\n";
}
?>