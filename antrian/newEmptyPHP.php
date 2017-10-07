 <?php
$uri=  explode('/',$_SERVER['REQUEST_URI']) ;
$uri_file=end($uri);
$file=  explode('.', $uri_file);
$file_uri=$file[0];
#echo "<pre>".print_r($_SESSION['userlogin-name'],true)."</pre>";
#userlogin-name
?>
<div class="leftpanel">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="profile.html">
            <img class="img-circle" src="images/photos/icon.png" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><?=$_SESSION['userlogin-name']?></h4>
            <small class="text-muted">petugas</small>
        </div>
    </div><!-- media -->

    <h5 class="leftpanel-title">Navigation</h5>

    <ul class="nav nav-pills nav-stacked">
        
<?php

$index=array('asign','monitoring','index','','input_antrian');
?>
      <?php if($_SESSION['groupId']==1){?>  
        <li class="parent <?=in_array($file_uri, $index) ? 'active' : '';?> "><a href="#"><i class="fa fa-home"></i> <span>Receptionist Menu</span></a>
            <ul class="children">
                <li class="<?=$file_uri=='asign' ? 'active' : '';?>"><a href="asign.php">
                        Assign Petugas CS & Fitting</a></li>
                <li class="<?=$file_uri=='index' || $file_uri=='' ? 'active' : '';?>"><a href="index.php"> <span>Monitoring Antrian</span></a></li>
                <li class="<?=$file_uri=='input_antrian' || $file_uri=='' ? 'active' : '';?>"><a href="input_antrian.php"> <span>Input Antrian</span></a></li>
            </ul>
        </li>
        <li><a href="management_user.php"><i class="fa fa-male"></i> <span>Management User</span></a></li>
        <li><a href="cs.php"><i class="fa fa-male"></i> <span>CS Menu</span></a></li>
        <li><a href="fitting.php"><i class="fa fa-male"></i> <span>Fitting Menu</span></a></li>
        <li><a href="logout.php"><i class="fa  fa-sign-out"></i> <span>Logout</span></a></li>
    </ul>
      <?php }else if($_SESSION['groupId']==3 || $_SESSION['groupId']==6){ ?>
        <li><a href="cs.php"><i class="fa fa-male"></i> <span>CS Menu</span></a></li>
        <li><a href="input_antrian.php"><i class="fa fa-child <?=$file_uri=='input_antrian_cs_to_fitting' || $file_uri=='' ? 'active' : '';?>" ></i> <span>Input Antrian</span></a></li>
        
        <li><a href="logout.php"><i class="fa  fa-sign-out"></i> <span>Logout</span></a></li>
      <?php }else if($_SESSION['groupId']==7 || $_SESSION['groupId']==8){ ?>
       <li><a href="fitting.php"><i class="fa fa-male"></i> <span>Fitting Menu</span></a></li>
	   
       <li><a href="input_antrian.php"><i class="fa fa-child <?=$file_uri=='input_antrian_fitting_to_cs' || $file_uri=='' ? 'active' : '';?>"></i> <span>Input Antrian</span></a></li>
        <li><a href="logout.php"><i class="fa  fa-sign-out"></i> <span>Logout</span></a></li>
      <?php } ?>

</div>


 