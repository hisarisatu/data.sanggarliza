<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
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



if($_GET['id_param']!=''){
    $sql_delete="delete from p_baju where id_layanan ='".$_GET['id_param']."'";
    $result = mysql_query($sql_delete, $connDB);
     if($result){
        $text_alert="Data Berhasil Dihapus";
     }else{
        $text_alert="Data Gagal Dihapus";
     }
}


unset($ii);
/*$runSQL = "select a.id_layanan, a.layanan, b.id_tipe_baju, b.keterangan,a.qty from p_baju a, p_baju_tipe b 
where b.id_tipe_baju=a.id_tipe_baju $filterSQL 
order by id_tipe_baju,id_layanan 
LIMIT $offsetRecord, $listRecord";
 */
 if ((strlen($run) < 1) and ($id <> "")){ 
 
$runSQL="select
c.nama_cpw,c.nama_cpp, c.tgl_rencana,
ifnull((case when a.id_acara = '2' then b.nama end),'-') AS akad,
ifnull((case when a.id_acara = '3' then b.nama end),'-') AS resepsi
from pegawai_tugas a
left join
pegawai b on b.id_pegawai=a.id_pegawai 
left join client c on c.id_client=a.id_client
where a.id_pekerjaan=17
and a.id_client='$id'
group by a.id_acara
order by a.id_acara asc";

#echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {  
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   <td align=center> $row[nama_cpw] / $row[nama_cpp] </td> 
				    <td align=center> $row[akad] </td>
					 <td align=center> $row[resepsi] </td>
					  
					   
                 
		  
	  </tr>
	";//htmlData
};//end-while
};//if-id
$uiddd=$_REQUEST['uid'];
?>
<script type="text/javascript">
function deleteconfirm(id){
    //alert(id);
    var tanya=confirm('Anda Yakin Akan Menghapus Data Ini '+id+' ?');
    if(tanya){
            window.location.href ='http://data.sanggarliza.com/?menu=4&uid=<?=$uiddd?>&page=p_baju_detail&id_param='+id;        
    }else{
        return false;
    }
   
}
</script>
<h3 style="color: red;"><?=@$text_alert?></h3>
<table  border="0" width="819" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Perias Pengantin</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr><td><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='781' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25" align="center">
			
                       
                        <td colspan='3'>Perias Pengantin</td>
						
                        
                          <tr bgcolor='#A7A7A7' height="25" align="center">
                        <td width="387">Nama Pengantin</td>
                        <td width="195">Akad Nikah</td>
                        <td width="175">Resepsi</td>
                      
                        
                      
                       
		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>
