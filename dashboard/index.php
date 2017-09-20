<!DOCTYPE html>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
session_start();
include($path . "/scripts/sessionvariables.php");
if ($permission == 1)
    include($path . "/scripts/adminsession.php");
else if ($permission == 2)
    include($path . "/scripts/usersession.php");
else {
    header("location:../");
    die();
}
include("variables.php");
include($path . "/scripts/includejs.php");
?>

<html>
<head>
    <link type="text/plain" rel="author" href="/humans.txt"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    include($path . "/scripts/includecss.php");
    ?>

    <script>
        $(document).ready(function () {
            $(".sidebar-menu-dashboard").addClass("active");
        });
    </script>

    <style>
        .hover a {
            color: #444444;
        }

        .hover a:hover {
            color: #0c0c0c;
        }

        .hoverinfo:hover {
            box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.2);
        }
    </style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php
    include($path . '/dashboard/sidebar-menu.php');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Dashboard
                <small>Version 1.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/dashboard/">Home</a></li>
                <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $entrance_in; ?></h3>

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
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $entrance; ?></h3>

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
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3><?php echo $digilib_in; ?></h3>

                            <p>Currently In</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Digital Library <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-teal ">
                        <div class="inner">
                            <h3><?php echo $digilib; ?></h3>

                            <p>Visited Today</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            Digital Library <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>
            <!-- /.row -->

            <h4>
                Hello <b><?php echo $name; ?></b>
                <small>You have access to the following modules</small>
            </h4>


            <div class="col-md-4 col-sm-6 col-xs-12 hover">
                <a href="/dashboard/users/">
                    <div class="info-box hoverinfo">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number">Manage Staff and Students</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12 hover">
                <a href="/dashboard/reports/">
                    <div class="info-box hoverinfo">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-table"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Reports</span>
                            <span class="info-box-number">Collect reports of library users</span>
                        </div>
                    </div>
                </a>
            </div>

            <?php
            if ($permission == 1) {
                ?>

                <div class="col-md-4 col-sm-6 col-xs-12 hover">
                    <a href="/dashboard/staff/">
                        <div class="info-box hoverinfo">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Library Staff</span>
                                <span class="info-box-number">Manage Library Staff</span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>

            <div class="col-md-4 col-sm-6 col-xs-12 hover">
                <a href="/dashboard/news/">
                    <div class="info-box hoverinfo">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-newspaper-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">News</span>
                            <span class="info-box-number">Manage Scrolls on home page</span>
                        </div>
                    </div>
                </a>
            </div>


        </section>
    </div>


    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <a href="/humans.txt">LUMS 2.0</a></strong> All
        rights
        reserved.
    </footer>


</div><!-- ./wrapper -->


</body>
</html>
