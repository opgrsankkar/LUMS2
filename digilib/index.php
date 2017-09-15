<?php
    include("../scripts/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Digilib</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../ext-res/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../ext-res/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/lums.css"/>
    <link rel="stylesheet" href="../../dist/css/site.css">

    <script type="text/javascript" src="../../dist/js/fullscreen/jquery.min.js"></script>
	<script type="text/javascript" src="../../dist/js/fullscreen/release/jquery.fullscreen.min.js"></script>

    <!--<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>-->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>

    <script src="../../dist/js/news/jquery.bootstrap.newsbox.min.js"></script>
    <script src="../../dist/js/news/script.js"></script>

    <script src="../../dist/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/sweetalert.css">

</head>



<body class="hold-transition lockscreen bgcol idcard" bgcolor="white">
<div class="lockscreen bgcol" id="fullscreen">


    <div class="idcard-logo">
        <div class="col-md-3">
            <img src="../ext-res/amrita.png" height="100px" width="130px">
        </div>

        <div class="col-md-6">
        <b>Digital Library</b><br/><small>Amrita Vishwa Vidyapeetham</small>
        </div>

        <div class="col-md-3">
            <img src="../ext-res/AMMA.png" height="100px" width="100px">
        </div>

        <div class="col-md-12">
                <div class="hr-fade"></div>
        </div>
    </div>





    <div class="col-md-6 news-panel">
        <div class="panel panel-default">
            <div class="panel-heading"> <span class="glyphicon glyphicon-list-alt"></span><b>News</b></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="demo2">

                            <?php
                            $news_sql = mysqli_query($connection,"select * from news");
                            $count = mysqli_num_rows($news_sql);
                            while($row = mysqli_fetch_assoc($news_sql)) {
                                print '<li class="news-item"><div class="news-item-div">'.$row['news'].'</div></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel-footer"> </div>
        </div>
        <div class="col-lg-6 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 id="currently-in">0</h3>
                    <p>Currently In</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <span class="small-box-footer">
                    Reloads in <span id="currently-in-timer"></span>
                </span>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3 id="visited-today">0</h3>
                    <p>Visited Today</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <span class="small-box-footer">
                    Reloads in <span id="visited-today-timer"></span>
                </span>
            </div>
        </div>

    </div>


    <div class="idcard-wrapper col-md-6">

        <h1 class="">
            Scan your ID card
        </h1>

        <div class="idcard-item" id="form-actual" >

            <form class="idcard-credentials" method="post" id="reg-form" autocomplete="off">
                <div class="input-group idcard-group">
                    <input id="idcard-number" type="text" class="form-control" name="id" placeholder="Roll Number" autofocus>
                    <div class="input-group-btn">
                        <button type="button" class="btn" tabindex="-1"><i class="fa fa-arrow-right text-muted"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <div id="form-content">

        </div>

    </div>


    <script type="text/javascript">


        window.onload = function(){
           checkFullScreen();
        }

        function checkFullScreen() {
            if($.fullscreen.isNativelySupported() && !$.fullscreen.isFullScreen()){
                swal({
                        title: "Go Fullscreen?",
                        text: "You must go Full Screen to continue!",
                        type: "warning",
                        confirmButtonColor: "#34dd61",
                        confirmButtonText: "Yes, do it!",
                        closeOnConfirm: true
                    },
                    function(){
                        $('#fullscreen').fullscreen();
                        $('#idcard-number').focus();
                        return false;
                    });
            }
        }


        $(document).ready(function() {

            // submit form using $.ajax() method

            $('#send-out-all-btn').click(function () {
                swal({
                    title: "Are You Sure?",
                    text: "Do you really want to send out all users?\nYou will be logged out after this",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        url: "send_out_all_api.php",
                        type: "POST"
                    }).done(function (data) {
                        swal({
                                title: "Done",
                                text: data.updated + " people were exited\nClick OK to logout",
                                type: "success",
                                confirmButtonText: "OK",
                                showCancelButton: false,
                                closeOnConfirm: false
                            }, function (isConfirm) {
                                if (isConfirm) {
                                    $.ajax({
                                        url: "../scripts/logout.php",
                                        type: "GET"
                                    }).done(function (data) {
                                        window.location = '/';
                                    });
                                }
                            }
                        );
                    });
                });
            });
            var resetvariable;
            $('#reg-form').submit(function(e){

                e.preventDefault(); // Prevent Default Submission

                $.ajax({
                    url: 'submit.php',
                    type: 'POST',
                    data: $(this).serialize() // it will serialize the form data
                })
                    .done(function(data){
                        var elem = document.getElementById("idcard-number"); // Get text field
                        elem.value = "";
                        $('#form-content').fadeOut('fast', function(){
                           $('#form-content').fadeIn('fast').html(data);
                        });

                        clearTimeout(resetvariable);
                        resetvariable=setTimeout(function(){
                            startresettimer();
                            }, 2000);


                    })
                    .fail(function(){
                        alert('Submit Failed ...');
                    });
            });

            function startresettimer(){
                $('#form-content').fadeOut('fast',null);
            }
        });


        $(function() {

            $('#fullscreen .exitfullscreen').click(function() {
                $.fullscreen.exit();
                return false;
            });

           $(document).bind('fscreenchange', function(e, state, elem) {
                if ($.fullscreen.isFullScreen()) {

                } else {
                    checkFullScreen();
                }
            });
        });

        updateCountTimerTime = 1000 * 60 * 0.5;
        function updateCurrentlyIn(){
            $.ajax({
            type: "POST",
            url: 'update_currently_in.php',
            dataType: 'json',
            data: {functionname: 'get_currently_in'},

            success: function (obj, textstatus) {
                        if( !('error' in obj) ) {
                            currently_in = obj.result1;
                            visited_today = obj.result2;
                            $("#currently-in").text(currently_in);
                            $("#visited-today").text(visited_today);
                        }
                        else {
                            console.log(obj.error);
                        }
                    }
            });
        }
        setInterval(updateCurrentlyIn,updateCountTimerTime);

        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.text(minutes + ":" + seconds);

                if (--timer < 0) {
                    timer = duration;
                }
            }, 1000);
        }
        timerTime = updateCountTimerTime/1000 - 1;
        startTimer(timerTime, $("#currently-in-timer"));
        startTimer(timerTime, $("#visited-today-timer"));
    </script>

</div>

<div class="col-md-12">
    <button id="send-out-all-btn" class="btn btn-danger" tabindex="-1">
        Send Out All Users
    </button>
</div>
</body>

</html>
