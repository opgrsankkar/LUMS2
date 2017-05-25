<?php
    include("../scripts/db.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Entrance</title>
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
        <b>Central Library</b><br/><small>Amrita Vishwa Vidyapeetham</small>
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
                    <h3>150</h3>
                    <p>Currently In</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Central Library <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12">
            <div class="small-box bg-teal">
                <div class="inner">
                    <h3>250</h3>
                    <p>Visited Today</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Central Library <i class="fa fa-arrow-circle-right"></i>
                </a>
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
                        <button type="button" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
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

                        setTimeout(function(){
                            startresettimer();
                            }, 1000);


                    })
                    .fail(function(){
                        alert('Submit Failed ...');
                    });
            });


            /*
             // submit form using ajax short hand $.post() method

             $('#reg-form').submit(function(e){

             e.preventDefault(); // Prevent Default Submission

             $.post('submit.php', $(this).serialize() )
             .done(function(data){
             $('#form-content').fadeOut('slow', function(){
             $('#form-content').fadeIn('slow').html(data);
             });
             })
             .fail(function(){
             alert('Ajax Submit Failed ...');
             });

             });
             */


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
    </script>

</div>

</body>

</html>
