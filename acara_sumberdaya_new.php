<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
if (($SAH[id_group]==3) or ($SAH[id_group]==1))
{
if($id_client=="")$id_client=$id;
$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_acara='$id_acara' and a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=mysql_query($sql);
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Tanggal</td><td>: <?=$tgl_acara?></td></tr>
<tr><td>Acara</td><td>: <?=mysql_result($rs,0,"acara")?></td></tr>
<tr><td>Client</td><td>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
</table><br><hr>
<table cellpadding=4 cellspacing=0 border=1>
<?php
$sql = "
select distinct id_layanan,layanan from
(
select id_layanan,layanan from p_layanan where id_layanan in (select distinct id_layanan from p_sublayanan a, pesanan_plus b where a.id_sublayanan=b.id_sublayanan and b.id_client='$id_client' and b.id_acara='$id_acara')
union
select id_layanan,layanan from p_layanan where id_layanan in (select distinct id_layanan from p_sublayanan a, paket_sub_paket b, acara c where a.id_sublayanan=b.id_sublayanan and b.id_paket=c.id_paket and c.id_acara='$id_acara' and c.id_client='$id_client')
) a order by id_layanan";
#echo "<pre>".print_r($sql,true)."</pre>";
$res = mysql_query($sql);
for($l=0;$l<@mysql_num_rows($res);$l++){
	echo "<h2>";
        echo mysql_result($res,$l,"layanan");
        echo "</h2>";
	$id_layanan=mysql_result($res,$l,"id_layanan");
	?>
	<table cellpadding=4 cellspacing=0 border=1>
	<?php
		$sql="select distinct a.id_sublayanan,a.detail_layanan,b.jml_orang,'0' id_paket 
		from p_sublayanan a, pesanan_plus b 
		where a.id_sublayanan=b.id_sublayanan and b.id_client='$id_client' and b.id_acara='$id_acara' 
		and a.id_layanan='$id_layanan' 
		union select distinct a.id_sublayanan,a.detail_layanan,b.jml_orang,b.id_paket 
		from p_sublayanan a, paket_sub_paket b, acara c 
		where a.id_sublayanan=b.id_sublayanan and b.id_paket=c.id_paket 
		and c.id_acara='$id_acara' and c.id_client='$id_client' 
		and a.id_layanan='$id_layanan'";
		#echo $sql;
                #echo "<pre>".print_r($sql,true)."</pre>";
		$rs2=mysql_query($sql);
		for($l2=0;$l2<@mysql_num_rows($rs2);$l2++){
			$id_paket=mysql_result($rs2,$l2,"id_paket");
			$id_sublayanan=mysql_result($rs2,$l2,"id_sublayanan");
			$id_paket=mysql_result($rs2,$l2,"id_paket");
			$jml_vol=mysql_result($rs2,$l2,"jml_orang");		
			$detail_layanan=mysql_result($rs2,$l2,"detail_layanan");
			$detil_layanan=str_replace("&","dan",$detail_layanan);		
			?>
		<tr>
			<td align=right><?=$l2+1?></td>
			<td><?=mysql_result($rs2,$l2,"detail_layanan")?></td>
			<?php 
			switch($id_layanan)
			{
				case 2:
					?>
					<td><?="<a href=\"javascript:void(window.open('assign_busana.php?jml_busana=$jml_vol&id_client=$id_client
					&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_sublayanan','operator','toolbar=0,width=1100,height=500,top=0, left=60'));\">"?>
						<?php
						$sbl=mysql_query("select count(*) jumlah from client_busana where id_acara='$id_acara' and id_client='$id_client' and id_plus='$id_sublayanan' and id_paket='$id_paket' ");
						$cl=mysql_result($sbl,0,"jumlah");
						if($cl!=0){ 
							echo "<img src='images/ok.png' border=0 width=12 height=12>";
						}else{?>
							<img src='images/arw.gif' border=0 title='Input Jenis Busana'>
						<? } ?>
						</a></td>
					<td><?="<a href=\"javascript:void(window.open('input_daftar_ukuran.php?id_paket=$id_paket&id_sublayanan=$id_sublayanan&jml_busana=$jml_vol&detail_layanan=$detil_layanan&id_client=$id_client
					&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_sublayanan','operator','scrollbars=1,toolbar=0,width=1100,height=500,top=0, left=60'));\">"?>
						<?php
						$sbl=mysql_query("select count(*) jumlah from client_busana where id_acara='$id_acara' and id_client='$id_client' and id_plus='$id_sublayanan' and id_paket='$id_paket' ");
						$cl=mysql_result($sbl,0,"jumlah");
						if($cl!=0){ 
							echo "<img src='images/ok.png' border=0 width=12 height=12>";
						}else{?>
							<img src='images/arw.gif' border=0 title='Input Daftar Ukuran'>
						<? } ?>
						</a></td>
				<?php break;
			}			
			?>
			<td align=right>
				<?php
				$sql="select count(*) jumlah from pegawai where id_pegawai in (select id_pegawai from pegawai_pekerjaan where id_pekerjaan='$id_layanan') and id_pegawai in (select id_pegawai from pegawai_tugas where tanggal='$tgl' and id_acara='$id_acara' and id_client='$id_client' and id_pekerjaan='$id_layanan')";//echo $sql;
                                #echo "<pre>".print_r($sql, true)."</pre>";
				$nc=mysql_query($sql);
				$nn=mysql_result($nc,0,"jumlah");
				echo "$jml_vol &nbsp;";
				if($jml_vol==$nn)
					echo "<img src='images/ok.png' border=0 width=12 height=12>";
				?></td>
			<td align=center><?="<a href='?menu=$menu&uid=$uid&page=assign_pekerjaan&id_acara=$id_acara&id_client=$id_client&id_tugas=$id_sublayanan&jumlah=$jml_vol&pekerjaan=$id_layanan'>"?><img src="images/res.gif" border=0 height=17 width=17 title='Penugasan'></a></td>
            
		</tr>
		<? } ?>
	</table><hr>
<?
}
?>
<?
}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>












