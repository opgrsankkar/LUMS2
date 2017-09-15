<!DOCTYPE html>
<?php
session_start();
include("../scripts/sessionvariables.php");
if ($permission == 1)
    include("../scripts/adminsession.php");
else if ($permission == 2)
    include("../scripts/usersession.php");
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
    <!-- Tell the browser to be responsive to screen width -->
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

    <!-- jquery -->
    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>

    <script src="../../dist/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/sweetalert.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
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
                    <a href="/">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="users/">
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
                        <li><a href="reports/report_entrance.php"><i class="fa fa-circle-o"></i> Central Library</a></li>
                        <li><a href="report_digilib.php"><i class="fa fa-circle-o"></i> Digital Library</a></li>
                    </ul>
                </li>


                <li>
                    <a href="staff/">
                        <i class="fa fa-user"></i> <span>Library Staff</span>
                    </a>
                </li>

                <li>
                    <a href="news/">
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
                <li><a href="index.php">Home</a></li>
                <li><i class="fa fa-dashboard"></i> Dashboard</li>
                <li class="active"><i class="fa fa-key"></i> Change Password</li>
            </ol>
        </section><!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-4">
                    <div class="box box-info">
                        <div class="box-header">
                            <h4>Change Password</h4>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form id="password-change-form" action="../scripts/change_password_api.php" method="POST">
                                <div class="form-group">
                                    <label for="old-password" class="control-label">
                                        <h5>Enter Old Password *</h5>
                                    </label>
                                    <input id="old-password" type="password" class="form-control"
                                           placeholder="Old Password" name="old_password"
                                           tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label for="new-password" class="control-label">
                                        <h5>Enter New Password *</h5>
                                    </label>
                                    <input id="new-password" type="password" class="form-control"
                                           placeholder="New Password" name="new_password"
                                           tabindex="2">
                                </div>
                                <div class="form-group">
                                    <label for="repeat-new-password" class="control-label">
                                        <h5>Confirm New Password *</h5>
                                    </label>
                                    <input id="repeat-new-password" type="password" class="form-control"
                                           placeholder="Re-enter New Password" name="repeat_new_password"
                                           tabindex="3">
                                </div>
                                <div class="form-group">
                                    <button id="submit-button" class="btn btn-info" tabindex="4">Change Password
                                    </button>
                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col-sm-4 -->
            </div><!-- /.row -->
        </section><!-- /.content -->
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

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../../../dist//js/app.min.js"></script>
<!-- Sparkline -->
<script src="../../plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="../../plugins/chartjs/Chart.min.js"></script>

<!-- Jquery Form -->
<script src="../dist/js/jquery.form.js"></script>

<script>
    /**
     * add event listener to check confirm password entry
     */
    $("#repeat-new-password").on("change keyup paste click", function () {
            if ($('#new-password').val() !== $('#repeat-new-password').val()) {
                $('#repeat-new-password').parent().addClass('has-error');
            } else {
                $('#repeat-new-password').parent().removeClass('has-error');
            }
        }
    );
    /**
     * Password change form submit using ajax
     */
    $("#password-change-form").ajaxForm({
        data: {
            "username": "<?php echo $username;?>"
        },
        success: function (result) {
            $("#password-change-form").resetForm();
            if (result.success) {
                swal("Password Changed", null, "success");
            } else {
                if (result.error_msg === "DB_ERROR") {
                    swal("Server Error\nTry Again Later", null, "error");
                } else {
                    console.log(result);
                    swal("Old Password is Incorrect", null, "error");
                }
            }
        }
    });
</script>

</body>
</html>
