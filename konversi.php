<?
	function bilang($bilangan, $satuan) {
       $kata="";
       switch ($bilangan) {
               case 1 :
                       if($satuan=="ratus" || $satuan=="puluh" || $satuan=="belas" ||
$satuan=="ribu") {
                               $kata=" se";
                       } else {
                               $kata=" satu";
                       }
                       break;
               case 2 :
                       $kata=" dua";
                       break;
               case 3 :
                       $kata=" tiga";
                       break;
               case 4 :
                       $kata=" empat";
                       break;
               case 5 :
                       $kata=" lima";
                       break;
               case 6 :
                       $kata=" enam";
                       break;
               case 7 :
                       $kata=" tujuh";
                       break;
               case 8 :
                       $kata=" delapan";
                       break;
               case 9 :
                       $kata=" sembilan";
                       break;
       }
       if($kata==" se") {
               return $kata.$satuan;
       } else {
               return $kata." ".$satuan;
       }
}

function katakan($uang){
$terbilang="";

$milyar=floor($uang/1000000000);
$uang=$uang % 1000000000;
if($milyar>0) {
       if($milyar<10 && $milyar > 0) {
               $terbilang.=bilang($milyar,"milyar");
       } else {
               $ratus=floor($milyar/100);
               if ($ratus>0) $terbilang.=bilang($ratus,"ratus");
               $milyar=$milyar % 100;
               $puluh=floor($milyar/10);
               if ($puluh>0) {
                       if ($puluh==1 && $milyar%10>0) {
                               $milyar=$milyar % 10;
                               if ($milyar > 0) $terbilang.=bilang($milyar,"belas");
                       } else {
                               $terbilang.=bilang($puluh,"puluh");
                               $milyar=$milyar % 10;
                               $terbilang.=bilang($milyar,"");
                       }
               } else {
                       $milyar=$milyar % 10;
                       $terbilang.=bilang($milyar,"");
               }
               $terbilang.=" milyar";
       }
}

$juta=floor($uang/1000000);
$uang=$uang % 1000000;
if($juta>0) {
       if($juta<10 && $juta > 0) {
               $terbilang.=bilang($juta,"juta");
       } else {
               $ratus=floor($juta/100);
               if ($ratus>0) $terbilang.=bilang($ratus,"ratus");
               $juta=$juta % 100;
               $puluh=floor($juta/10);
               if ($puluh>0) {
                       if ($puluh==1 && $juta%10>0) {
                               $juta=$juta % 10;
                               if ($juta > 0) $terbilang.=bilang($juta,"belas");
                       } else {
                               $terbilang.=bilang($puluh,"puluh");
                               $juta=$juta % 10;
                               $terbilang.=bilang($juta,"");
                       }
               } else {
                       $juta=$juta % 10;
                       $terbilang.=bilang($juta,"");
               }
               $terbilang.=" juta";
       }
}

$ribu=floor($uang/1000);
$uang=$uang % 1000;
if ($ribu>0) {
       if($ribu<10) {
               $terbilang.=bilang($ribu,"ribu");
       } else {
               $ratus=floor($ribu/100);
               if ($ratus>0) $terbilang.=bilang($ratus,"ratus");
               $ribu=$ribu % 100;
               $puluh=floor($ribu/10);
               if ($puluh>0) {
                       if ($puluh==1 && $ribu%10>0) {
                               $ribu=$ribu % 10;
                               if ($ribu > 0) $terbilang.=bilang($ribu,"belas");
                       } else {
                               $terbilang.=bilang($puluh,"puluh");
                               $ribu=$ribu % 10;
                               $terbilang.=bilang($ribu,"");
                       }
               } else {
                       $ribu=$ribu % 10;
                       $terbilang.=bilang($ribu,"");
               }
               $terbilang.=" ribu";
       }
}

$ratus=floor($uang/100);
if ($ratus>0) $terbilang.=bilang($ratus,"ratus");
$uang=$uang % 100;
$puluh=floor($uang/10);
if ($puluh>0) {
       if ($puluh==1 && $uang%10 > 0) {
               $uang=$uang % 10;
               if ($uang>0) $terbilang.=bilang($uang,"belas");
       } else {
               $terbilang.=bilang($puluh,"puluh");
               $uang=$uang % 10;
               $terbilang.=bilang($uang,"");
       }
} else {
       $uang=$uang % 10;
       $terbilang.=bilang($uang,"");
}
//$terbilang.=" rupiah";
$nilai=ucwords(strtolower($terbilang));

return $nilai;
}