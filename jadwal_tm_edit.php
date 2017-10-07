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
if($id_client=="")$id_client=$id;

$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=@mysql_query($sql);
$n=mysql_num_rows($rs);
if($n==0)
{ 
?>
    <br><br><br>
    <table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
        <tr>
            <td colspan="2">-- <strong><em>BELUM ADA ORDER !!!</em></strong> --</td>
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
                        <?=mysql_result($rs,$a,"tgl_acara");?>
                    </td>
                    <td>(
                        <?=mysql_result($rs,$a,"acara")?> )</td>
                </tr>
                <? } 
} 

$sqltm="select * from jadwal_tm where id_client=$id_client and id_tm=$id_tm";
$rst=@mysql_query($sqltm);
$tanggal=mysql_result($rst,0,"tgl_tm");
//echo $sqlbayar;
?>

                    <form name="form" method="post" action="<?=" ?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client&id_tm=$id_tm ";?>">

                        <table>
                            <tr>
                                <td nowrap>Tanggal TM</td>
                                <td><input type='text' name='tgl_tm' id='tgl_tm' size='11' value=''>
                                    <script type="text/javascript">
                                        //<![CDATA[
                                        var cal = Calendar.setup({
                                            onSelect: function(cal) {
                                                cal.hide()
                                            }
                                        });
                                        cal.manageFields("tgl_tm", "tgl_tm", "%Y-%m-%d");

                                    </script>

                                </td>
                            </tr>

                            <tr>
                                <td>Waktu TM</td>
                                <td><input type="text" name="waktu_tm" id="waktu_tm" value="<?=mysql_result($rst,0," waktu_tm ");?>">

                                </td>
                            </tr>
                            <tr>
                                <td>Lokasi</td>
                                <td><textarea rows=2 cols=30 name="lokasi"><?=mysql_result($rst,0,"lokasi");?></textarea></td>
                            </tr>
                            <tr>
                                <td>
                                    Petugas TM
                                    <td>
                                        <select name="petugas_tm">
                <option value="<?=mysql_result($rst,0,"petugas_tm");?>"><?=mysql_result($rst,0,"petugas_tm");?></option>
                 <option value="faisal">Faisal</option>
                                <option value="ruly">Ruly</option>
                                <option value="azis">Azis</option>
                                <option value="deden">Deden</option>
                                <option value="wulan">Wulan</option>
            </select>
                                    </td>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    Keterangan
                                    <td>
                                        <select name="keterangan">
                <option value="<?=mysql_result($rst,0,"keterangan");?>"><?=mysql_result($rst,0,"keterangan");?></option>
                              <option value="bersedia">bersedia</option>
                                <option value="tidak bersedia">tidak bersedia</option>
                                <option value="belum ditelepon">belum ditelepon</option>
                               
            </select>
                                    </td>
                                </td>
                            </tr>

                            <tr>
                                <td colspan=2 align=center><input type="submit" value="Delete" name="delete"><b> | </b><input type="submit" value="Edit" name="edit"></td>
                            </tr>
                            <tr>
                                <td colspan=2 align=center>
                                    <a href="<?=" ?menu=$menu&uid=$uid&page=jadwal_tm_input&id=$id_client ";?>">
                                        <img src="images/back2.png" width="100" height="75"></a>
                                </td>
                            </tr>
                    </form>
                    <?

if($delete){


$sql="delete from jadwal_tm where id_client=$id_client and id_tm=$id_tm ";
?>
                        <br><br>
                        <table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
                            <tr>
                                <td colspan="2">-- <strong><em>Delete penjadwalan Sukses!!!!</em></strong> --</td>
                            </tr>
                        </table><br><br>
                        <?
mysql_query($sql);
$act=null;

}

if($edit){



$sql="update jadwal_tm
set petugas_tm='$petugas_tm',tgl_tm='$tgl_tm',waktu_tm='waktu_tm',lokasi='$lokasi',keterangan='$keterangan',
id_user='$SAH[id_user]',login_ip='$REMOTE_ADDR',created=now()
where id_client=$id_client and id_tm=$id_tm ";
?>
                            <br><br>
                            <table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
                                <tr>
                                    <td colspan="2">-- <strong><em>Update penjadwalan Sukses!!!!</em></strong> --</td>
                                </tr>
                            </table><br><br>
                            <?
mysql_query($sql);
$act=null;

}


if(!$act){

$sql = "select date_format(tgl_tm,'%d-%m-%Y') tgl_tm, waktu_tm, petugas_tm, lokasi, keterangan,id_client,id_tm
from jadwal_tm where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
echo "<table width='500' cellspacing='1' cellpadding='3'>";
echo "<tr align=center bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td>
<td>Tanggal TM</td>
<td>Waktu TM</td>
<td>Lokasi</td>
<td>Petugas TM</td>
<td>Keterangan</td>

<td><img src='images/edit.gif' border=0></td>
</tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($ccc)."</td>";?>

                                <td align=center>
                                    <?=mysql_result($rk,$k,"tgl_tm")?>
                                </td>
                                <td>
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
	$id_tm=mysql_result($rk,$k,"id_tm");
	echo "<a href=?menu=$menu&uid=$uid&page=jadwal_tm_edit&id_client=$id_client&id_tm=$id_tm>"?><img border=0 src='images/edit.gif'></a>
                                </td>

                                </tr>
                                <?
}
echo "</table>";
}
?>
