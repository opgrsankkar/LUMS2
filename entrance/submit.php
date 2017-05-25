<?php
session_start();
include("../scripts/entrancesession.php");

if( $_POST ){
	$roll = $_POST['id'];
	if($roll=='1')
        $status='EXIT';//ENTRY,EXIT,ERROR
    else if($roll=='2')
        $status='ERROR';//ENTRY,EXIT,ERROR
    else
        $status='ENTRY';//ENTRY,EXIT,ERROR

    $roll='CB.EN.U4CSE14051';
    $timein='09:22 AM';
    $timeout='10:53 AM';
    $name='Sri Darshan S';
    $visitsThisMonth=15;
    $timespent="2:52";

	?>


    <div class="col-md-11">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user-2">

                <?php if($status=='ENTRY'){?>
                    <div class="widget-user-header bg-green">
                <?php }else if($status=='EXIT'){?>
                    <div class="widget-user-header bg-red">
                <?php }else{?>
                    <div class="widget-user-header bg-yellow">
                <?php } ?>

                    <div class="idcard-user-image">
                    <img class="img-rounded img-responsive" src="http://gpms.amritanet.edu/gpis/photos/U4CSE14/U4CSE14008.png" onError="this.onerror=null;this.src='../../ext-res/png/512/android-social-user.png';" alt="User Avatar">
                </div>


                <h1 align="center"><?php echo $status;?></h1>
                <h1 class="widget-user-username"><b><?php echo $name;?></b></h1>
                <h5 class="widget-user-desc"><?php echo $roll;?></h5>
            </div>
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <?php if($status=='ENTRY'){?>
                        <li><a><b><h2>Previous Visits This Month &emsp;&emsp;<span class="badge bg-blue"><h4><?php echo $visitsThisMonth;?></h4></span></h2></b></a></li>
                    <?php }else if($status=='EXIT'){?>
                        <li><a><b><h2>Time In &emsp;&emsp;<span class="badge bg-blue"><h4><?php echo $timein;?></h4></span></h2></b></a></li>
                        <li><a><b><h2>Time Spent &emsp;&emsp;<span class="badge bg-blue"><h4><?php echo $timespent;?></h4></span></h2></b></a></li>
                    <?php }else{?>
                        <li><a><b><h2>Contact the Librarian</h2></b></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>

   <!--


            <div class="col-md-11 alert alert-success">
                <h1>ENTRY</h1>
            </div>

            <div class="col-md-11 alert alert-error">
                <h1>EXIT</h1>
            </div>
            <div class="col-md-11 alert alert-warning">
                <h1>ERROR</h1>
            </div>



    <div class="col-md-4" style="padding-left: 0px;  padding-right: 0px;">
        <img src="" class="img-responsive">
    </div>


    <div class="col-md-7">

    <h3><?php echo $name ?></h3>
    <br/>
        <h3><?php echo $roll ?></h3>
    <br/>
        <h3><?php echo $timein ?></h3>

    </div>
    <?php
} ?>-->