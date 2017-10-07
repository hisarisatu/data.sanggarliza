<?php

@mysql_connect('localhost', 'h67649_liza642', 'telkom135');
@mysql_select_db('h67649_liza642');

function selisih($jam_masuk,$finish) {
    #echo exit;

    if (strlen($jam_masuk) <= 5) {
        $jam_masuk = "00" . $jam_masuk;
    } else {
        $jam_masuk = $jam_masuk;
    }
    #echo $jam_masuk."-";
    $jam_masuk = substr($jam_masuk, 0, 2) . ":" . substr($jam_masuk, 2, 2) . ":" . substr($jam_masuk, 4, 2);
    $jam_keluar = date("G:i:s");
    #echo $jam_masuk;
    #exit;

    list($h, $m, $s) = explode(":", $jam_masuk);
    $dtAwal = mktime($h, $m, $s, "1", "1", "1");
    list($h, $m, $s) = explode(":", $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
    $dtSelisih = $dtAkhir - $dtAwal;

    
    
    $totalmenit = $dtSelisih / 60;
    $jam = explode(".", $totalmenit / 60);
    $jml_jam = $jam[0];

    $jam = $jml_jam == '' ? 0 * 60 : $jml_jam * 60;


    $sisamenit = ($totalmenit / 60) - $jam[0];
    $sisamenit2 = ($jam + $sisamenit) * 60;
    $detik = $sisamenit2 * 60;
    $arr = array('detik' => $detik, 'menit' => $sisamenit2);


    return $arr;
}

function button_exec($x, $id_client, $status) {
    
    $html = "";
    
    if ($status > 0) {
        $display = '';
        if ($status == 1) {
            $html.=stop($x, $id_client, '');
            $html.=finish($x, $id_client, 'none');
        } else {
            $html.=finish($x, $id_client, '');
        }
    } else {
         
            $html.=start($x, $id_client, '');
            $html.=stop($x, $id_client, 'none');
            $html.=finish($x, $id_client, 'none');
            $display = 'none';
    }
    $html.="<div style=\"display: $display;\" id=\"waktu$x\" class=\"demo\">00:00:00</div>";
    return $html;
}

  
function lama($jam_masuk){
    
    if($jam_masuk!=''){
    $jam_keluar = date("Gis");
    
    #echo strlen($jam_keluar)."</br>";
    
    $jam_keluar=strlen($jam_keluar)<=5 ? "0".$jam_keluar : $jam_keluar;
    
    $selisih = strtotime($jam_keluar) -  strtotime($jam_masuk);
   # echo $jam_keluar."-".$jam_masuk."</br>";
    #echo $selisih; exit;
    
    $hari = $selisih/(60);
    $lama['detik']= $hari*60;
    return $lama;
    }else{
    return 10000;    
    }
}


function timers($x,$waktu,$status,$finish){
    
   if($status==1){ 
    $wktu=strlen($waktu) >5 ? $waktu : (strlen($waktu)==4 ? "00".$waktu : "0".$waktu);
    $xs=lama($wktu);
     
    $wktu=$xs['detik']*1000;
       
    $html="<script>
    $(document).ready(function(){
        $('#waktu' + $x).stopwatch({startTime:".$wktu." }).stopwatch('start');
    });
    </script>";
    return $html;
   }
     
    
}

function start($x, $id_client, $status) {
     
    $html = "<button style=\"display: $status;\" id=\"cs-start$x\" onclick=\"cs_start('$x', '$id_client')\" class=\"btn btn-success btn-bordered\">Start</button>";
    return $html;
}

function stop($x, $id_client, $status) {
    $html = "<button style=\"display: $status;\" id=\"cs-stop$x\" onclick=\"cs_stop('$x', '$id_client')\" class=\"btn btn-danger btn-bordered\">Stop</button>";
    return $html;
}

function finish($x, $id_client, $status) {
    $html = "<button style=\"display: $status;\" id=\"cs-finish$x\" onclick=\"cs_finish('$x', '$id_client')\" class=\"btn btn-default btn-bordered\">Finish</button>";
    return $html;
}

function label_timer($x,$sts,$idClient,$cf,$id_antrian){
    if(intval($sts)==1){
        $scolor="success";
        $lbl="00:00:00";
        $cursor="initial";
    }else if(intval($sts)==0){
        $scolor="danger";
        $lbl="00:00:00";
        $cursor="initial";
    }else{
        $scolor="default";
        $lbl="--Clear--";
        $cursor="pointer";
        $action ="onclick=\"clearreseptionis('$id_antrian','$cf')\"";
    }    
    #$html="<div style=\"\" id=\"waktu$x\" class=\"demo\">00:00:00</div>";
    $html="<button $action style=\"margin-bottom: 3px;cursor: $cursor;\" id=\"waktu$x\"  class=\"btn btn-$scolor btn-bordered popovers\" >$lbl</button>";
    return $html;
}
function button($waktu){
    
   
    return $html;
}
?>