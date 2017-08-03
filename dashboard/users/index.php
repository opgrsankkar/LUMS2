<!DOCTYPE html>
<?php
session_start();
include("../../scripts/sessionvariables.php");
if ($permission == 1)
    include("../../scripts/adminsession.php");
else if ($permission == 2)
    include("../../scripts/usersession.php");
else {
    header("location:../");
    die();
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../ext-res/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../ext-res/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="../../dist/css/animate.min.css">
    <!-- custom css for news page -->
    <link rel="stylesheet" href="usersCustom.css">


    <!-- jquery -->
    <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- excel parser -->
    <script src="../../dist/js/xlsxjs.full.min.js"></script>
    <!-- angular includes -->
    <script src="../../dist/js/angular.min.js"></script>
    <script src="../../dist/js/angular-animate.min.js"></script>
    <!-- angular news app -->
    <script src="usersApp.js">

    </script>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="../index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Administrator</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $name; ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">Last Login : <?php echo $lastlogin; ?><br/>Last Login IP : <?php echo $lastip; ?>
                </li>

                <li class="active">
                    <a href="../">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href=".">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="report_entrance.php"><i class="fa fa-circle-o"></i> Central Library</a></li>
                        <li><a href="report_digilib.php"><i class="fa fa-circle-o"></i> Digital Library</a></li>
                    </ul>
                </li>


                <li>
                    <a href="staff.php">
                        <i class="fa fa-user"></i> <span>Library Staff</span>
                    </a>
                </li>

                <li>
                    <a href="../news">
                        <i class="fa fa-newspaper-o"></i> <span>News</span>
                    </a>
                </li>


                <li>
                    <a href="../../scripts/logout.php">
                        <i class="fa fa-lock"></i> <span>Logout</span>
                    </a>
                </li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Dashboard
                <small>Version 1.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-newspaper-o"></i> News</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="row content" ng-app="usersApp" ng-controller="usersControl">
            <label class="btn btn-primary btn-file">
                Select File <input onchange="handleFileSelect(event)" type="file" name="files[]" style="display: none;">
            </label>
            <button id="load-data-btn" class="btn btn-success" ng-click="loadData()" disabled>Load File</button>
            <button id="upload-data-btn" class="btn btn-success" ng-click="uploadData()" disabled>Upload File</button>
            <br>
            <div class="alert alert-success alert-dismissible" role="alert"
                 ng-show="usersTable.numberOfRecords && uploadComplete">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                Upload Complete
            </div>
            <div id="uploading" class="alert alert-info" role="alert" ng-show="uploading">
                Uploading...
            </div>

            <div class="alert alert-warning alert-dismissible" role="alert" ng-show="!usersTable.numberOfRecords">

                <strong>Steps to upload Excel files</strong>
                <ol>
                    <li>Select the '.xls' file</li>
                    <li>Load the file</li>
                    <li>Upload the file</li>
                </ol>
            </div>

            <div id="output" ng-show="usersTable.numberOfRecords">
                <table>
                    <caption class="page-header">There are {{usersTable.numberOfRecords}} records in the uploaded
                        sheet
                    </caption>
                    <thead>
                    <tr>
                        <th>S.No.</th>
                        <th ng-repeat="key in usersTable.keys">
                            {{key}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="user in usersTable.data">
                        <td>{{$index + 1}}</td>
                        <td ng-repeat="key in usersTable.keys">{{user[key]}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <a href="http://sridarshan.tk">Sri Darshan S</a>, Sankkara Narayanan.</strong> All
        rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="../../plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../../plugins/chartjs/Chart.min.js"></script>

</body>
</html>
