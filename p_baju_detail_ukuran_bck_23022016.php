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

  ifnull(Sum(CASE tipe_ukuran_baju WHEN '1' THEN jumlah ELSE null END),'-')L1,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '2' THEN jumlah ELSE null END),'-')L2,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '3' THEN jumlah ELSE null END),'-')L3,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '4' THEN jumlah ELSE null END),'-')L4,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '5' THEN jumlah ELSE null END),'-')L5,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '6' THEN jumlah ELSE null END),'-')L6,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '7' THEN jumlah ELSE null END),'-')L7,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '8' THEN jumlah ELSE null END),'-')L8,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '25' THEN jumlah ELSE null END),'-')L9,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '24' THEN jumlah ELSE null END),'-')S1,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '9' THEN jumlah ELSE null END),'-')S,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '10' THEN jumlah ELSE null END),'-')M,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '11' THEN jumlah ELSE null END),'-')L,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '12' THEN jumlah ELSE null END),'-')XL,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '13' THEN jumlah ELSE null END),'-')XXL,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '14' THEN jumlah ELSE null END),'-')B55,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '15' THEN jumlah ELSE null END),'-')B56,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '16' THEN jumlah ELSE null END),'-')B57,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '17' THEN jumlah ELSE null END),'-')B58,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '18' THEN jumlah ELSE null END),'-')B59,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '19' THEN jumlah ELSE null END),'-')B60,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '20' THEN jumlah ELSE null END),'-')B61,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '21' THEN jumlah ELSE null END),'-')B62,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '22' THEN jumlah ELSE null END),'-')B63,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '23' THEN jumlah ELSE null END),'-')B64,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '24' THEN jumlah ELSE null END),'-')B60,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '26' THEN jumlah ELSE null END),'-')B50,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '27' THEN jumlah ELSE null END),'-')B51,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '28' THEN jumlah ELSE null END),'-')B52,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '29' THEN jumlah ELSE null END),'-')B53,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '30' THEN jumlah ELSE null END),'-')B54,
  ifnull(Sum(CASE tipe_ukuran_baju WHEN '31' THEN jumlah ELSE null END),'-')A11

 ,IFNULL(sum(jumlah),'-') jumlah
 
from    p_ukuran_baju 
   where  id_layanan='$id'

  group by id_layanan";

#echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {  
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
		 
				   <td align=center> $row[L1] </td>
				    <td align=center> $row[L2] </td>
					 <td align=center> $row[L3] </td>
					  <td align=center> $row[L4] </td>
					   <td align=center> $row[L5] </td>
					   <td align=center> $row[L6] </td>
				    <td align=center> $row[L7] </td>
					 <td align=center> $row[L8] </td>
					 <td align=center> $row[L9] </td>
					 <td align=center> $row[S1] </td>
					  <td align=center> $row[S] </td>
					   <td align=center> $row[M] </td>
					   <td align=center> $row[L] </td>
				    <td align=center> $row[XL] </td>
					 <td align=center> $row[XXL] </td>
					   <td align=center> $row[B50] </td>
					   <td align=center> $row[B51] </td>
		             <td align=center> $row[B52] </td>
					  <td align=center> $row[B53] </td>
					   <td align=center> $row[B54] </td>
					  <td align=center> $row[B55] </td>
					   <td align=center> $row[B56] </td>
					   <td align=center> $row[B57] </td>
				    <td align=center> $row[B58] </td>
					 <td align=center> $row[B59] </td>
					  <td align=center> $row[B60] </td>
					   <td align=center> $row[B61] </td>
		             <td align=center> $row[B62] </td>
					  <td align=center> $row[B63] </td>
					   <td align=center> $row[B64] </td>
					 <td align=center> $row[jumlah] </td>
                 
		  
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
	 <font class="titledata"><b>Data Ukuran Baju</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr><td><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='814' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25" align="center">
			
                       
                        <td colspan='9'>Besekap</td>
						<td colspan='6'>Kebaya</td>
                        <td colspan='15'>Blangkon</td>
                        <td rowspan='2'>Jumlah</td>
                        
                          <tr bgcolor='#A7A7A7' height="25" align="center">
                        <td>L1</td>
                        <td>L2</td>
                        <td>L3</td>
                        <td>L4</td>
                        <td>L5</td>
                        <td>L6</td>
                        <td>L7</td>
                        <td>L8</td>
                        <td>L9 </td>
                        <td>0 </td>
                        <td>S </td>
                        <td>M </td>
                        <td>L </td>
                        <td>XL</td>
                        <td>XLL</td>
                        <td>50</td>
                        <td>51</td>
                        <td>52</td>
                        <td>53</td>
                        <td>54</td>
                        <td>55</td>
                        <td>56</td>
                        <td>57</td>
                        <td>58</td>
                        <td>59</td>
                        <td>60</td>
                        <td>61</td>
                        <td>62</td>
                        <td>63</td>
                        <td>64</td>
                      
                       
		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>

