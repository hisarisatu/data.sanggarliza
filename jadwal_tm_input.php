<script src="src/js/jscal2.js"></script>
<script src="src/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
include_once("p_bulan.php");
if($id_client=="")$id_client=$id;

$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
$urut=mysql_query("SELECT MAX(no_urut) as no_urut FROM jadwal_tm");
$no_urut=mysql_result($urut,0,"no_urut");
$no_urut+=1;


//echo $sql;
$rs=@mysql_query($sql);
$n=mysql_num_rows($rs);
if($n==0)
{ 
?>
    <br><br><br>
    <table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
        <tr>
            <td colspan="2">-- <strong><em>CLIENT BELUM ORDER !!</em></strong> --</td>
        </tr>
    </table><br>
    <?	
}
else
{
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
        <br><br><br>
        <table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
            <tr>
                <td>Client</td>
                <td colspan=3>:
                    <?=mysql_result($rs,0,"nama_cpw")?> /
                        <?=mysql_result($rs,0,"nama_cpp")?>
                </td>
            </tr>
            <? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
                <tr>
                    <td>Tanggal</td>
                    <td>:
                        <?=mysql_result($rs,$a,"tgl_acara");?> (
                            <?=mysql_result($rs,$a,"acara")?>)</td>
                </tr>
                <? } ?>


        </table><br>
        <? } ?>

            <form name="form" method="post" action="<?=" ?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client ";?>">
                <table>
                    <tr>
                        <td nowrap>Tanggal TM</td>
                        <td><input type='text' name='tgl_tm' id='tgl_tm' size='10' value='<?=$tgl_tm?>' placeholder="Tanggal TM">
                            <script type="text/javascript">
                                //<![CDATA[
                                var cal1 = Calendar.setup({
                                    onSelect: function(cal1) {
                                        cal1.hide()
                                    }
                                });
                                cal1.manageFields("tgl_tm", "tgl_tm", "%Y-%m-%d");

                            </script>

                        </td>
                    </tr>

                    <tr>
                        <td nowrap>Waktu TM</td>
                        <td><input type='text' name='waktu_tm' id='waktu_tm' size='10' value='<?=$waktu?>' placeholder="Jam TM">
                        </td>
                    </tr>


                    <tr>
                        <td>Lokasi TM</td>
                        <td><textarea rows=5 cols=50 name="lokasi" placeholder="Harap diisi dengan baik, benar, dan teliti"></textarea></td>
                    </tr>

<tr>
    <td>Petugas TM</td>
    <td>
        <select name="petugas_tm" id="petugas_tm">
                                <option value="faisal">Faisal</option>
                                <option value="ruly">Ruly</option>
                                <option value="azis">Azis</option>
                                <option value="deden">Deden</option>
                                <option value="wulan">Wulan</option>
                            </select>
    </td>
</tr>

<tr>
    <td>Keterangan</td>
    <td>
        <select name="keterangan" id="keterangan">
                                <option value="bersedia">bersedia</option>
                                <option value="tidak bersedia">tidak bersedia</option>
                                <option value="belum ditelepon">belum ditelepon</option>
        </select>
    </td>
</tr>
<tr><td colspan=2 align=center><a href="<?="?menu=$menu&uid=$uid&page=jadwal_tm";?>" > 
<img src="images/back2.png" width="100" height="75"></a> </td></tr>
                    <tr>
                        <td colspan=2 align=center><input type="submit" value="simpan" name="tombol"></td>
                    </tr>
            </form>
            <?

if($act=="proses"){


$sql="insert into jadwal_tm values ('$id_client',null,'$petugas_tm','$tgl_tm','$waktu_tm','$lokasi','$keterangan','$SAH[id_user]', '$REMOTE_ADDR', now(),'$no_urut')";
//echo "<br>$sql";
mysql_query($sql);
$act=null;
}

if(!$act){

$sql = "select date_format(tgl_tm,'%d-%M-%Y') tgl_tm, waktu_tm, lokasi,  petugas_tm,id_client,id_tm,keterangan
from jadwal_tm where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
echo "<table width='500' cellspacing='1' cellpadding='3'>";
echo "<tr align=center bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</b></td>
<td>Tgl TM</td>
<td>Waktu TM</td>
<td>Lokasi</td>
<td>petugas TM</td>
<td>keterangan</td>
<td>Edit</td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($ccc)."</td>";?>
                <td align=center>
                    <?=mysql_result($rk,$k,"tgl_tm")?>
                </td>
                <td align=center>
                    <?=mysql_result($rk,$k,"waktu_tm")?>
                </td>
                <td>
                    <?=mysql_result($rk,$k,"lokasi")?>
                </td>
                <td>
                    <?=mysql_result($rk,$k,"petugas_tm")?>
                </td>
                <td>
                    <?=mysql_result($rk,$k,"keterangan")?>
                </td>

                <td align=center>
                    <? $id_client=mysql_result($rk,$k,"id_client");
	$id_bayar=mysql_result($rk,$k,"id_tm");
	echo "<a href=?menu=$menu&uid=$uid&page=jadwal_tm_edit&id_client=$id_client&id_tm=$id_tm>"?><img border=0 src='images/edit.gif'></a>
                </td>


                </tr>
                <?
}
echo "</table>";
}
?>
