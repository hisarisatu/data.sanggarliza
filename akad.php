<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>1. Tata Rias</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a> </td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr><td>
        <?
        $runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) { $arr_jabatan[$row[id_jabatan]]=$row[nama_jabatan]; }

        unset($ii);
        $runSQL = "select id_client, id_acara, id_jabatan, sgljbl_standart, sgljbl_spesial, makeup_standart, makeup_spesial, catatan from order_tatarias where id_client='$id' and id_acara='$id_acara' order by id_jabatan asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          $ii++;
          if ($row[id_jabatan] == 1){ 
            $bsn_satuan="Buah";
            $rias_satuan="Kali";
          } else { 
            $bsn_satuan="Orang";
            $rias_satuan="Orang";
          };//if
          if ($row[sgljbl_standart]<=0){ $row[sgljbl_standart]="-"; };   if ($row[sgljbl_spesial]<=0){ $row[sgljbl_spesial]="-"; }
          if ($row[makeup_standart]<=0){ $row[makeup_standart]="-"; };   if ($row[makeup_spesial]<=0){ $row[makeup_spesial]="-"; }
        ?>
        <font color="#009900"><b><?=$ii;?>. <?=$arr_jabatan[$row[id_jabatan]];?></b></font>
        <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
        <table width="200" border="0" cellpadding="5" cellspacing="0">
         <tr>
           <td width="50%" vAlign="top">
           <table width="100%" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Sanggul/Jilbab</b> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Standart </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[sgljbl_standart];?> <?=$rias_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Spesial </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[sgljbl_spesial];?> <?=$rias_satuan;?> </td>
             </tr>
           </table>
           </td>
           <td width="45%" vAlign="top">
           <table width="100%" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Make UP</b> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Standart </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[makeup_standart];?> <?=$rias_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Spesial </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[makeup_spesial];?> <?=$rias_satuan;?> </td>
             </tr>
           </table>
           </td>
         </tr>
        </table>
        <?
          if ($ii%3 > 0){ echo "</td><td>"; } else { echo "</td></tr><tr><td>"; };
        };//while
        ?>
        </td></tr>
    </table>
    <br>
    </td>
  </tr>

  <tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>2. Tata Busana</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr><td>
        <?
        $runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) { $arr_jabatan[$row[id_jabatan]]=$row[nama_jabatan]; }

        unset($ii);
        $runSQL = "select id_client, id_acara, id_jabatan, baju_sewa, baju_sendiri, kain_sewa, kain_sendiri, selop_sewa, selop_sendiri, blangkon_sewa, blangkon_sendiri, asesoris_sewa, asesoris_sendiri, catatan from order_tatabusana where id_client='$id' and id_acara='$id_acara' order by id_jabatan asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          $ii++;
          if ($row[id_jabatan] == 1){ 
            $bsn_satuan="Buah";
            $rias_satuan="Kali";
          } else { 
            $bsn_satuan="Orang";
            $rias_satuan="Orang";
          };//if
          if ($row[baju_sewa]<=0){ $row[baju_sewa]="-"; };   if ($row[baju_sendiri]<=0){ $row[baju_sendiri]="-"; }
          if ($row[kain_sewa]<=0){ $row[kain_sewa]="-"; };   if ($row[kain_sendiri]<=0){ $row[kain_sendiri]="-"; }
          if ($row[selop_sewa]<=0){ $row[selop_sewa]="-"; };   if ($row[selop_sendiri]<=0){ $row[selop_sendiri]="-"; }
          if ($row[blangkon_sewa]<=0){ $row[blangkon_sewa]="-"; };   if ($row[blangkon_sendiri]<=0){ $row[blangkon_sendiri]="-"; }
          if ($row[asesoris_sewa]<=0){ $row[asesoris_sewa]="-"; };   if ($row[asesoris_sendiri]<=0){ $row[asesoris_sendiri]="-"; }
        ?>
        <font color="#009900"><b><?=$ii;?>. <?=$arr_jabatan[$row[id_jabatan]];?></b></font>
        <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
        <table width="200" border="0" cellpadding="5" cellspacing="0">
         <tr>
           <td width="50%" vAlign="top">
           <table width="100%" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Baju</b> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sewa </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[baju_sewa];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sendiri </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[baju_sendiri];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Selop</b> </td>
             </tr>
             <tr>
               <td width="40%"> &nbsp; - Sewa </td><td width="5%"> : </td>
               <td width="60%"> <?=$row[selop_sewa];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sendiri </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[selop_sendiri];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Blangkon</b> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sewa </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[blangkon_sewa];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sendiri </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[blangkon_sendiri];?> <?=$bsn_satuan;?> </td>
             </tr>
           </table>
           </td>
           <td width="45%" vAlign="top">
           <table width="100%" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Kain</b> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sewa </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[kain_sewa];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sendiri </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[kain_sendiri];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="100%" colspan="3"> <font class="titleitems"><b>Asesoris</b> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sewa </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[asesoris_sewa];?> <?=$bsn_satuan;?> </td>
             </tr>
             <tr>
               <td width="40%" nowrap> &nbsp; - Sendiri </td><td width="5%"> : </td>
               <td width="60%" nowrap> <?=$row[asesoris_sendiri];?> <?=$bsn_satuan;?> </td>
             </tr>
           </table>
           </td>
         </tr>
        </table>
        <?
          if ($ii%3 > 0){ echo "</td><td>"; } else { echo "</td></tr><tr><td>"; };
        };//while
        ?>
        </td></tr>
    </table>
    </td>
  </tr>

  <tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>3. Sajen</b></font> <a href="<?="?menu=$menu&uid=$uid&page=sajen_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table border="0" cellspacing="1" cellpadding="5">
      <tr>
        <?
        $runSQL = "select id_sajen, nama, keterangan, foto, tarif from p_sajen order by id_sajen asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) { $arr_sajen[$row[id_sajen]]=$row[nama]; }

        unset($ii);
        $runSQL = "select id_client, id_acara, id_sajen, id_pegawai, jumlah, catatan, harga_baru from order_sajen where id_client='$id' and id_acara='$id_acara' order by id_sajen asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          if ($ii%3 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; }; $ii++;

					$runSQL2 = "select id_pegawai, nama, tlp_rumah, tlp_mobile, alamat, catatan from pegawai where id_pegawai='$row[id_pegawai]'";
					$result2 = mysql_query($runSQL2, $connDB);
					if ($row2 = mysql_fetch_array ($result2)){}

        ?>
           <table width="220" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3">
               <font color="#009900"><b><?=$ii;?>. <?=$arr_sajen[$row[id_sajen]];?></b></font>
               <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
               </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Jumlah </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[jumlah];?> Buah </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Catatan </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[catatan];?> </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Harga </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[harga_baru];?> </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Pelaksana </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row2[nama];?> </td>
             </tr>
           </table>
        <?
        };//while
        ?>
      </tr>
    </table>
    </td>
  </tr>

  <tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>4. Master Of Ceremony</b></font> <a href="<?="?menu=$menu&uid=$uid&page=mc_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table border="0" cellspacing="1" cellpadding="5">
      <tr>
        <?
        unset($ii);
        $runSQL = "select id_client, id_acara, id_mc, catatan, harga_baru from order_mc where id_client='$id' and id_acara='$id_acara' order by id_mc asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          if ($ii%3 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; }; $ii++;

					$runSQL2 = "select id_mc, nama, keterangan, foto, tarif from p_mc where id_mc='$row[id_mc]'";
					$result2 = mysql_query($runSQL2, $connDB);
					if ($row2 = mysql_fetch_array ($result2)){}

        ?>
           <table width="220" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3">
               <font color="#009900"><b><?=$ii;?>. <?=$row2[nama];?></b></font>
               <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
               </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Catatan </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[catatan];?> </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Harga </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[harga_baru];?> </td>
             </tr>
           </table>
        <?
        };//while
        ?>
      </tr>
    </table>		
		</td>
  </tr>

  <tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>5. Tarian</b></font> <a href="<?="?menu=$menu&uid=$uid&page=tarian_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table border="0" cellspacing="1" cellpadding="5">
      <tr>
        <?
        unset($ii);
        $runSQL = "select id_client, id_acara, id_tarian, catatan, harga_baru, jml_penari from order_tarian where id_client='$id' and id_acara='$id_acara' order by id_tarian asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          if ($ii%3 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; }; $ii++;

					$runSQL2 = "select id_tarian, nama, keterangan, foto, tarif, jml_penari from p_tarian where id_tarian='$row[id_tarian]'";
					$result2 = mysql_query($runSQL2, $connDB);
					if ($row2 = mysql_fetch_array ($result2)){}

        ?>
           <table width="220" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3">
               <font color="#009900"><b><?=$ii;?>. <?=$row2[nama];?></b></font>
               <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
               </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Catatan </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[catatan];?> </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - JmlPenari </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[jml_penari];?> </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Harga </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[harga_baru];?> </td>
             </tr>
           </table>
        <?
        };//while
        ?>
      </tr>
    </table>
    </td>
  </tr>

  <tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>6. Upacara Adat</b></font> <a href="<?="?menu=$menu&uid=$uid&page=adat_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table border="0" cellspacing="1" cellpadding="5">
      <tr>
        <?
        unset($ii);
        $runSQL = "select id_client, id_acara, id_adat, catatan, harga_baru from order_adat where id_client='$id' and id_acara='$id_acara' order by id_adat asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          if ($ii%3 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; }; $ii++;

					$runSQL2 = "select id_adat, nama, keterangan, foto, tarif from p_adat where id_adat='$row[id_adat]'";
					$result2 = mysql_query($runSQL2, $connDB);
					if ($row2 = mysql_fetch_array ($result2)){}

        ?>
           <table width="220" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3">
               <font color="#009900"><b><?=$ii;?>. <?=$row2[nama];?></b></font>
               <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
               </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Catatan </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[catatan];?> </td>
             </tr>
             <tr>
               <td width="30%" nowrap vAlign="top"> &nbsp; - Harga </td><td width="5%" vAlign="top"> : </td>
               <td width="70%"> <?=$row[harga_baru];?> </td>
             </tr>
           </table>
        <?
        };//while
        ?>
      </tr>
    </table>
    </td>
  </tr>


  <tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>7. Lainnya</b></font> <a href="<?="?menu=$menu&uid=$uid&page=lainnya_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
  <tr>
    <td width="5%"></td>
    <td width="95%">
    <table border="0" cellspacing="1" cellpadding="5">
      <tr>
        <?
        unset($ii);
        $runSQL = "select id_client, id_acara, id_lain, catatan, harga_baru from order_lain where id_client='$id' and id_acara='$id_acara' order by id_lain asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
          if ($ii%2 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; }; $ii++;

        ?>
           <table width="300" border="0" cellpadding="0" cellspacing="2">
             <tr>
               <td width="100%" colspan="3">
               <font color="#009900"><b><?=$ii;?>.</b> <?=$row[catatan];?></font>
               <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
               </td>
             </tr>
             <tr>
               <td width="20%" nowrap vAlign="top"> &nbsp; - Harga </td><td width="5%" vAlign="top"> : </td>
               <td width="80%"> <?=$row[harga_baru];?> </td>
             </tr>
           </table>
        <?
        };//while
        ?>
      </tr>
    </table>
    </td>
  </tr>
</table>
