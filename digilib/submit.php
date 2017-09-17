<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
include($path . "/scripts/digilibsession.php");

if ($_POST) {

    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

    $status = 'ERROR';//ENTRY,EXIT,ERROR
    $name = "";
    try {
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if ($count == 1) {

            date_default_timezone_set("Asia/Kolkata");
            $name = $row['name'];
            $visitsThisMonth = $row['digilib'];

            $sql = "SELECT * FROM digilib WHERE id = '$id' and timeout is null";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if ($count >= 1) {
                $timein = strtotime($row['timein']);
                $timeout = date("H:i:s");
                $timespent = strtotime(date("Y-m-d H:i:s")) - $timein;
                $status = 'EXIT';//ENTRY,EXIT,ERROR

                $sqltime = "Update digilib set timeout=now() where id = '$id' and timeout is null";
                mysqli_query($connection, $sqltime);

            } else {
                $status = 'ENTRY';

                $sqltime = "Insert into digilib (id,timein) values('$id',now())";
                mysqli_query($connection, $sqltime);
                $sqltime = "Update users set digilib=case when month = " . date("m") . " then digilib+1 else 1 end, month=" . date("m") . " where id='$id'";
                mysqli_query($connection, $sqltime);


            }

        }
    } catch (Exception $e) {
        $status = 'ERROR';//ENTRY,EXIT,ERROR
    }


    ?>


    <div class="col-md-11">
    <!-- Widget: user widget style 1 -->
    <div class="box box-widget widget-user-2">

    <?php if ($status == 'ENTRY'){ ?>
    <div class="widget-user-header bg-green">
    <div class="col-md-3">
        <img class="img-rounded img-responsive" src="/ext-res/png/512/android-social-user.png"
             onError="this.onerror=null;this.src='/ext-res/png/512/android-social-user.png';" alt="User Avatar">
    </div>
    <?php }else if ($status == 'EXIT'){ ?>
    <div class="widget-user-header bg-red">
    <div class="col-md-3">
        <img class="img-rounded img-responsive" src="/ext-res/png/512/android-social-user.png"
             onError="this.onerror=null;this.src='/ext-res/png/512/android-social-user.png';" alt="User Avatar">
    </div>
    <?php }else{ ?>
    <div class="widget-user-header bg-yellow">
<?php } ?>


    <h1 align="center"><?php echo $status; ?></h1>
    <h1 class="widget-user-username"><b><?php echo $name; ?></b></h1>
    <h5 class="widget-user-desc"><?php echo $id; ?></h5>
    </div>
    <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
            <?php if ($status == 'ENTRY') { ?>
                <li><a><b>
                            <h2>Previous Visits This Month &emsp;&emsp;<span
                                        class="badge bg-blue"><h4><?php echo $visitsThisMonth; ?></h4></span></h2>
                        </b></a></li>
            <?php } else if ($status == 'EXIT') { ?>
                <li><a><b>
                            <h2>Time In &emsp;&emsp;<span
                                        class="badge bg-blue"><h4><?php echo gmdate("d-m-Y H:i:s ", $timein); ?></h4></span>
                            </h2>
                        </b></a></li>
                <li><a><b>
                            <h2>Time Spent <span
                                        class="badge bg-blue"><h4><?php echo gmdate("H:i:s ", $timespent) ?></h4></span>
                            </h2>
                        </b></a></li>
            <?php } else { ?>
                <li><a><b><h2>Contact the Librarian</h2></b></a></li>
            <?php } ?>
        </ul>
    </div>
    </div>
    <!-- /.widget-user -->
    </div>

    <?php
} ?>