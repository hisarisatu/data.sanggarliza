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

  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '32' THEN jumlah ELSE null END),'-')A1,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '33' THEN jumlah ELSE null END),'-')A2,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '34' THEN jumlah ELSE null END),'-')A3,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '35' THEN jumlah ELSE null END),'-')A4,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '36' THEN jumlah ELSE null END),'-')A5,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '37' THEN jumlah ELSE null END),'-')A6,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '38' THEN jumlah ELSE null END),'-')A7,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '39' THEN jumlah ELSE null END),'-')A8,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '40' THEN jumlah ELSE null END),'-')A9,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '41' THEN jumlah ELSE null END),'-')A10,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '42' THEN jumlah ELSE null END),'-')A11,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '43' THEN jumlah ELSE null END),'-')A12,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '44' THEN jumlah ELSE null END),'-')A13,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '45' THEN jumlah ELSE null END),'-')A14,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '46' THEN jumlah ELSE null END),'-')A15,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '47' THEN jumlah ELSE null END),'-')A16,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '48' THEN jumlah ELSE null END),'-')A17,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '49' THEN jumlah ELSE null END),'-')A18,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '50' THEN jumlah ELSE null END),'-')A19,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '51' THEN jumlah ELSE null END),'-')A20,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '52' THEN jumlah ELSE null END),'-')A21,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '53' THEN jumlah ELSE null END),'-')A22,
  ifnull(Sum(CASE tipe_ukuran_sepatu WHEN '54' THEN jumlah ELSE null END),'-')A23
 

 ,IFNULL(sum(jumlah),'-') jumlah
 
from    p_ukuran_sepatu 
   where  id_layanan='$id'

  group by id_layanan";

#echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {  
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  
				   <td align=center> $row[A1] </td>
				   <td align=center> $row[A2] </td>
				   <td align=center> $row[A3] </td>
				   <td align=center> $row[A4] </td>
				   <td align=center> $row[A5] </td>
				   <td align=center> $row[A6] </td>
				   <td align=center> $row[A7] </td>
				   <td align=center> $row[A8] </td>
				   <td align=center> $row[A9] </td>
					 
				   <td align=center> $row[A10]</td>
				   <td align=center> $row[A11] </td>
				   <td align=center> $row[A12] </td>
				   <td align=center> $row[A13] </td>
				   <td align=center> $row[A14] </td>
				   <td align=center> $row[A15] </td>
					 
				   <td align=center> $row[A16] </td>
				   <td align=center> $row[A17] </td>
		           <td align=center> $row[A18] </td>
				   <td align=center> $row[A19] </td>
				   <td align=center> $row[A20] </td>
				   <td align=center> $row[A21] </td>
				   <td align=center> $row[A22] </td>
				   <td align=center> $row[A23] </td>
				     
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
	 <font class="titledata"><b>Data Ukuran Sepatu</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr><td><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='814' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25" align="center">
			
                       
                        <td colspan='23'>Sepatu/Selop</td>
						
                        <td rowspan='2'>Jumlah</td>
                        
                          <tr bgcolor='#A7A7A7' height="25" align="center">
                        <td>26</td>
                        <td>27</td>
                        <td>28</td>
                        <td>29</td>
                        <td>30</td>
                        <td>31</td>
                        <td>32</td>
                        <td>33</td>
                        <td>34 </td>
                        
                        <td>35</td>
                        <td>36</td>
                        <td>37</td>
                        <td>38</td>
                        <td>39</td>
                        <td>40</td>
                        
                        <td>41</td>
                        <td>42</td>
                        <td>43</td>
                        <td>44</td>
                        <td>45</td>
                        <td>46</td>
                        <td>47</td>
                        <td>48</td>
                        
                      
                       
		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">&nbsp;</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>

