<?php
    include("../scripts/db.php");
    $news_sql = mysqli_query($connection,"select * from news");
    $count = mysqli_num_rows($news_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Lockscreen</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../dist/css/lums.css"/>
    <link rel="stylesheet" href="../../TEST/Responsive-jQuery-News-Ticker-Plugin-with-Bootstrap-3-Bootstrap-News-Box/css/site.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="../../jquery/jquery.min.js"></script>
</head>
<img class="square-image-logo left" src="../../TEST/Responsive-jQuery-News-Ticker-Plugin-with-Bootstrap-3-Bootstrap-News-Box/images/1.png"/>
<div class="idcard-logo">
      <b>Central Library</b><br/><small>Amrita Vishwa Vidyapeetham</small>
</div>
<img class="square-image-logo right" src="../../TEST/Responsive-jQuery-News-Ticker-Plugin-with-Bootstrap-3-Bootstrap-News-Box\images/1.png"/>
<div class="hr-fade"></div>
<body class="hold-transition lockscreen idcard">
    <div class="col-md-6 news-panel">
                <div class="panel panel-default">
                    <div class="panel-heading"> <span class="glyphicon glyphicon-list-alt"></span><b>News</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="demo2">
                                    <?php
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
            </div>
<!-- Automatic element centering -->
<div class="idcard-wrapper col-md-6">
    <h3 class="idcard-instructions">
    Scan your ID card
    </h3>
  <!-- START LOCK SCREEN ITEM -->
  <div class="idcard-item">
      
    <!-- lockscreen credentials (contains the form) -->
    <form class="idcard-credentials">
      <div class="input-group">
        <input id="idcard-number" type="text" class="form-control" placeholder="Roll Number" autofocus>

        <div class="input-group-btn">
          <button type="button" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
</div>
<!-- /.center -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!--carsousal scroll-->
<script src="../../TEST/Responsive-jQuery-News-Ticker-Plugin-with-Bootstrap-3-Bootstrap-News-Box/scripts/jquery.bootstrap.newsbox.min.js"></script>
<script src="../../TEST/Responsive-jQuery-News-Ticker-Plugin-with-Bootstrap-3-Bootstrap-News-Box/scripts/script.js"></script>
</body>
</html>
