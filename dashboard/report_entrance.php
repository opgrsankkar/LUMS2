<!DOCTYPE html>
<?php
session_start();
include("../scripts/sessionvariables.php");
if($permission==1)
    include("../scripts/adminsession.php");
else if($permission==2)
    include("../scripts/usersession.php");
else{
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
  <!-- DataTables-->
  <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">


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
          <p><?php echo $name;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		  
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Last Login : <?php echo $lastlogin;?><br/>Last Login IP : <?php echo $lastip;?></li>

        <li>
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="users.php">
              <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>


        <li class="treeview active">
          <a href="#">
              <i class="fa fa-table"></i> <span>Reports</span>
              <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
          </a>
          <ul class="treeview-menu">
              <li class="active"><a href="report_entrance.php"><i class="fa fa-circle-o"></i> Central Library</a></li>
              <li><a href="report_digilib.php"><i class="fa fa-circle-o"></i> Digital Library</a></li>
          </ul>
        </li>


        <li>
          <a href="staff.php">
              <i class="fa fa-user"></i> <span>Library Staff</span>
          </a>
        </li>

        <li>
          <a href="news.php">
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
        Report
        <small>Central Library</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li class="active"> <i class="fa fa-table"></i> Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <div class="row">
                        <h3 class="box-title col-md-2 col-sm-6 col-xs-12 pull-left">Central Library</h3>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="pull-right" style="padding: 0cm 30px 0cm 0cm;">
                                    <label>Date Range:</label>


                                <div class="input-group">
                                    <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>
                                          <i class="fa fa-calendar"></i> Filter
                                        </span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <table id="report" class="table table-hover table-bordered ">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


    </section>
   </div>
 
 <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; <a href="http://sridarshan.tk">Sri Darshan S</a>.</strong> All rights
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
<!-- DataTables-->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
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
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>//check
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>



<script type="text/javascript">
    var datefrom="";
    var dateto="";

    var table=$('#report').DataTable({

        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
        "processing": true,
        "serverSide": true,
        "sAjaxSource": "../../scripts/entrance_report.php",
        "sServerMethod": "GET",
        "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "fromdate", "value": datefrom } );
                aoData.push( { "name": "todate", "value": dateto } );
            },

    });


    $(function () {
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
            //do something, like clearing an input
            $('#daterange-btn span').html(" \<i class=\"fa fa-calendar\"\>\</i\> Filter");
            dateto=datefrom="";

            table.ajax.reload( null, false );

            console.log("Cleared");

        });
        $('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
            datefrom=picker.startDate.format('YYYY-MM-DD')+" 00:00:00";
            dateto=picker.endDate.format('YYYY-MM-DD')+" 23:59:59";
            table.ajax.reload( null, false );
            console.log(picker.startDate.format('YYYY-MM-DD'));
            console.log(picker.endDate.format('YYYY-MM-DD'));
        });


    });
</script>

</body>
</html>
