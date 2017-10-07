<html>
	<head>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/highcharts.js" type="text/javascript"></script>

<script type="text/javascript">
	var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Grafik Antrian Fitting '
         },
         xAxis: {
            categories: ['Fitting']
         },
         yAxis: {
            title: {
               text: 'Jumlah Customer Service'
            }
         },
              series:             
            [
            <? 
        	include_once './lib/conection.php';
          $sql = "select a.*,b.status from (
select distinct a.id_pegawai ,a.nama 
  from pegawai a ,pegawai_pekerjaan b  where a.id_pegawai=b.id_pegawai  and b.id_pekerjaan=27 
  )a left join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai 
    and tgl=".date('Y'-'m'-'d'). " 
    and status='fitting' order by nama asc";
            $query = mysql_query( $sql )  or die(mysql_error());
            while( $ret = mysql_fetch_array( $query ) ){
            	$nama=$ret['nama'];                     
                 $sql_jumlah   = "SELECT COUNT(fitting.id_antrian) as jumlah FROM fitting WHERE id_pegawai=$ret[id_pegawai]";        
                 $query_jumlah = mysql_query( $sql_jumlah ) or die(mysql_error());
                 while( $data = mysql_fetch_array( $query_jumlah ) ){
                    $jumlah = $data['jumlah'];                 
                  }             
                  ?>
                  {
                      name: '<?php echo $nama; ?>',
                      data: [<?php echo $jumlah; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
</script>
	</head>
	<body>
		<div id='container'></div>		
	</body>
</html>