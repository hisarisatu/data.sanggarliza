<?

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



	
include './include.php';
$id_client=$_GET['id_client'];
$id_konsultas1=$_GET['id_konsultasi1'];
$client_hadir=$_POST['client_hadir'];
	$isi=$_POST['isi'];
	$id_pegawai=$_POST['id_pegawai'];
	$status=$_POST['status'];
	$acara=$_POST['acara'];
$query=mysql_query("SELECT a.id_client, a.id_konsultasi1, a.tanggal, a.client_hadir,a.isi, b.nama, a.status, a.acara FROM konsultasi_fiting a, pegawai b WHERE a.petugas = b.id_pegawai AND id_client='$id_client' and id_konsultasi1=$id_konsultasi1");
while ($q = mysql_fetch_array($query)) {

?>
    
    <table>
        <form action="update_konsultasi1.php" method="POST">
               <div style="font-family:Arial;font-size:12px;padding:3px ">
		<div style="font-size:24px;padding:10px;padding-left:0px;">UPDATE DATA KONSULTASI</div>
		<div style="height:20px;"></div>
	    
 <tr><td>Id Client :</td><td><input type="hiden" name="id_client" value="<?php echo $q['id_client'];?>"></td></tr> <tr><td>Id Konsultasi :</td><td><input type="hiden" name="id_konsultasi1" value="<?php echo $q['id_konsultasi1'];?>"></td></tr>    	
<tr><td>Client Hadir :</td><td><input type="text" name="client_hadir" value="<?php echo $q['client_hadir'];?>"></td></tr>
<tr><td>Isi Konsultasi :</td><td><input type name="isi" value="<?php echo $q['isi'];?>"></input></td></tr>
<tr><td>Acara :</td><td>
<select name="acara" id="acara">
    <option>---- Pilih Acara ----</option>
    <?php
   include_once("include.php"); 
    $sql = mysql_query("SELECT * FROM p_acara ORDER BY id_acara ASC");
    if(mysql_num_rows($sql) != 0){
        while($data = mysql_fetch_assoc($sql)){
            echo '<option>'.$data['acara'].'</option>';
        }
    }
    ?>
</select>

<tr><td>Petugas :</td><td>	<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?>
<tr>
                <td>Status</td>
                <td><select name="status">
                       <?php
                       if($q['status']=="Fix"){
                           $fix="selected";
                       }else if($q['status']=="Batal"){
                           $batal="selected";
                       }
                       ?>
                        <option value="Fix" <?php echo $fix ?>>Fix</option>
                        <option value="Batal" <?php echo $batal ?>>Batal</option>
                    </select></td>
            </tr>
            
            
<tr><td><input type="submit" value="simpan" name="tombol"></td></tr>

	
	</div>
        </form>
    </table>

    	
<?php
}
?>