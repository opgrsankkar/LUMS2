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
    <link rel="stylesheet" href="staffCustom.css">


    <!-- jquery -->
    <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- excel parser -->
    <script src="../../dist/js/xlsxjs.full.min.js"></script>

    <script src="../../dist/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/sweetalert.css">
    <!-- angular includes -->
    <script src="../../dist/js/angular.min.js"></script>
    <script src="../../dist/js/angular-animate.min.js"></script>
    <!-- angular news app -->
    <script src="staffApp.js">

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

                <li>
                    <a href="../">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="../users">
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


                <li class="active">
                    <a href=".">
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
                <li class="active"><i class="fa fa-user"></i> Staff</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="row content" ng-app="staffApp" ng-controller="staffController">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="">Staff List</h3>
                </div>

                <div class="box-body">
                    <div id="add-refresh-button-group">
                        <button class="btn btn-success" data-toggle="modal" data-target="#add-staff-modal">
                            <i class="fa fa-plus"></i> Add Staff
                        </button>
                        <button class="btn btn-warning" ng-click="refreshStaffTable()">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                    </div>
                    <div class="modal fade" id="add-staff-modal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Staff Details</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-staff-form" ng-submit="addStaff()">
                                        <div class="form-group">
                                            <label for="username" class="control-label">
                                                <h5>Enter Username</h5>
                                            </label>
                                            <input id="username" type="text" class="form-control" placeholder="Username"
                                                   ng-model="newStaff.username" ng-change="checkUsernameExists()"
                                                   autocomplete="false" autofocus="autofocus">
                                            <span id="helpBlock"
                                                  class="help-block hidden">Username already exists</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="full-name" class="control-label">
                                                <h5>Enter Full name</h5>
                                            </label>
                                            <input id="full-name" type="text" class="form-control"
                                                   placeholder="Full Name" ng-model="newStaff.fullName">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="control-label">
                                                <h5>Enter Password</h5>
                                            </label>
                                            <input id="password" type="password" class="form-control"
                                                   placeholder="Password" ng-model="newStaff.password">
                                        </div>
                                        <div class="form-group">
                                            <label for="permission" class="control-label">
                                                <h5>Select Permission</h5>
                                            </label>
                                            <select name="permission" id="permission" ng-model="newStaff.permission">
                                                <option value="" disabled selected>Permission Level</option>
                                                <option value="1">Full</option>
                                                <option value="2">Full except staff list editing</option>
                                                <option value="3">Main Entrance</option>
                                                <option value="4">Digital Library Entrance</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button id="add-staff-submit-button" form="add-staff-form" type="submit"
                                            value="Submit" class="btn btn-primary">
                                        Add Staff
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /#add-staff-modal -->
                    <div class="modal fade" id="edit-staff-modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Staff Details</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-staff-form" ng-submit="editStaffFunction()">
                                        <div class="form-group">
                                            <label for="username" class="control-label">
                                                <h5>Username</h5>
                                            </label>
                                            <input id="username" type="text" class="form-control" placeholder="Username"
                                                   ng-model="editStaff.username" ng-change="checkUsernameExists()"
                                                   disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="full-name" class="control-label">
                                                <h5>Edit Full name</h5>
                                            </label>
                                            <input id="full-name" type="text" class="form-control"
                                                   placeholder="Full Name" ng-model="editStaff.fullName"
                                                   autofocus="autofocus">
                                        </div>
                                        <div class="form-group">
                                            <label for="permission" class="control-label">
                                                <h5>Select Permission</h5>
                                            </label>
                                            <select name="permission" id="permission" ng-model="editStaff.permission">
                                                <option value="" disabled selected>Permission Level</option>
                                                <option value="1">Full</option>
                                                <option value="2">Full except staff list editing</option>
                                                <option value="3">Main Entrance</option>
                                                <option value="4">Digital Library Entrance</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button form="edit-staff-form" type="submit" value="Submit" class="btn btn-primary">
                                        Edit Staff Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /#edit-staff-modal -->
                    <div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Staff Details</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="change-password-form" ng-submit="changePasswordFunction()">
                                        <div class="form-group">
                                            <label for="username" class="control-label">
                                                <h5>Username</h5>
                                            </label>
                                            <input id="username" type="text" class="form-control" placeholder="Username"
                                                   ng-model="changePassword.username" readonly="readonly">
                                        </div>
                                        <div class="form-group" ng-show="checkOldPassword">
                                            <label for="old-password" class="control-label">
                                                <h5>Enter Old Password</h5>
                                            </label>
                                            <input id="old-password" type="password" class="form-control"
                                                   placeholder="Old Password" ng-model="changePassword.oldPassword">
                                        </div>
                                        <div class="form-group">
                                            <label for="new-password" class="control-label">
                                                <h5>Enter New Password</h5>
                                            </label>
                                            <input id="new-password" type="password" class="form-control"
                                                   placeholder="New Password" ng-model="changePassword.newPassword">
                                        </div>
                                        <div class="form-group">
                                            <label for="repeat-new-password" class="control-label">
                                                <h5>Repeat New Password</h5>
                                            </label>
                                            <input id="repeat-new-password" type="password" class="form-control"
                                                   placeholder="Repeat Password" ng-model="changePassword.repeatNewPassword">
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button form="change-password-form" type="submit" value="Submit" class="btn btn-primary disable-on-check-repeat">
                                        Edit Staff Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /#change-password-modal -->

                    <table class="table table-bordered table-responsive table-hover" ng-show="staffTable.data.length">

                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Permission</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr ng-repeat="s in staffTable.data">
                            <td>{{s.username}}</td>
                            <td>{{s.name}}</td>
                            <td>

                                <button class="btn btn-warning btn-xs" ng-click="resetPassword(s.username)" ng-show="checkOldPassword || s.username == '<?= $username ?>'">
                                    Reset Password
                                </button>

                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#change-password-modal"
                                        ng-click="changePasswordFillModal(s.username)"
                                        ng-show="!(s.username == '<?= $username ?>') && (!checkOldPassword || s.permission == 3 || s.permission == 4)">
                                    Change Password
                                </button>
                            </td>
                            <td>{{s.permission | userPermissionsFilter}}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-info btn-sm" title="Edit" data-toggle="modal"
                                            data-target="#edit-staff-modal"
                                            ng-click="editStaffFillModal(s.username,s.name,s.permission)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" title="Delete"
                                            ng-click="deleteStaff(s.username)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
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

<script>
    $(document).ready(function () {
        /**
         * add event listener to check confirm password entry
         */
        $("#repeat-new-password").on("change keyup paste click", function () {
                if ($('#new-password').val() !== $('#repeat-new-password').val()) {
                    $('#repeat-new-password').parent().addClass('has-error');
                    $('.disable-on-check-repeat').prop('disabled', true);
                } else {
                    $('#repeat-new-password').parent().removeClass('has-error');
                    $('.disable-on-check-repeat').prop('disabled', false);
                }
            }
        );
    });
</script>
</body>
</html>
