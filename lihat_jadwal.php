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
 *  
from    jadwal_upload
   where  id_jadwal='$id'
";

#echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {  
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   
				    <td align=center><img src='upload/$row[filename]'border='0' width='600' heigth='800'/>  </td>
					
					
		  
	  </tr>
	   <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   
				    <td align=center><img src='upload/$row[filename1]'border='0' width='600' heigth='800'/>  </td>
					
					
		  
	  </tr>
	   <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   
				    <td align=center><img src='upload/$row[filename2]'border='0' width='600' heigth='800'/>  </td>
					
					
		  
	  </tr>
	   <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   
				    <td align=center><img src='upload/$row[filename3]'border='0' width='600' heigth='800'/>  </td>
					
					
		  
	  </tr>
	   <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   
				    <td align=center><img src='upload/$row[filename4]'border='0' width='600' heigth='800'/>  </td>
					
					
		  
	  </tr>
	   <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   
				    <td align=center><img src='upload/$row[filename5]'border='0' width='600' heigth='800'/>  </td>
					
					
		  
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
	 <font class="titledata"><b>Foto Jadwal</b></font>
     <tr>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0" >
			 <b><a href="<?="?menu=$menu&uid=$uid&page=jadwal_upload";?>">List All</a> </b>
		 </td>
</tr>
	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr><td><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='850' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25" align="center">
			
                       
                       
						<td width="543" >Foto</td>
                        
                        
                          
                          
                       
		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>
